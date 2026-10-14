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

        return view('admin.reviews.daftar_ulasan', compact('reviews'));
    }
}