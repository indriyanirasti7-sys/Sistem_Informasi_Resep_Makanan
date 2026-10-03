<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeController extends Controller
{

    public function index(Request $request)
    {
        $query = Recipe::with(['category', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        $recipes = $query->latest()->paginate(10)->withQueryString();

        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories  = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.recipes.create', compact('categories', 'ingredients'));
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
                'calories'         => $validated['calories'] ?? null,
                'status'           => $validated['status'],
                'image'            => $this->handleImageUpload($request),
            ]);

            $this->syncIngredients($recipe, $request->input('ingredients', []));
            $this->syncSteps($recipe, $request->input('steps', []));
        });

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil ditambahkan.');
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['category', 'user', 'steps', 'recipeIngredients.ingredient', 'ratings.user']);

        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load(['steps', 'recipeIngredients']);
        $categories  = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $this->validateRecipe($request, $recipe->id);

        DB::transaction(function () use ($validated, $request, $recipe) {
            $recipe->update([
                'title'            => $validated['title'],
                'category_id'      => $validated['category_id'],
                'description'      => $validated['description'] ?? null,
                'servings'         => $validated['servings'],
                'duration_minutes' => $validated['duration_minutes'] ?? null,
                'difficulty'       => $validated['difficulty'],
                'calories'         => $validated['calories'] ?? null,
                'status'           => $validated['status'],
                'image'            => $this->handleImageUpload($request) ?? $recipe->image,
            ]);

            $recipe->recipeIngredients()->delete();
            $recipe->steps()->delete();

            $this->syncIngredients($recipe, $request->input('ingredients', []));
            $this->syncSteps($recipe, $request->input('steps', []));
        });

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil diperbarui.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Resep berhasil dihapus.');
    }

    /* ---------------- Helpers ---------------- */

    private function validateRecipe(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'                  => 'required|string|max:150',
            'category_id'            => 'required|exists:categories,id',
            'description'            => 'nullable|string',
            'servings'               => 'required|integer|min:1|max:255',
            'duration_minutes'       => 'nullable|integer|min:1|max:65535',
            'difficulty'             => 'required|in:Mudah,Sedang,Sulit',
            'calories'               => 'nullable|integer|min:1|max:65535',
            'status'                 => 'required|in:draft,published',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients'            => 'array',
            'ingredients.*.id'       => 'required|exists:ingredients,id',
            'ingredients.*.amount'   => 'required|numeric|min:0',
            'ingredients.*.unit'     => 'nullable|string|max:20',
            'steps'                  => 'array',
            'steps.*.instruction'    => 'required|string',
            'steps.*.duration_minutes' => 'nullable|integer|min:1|max:65535',
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
            if (empty($item['id']) || !isset($item['amount'])) continue;

            $recipe->recipeIngredients()->create([
                'ingredient_id' => $item['id'],
                'amount'        => $item['amount'],
                'unit'          => $item['unit'] ?? null,
            ]);
        }
    }

    private function syncSteps(Recipe $recipe, array $items): void
    {
        $number = 1;
        foreach ($items as $item) {
            if (empty($item['instruction'])) continue;

            $recipe->steps()->create([
                'step_number'      => $number++,
                'instruction'      => $item['instruction'],
                'duration_minutes' => $item['duration_minutes'] ?? null,
            ]);
        }
    }
}