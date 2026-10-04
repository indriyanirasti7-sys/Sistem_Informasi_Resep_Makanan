<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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

    $topRecipes = \App\Models\Recipe::with(['category', 'user', 'ratings'])
        ->orderByDesc('views')
        ->limit(5)
        ->get();

    $latestRatings = \App\Models\Rating::with(['user', 'recipe'])
        ->latest()
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact('stats', 'topRecipes', 'latestRatings'));
    }
}