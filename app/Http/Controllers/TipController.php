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
            ->paginate(9);

        return view('tips.panduan', compact('featured', 'tips'));
    }
}