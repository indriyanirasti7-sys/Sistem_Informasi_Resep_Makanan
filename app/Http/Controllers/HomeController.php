<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tip;
use Illuminate\Http\Request; // TAMBAHKAN INI UNTUK AJAX

class HomeController extends Controller
{
    public function index()
    {
        $featured = Recipe::published()
            ->with(['category', 'ratings'])
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        // DIUBAH: Menjadi 20 agar load awal tidak terlalu berat
        $latest = Recipe::published()
            ->with(['category'])
            ->latest()
            ->take(20) 
            ->get();

        $categories = Category::withCount(['recipes' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        // Tips tetap 3 atau bisa disesuaikan
        $tips = Tip::latest()->limit(3)->get();

        return view('home', compact('featured', 'latest', 'categories', 'tips'));
    }

    /**
     * FUNGSI BARU UNTUK AJAX "MUAT LEBIH BANYAK"
     */
    public function loadMoreRecipes(Request $request)
    {
        $skip = $request->input('skip', 20);
        $take = 20; // Ambil 20 resep selanjutnya

        $recipes = Recipe::published()
            ->with(['category'])
            ->latest()
            ->skip($skip)
            ->take($take)
            ->get();
        
        // Cek apakah masih ada sisa data di database
        $total = Recipe::published()->count();
        $hasMore = $total > ($skip + $take);

        // Render file partial card resep menjadi teks HTML
        $html = view('recipes.partials.recipe_items', compact('recipes'))->render();
        
        return response()->json([
            'html' => $html,
            'has_more' => $hasMore
        ]);
    }
}