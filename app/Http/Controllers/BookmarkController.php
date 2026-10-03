<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookmarks = Bookmark::with(['recipe.category', 'recipe.ratings'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(9);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Recipe $recipe)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $status = 'removed';
            $message = 'Resep dihapus dari bookmark.';
        } else {
            Bookmark::create([
                'user_id'   => Auth::id(),
                'recipe_id' => $recipe->id,
            ]);
            $status = 'added';
            $message = 'Resep ditambahkan ke bookmark.';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'status'  => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Bookmark $bookmark)
    {
        abort_if($bookmark->user_id !== Auth::id(), 403);
        $bookmark->delete();

        return back()->with('success', 'Bookmark dihapus.');
    }
}