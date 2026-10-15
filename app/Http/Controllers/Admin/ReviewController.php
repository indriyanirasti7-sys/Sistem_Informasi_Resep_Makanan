<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Rating::with(['user', 'recipe'])
            ->latest()
            ->paginate(10);

        // Hitung statistik
        $totalReviews   = Rating::count();
        $averageRating  = round(Rating::avg('rating') ?? 0, 1);
        $fiveStarCount  = Rating::where('rating', 5)->count();
        $attentionCount = Rating::whereIn('rating', [1, 2])->count();

        // Persentase bintang 5
        $fiveStarPercent = $totalReviews > 0
            ? round(($fiveStarCount / $totalReviews) * 100, 1)
            : 0;

        // Distribusi bintang (5 sampai 1)
        $distribution = [];
        foreach ([5, 4, 3, 2, 1] as $star) {
            $count = Rating::where('rating', $star)->count();
            $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;
            $distribution[$star] = [
                'count'   => $count,
                'percent' => $percent,
            ];
        }

        return view('admin.reviews.daftar_ulasan', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'fiveStarCount',
            'fiveStarPercent',
            'attentionCount',
            'distribution'
        ));
    }
}