@extends('layouts.app')

@section('title', 'Daftar Resep — L\'Art de Cuisine')

@push('styles')
<style>
    .line-clamp-1 { display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
<div class="relative w-full px-5 lg:px-12 pt-32 pb-16">
    {{-- Ambient Glow --}}
    <div class="absolute top-12 left-1/3 w-96 h-96 bg-primary-fixed/30 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-48 right-10 w-80 h-80 bg-secondary-fixed/35 rounded-full blur-3xl pointer-events-none -z-10"></div>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-on-surface-variant mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">home</span>
            Beranda
        </a>
        <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
        <span class="text-primary font-semibold">Daftar Resep</span>
    </nav>

    {{-- Hero --}}
    <div class="flex flex-col gap-3 max-w-3xl mb-10">
        <div class="inline-flex items-center gap-2 self-start px-4 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[11px] uppercase tracking-wider font-bold">
            <span class="material-symbols-outlined text-[14px]">local_florist</span>
            Kurasi Gastronomi Nusantara
        </div>
        <h1 class="font-display text-4xl lg:text-5xl font-semibold text-primary tracking-tight">
            Jelajahi Resep Pilihan
        </h1>
        <p class="text-base lg:text-lg text-on-surface-variant leading-relaxed">
            Temukan inspirasi kreasi hidangan terbaik, takaran bumbu presisi, dan teknik memasak otentik dari dapur kurator kami.
        </p>
    </div>

    {{-- Search Bar --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('recipes.daftar_resep') }}" 
              class="relative w-full flex items-center bg-surface-container-lowest rounded-full shadow-sm p-2 transition focus-within:shadow-md">
            <div class="flex items-center justify-center pl-4 pr-2 text-primary">
                <span class="material-symbols-outlined text-[24px]">search</span>
            </div>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari resep berdasarkan judul, bahan utama, atau nama chef..."
                   class="w-full bg-transparent text-sm text-on-surface placeholder:text-outline focus:outline-none py-2"/>
            <div class="flex items-center gap-2 pr-2">
                @if (request('q'))
                    <a href="{{ route('recipes.daftar_resep') }}"
                       class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:text-on-surface hover:bg-surface-container transition"
                       title="Bersihkan Pencarian">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
                <button type="submit"
                        class="px-4 py-2.5 bg-primary-container text-white rounded-full text-xs font-bold flex items-center gap-2 hover:bg-primary transition">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Category Filter --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 scrollbar-none">
        <a href="{{ route('recipes.daftar_resep', array_merge(request()->except('category'), [])) }}"
           class="px-5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition
                  {{ !request('category') ? 'bg-primary-container text-white shadow-sm' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('recipes.daftar_resep', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
               class="px-5 py-2 rounded-full text-xs font-bold whitespace-nowrap transition
                      {{ request('category') === $cat->slug ? 'bg-primary-container text-white shadow-sm' : 'bg-surface-container text-on-surface hover:bg-surface-container-high' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    {{-- Difficulty & Sort Row --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8 p-4 rounded-2xl bg-surface-container-lowest shadow-sm">

        {{-- Difficulty Chips --}}
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-[11px] uppercase tracking-wider text-outline font-bold mr-1">Tingkat:</span>
            @foreach (['Mudah', 'Sedang', 'Sulit'] as $level)
                <a href="{{ route('recipes.daftar_resep', array_merge(request()->except('difficulty'), ['difficulty' => $level])) }}"
                   class="px-4 py-1 rounded-full text-xs font-bold transition
                          {{ request('difficulty') === $level ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant hover:bg-secondary hover:text-white' }}">
                    {{ $level }}
                </a>
            @endforeach
            @if (request('difficulty'))
                <a href="{{ route('recipes.daftar_resep', request()->except('difficulty')) }}"
                   class="px-3 py-1 rounded-full text-xs text-error hover:bg-error-container/30 transition">
                    ✕ Reset
                </a>
            @endif
        </div>

        {{-- Sort --}}
        <form method="GET" action="{{ route('recipes.daftar_resep') }}" class="flex items-center gap-3">
            @foreach (request()->except('sort') as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
            <span class="text-[11px] text-outline hidden sm:inline">Urutkan:</span>
            <div class="relative inline-flex items-center">
                <select name="sort" onchange="this.form.submit()"
                        class="appearance-none bg-surface-container py-1.5 pl-4 pr-8 rounded-full text-xs font-bold text-on-surface focus:outline-none cursor-pointer">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="duration" {{ request('sort') === 'duration' ? 'selected' : '' }}>Durasi Tercepat</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
                <span class="material-symbols-outlined absolute right-2 text-outline pointer-events-none text-[18px]">arrow_drop_down</span>
            </div>
        </form>
    </div>

    {{-- Counter --}}
    <div class="flex items-center justify-between mb-6 text-sm text-on-surface-variant">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-secondary"></span>
            <span>Menampilkan <strong class="text-on-surface">{{ $recipes->count() }}</strong> dari <strong class="text-on-surface">{{ $recipes->total() }}</strong> resep</span>
        </div>
        <span class="text-outline text-xs hidden sm:inline">Diperbarui setiap minggu</span>
    </div>

    {{-- RECIPE GRID --}}
        {{-- RECIPE GRID --}}
    @if ($recipes->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">            @foreach ($recipes as $recipe)
                @php
                    $diffColor = match($recipe->difficulty) {
                        'Mudah'  => 'bg-secondary-container text-on-secondary-container',
                        'Sedang' => 'bg-primary-fixed text-primary',
                        'Sulit'  => 'bg-error-container text-on-error-container',
                        default  => 'bg-surface-container-high',
                    };
                @endphp

                {{-- Card: Flex Row di HP, Flex Col di Desktop --}}
                <article class="group flex flex-row md:flex-col bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                    
                    {{-- IMAGE (Kiri di HP, Atas di Desktop) --}}
                    <div class="relative w-[120px] sm:w-44 md:w-full aspect-square md:aspect-[4/3] shrink-0 overflow-hidden bg-surface-container">
                        <a href="{{ route('recipes.show', $recipe->slug) }}" class="block w-full h-full">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                                 alt="{{ $recipe->title }}"/>
                        </a>

                        {{-- Badge Kategori (Desktop Only) --}}
                        <div class="absolute top-3 left-3 hidden md:flex flex-wrap gap-1">
                            @if ($recipe->category)
                                <span class="px-3 py-0.5 rounded-full bg-white/90 backdrop-blur-md text-primary text-[11px] font-bold shadow-sm">
                                    {{ $recipe->category->name }}
                                </span>
                            @endif
                            <span class="px-3 py-0.5 rounded-full {{ $diffColor }} text-[11px] font-bold">
                                {{ $recipe->difficulty }}
                            </span>
                        </div>

                        {{-- Bookmark Button (Desktop Only) --}}
                        @auth
                            <button type="button" data-recipe-id="{{ $recipe->id }}"
                                    class="bookmark-btn hidden md:flex absolute top-3 right-3 w-9 h-9 rounded-full bg-white/80 backdrop-blur-md text-on-surface items-center justify-center hover:bg-white transition shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">favorite</span>
                            </button>
                        @endauth
                    </div>

                    {{-- BODY (Kanan di HP, Bawah di Desktop) --}}
                    <div class="p-3 md:p-5 flex flex-col flex-1 justify-between min-w-0">
                        
                        <div class="flex flex-col gap-1 md:gap-2">
                            {{-- Rating (Desktop Only) --}}
                            <div class="hidden md:flex items-center gap-1.5 text-on-tertiary-container mb-1">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-base font-bold text-on-surface">{{ $recipe->average_rating }}</span>
                                <span class="text-xs text-outline">({{ $recipe->rating_count }} ulasan)</span>
                            </div>

                            {{-- Title --}}
                            <a href="{{ route('recipes.show', $recipe->slug) }}">
                                <h3 class="font-display text-[14px] md:text-lg font-bold text-primary group-hover:text-primary-container transition line-clamp-2 leading-snug">
                                    {{ $recipe->title }}
                                </h3>
                            </a>

                            {{-- Author (Mobile Only) --}}
                            <div class="flex items-center gap-1.5 mt-1 md:hidden">
                                <div class="w-4 h-4 rounded-full overflow-hidden bg-surface-container shrink-0">
                                    <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($recipe->user->name ?? 'Chef') }}&background=5a3a22&color=fff&bold=true"/>
                                </div>
                                <span class="text-[11px] text-on-surface-variant truncate">
                                    {{ $recipe->user->name ?? 'Tim Dapur' }}
                                </span>
                            </div>

                            {{-- Description (Desktop Only) --}}
                            <p class="hidden md:block text-sm text-on-surface-variant mb-4 line-clamp-2 mt-1">
                                {{ $recipe->description }}
                            </p>
                        </div>

                        {{-- FOOTER SECTION --}}
                        <div>
                            {{-- Metrics Ringkas (Mobile Only) --}}
                            <div class="flex items-center gap-3 mt-2 pt-2 border-t border-surface-container/50 md:hidden">
                                <span class="flex items-center gap-1 text-[11px] font-bold text-primary">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary-container" style="font-variation-settings: 'FILL' 1;">star</span>
                                    {{ $recipe->average_rating }}
                                </span>
                                <span class="flex items-center gap-1 text-[11px] text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[14px] text-error" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                    {{ $recipe->bookmarks_count ?? 0 }}
                                </span>
                                <span class="flex items-center gap-1 text-[11px] text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">timer</span>
                                    {{ $recipe->duration_minutes ?? '-' }}m
                                </span>
                            </div>

                            {{-- Original Metrics Grid (Desktop Only) --}}
                            <div class="hidden md:grid grid-cols-4 gap-1 p-2 rounded-2xl bg-surface-container-low mb-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                                    <span class="text-[10px] text-on-surface font-semibold mt-0.5">{{ $recipe->duration_minutes ?? '-' }} mnt</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">group</span>
                                    <span class="text-[10px] text-on-surface font-semibold mt-0.5">{{ $recipe->servings }} Porsi</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">local_fire_department</span>
                                    <span class="text-[10px] text-on-surface font-semibold mt-0.5">{{ $recipe->calories ?? '-' }} kkal</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">visibility</span>
                                    <span class="text-[10px] text-on-surface font-semibold mt-0.5">{{ $recipe->views }}</span>
                                </div>
                            </div>

                            {{-- Chef & Button (Desktop Only) --}}
                            <div class="hidden md:flex mt-auto pt-2 items-center justify-between border-t border-surface-container pt-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-surface-container">
                                        <img class="w-full h-full object-cover"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($recipe->user->name ?? 'Chef') }}&background=5a3a22&color=fff&bold=true"/>
                                    </div>
                                    <span class="text-[11px] text-on-surface-variant font-medium">
                                        {{ Str::limit($recipe->user->name ?? 'Tim Dapur', 12) }}
                                    </span>
                                </div>
                                <a href="{{ route('recipes.show', $recipe->slug) }}"
                                   class="inline-flex items-center gap-1 px-4 py-2 bg-primary-container text-white rounded-full text-[11px] font-bold hover:bg-primary transition shadow-sm">
                                    <span>Lihat</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </article>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 bg-surface-container-lowest rounded-3xl shadow-sm mb-12">
            <span class="material-symbols-outlined text-[64px] text-outline block mb-4">search_off</span>
            <h3 class="font-display text-xl font-bold text-primary mb-2">Tidak ada resep ditemukan</h3>
            <p class="text-sm text-on-surface-variant mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
            <a href="{{ route('recipes.daftar_resep') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-primary-container text-white rounded-full text-sm font-bold hover:bg-primary transition">
                <span class="material-symbols-outlined text-[18px]">refresh</span>
                <span>Reset Filter</span>
            </a>
        </div>
    @endif

    {{-- Pantry Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary via-primary-container to-tertiary p-6 lg:p-8 text-white shadow-lg mb-8">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-secondary/20 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-start gap-4 max-w-2xl">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-primary-fixed shrink-0">
                    <span class="material-symbols-outlined text-[32px]">kitchen</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-[11px] text-primary-fixed uppercase tracking-wider font-bold">Inovasi Dapur Praktis</span>
                    <h2 class="font-display text-xl lg:text-2xl font-semibold">Punya Bahan Tertentu di Dapur?</h2>
                    <p class="text-sm text-white/80">
                        Gunakan fitur <strong class="text-white">Asisten Kulkas Pintar</strong> untuk menemukan resep yang bisa langsung Anda olah dengan bahan yang tersedia hari ini.
                    </p>
                </div>
            </div>
            <button type="button"
                    class="px-6 py-3 rounded-full bg-secondary text-white text-sm font-bold hover:opacity-90 transition flex items-center gap-2 shadow-md shrink-0"
                    onclick="showToast('Fitur segera hadir!', 'auto_fix_high')">
                <span class="material-symbols-outlined text-[18px]">auto_fix_high</span>
                <span>Buka Filter Bahan Dapur</span>
            </button>
        </div>
    </div>

    {{-- Pagination --}}
    @if ($recipes->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-surface-container-lowest shadow-sm">

            {{-- Prev --}}
            @if ($recipes->onFirstPage())
                <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-on-surface-variant text-xs font-semibold opacity-40 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Sebelumnya</span>
                </span>
            @else
                <a href="{{ $recipes->previousPageUrl() }}"
                   class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-on-surface-variant text-xs font-semibold hover:bg-surface-container transition">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Sebelumnya</span>
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="flex items-center gap-1">
                @foreach ($recipes->getUrlRange(max(1, $recipes->currentPage() - 2), min($recipes->lastPage(), $recipes->currentPage() + 2)) as $page => $url)
                    @if ($page == $recipes->currentPage())
                        <span class="w-10 h-10 rounded-full bg-primary-container text-white text-xs font-bold flex items-center justify-center shadow-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="w-10 h-10 rounded-full text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if ($recipes->hasMorePages())
                <a href="{{ $recipes->nextPageUrl() }}"
                   class="inline-flex items-center gap-1 px-4 py-2 rounded-full bg-surface-container text-primary text-xs font-bold hover:bg-surface-container-high transition shadow-sm">
                    <span>Berikutnya</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-on-surface-variant text-xs font-semibold opacity-40 cursor-not-allowed">
                    <span>Berikutnya</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </span>
            @endif
        </div>
    @endif

</div>

{{-- Toast --}}
<div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-full shadow-lg"
     id="toastNotification">
    <span class="material-symbols-outlined text-[20px]" id="toastIcon">check_circle</span>
    <span class="text-sm font-semibold" id="toastMessage">Berhasil!</span>
</div>

@endsection

@push('scripts')
<script>
function showToast(message, icon = 'check_circle') {
    const toast = document.getElementById('toastNotification');
    const msg = document.getElementById('toastMessage');
    const ic = document.getElementById('toastIcon');
    if (!toast) return;
    msg.textContent = message;
    ic.textContent = icon;
    toast.classList.remove('translate-y-24', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-24', 'opacity-0');
    }, 2800);
}

// Bookmark toggle (AJAX)
document.querySelectorAll('.bookmark-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        const id = btn.dataset.recipeId;
        const icon = btn.querySelector('.material-symbols-outlined');
        try {
            const res = await fetch(`/bookmark/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();
            icon.style.fontVariationSettings = data.status === 'added' ? "'FILL' 1" : "'FILL' 0";
            icon.classList.toggle('text-error', data.status === 'added');
            showToast(data.message, data.status === 'added' ? 'favorite' : 'favorite_border');
        } catch (err) {
            console.error(err);
        }
    });
});
</script>
@endpush