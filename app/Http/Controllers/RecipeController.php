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
    public function index(Request $request)
    {
        $query = Recipe::published()->with(['category', 'ratings']);

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->category)
            );
        }

        // Filter difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter durasi maksimal
        if ($request->filled('max_duration')) {
            $query->where('duration_minutes', '<=', $request->max_duration);
        }

        // Search
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'popular'   => $query->orderByDesc('views'),
            'rating'    => $query->withAvg('ratings', 'rating')
                                 ->orderByDesc('ratings_avg_rating'),
            'duration'  => $query->orderBy('duration_minutes'),
            default     => $query->latest(),
        };

        $recipes    = $query->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories'));
    }

    public function show(Recipe $recipe)
    {
        // Hanya tampilkan published, kecuali admin
        if ($recipe->status !== 'published' && !Auth::check() || 
            ($recipe->status !== 'published' && !Auth::user()?->isAdmin())) {
            abort(404);
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

        $related = Recipe::published()
            ->where('category_id', $recipe->category_id)
            ->where('id', '!=', $recipe->id)
            ->limit(3)
            ->get();

        return view('recipes.show', compact(
            'recipe', 'isBookmarked', 'userRating', 'related'
        ));
    }
}