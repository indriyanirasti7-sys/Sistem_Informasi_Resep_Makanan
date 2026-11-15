<?php

namespace App\Http\Controllers;

use App\Models\Tip;

class TipController extends Controller
{
    public function panduan()
    {
        // Featured tip (paling baru)
        $featured = Tip::with('user')->latest()->first();

        // Tips reguler (semua kecuali featured)
        $tips = Tip::with('user')
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->latest()
            ->paginate(8);

        return view('tips.panduan', compact('featured', 'tips'));
    }

     public function show(Tip $tip)
    {
        $related = Tip::with('user')
            ->where('id', '!=', $tip->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('tips.detail_tips', compact('tip', 'related'));
    }
}