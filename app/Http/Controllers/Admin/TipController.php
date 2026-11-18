<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TipController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan 'updated_at' terbaru agar data yang baru ditambah/diupdate langsung di posisi ke-1
        $tips = Tip::with('user')->latest('updated_at')->paginate(9);

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
        return view('admin.tips.tambah_tips');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'difficulty' => 'nullable|string|max:50',
            'summary'    => 'nullable|string|max:300',
            'content'    => 'required|string',
            'image'      => 'nullable|image|max:5120',
            'status'     => 'nullable|in:draft,published',
        ]);

        $validated['user_id'] = auth()->id(); 
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tips', 'public');
        }

        Tip::create($validated);

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil ditambahkan.');
    }
 
    public function detail(Tip $tip)
    {
        return view('admin.tips.detail', compact('tip'));
    }

    public function edit(Tip $tip)
    {
        return view('admin.tips.edit', compact('tip'));
    }

    public function update(Request $request, Tip $tip)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'difficulty' => 'nullable|string|max:50',
            'summary'    => 'nullable|string|max:300',
            'content'    => 'required|string',
            'image'      => 'nullable|image|max:5120',
            'status'     => 'nullable|in:draft,published', 
        ]);

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada agar storage tidak menumpuk
            if ($tip->image && Storage::disk('public')->exists($tip->image)) {
                Storage::disk('public')->delete($tip->image);
            }
            $validated['image'] = $request->file('image')->store('tips', 'public');
        }

        $tip->update($validated);

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil diperbarui.');
    }

    public function destroy(Tip $tip)
    {
        if ($tip->image && Storage::disk('public')->exists($tip->image)) {
            Storage::disk('public')->delete($tip->image);
        }

        $tip->delete();

        return redirect()
            ->route('admin.tips.index')
            ->with('success', 'Tips berhasil dihapus.');
    }
}