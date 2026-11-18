<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil.
     */
    public function edit()
    {
        $user = Auth::user();

        // 1. Hitung total bookmark resep
        $recipeBookmarksCount = method_exists($user, 'bookmarks') ? $user->bookmarks()->count() : 0;

        // 2. Hitung total bookmark tips (jika ada relasi bookmarkedTips / tipBookmarks)
        // Sesuaikan nama fungsi relasinya dengan model User Anda jika berbeda
        $tipBookmarksCount = method_exists($user, 'tipBookmarks') ? $user->tipBookmarks()->count() : 0;
        
        // Total keseluruhan bookmark
        $totalBookmarks = $recipeBookmarksCount + $tipBookmarksCount;

        return view('profile.edit', [
            'user' => $user,
            'totalBookmarks' => $totalBookmarks, // Kirim variabel ini ke view
        ]);
    }

    /**
     * Update data profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Upload avatar kalau ada (disesuaikan dengan folder public/uploads jika Anda memakainya)
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('uploads/' . $user->avatar))) {
                @unlink(public_path('uploads/' . $user->avatar));
            }
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $validated['avatar'] = 'avatars/' . $filename;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}