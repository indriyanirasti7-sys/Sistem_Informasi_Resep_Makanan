<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
        public function index(Request $request)
    {
        $query = Rating::with(['user', 'recipe']);

        // Filter: pencarian (komentar, nama user, atau judul resep)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('comment', 'like', "%{$q}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"))
                ->orWhereHas('recipe', fn($r) => $r->where('title', 'like', "%{$q}%"));
            });
        }

        // Filter: bintang
        if ($request->filled('rating') && $request->rating !== 'all') {
            $query->where('rating', $request->rating);
        }

        // Filter: resep tertentu
        if ($request->filled('recipe_id') && $request->recipe_id !== 'all') {
            $query->where('recipe_id', $request->recipe_id);
        }

        // Sort
        match ($request->sort) {
            'rating_high' => $query->orderByDesc('rating')->latest(),
            'rating_low'  => $query->orderBy('rating')->latest(),
            'oldest'      => $query->oldest(),
            default       => $query->latest(),
        };

        $reviews = $query->paginate(10)->withQueryString();

        // Statistik utama (tidak terpengaruh filter)
        $totalReviews   = Rating::count();
        $averageRating  = round(Rating::avg('rating') ?? 0, 1);
        $fiveStarCount  = Rating::where('rating', 5)->count();
        $attentionCount = Rating::whereIn('rating', [1, 2])->count();

        $fiveStarPercent = $totalReviews > 0
            ? round(($fiveStarCount / $totalReviews) * 100, 1)
            : 0;

        // Distribusi bintang
        $distribution = [];
        foreach ([5, 4, 3, 2, 1] as $star) {
            $count = Rating::where('rating', $star)->count();
            $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;
            $distribution[$star] = [
                'count'   => $count,
                'percent' => $percent,
            ];
        }

        // Daftar resep untuk dropdown filter
        $recipesForFilter = \App\Models\Recipe::orderBy('title')->get(['id', 'title']);

        return view('admin.reviews.daftar_ulasan', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'fiveStarCount',
            'fiveStarPercent',
            'attentionCount',
            'distribution',
            'recipesForFilter'
        ));
    }

     public function destroy($review)
    {
        $rating = Rating::findOrFail($review);

        // Ambil info dulu sebelum dihapus (untuk flash message)
        $userName   = $rating->user->name ?? 'Anonim';
        $recipeName = $rating->recipe->title ?? 'Resep';

        $rating->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', "Ulasan dari {$userName} pada resep '{$recipeName}' berhasil dihapus.");
    }
}