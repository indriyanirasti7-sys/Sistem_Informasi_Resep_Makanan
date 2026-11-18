<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('recipes')->latest()->paginate(10);

        return view('admin.categories.daftar_kategori', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.tambah');
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk 'image'
        $validated = $request->validate([
            'name'  => 'required|string|max:50|unique:categories,name',
            'icon'  => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'image' => $imagePath, // Simpan path gambar ke database
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $category->load(['recipes' => fn($q) => $q->latest()->limit(10)]);

        return view('admin.categories.detail_kategori', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Tambahkan validasi untuk 'image'
        $validated = $request->validate([
            'name'  => 'required|string|max:50|unique:categories,name,' . $category->id,
            'icon'  => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $category->image; // Simpan path gambar lama sebagai default

        // Jika user mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage (jika ada)
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? null,
            'image' => $imagePath, // Update path gambar
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Hapus file gambar dari storage sebelum menghapus data di database
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}