<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Halaman daftar resep favorit user.
     *
     * - Guest (belum login)   → empty state + rekomendasi
     * - User login (kosong)   → empty state + rekomendasi
     * - User login (ada isi)  → grid favorit
     */
    public function favorit(Request $request)
    {
        $isGuest = !Auth::check();
        $bookmarks = null;

        // Ambil bookmark HANYA kalau user sudah login
        if (!$isGuest) {
            $query = Bookmark::with(['recipe.category', 'recipe.user', 'recipe.ratings'])
                ->where('user_id', Auth::id());

            // Filter kategori
            if ($request->filled('category')) {
                $query->whereHas('recipe.category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            // Sort
            $sort = $request->get('sort', 'newest');
            match ($sort) {
                'az'     => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')
                                  ->orderBy('recipes.title', 'asc')
                                  ->select('bookmarks.*'),
                'rating' => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')
                                  ->orderByDesc('recipes.views')
                                  ->select('bookmarks.*'),
                'time'   => $query->join('recipes', 'bookmarks.recipe_id', '=', 'recipes.id')
                                  ->orderBy('recipes.duration_minutes', 'asc')
                                  ->select('bookmarks.*'),
                default  => $query->latest(),
            };

            $bookmarks = $query->paginate(12)->withQueryString();
        } else {
            // Guest → paginator kosong (biar view tidak error)
            $bookmarks = new LengthAwarePaginator(
                collect(),
                0,
                12,
                1,
                ['path' => $request->url()]
            );
        }

        // Kategori untuk filter (semua user boleh lihat)
        $categories = Category::orderBy('name')->get();

        // Rekomendasi resep populer kalau favorit kosong
        $popularRecipes = collect();
        if (($bookmarks->total() ?? 0) === 0) {
            // Kecualikan resep yang sudah di-bookmark (kalau user login)
            $bookmarkedIds = $isGuest
                ? collect()
                : Bookmark::where('user_id', Auth::id())->pluck('recipe_id');

            $popularRecipes = Recipe::published()
                ->with(['category', 'user', 'ratings'])
                ->whereNotIn('id', $bookmarkedIds)
                ->orderByDesc('views')
                ->limit(4)
                ->get();
        }

        return view('bookmarks.favorit', compact(
            'bookmarks',
            'categories',
            'popularRecipes',
            'isGuest'
        ));
    }

    /**
     * Toggle bookmark (tambah/hapus).
     * Support AJAX & form biasa.
     */
    public function toggle(Recipe $recipe)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $status  = 'removed';
            $message = 'Resep dihapus dari favorit.';
        } else {
            Bookmark::create([
                'user_id'   => Auth::id(),
                'recipe_id' => $recipe->id,
            ]);
            $status  = 'added';
            $message = 'Resep ditambahkan ke favorit!';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'status'  => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Hapus bookmark dari halaman favorit (by ID).
     */
   public function destroy(Bookmark $bookmark)
    {
        // Cek kepemilikan
        if ($bookmark->user_id !== Auth::id()) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Tidak diizinkan.'], 403);
            }
            abort(403);
        }

        $bookmark->delete();

        // Kalau AJAX → return JSON
        if (request()->wantsJson()) {
            return response()->json([
                'status'  => 'removed',
                'message' => 'Resep dihapus dari favorit.',
            ]);
        }

        // Kalau form biasa → redirect
        return back()->with('success', 'Favorit dihapus.');
    }
}