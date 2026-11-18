<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Tambahkan 'tipBookmarks' jika ingin menghitungnya juga di halaman index
        $query = User::withCount(['bookmarks', 'ratings', 'tipBookmarks']);

        /* Filter role */
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        /* Search */
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn($qb) =>
                $qb->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
            );
        }

        /* Sort */
        match ($request->sort) {
            'name_asc'  => $query->orderBy('name'),
            'name_desc' => $query->orderByDesc('name'),
            default     => $query->latest(),
        };

        $users = $query->paginate(10)->withQueryString();

        $totalUsers         = User::count();
        $totalAdmins        = User::where('role', 'admin')->count();
        $newUsersThisMonth  = User::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count();

        return view('admin.users.daftar_user', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'newUsersThisMonth'
        ));
    }

    public function show(User $user)
    {
        // SUDAH DIPERBAIKI: Menggunakan 'tipBookmarks' sesuai Model User
        $user->loadCount(['bookmarks', 'ratings', 'tipBookmarks']);
        
        $user->load([
            'bookmarks.recipe.category',
            'ratings.recipe',
        ]);

        return view('admin.users.detail_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Peran {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }

    public function destroy(User $user)
    {
        /* Cegah hapus diri sendiri */
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun {$name} berhasil dihapus.");
    }
}