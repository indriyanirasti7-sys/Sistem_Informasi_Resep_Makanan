<?php

namespace App\Http\Controllers;

use App\Models\Tip;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->latest()->paginate(9);

        return view('tips.index', compact('tips'));
    }

    public function show(Tip $tip)
    {
        return view('tips.show', compact('tip'));
    }
}