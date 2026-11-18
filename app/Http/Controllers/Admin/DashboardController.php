<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
date_default_timezone_set('Asia/Jakarta');

class DashboardController extends Controller
{

   // app/Http/Controllers/Admin/DashboardController.php

public function index()
    {
    $stats = [
        'recipes_total'     => \App\Models\Recipe::count(),
        'recipes_published' => \App\Models\Recipe::where('status', 'published')->count(),
        'recipes_draft'     => \App\Models\Recipe::where('status', 'draft')->count(),
        'categories_total'  => \App\Models\Category::count(),
        'users_total'       => \App\Models\User::count(),
        'ratings_total'     => \App\Models\Rating::count(),
        'tips_total'        => \App\Models\Tip::count(),
    ];

     $hour = date('H');
    if ($hour >= 5 && $hour < 11) {
        $greeting = 'Selamat pagi';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat sore';
    } else {
        $greeting = 'Selamat malam';
    }

    $topRecipes = \App\Models\Recipe::with(['category', 'user', 'ratings'])
        ->orderByDesc('views')
        ->limit(5)
        ->get();

    $latestRatings = \App\Models\Rating::with(['user', 'recipe'])
        ->latest()
        ->limit(5)
        ->get();

            // 1. Ambil data 6 bulan terakhir
        $months = collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i);
        });

        $chartData = [];
        $maxCount = 1; // Untuk mencegah pembagian dengan nol

        foreach ($months as $date) {
            $monthName = $date->translatedFormat('M'); // Jan, Feb, Mar...
            $year = $date->year;
            $month = $date->month;

            // Hitung Resep Masakan Tradisional (Semua resep KECUALI Dessert dan Minuman)
            $tradisional = \App\Models\Recipe::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereHas('category', function($q) {
                    $q->whereNotIn('name', ['Dessert', 'Minuman']);
                })->count();

            // Hitung Resep Pastry & Minuman
            $pastry = \App\Models\Recipe::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereHas('category', function($q) {
                    $q->whereIn('name', ['Dessert', 'Minuman']);
                })->count();

            // Hitung total views dari resep yang di-upload bulan itu
            $views = \App\Models\Recipe::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('views');

            // Simpan ke array sementara
            $chartData[] = [
                'month' => $monthName,
                'tradisional_raw' => $tradisional,
                'pastry_raw' => $pastry,
                'akses' => $views > 0 ? number_format($views / 1000, 1) . 'k' : '0',
            ];

            // Cari nilai tertinggi untuk menentukan tinggi bar (persentase)
            if ($tradisional > $maxCount) $maxCount = $tradisional;
            if ($pastry > $maxCount) $maxCount = $pastry;
        }

        // Ubah data mentah menjadi persentase tinggi bar (0-100%)
        $chartData = array_map(function($data) use ($maxCount) {
            $data['tradisional'] = round(($data['tradisional_raw'] / $maxCount) * 100);
            $data['pastry'] = round(($data['pastry_raw'] / $maxCount) * 100);
            return $data;
        }, $chartData);

       return view('admin.dashboard', compact('stats', 'topRecipes', 'latestRatings', 'chartData', 'greeting'));
    }
}