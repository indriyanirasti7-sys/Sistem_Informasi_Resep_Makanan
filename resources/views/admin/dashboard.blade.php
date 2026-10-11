@extends('admin.layout')

@section('title', 'Dashboard — L\'Art de Cuisine')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="flex flex-col w-full">

    {{-- TOP BANNER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-8 border-b border-surface-container gap-4 pt-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary/15 text-secondary text-[11px] font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    Gastronomie Haute Administration
                </span>
                <span class="text-on-surface-variant text-[11px] tracking-wide">• Versi 3.4.1</span>
            </div>
            <h1 class="font-display text-3xl lg:text-4xl text-primary tracking-tight font-bold">
                Ikhtisar & Manajemen Dapur Resep
            </h1>
            <p class="text-sm text-on-surface-variant mt-1">
                Pantau performa kuliner nusantara, kurasi arsip resep haute cuisine, dan rilis mahakarya terbaru.
            </p>
        </div>

        <div class="flex items-center gap-3 self-start md:self-auto">
            <a href="{{ route('admin.recipes.create') }}"
               class="flex items-center gap-2.5 px-6 py-3 rounded-full bg-primary-container text-white text-sm font-bold shadow-[0_4px_16px_rgba(90,58,34,0.18)] hover:bg-primary transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                <span>Tambah Resep Baru</span>
            </a>
            <a href="{{ route('admin.export.recipes') }}"
               class="flex items-center gap-2 px-5 py-3 rounded-full bg-secondary text-white text-sm font-bold shadow-[0_4px_14px_rgba(85,100,59,0.2)] hover:opacity-95 transition-all">
                <span class="material-symbols-outlined text-[20px]">table_view</span>
                <span>Ekspor ke Excel</span>
            </a>
        </div>
    </div>

    {{-- 4 STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-8">

        {{-- Card 1: Total Resep --}}
        <div class="relative bg-surface-container-lowest rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-surface-container rounded-full opacity-40 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Total Resep Terbit</span>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="font-display text-3xl text-primary font-bold">{{ $stats['recipes_total'] }}</span>
                        <span class="text-xs text-on-surface-variant">resep</span>
                    </div>
                </div>
                <div class="p-3 bg-secondary/15 text-secondary rounded-full">
                    <span class="material-symbols-outlined text-[26px]">menu_book</span>
                </div>
            </div>
            <div class="mt-4 pt-3 flex items-center justify-between border-t border-surface-container relative z-10">
                <span class="inline-flex items-center gap-1 text-[11px] text-secondary font-bold">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    {{ $stats['recipes_published'] }} published
                </span>
                <span class="text-[11px] text-outline">{{ $stats['recipes_draft'] }} draf</span>
            </div>
        </div>

        {{-- Card 2: Total User --}}
        <div class="relative bg-surface-container-lowest rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-secondary-fixed/30 rounded-full opacity-40 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Komunitas Pengguna</span>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="font-display text-3xl text-primary font-bold">{{ number_format($stats['users_total'], 0, ',', '.') }}</span>
                        <span class="text-xs text-on-surface-variant">aktif</span>
                    </div>
                </div>
                <div class="p-3 bg-primary-fixed text-primary rounded-full">
                    <span class="material-symbols-outlined text-[26px]">group</span>
                </div>
            </div>
            <div class="mt-4 pt-3 flex items-center justify-between border-t border-surface-container relative z-10">
                <span class="inline-flex items-center gap-1 text-[11px] text-secondary font-bold">
                    <span class="material-symbols-outlined text-[16px]">north_east</span>
                    Komunitas tumbuh
                </span>
                <span class="text-[11px] text-outline">Total terdaftar</span>
            </div>
        </div>

        {{-- Card 3: Total Ulasan --}}
        <div class="relative bg-surface-container-lowest rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-tertiary-fixed/40 rounded-full opacity-40 group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-start justify-between relative z-10">
                <div>
                    <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Total Ulasan Resep</span>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="font-display text-3xl text-primary font-bold">{{ number_format($stats['ratings_total'], 0, ',', '.') }}</span>
                        <span class="text-xs text-on-surface-variant">ulasan</span>
                    </div>
                </div>
                <div class="p-3 bg-tertiary-container text-white rounded-full">
                    <span class="material-symbols-outlined text-[26px]">reviews</span>
                </div>
            </div>
            <div class="mt-4 pt-3 flex items-center justify-between border-t border-surface-container relative z-10">
                <span class="inline-flex items-center gap-1 text-[11px] text-tertiary-container font-bold">
                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    Feedback aktif
                </span>
                <span class="text-[11px] text-secondary">{{ $stats['categories_total'] }} kategori</span>
            </div>
        </div>

        {{-- Card 4: Resep Terpopuler --}}
        @php $top = $topRecipes->first(); @endphp
        <div class="relative bg-gradient-to-br from-primary-container to-primary rounded-2xl p-6 text-white shadow-md flex flex-col justify-between overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-15 pointer-events-none transform translate-x-4 translate-y-4">
                <span class="material-symbols-outlined text-[110px]">local_fire_department</span>
            </div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] uppercase tracking-widest text-primary-fixed-dim font-bold">Resep Terpopuler</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed text-[11px] font-bold">
                        <span class="material-symbols-outlined text-[14px]">local_fire_department</span> Trending #1
                    </span>
                </div>
                <h2 class="font-display text-lg font-bold mt-2 text-white leading-snug line-clamp-2">
                    {{ $top->title ?? 'Belum ada resep' }}
                </h2>
            </div>
            @if ($top)
            <div class="mt-4 pt-3 flex items-center justify-between border-t border-primary-fixed/20 relative z-10 text-xs text-primary-fixed-dim">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">visibility</span> {{ number_format($top->views) }} tayang</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">bookmark</span> {{ $top->bookmarks()->count() }} simpan</span>
            </div>
            @endif
        </div>
    </div>

    {{-- BAR CHART --}}
    @php
        $chartData = [
            ['month' => 'Jan', 'tradisional' => 60, 'pastry' => 38, 'akses' => '42k'],
            ['month' => 'Feb', 'tradisional' => 72, 'pastry' => 48, 'akses' => '58k'],
            ['month' => 'Mar', 'tradisional' => 85, 'pastry' => 62, 'akses' => '79k'],
            ['month' => 'Apr', 'tradisional' => 94, 'pastry' => 70, 'akses' => '88k'],
            ['month' => 'Mei', 'tradisional' => 80, 'pastry' => 54, 'akses' => '74k'],
            ['month' => 'Jun', 'tradisional' => 100, 'pastry' => 78, 'akses' => '96k', 'peak' => true],
        ];
    @endphp

    <div class="mt-8 bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-surface-container">
            <div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[22px]">bar_chart</span>
                    <h2 class="text-xl text-primary font-bold">Aktivitas Unggahan & Akses Resep 6 Bulan Terakhir</h2>
                </div>
                <p class="text-xs text-on-surface-variant mt-0.5">Perbandingan publikasi kuliner tradisional dengan pastry & dessert.</p>
            </div>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2 text-xs text-on-surface">
                    <span class="w-3.5 h-3.5 rounded-full bg-primary-container"></span>
                    <span>Masakan Tradisional</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-on-surface">
                    <span class="w-3.5 h-3.5 rounded-full bg-secondary"></span>
                    <span>Pastry & Minuman</span>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="grid grid-cols-6 gap-3 sm:gap-6 items-end h-56 w-full px-2 sm:px-6">
                @foreach ($chartData as $d)
                    <div class="flex flex-col items-center h-full justify-end group cursor-pointer">
                        <div class="text-xs {{ !empty($d['peak']) ? 'text-secondary font-bold opacity-100' : 'text-on-surface-variant opacity-0 group-hover:opacity-100' }} transition-opacity mb-2 bg-surface-container-high px-2 py-0.5 rounded shadow-sm">
                            {{ $d['akses'] }} akses
                        </div>
                        <div class="flex items-end gap-1.5 sm:gap-2.5 h-44 w-full justify-center">
                            <div class="w-4 sm:w-8 bg-primary-container rounded-t-md transition-all duration-300 group-hover:opacity-90"
                                 style="height: {{ $d['tradisional'] }}%;"></div>
                            <div class="w-4 sm:w-8 bg-secondary rounded-t-md transition-all duration-300 group-hover:opacity-90"
                                 style="height: {{ $d['pastry'] }}%;"></div>
                        </div>
                        <span class="text-xs {{ !empty($d['peak']) ? 'text-primary font-bold' : 'text-on-surface font-semibold' }} mt-3">
                            {{ $d['month'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RECIPE TABLE --}}
    <div class="mt-10 bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm">
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 pb-6 border-b border-surface-container">
            <div>
                <h2 class="font-display text-2xl text-primary font-bold">Daftar & Kurasi Resep Masakan</h2>
                <p class="text-xs text-on-surface-variant">Kelola arsip resep, tinjau rating, durasi saji, serta status penerbitan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative flex-1 sm:w-72">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                    <input type="text" id="recipeSearchInput" onkeyup="filterRecipesTable()"
                           placeholder="Cari resep, chef, tag..."
                           class="w-full bg-surface-container-low text-on-surface text-sm rounded-full pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-secondary/50 placeholder:text-outline"/>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left border-collapse" id="recipeTable">
                <thead>
                    <tr class="border-b border-surface-container text-on-surface-variant text-[11px] uppercase tracking-wider">
                        <th class="py-4 px-3 w-16">Foto</th>
                        <th class="py-4 px-3">Judul Resep & Chef</th>
                        <th class="py-4 px-3">Kategori</th>
                        <th class="py-4 px-3">Porsi & Waktu</th>
                        <th class="py-4 px-3">Rating</th>
                        <th class="py-4 px-3">Status</th>
                        <th class="py-4 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse ($topRecipes as $r)
                        <tr class="hover:bg-surface-container-low/60 transition-colors group">
                            <td class="py-4 px-3">
                                <img class="w-14 h-14 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform"
                                     src="{{ $r->image ? Storage::url($r->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=200' }}"
                                     alt="{{ $r->title }}"/>
                            </td>
                            <td class="py-4 px-3">
                                <span class="text-base text-primary font-bold block leading-tight">{{ $r->title }}</span>
                                <span class="text-xs text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">person</span>
                                    {{ $r->user->name ?? 'Anonim' }}
                                </span>
                            </td>
                            <td class="py-4 px-3">
                                <span class="inline-flex px-3 py-1 rounded-full bg-primary-fixed text-primary text-[11px] font-semibold">
                                    {{ $r->category->name ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="py-4 px-3">
                                <div class="flex flex-col text-xs text-on-surface">
                                    <span class="font-semibold">{{ $r->servings }} Porsi</span>
                                    <span class="text-on-surface-variant text-[11px] flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">timer</span>
                                        {{ $r->duration_minutes ?? '-' }} mnt
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-tertiary-container text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="text-xs font-bold text-on-surface">{{ $r->average_rating }}</span>
                                    <span class="text-[11px] text-outline">({{ $r->rating_count }})</span>
                                </div>
                            </td>
                            <td class="py-4 px-3">
                                @if ($r->status === 'published')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                        Draf
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.recipes.edit', $r->id) }}"
                                       class="p-2 rounded-full hover:bg-surface-container text-primary transition-all" title="Edit">
                                        <span class="material-symbols-outlined text-[19px]">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.recipes.destroy', $r->id) }}"
                                          onsubmit="return confirm('Hapus resep ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-full hover:bg-error-container text-error transition-all" title="Hapus">
                                            <span class="material-symbols-outlined text-[19px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-[40px] block mb-2 opacity-40">menu_book</span>
                                Belum ada resep. Klik "Tambah Resep Baru" untuk mulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-surface-container mt-4">
            <span class="text-xs text-on-surface-variant" id="tableCountText">
                Menampilkan {{ $topRecipes->count() }} resep terbaru
            </span>
            <a href="{{ route('admin.recipes.index') }}"
               class="px-5 py-2 rounded-full bg-primary-container text-white text-xs font-bold hover:bg-primary transition">
                Lihat Semua Resep →
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function filterRecipesTable() {
    const searchVal = (document.getElementById('recipeSearchInput')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#recipeTable tbody tr');
    let count = 0;
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchVal)) {
            row.style.display = '';
            count++;
        } else {
            row.style.display = 'none';
        }
    });
    const counter = document.getElementById('tableCountText');
    if (counter) counter.innerText = `Menampilkan ${count} resep`;
}
</script>
@endpush