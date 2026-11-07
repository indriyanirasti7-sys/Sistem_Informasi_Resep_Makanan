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

        public function toggleVote(Request $request, \App\Models\Rating $rating)
    {
        $request->validate(['vote_type' => 'required|in:like,dislike']);
        $userId = auth()->id();

        $existingVote = \App\Models\RatingVote::where('user_id', $userId)
                        ->where('rating_id', $rating->id)
                        ->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $request->vote_type) {
                $existingVote->delete();
                return response()->json(['status' => 'removed']);
            } else {
                
                $existingVote->update(['vote_type' => $request->vote_type]);
                return response()->json(['status' => 'updated']);
            }
        }

        
        \App\Models\RatingVote::create([
            'user_id' => $userId,
            'rating_id' => $rating->id,
            'vote_type' => $request->vote_type
        ]);

        return response()->json(['status' => 'added']);
    }

    public function destroy(Rating $rating)
    {
        abort_if($rating->user_id !== Auth::id(), 403);
        $rating->delete();

        return back()->with('success', 'Ulasan dihapus.');
    }
}