<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Tip;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'recipes_total'     => Recipe::count(),
            'recipes_published' => Recipe::where('status', 'published')->count(),
            'recipes_draft'     => Recipe::where('status', 'draft')->count(),
            'categories_total'  => Category::count(),
            'users_total'       => User::count(),
            'ratings_total'     => Rating::count(),
            'tips_total'        => Tip::count(),
        ];

        $topRecipes = Recipe::with('category')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $latestRatings = Rating::with(['user', 'recipe'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'topRecipes', 'latestRatings'));
    }
} 