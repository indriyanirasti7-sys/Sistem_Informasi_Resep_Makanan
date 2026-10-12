<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TipController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->latest()->paginate(9);

        $totalTips     = Tip::count();
        $tipsThisMonth = Tip::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        $topAuthor = Tip::selectRaw('user_id, COUNT(*) as total')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->first();

        $topAuthorName  = optional($topAuthor?->user)->name ?? '—';
        $topAuthorCount = $topAuthor->total ?? 0;

        return view('admin.tips.daftar_tips', compact(
            'tips',
            'totalTips',
            'tipsThisMonth',
            'topAuthorName',
            'topAuthorCount'
        ));
    }

    public function create()
    {
        return view('admin.tips.tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $validated['slug']    = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tips', 'public');
        }

        Tip::create($validated);

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil ditambahkan.');
    }

    public function show(Tip $tip)
    {
        return view('admin.tips.show', compact('tip'));
    }

    public function edit(Tip $tip)
    {
        return view('admin.tips.edit', compact('tip'));
    }

    public function update(Request $request, Tip $tip)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:150',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tips', 'public');
        }

        $tip->update($validated);

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil diperbarui.');
    }

    public function destroy(Tip $tip)
    {
        $tip->delete();

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil dihapus.');
    }
}