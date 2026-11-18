<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with(['category', 'user', 'ratings']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('title', 'like', "%{$q}%");
        }

        $recipes = $query->latest('updated_at')->paginate(10)->withQueryString();

        $stats = [
            'total'     => Recipe::count(),
            'published' => Recipe::where('status', 'published')->count(),
            'draft'     => Recipe::where('status', 'draft')->count(),
        ];

        return view('admin.recipes.kelola_resep', compact('recipes', 'stats'));
    }

    public function detail_tampilan(Recipe $recipe)
    {
        $recipe->load(['category', 'user', 'steps', 'recipeIngredients.ingredient', 'ratings.user']);

        return view('admin.recipes.detail_tampilan', compact('recipe'));
    }

    public function create()
    {
        $categories  = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.recipes.tambah_resep', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRecipe($request);

        DB::transaction(function () use ($validated, $request) {
            $recipe = Recipe::create([
                'title'            => $validated['title'],
                'slug'             => Str::slug($validated['title']) . '-' . Str::random(4),
                'category_id'      => $validated['category_id'],
                'user_id'          => Auth::id(),
                'description'      => $validated['description'] ?? null,
                'servings'         => $validated['servings'],
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'difficulty'       => $validated['difficulty'],
                'status'           => $validated['status'],
                'image'            => $this->handleImageUpload($request),
            ]);

            $this->syncIngredients($recipe, $request->input('ingredients', []));
            $this->syncSteps($recipe, $request->input('steps', []), $request);
        });

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil ditambahkan.');
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load(['steps', 'recipeIngredients']);
        $categories  = Category::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $this->validateRecipe($request, $recipe->id);

        DB::transaction(function () use ($validated, $request, $recipe) {
            $newImage = $this->handleImageUpload($request);

            // Hapus file gambar lama kalau user upload gambar baru
            if ($newImage && $recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }

            $recipe->update([
                'title'            => $validated['title'],
                'category_id'      => $validated['category_id'],
                'description'      => $validated['description'] ?? null,
                'servings'         => $validated['servings'],
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'difficulty'       => $validated['difficulty'],
                'status'           => $validated['status'],
                'image'            => $newImage ?? $recipe->image,
            ]);

            // Hapus bahan & langkah lama sebelum menyimpan yang baru
            $recipe->recipeIngredients()->delete();
            foreach ($recipe->steps as $oldStep) {
                if ($oldStep->image) {
                    Storage::disk('public')->delete($oldStep->image);
                }
            }
            $recipe->steps()->delete();

            $this->syncIngredients($recipe, $request->input('ingredients', []));
            $this->syncSteps($recipe, $request->input('steps', []), $request);
        });

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil diperbarui.');
    }

    public function destroy(Recipe $recipe)
    {
        DB::transaction(function () use ($recipe) {
            // 1. Hapus semua data anak (foreign key dependents)
            $recipe->recipeIngredients()->delete();
            
            foreach ($recipe->steps as $oldStep) {
                if ($oldStep->image) {
                    Storage::disk('public')->delete($oldStep->image);
                }
            }
            $recipe->steps()->delete();
            
            $recipe->ratings()->delete();
            $recipe->bookmarks()->delete();

            // 2. Hapus file gambar dari storage
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }

            // 3. Baru hapus resep induk
            $recipe->delete();
        });

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil dihapus.');
    }

    public function exportPdf()
    {
        // Ambil semua data resep
        $recipes = Recipe::with('category')->latest()->get();

        // Load file blade khusus PDF
        $pdf = Pdf::loadView('admin.laporan.laporan_pdf', compact('recipes'));
        
        // Atur orientasi kertas menjadi Landscape (Mendatar)
        $pdf->setPaper('A4', 'landscape');

        // Download file PDF
        return $pdf->download('Laporan-Resep-Jelajah-Rasa-' . date('Y-m-d') . '.pdf');
    }

    private function validateRecipe(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'                    => 'required|string|max:150',
            'category_id'              => 'required|exists:categories,id',
            'description'              => 'nullable|string',
            'servings'                 => 'required|integer|min:1|max:255',
            'duration_minutes'         => 'nullable|integer|min:1|max:65535',
            'difficulty'               => 'required|in:Mudah,Sedang,Sulit',
            'status'                   => 'required|in:draft,published',
            'image'                    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'ingredients'              => 'required|array',
            'ingredients.*.name'       => 'required|string|max:225',

            'steps'                    => 'required|array',
            'steps.*.instruction'      => 'required|string',
            'steps.*.duration_minutes' => 'nullable|integer|min:1|max:65535',
            'steps.*.image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    }

    private function handleImageUpload(Request $request): ?string
    {
        if (!$request->hasFile('image')) return null;
        return $request->file('image')->store('recipes', 'public');
    }

    private function syncIngredients(Recipe $recipe, array $items): void
    {
        foreach ($items as $item) {
            if (empty($item['name'])) continue;

            // Simpan seluruh teks (misal: "Garam 1 sdt") ke dalam nama bahan
            $ingredient = Ingredient::firstOrCreate(
                ['name' => trim($item['name'])],
                ['unit' => 'gram'] // Default value jika tabel mewajibkannya
            );

            $recipe->recipeIngredients()->create([
                'ingredient_id' => $ingredient->id,
                'amount'        => 1, // Dummy value karena sudah digabung di nama
                'unit'          => '-', // Dummy value
            ]);
        }
    }

    private function syncSteps(Recipe $recipe, array $items, Request $request): void
    {
        $number = 1;
        foreach ($items as $index => $item) {
            if (empty($item['instruction'])) continue;

            // Cek apakah ada file gambar yang di-upload untuk step ini
            $imagePath = null;
            if ($request->hasFile("steps.{$index}.image")) {
                $imagePath = $request->file("steps.{$index}.image")->store('steps', 'public');
            }

            $recipe->steps()->create([
                'step_number'      => $number++,
                'instruction'      => $item['instruction'],
                'duration_minutes' => $item['duration_minutes'] ?? null,
                'image'            => $imagePath, // Simpan path gambar
            ]);
        }
    }
}