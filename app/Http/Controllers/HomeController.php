<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. RESEP TERPOPULER DIUBAH MENJADI PAGINATION (misal 8 item per halaman)
        $featured = Recipe::published()
            ->with(['category', 'ratings'])
            ->orderByDesc('views')
            ->paginate(8)
            ->withQueryString();

        // Resep terbaru (tetap menggunakan sistem muat lebih banyak / take 20)
        $latest = Recipe::published()
            ->with(['category'])
            ->latest()
            ->take(20) 
            ->get();

        $categories = Category::withCount(['recipes' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        // 2. TIPS DIUBAH MENJADI 9 ITEM
        $tips = Tip::latest()->limit(9)->get();

        return view('home', compact('featured', 'latest', 'categories', 'tips'));
    }

    /**
     * FUNGSI UNTUK AJAX "MUAT LEBIH BANYAK" (RESEP TERBARU)
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