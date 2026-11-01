<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function store(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Update or create (unique user_id + recipe_id)
        Rating::updateOrCreate(
            [
                'user_id'   => Auth::id(),
                'recipe_id' => $recipe->id,
            ],
            [
                'rating'  => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Ulasan berhasil disimpan.',
                'average' => $recipe->fresh()->average_rating,
                'count'   => $recipe->fresh()->rating_count,
            ]);
        }

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }

    public function destroy(Rating $rating)
    {
        abort_if($rating->user_id !== Auth::id(), 403);
        $rating->delete();

        return back()->with('success', 'Ulasan dihapus.');
    }
}