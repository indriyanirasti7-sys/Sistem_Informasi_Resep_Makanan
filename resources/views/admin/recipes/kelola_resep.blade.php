@extends('admin.layout')

@section('title', 'Kelola Resep — Admin L\'Art de Cuisine')
@section('breadcrumb', 'Kelola Resep')

@section('content')

{{-- ========== SECTION 1: HEADER & STATS ========== --}}
<section class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined text-lg">restaurant_menu</span>
                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Inventaris Gastronomi</span>
            </div>
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Kelola Resep</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Tambah, kurasi, ubah, dan atur sajian kuliner nusantara yang tampil di etalase L'Art de Cuisine.
            </p>
        </div>

        <a href="{{ route('admin.recipes.create') }}"
           class="group inline-flex items-center gap-2.5 px-6 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:rotate-90">add</span>
            <span>Tambah Resep Baru</span>
        </a>
    </div>

    {{-- 3 Mini Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-2">
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Koleksi</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-['Playfair_Display'] text-3xl text-primary font-bold">{{ $stats['total'] ?? \App\Models\Recipe::count() }}</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Semua kreasi terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">menu_book</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Dipublikasikan</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-['Playfair_Display'] text-3xl text-primary font-bold">{{ $stats['published'] ?? \App\Models\Recipe::where('status','published')->count() }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold">Aktif</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Dapat diakses publik</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-container/50 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">public</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Draft Resep</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-['Playfair_Display'] text-3xl text-primary font-bold">{{ $stats['draft'] ?? \App\Models\Recipe::where('status','draft')->count() }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">Uji Coba</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Menunggu finalisasi rasa</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-tertiary">
                <span class="material-symbols-outlined text-[24px]">edit_note</span>
            </div>
        </div>
    </div>
</section>

{{-- ========== SECTION 2: FILTER ========== --}}
<section class="bg-surface-container-lowest p-4 md:p-5 rounded-2xl shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
    <form method="GET" action="{{ route('admin.recipes.index') }}" class="flex flex-wrap items-center gap-3 flex-1 min-w-[280px]">

        <div class="relative flex-1 min-w-[240px] max-w-md">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari judul resep, bahan, bumbu..."
                   class="w-full bg-surface-container-low text-primary placeholder:text-outline pl-10 pr-4 py-2.5 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition"/>
        </div>

        <div class="relative">
            <select name="category"
                    class="appearance-none bg-surface-container-low text-primary text-sm font-semibold pl-4 pr-10 py-2.5 rounded-full focus:outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach (\App\Models\Category::orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary pointer-events-none text-[18px]">expand_more</span>
        </div>

        <div class="relative">
            <select name="status"
                    class="appearance-none bg-surface-container-low text-primary text-sm font-semibold pl-4 pr-10 py-2.5 rounded-full focus:outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary pointer-events-none text-[18px]">expand_more</span>
        </div>

        <button type="submit"
                class="px-5 py-2.5 rounded-full bg-secondary text-white text-xs font-bold hover:opacity-90 transition">
            Filter
        </button>

        @if (request()->hasAny(['q', 'category', 'status']))
            <a href="{{ route('admin.recipes.index') }}"
               class="flex items-center gap-1.5 px-4 py-2.5 text-on-surface-variant hover:text-primary hover:bg-surface-container-low rounded-full transition text-xs font-semibold">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                <span>Reset</span>
            </a>
        @endif
    </form>
</section>

{{-- ========== SECTION 3: TABEL ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm overflow-hidden">

    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/60 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl">Foto</th>
                    <th class="py-3.5 px-4">Judul Resep</th>
                    <th class="py-3.5 px-3">Kategori</th>
                    <th class="py-3.5 px-3">Kesulitan</th>
                    <th class="py-3.5 px-3">Durasi</th>
                    <th class="py-3.5 px-3">Kalori</th>
                    <th class="py-3.5 px-3">Rating</th>
                    <th class="py-3.5 px-3">Dilihat</th>
                    <th class="py-3.5 px-3">Status</th>
                    <th class="py-3.5 px-4 text-right rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($recipes as $recipe)
                    @php
                        $diffColor = match($recipe->difficulty) {
                            'Mudah'  => 'bg-surface-container text-on-surface-variant',
                            'Sedang' => 'bg-primary-fixed text-primary',
                            'Sulit'  => 'bg-error-container text-on-error-container',
                            default  => 'bg-surface-container',
                        };
                    @endphp
                    <tr class="hover:bg-surface-container-low/40 transition group">

                        {{-- Foto --}}
                        <td class="py-4 px-4">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden shadow-sm bg-surface-container">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=200' }}"
                                     alt="{{ $recipe->title }}"/>
                            </div>
                        </td>

                        {{-- Judul --}}
                        <td class="py-4 px-4 min-w-[200px]">
                            <div class="flex flex-col">
                                <span class="text-base text-primary font-bold group-hover:text-tertiary-container transition line-clamp-1">
                                    {{ $recipe->title }}
                                </span>
                                <span class="text-xs text-on-surface-variant">Oleh {{ $recipe->user->name ?? 'Anonim' }}</span>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td class="py-4 px-3 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full bg-secondary-container/70 text-on-secondary-container text-[11px] font-bold">
                                {{ $recipe->category->name ?? 'Umum' }}
                            </span>
                        </td>

                        {{-- Kesulitan --}}
                        <td class="py-4 px-3 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full {{ $diffColor }} text-[11px] font-bold">
                                {{ $recipe->difficulty }}
                            </span>
                        </td>

                        {{-- Durasi --}}
                        <td class="py-4 px-3 text-xs whitespace-nowrap text-on-surface-variant">{{ $recipe->duration_minutes ?? '-' }} mnt</td>

                        {{-- Kalori --}}
                        <td class="py-4 px-3 text-xs whitespace-nowrap text-on-surface-variant">{{ $recipe->calories ?? '-' }} kkal</td>

                        {{-- Rating --}}
                        <td class="py-4 px-3 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-tertiary" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-xs font-bold text-primary">{{ $recipe->average_rating }}</span>
                                <span class="text-[11px] text-on-surface-variant/70">({{ $recipe->rating_count }})</span>
                            </div>
                        </td>

                        {{-- Dilihat --}}
                        <td class="py-4 px-3 text-xs whitespace-nowrap text-on-surface-variant">{{ number_format($recipe->views) }}</td>

                        {{-- Status --}}
                        <td class="py-4 px-3 whitespace-nowrap">
                            @if ($recipe->status === 'published')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                    Draft
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.recipes.detail_tampilan', $recipe->slug) }}" target="_blank"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.recipes.edit', $recipe->slug) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.recipes.destroy', $recipe->id) }}"
                                      onsubmit="return confirm('Hapus resep {{ $recipe->title }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-error hover:bg-error-container/60 rounded-full transition" title="Hapus">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">menu_book</span>
                                </div>
                                <h3 class="font-['Playfair_Display'] text-xl text-primary font-bold">Belum Ada Resep</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Mulai tambahkan resep pertama ke kurasi L'Art de Cuisine.
                                </p>
                                <a href="{{ route('admin.recipes.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Tambah Resep
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($recipes->hasPages())
        <div class="mt-6 pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-surface-container">
            <span class="text-xs text-on-surface-variant">
                Menampilkan <strong class="text-primary font-bold">{{ $recipes->firstItem() }}-{{ $recipes->lastItem() }}</strong>
                dari <strong class="text-primary font-bold">{{ $recipes->total() }}</strong> resep
            </span>

            <div class="flex items-center gap-1.5">
                @if ($recipes->onFirstPage())
                    <span class="px-3.5 py-1.5 rounded-full text-outline text-xs font-bold cursor-not-allowed">← Sebelumnya</span>
                @else
                    <a href="{{ $recipes->previousPageUrl() }}"
                       class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                        ← Sebelumnya
                    </a>
                @endif

                @foreach ($recipes->getUrlRange(max(1, $recipes->currentPage() - 2), min($recipes->lastPage(), $recipes->currentPage() + 2)) as $page => $url)
                    @if ($page == $recipes->currentPage())
                        <span class="w-8 h-8 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="w-8 h-8 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($recipes->hasMorePages())
                    <a href="{{ $recipes->nextPageUrl() }}"
                       class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                        Berikutnya →
                    </a>
                @else
                    <span class="px-3.5 py-1.5 rounded-full text-outline text-xs font-bold cursor-not-allowed">Berikutnya →</span>
                @endif
            </div>
        </div>
    @endif
</section>

@endsection