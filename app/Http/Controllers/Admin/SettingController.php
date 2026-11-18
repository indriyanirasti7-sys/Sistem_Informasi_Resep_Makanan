<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data dari file settings.json jika ada
        $settings = [];
        if (Storage::exists('settings.json')) {
            $settings = json_decode(Storage::get('settings.json'), true);
        }

        return view('admin.settings.pengaturan', compact('settings'));
    }

    // Fungsi untuk menyimpan Tagline & Deskripsi
    public function update(Request $request)
    {
        $request->validate([
            'site_tagline' => 'required|string|max:100',
            'site_description' => 'required|string|max:160',
        ]);

        // Simpan data ke file JSON (bisa diganti ke database nanti jika sudah ada tabelnya)
        $settings = [
            'tagline' => $request->site_tagline,
            'description' => $request->site_description,
        ];

        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Pengaturan situs berhasil disimpan!');
    }

    // Fungsi untuk mengganti Kata Sandi
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed', // 'confirmed' mengecek new_password_confirmation
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui!');
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}