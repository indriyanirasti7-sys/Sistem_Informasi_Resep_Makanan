<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tip;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Recipe::published()
            ->with(['category', 'ratings'])
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        $latest = Recipe::published()
            ->with(['category'])
            ->latest()
            ->limit(6)
            ->get();

        $categories = Category::withCount(['recipes' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        $tips = Tip::latest()->limit(3)->get();

        return view('home', compact('featured', 'latest', 'categories', 'tips'));
    }
}