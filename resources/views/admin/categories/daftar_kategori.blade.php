@extends('admin.layout')

@section('title', 'Kelola Kategori — L\'Art de Cuisine')
@section('breadcrumb', 'Kelola Kategori')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined text-lg">category</span>
                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Inventaris Gastronomi</span>
            </div>
            <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Kelola Kategori</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Atur klasifikasi menu kuliner: sarapan, makan siang, dessert, dan lainnya untuk memudahkan navigasi pengunjung.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="group inline-flex items-center gap-2.5 px-6 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:rotate-90">add</span>
            <span>Tambah Kategori</span>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-2">
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Kategori</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $categories->total() }}</span>
                    <span class="text-xs text-on-surface-variant">kategori</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Semua kategori terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">category</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Kategori Terpakai</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">
                        {{ $categories->where('recipes_count', '>', 0)->count() }}
                    </span>
                    <span class="text-xs text-on-surface-variant">aktif</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Kategori dengan resep</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">check_circle</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Resep</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">
                        {{ $categories->sum('recipes_count') }}
                    </span>
                    <span class="text-xs text-on-surface-variant">resep</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Terdistribusi di semua kategori</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-container/70 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">restaurant_menu</span>
            </div>
        </div>
    </div>
</header>

{{-- ========== TABEL KATEGORI ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm overflow-hidden">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/60 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl w-20">Icon</th>
                    <th class="py-3.5 px-4">Nama Kategori</th>
                    <th class="py-3.5 px-4">Slug</th>
                    <th class="py-3.5 px-4">Jumlah Resep</th>
                    <th class="py-3.5 px-4">Dibuat</th>
                    <th class="py-3.5 px-4 text-right rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($categories as $category)
                    <tr class="hover:bg-surface-container-low/40 transition group">
                        <td class="py-4 px-4">
                            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary shadow-sm">
                                <span class="material-symbols-outlined text-[24px]">
                                    {{ $category->icon ?? 'restaurant' }}
                                </span>
                            </div>
                        </td>

                        <td class="py-4 px-4">
                            <span class="text-base font-bold text-primary group-hover:text-tertiary-container transition">
                                {{ $category->name }}
                            </span>
                        </td>

                        <td class="py-4 px-4">
                            <code class="text-xs bg-surface-container-low px-2.5 py-1 rounded-full text-on-surface-variant">
                                {{ $category->slug }}
                            </code>
                        </td>

                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/70 text-on-secondary-container text-[11px] font-bold">
                                <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                {{ $category->recipes_count }} resep
                            </span>
                        </td>

                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ $category->created_at->translatedFormat('d M Y') }}
                        </td>

                        <td class="py-4 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.categories.show', $category->id) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}"
                                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')" class="inline">
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
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">category</span>
                                </div>
                                <h3 class="font-display text-xl text-primary font-bold">Belum Ada Kategori</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Mulai buat kategori pertama untuk klasifikasi resep.
                                </p>
                                <a href="{{ route('admin.categories.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Tambah Kategori
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($categories->hasPages())
        <div class="mt-6 pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-surface-container">
            <span class="text-xs text-on-surface-variant">
                Menampilkan <strong class="text-primary font-bold">{{ $categories->firstItem() }}-{{ $categories->lastItem() }}</strong>
                dari <strong class="text-primary font-bold">{{ $categories->total() }}</strong> kategori
            </span>

            <div class="flex items-center gap-1.5">
                @if (!$categories->onFirstPage())
                    <a href="{{ $categories->previousPageUrl() }}"
                       class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                        ← Sebelumnya
                    </a>
                @endif

                @foreach ($categories->getUrlRange(max(1, $categories->currentPage() - 2), min($categories->lastPage(), $categories->currentPage() + 2)) as $page => $url)
                    @if ($page == $categories->currentPage())
                        <span class="w-8 h-8 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="w-8 h-8 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}"
                       class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                        Berikutnya →
                    </a>
                @endif
            </div>
        </div>
    @endif
</section>

@endsection