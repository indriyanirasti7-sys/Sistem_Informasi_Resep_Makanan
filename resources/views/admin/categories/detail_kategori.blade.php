@extends('admin.layout')

@section('title', 'Detail Kategori — L\'Art de Cuisine')
@section('breadcrumb', $category->name)

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <a href="{{ route('admin.categories.index') }}"
       class="inline-flex items-center gap-1.5 text-on-surface-variant hover:text-primary text-xs font-bold w-fit transition">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        <span>Kembali ke Daftar Kategori</span>
    </a>

    {{-- Hero Card --}}
    <div class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center gap-6">

            {{-- Icon --}}
            <div class="w-20 h-20 rounded-3xl bg-secondary/15 flex items-center justify-center text-secondary shrink-0">
                <span class="material-symbols-outlined text-[44px]">{{ $category->icon ?? 'restaurant' }}</span>
            </div>

            {{-- Info --}}
            <div class="flex flex-col flex-1 min-w-0">
                <div class="flex items-center gap-2 text-secondary">
                    <span class="material-symbols-outlined text-lg">category</span>
                    <span class="text-[11px] uppercase tracking-widest font-bold">Detail Kategori</span>
                </div>
                <h1 class="font-display text-4xl text-primary tracking-tight font-bold mt-1">
                    {{ $category->name }}
                </h1>
                <div class="flex items-center gap-3 mt-2 flex-wrap">
                    <code class="text-xs bg-surface-container-low px-3 py-1 rounded-full text-on-surface-variant">
                        /kategori/{{ $category->slug }}
                    </code>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/70 text-on-secondary-container text-[11px] font-bold">
                        <span class="material-symbols-outlined text-[14px]">menu_book</span>
                        {{ $category->recipes_count ?? 0 }} resep
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold
                                 {{ ($category->is_active ?? true) ? 'bg-secondary/15 text-secondary' : 'bg-surface-container text-on-surface-variant' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ ($category->is_active ?? true) ? 'bg-secondary' : 'bg-outline' }}"></span>
                        {{ ($category->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    <span>Edit</span>
                </a>

                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}"
                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2.5 text-error hover:bg-error-container/60 rounded-full transition" title="Hapus">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Deskripsi --}}
        @if ($category->description)
            <p class="text-sm text-on-surface-variant mt-6 leading-relaxed max-w-3xl">
                {{ $category->description }}
            </p>
        @endif
    </div>
</header>

{{-- ========== STATS ========== --}}
<section class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="text-xs text-on-surface-variant font-medium">Jumlah Resep</span>
            <span class="font-display text-3xl text-primary font-bold mt-1">{{ $category->recipes_count ?? 0 }}</span>
            <span class="text-[11px] text-on-surface-variant/80 mt-0.5">Total resep terdaftar</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[24px]">menu_book</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="text-xs text-on-surface-variant font-medium">Dibuat</span>
            <span class="font-display text-xl text-primary font-bold mt-1">
                {{ $category->created_at->translatedFormat('d M Y') }}
            </span>
            <span class="text-[11px] text-on-surface-variant/80 mt-0.5">{{ $category->created_at->diffForHumans() }}</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[24px]">calendar_today</span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
        <div class="flex flex-col">
            <span class="text-xs text-on-surface-variant font-medium">Terakhir Diperbarui</span>
            <span class="font-display text-xl text-primary font-bold mt-1">
                {{ $category->updated_at->translatedFormat('d M Y') }}
            </span>
            <span class="text-[11px] text-on-surface-variant/80 mt-0.5">{{ $category->updated_at->diffForHumans() }}</span>
        </div>
        <div class="w-12 h-12 rounded-full bg-secondary-container/70 flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-[24px]">schedule</span>
        </div>
    </div>
</section>

{{-- ========== DAFTAR RESEP DALAM KATEGORI ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
    <div class="flex items-center justify-between mb-5">
        <div class="flex flex-col">
            <h2 class="font-display text-2xl text-primary font-bold">Resep dalam Kategori</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">
                Daftar hidangan yang termasuk dalam klasifikasi ini.
            </p>
        </div>

        @if (!empty($category->recipes_count))
            <a href="{{ route('admin.recipes.index', ['category' => $category->id]) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold text-primary hover:bg-surface-container transition">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        @endif
    </div>

    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/60 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl">Nama Resep</th>
                    <th class="py-3.5 px-4">Durasi</th>
                    <th class="py-3.5 px-4">Porsi</th>
                    <th class="py-3.5 px-4 rounded-r-2xl text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse (($recipes ?? collect()) as $recipe)
                    <tr class="hover:bg-surface-container-low/40 transition group">
                        <td class="py-4 px-4">
                            <span class="text-sm font-bold text-primary group-hover:text-tertiary-container transition">
                                {{ $recipe->title ?? $recipe->name }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ $recipe->duration ?? '—' }} menit
                        </td>
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ $recipe->servings ?? '—' }} porsi
                        </td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('admin.recipes.show', $recipe->id) }}"
                               class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition inline-flex" title="Lihat">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">restaurant_menu</span>
                                </div>
                                <h3 class="font-display text-xl text-primary font-bold">Belum Ada Resep</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Kategori ini belum memiliki resep terdaftar.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection