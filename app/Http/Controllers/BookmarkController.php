<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tip;
use App\Models\TipBookmark; // <--- Import Model baru
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function favorit(Request $request)
    {
        $isGuest = !Auth::check();
        $bookmarks = null;
        $bookmarkedTips = collect();

        if (!$isGuest) {
            $query = Bookmark::with(['recipe.category', 'recipe.user', 'recipe.ratings'])
                ->where('user_id', Auth::id());

            if ($request->filled('category')) {
                $query->whereHas('recipe.category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            $sort = $request->get('sort', 'newest');
            match ($sort) {
                'az'     => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')->orderBy('recipes.title', 'asc')->select('bookmarks.*'),
                'rating' => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')->orderByDesc('recipes.views')->select('bookmarks.*'),
                'time'   => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')->orderBy('recipes.duration_minutes', 'asc')->select('bookmarks.*'),
                default  => $query->latest(),
            };

            $bookmarks = $query->paginate(12)->withQueryString();

            // Ambil Tips menggunakan Model
            $bookmarkedTips = TipBookmark::with('tip')
                                ->where('user_id', Auth::id())
                                ->latest()
                                ->get();

        } else {
            $bookmarks = new LengthAwarePaginator(collect(), 0, 12, 1, ['path' => $request->url()]);
        }

        $categories = Category::orderBy('name')->get();

        $popularRecipes = collect();
        if (($bookmarks->total() ?? 0) === 0 && $bookmarkedTips->isEmpty()) {
            $bookmarkedIds = $isGuest ? collect() : Bookmark::where('user_id', Auth::id())->pluck('recipe_id');

            $popularRecipes = Recipe::published()
                ->with(['category', 'user', 'ratings'])
                ->whereNotIn('id', $bookmarkedIds)
                ->orderByDesc('views')
                ->limit(4)
                ->get();
        }

        return view('bookmarks.favorit', compact(
            'bookmarks',
            'bookmarkedTips',
            'categories',
            'popularRecipes',
            'isGuest'
        ));
    }

    public function toggle(Recipe $recipe)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('recipe_id', $recipe->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            $status  = 'removed';
            $message = 'Resep dihapus dari koleksi.';
        } else {
            Bookmark::create(['user_id' => Auth::id(), 'recipe_id' => $recipe->id]);
            $status  = 'added';
            $message = 'Resep ditambahkan ke koleksi!';
        }

        if (request()->wantsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function toggleTip($slug)
    {
        $tip = Tip::where('slug', $slug)->firstOrFail();
        
        // Gunakan Model TipBookmark
        $bookmark = TipBookmark::where('user_id', Auth::id())->where('tip_id', $tip->id)->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        } else {
            TipBookmark::create([
                'user_id' => Auth::id(),
                'tip_id'  => $tip->id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== Auth::id()) {
            if (request()->wantsJson()) return response()->json(['error' => 'Tidak diizinkan.'], 403);
            abort(403);
        }

        $bookmark->delete();

        if (request()->wantsJson()) {
            return response()->json(['status' => 'removed', 'message' => 'Resep dihapus dari koleksi.']);
        }

        return back()->with('success', 'Favorit dihapus.');
    }
    public function destroyTip($id)
    {
        $bookmark = \App\Models\TipBookmark::where('id', $id)->where('user_id', Auth::id())->first();
        
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        }
        
        return response()->json(['error' => 'Tidak ditemukan'], 404);
    }
}