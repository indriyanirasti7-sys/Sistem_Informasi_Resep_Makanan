<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Rating;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function daftar_resep(Request $request)
    {
        $query = Recipe::published()->with(['category', 'ratings']);

        // 1. Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->category)
            );
        }

        // 2. Filter difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // 3. Filter durasi maksimal
        if ($request->filled('max_duration')) {
            $query->where('duration_minutes', '<=', $request->max_duration);
        }

        // 4. Search Text
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // 5. Filter Bahan Dapur (Smart Pantry)
        if ($request->filled('ingredients')) {
            $ingredientList = explode(',', $request->ingredients);
            // Cari resep yang mengandung salah satu bahan yang dipilih
            $query->whereHas('recipeIngredients.ingredient', function($q) use ($ingredientList) {
                $q->whereIn('name', $ingredientList);
            });
        }

        // 6. Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'popular'   => $query->orderByDesc('views'),
            'rating'    => $query->withAvg('ratings', 'rating')
                                 ->orderByDesc('ratings_avg_rating'),
            'duration'  => $query->orderBy('duration_minutes'),
            default     => $query->latest(),
        };

        $recipes    = $query->paginate(8)->withQueryString();
        $categories = Category::all();

        return view('recipes.daftar_resep', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe)
    {
        // PERBAIKAN LOGIKA DRAFT: 
        // Jika statusnya BUKAN published, cek apakah user sudah login DAN admin.
        // Jika bukan admin, tendang dengan error 404.
        if ($recipe->status !== 'published') {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                abort(404);
            }
        }

        // Increment views
        $recipe->increment('views');

        $recipe->load([
            'category',
            'user',
            'steps',
            'recipeIngredients.ingredient',
            'ratings.user',
        ]);

        $isBookmarked = Auth::check()
            ? Bookmark::where('user_id', Auth::id())
                      ->where('recipe_id', $recipe->id)
                      ->exists()
            : false;

        $userRating = Auth::check()
            ? Rating::where('user_id', Auth::id())
                    ->where('recipe_id', $recipe->id)
                    ->first()
            : null;

        // Ambil resep terkait (Diperbarui menjadi 6 dan diacak)
        $related = Recipe::published()
            ->where('category_id', $recipe->category_id)
            ->where('id', '!=', $recipe->id)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Jika resep terkait kurang dari 2, ambil resep acak dari kategori lain
        if ($related->count() < 2) {
            $related = Recipe::published()
                ->where('id', '!=', $recipe->id)
                ->inRandomOrder()
                ->take(6)
                ->get();
        }

        return view('recipes.show', compact(
            'recipe', 'isBookmarked', 'userRating', 'related'
        ));
    }
}