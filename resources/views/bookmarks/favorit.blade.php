@extends('layouts.app')

@section('title', 'Koleksi Saya — Griya Rasa')

@push('styles')
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-12 pt-8 lg:pt-12 pb-16 bg-surface-container-low/30 min-h-screen">
    
    {{-- ========== HEADER ========== --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 bg-gradient-to-r from-primary/5 via-transparent to-transparent p-6 sm:p-8 rounded-3xl border border-surface-container-high/50">
        <div class="flex flex-col gap-3 max-w-2xl">
            <div class="inline-flex items-center gap-2 self-start px-3.5 py-1.5 rounded-full bg-secondary-container/60 border border-secondary/20 text-secondary w-fit shadow-sm">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                <span class="text-[10px] sm:text-[11px] uppercase tracking-widest font-bold">Koleksi Pribadi Anda</span>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-primary tracking-tight">
                Koleksi <span class="italic text-secondary">Saya</span>
            </h1>
            <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
                Semua resep masakan dan tips dapur yang telah Anda simpan, siap diakses kapan saja.
            </p>
        </div>

        {{-- Statistik Ringkas --}}
        <div class="shrink-0 flex gap-3">
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-surface-container-lowest shadow-sm border border-surface-container">
                <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-primary leading-none">{{ $bookmarks->total() ?? 0 }}</span>
                    <span class="text-[10px] uppercase tracking-wider text-on-surface-variant font-semibold mt-1">Resep</span>
                </div>
            </div>
            <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-surface-container-lowest shadow-sm border border-surface-container">
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-primary leading-none">{{ $bookmarkedTips->count() ?? 0 }}</span>
                    <span class="text-[10px] uppercase tracking-wider text-on-surface-variant font-semibold mt-1">Tips</span>
                </div>
            </div>
        </div>
    </header>

    {{-- ========== TAB MENU ========== --}}
    <div class="flex items-center gap-2 mb-6 border-b border-surface-container-high pb-4 overflow-x-auto no-scrollbar">
        <button onclick="switchTab('resep')" id="tab-btn-resep" class="px-6 py-3 rounded-full bg-primary text-white text-sm font-bold transition-all shadow-sm flex items-center gap-2 whitespace-nowrap">
            <span class="material-symbols-outlined text-[18px]">restaurant_menu</span>
            Resep Tersimpan ({{ $bookmarks->total() ?? 0 }})
        </button>
        <button onclick="switchTab('tips')" id="tab-btn-tips" class="px-6 py-3 rounded-full bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container border border-surface-container-high text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap">
            <span class="material-symbols-outlined text-[18px]">lightbulb</span>
            Tips Tersimpan ({{ $bookmarkedTips->count() ?? 0 }})
        </button>
    </div>

    {{-- ============================================ --}}
    {{-- TAB CONTENT: RESEP --}}
    {{-- ============================================ --}}
    <div id="tab-content-resep" class="tab-content active">
        @if ($bookmarks->total() > 0)
            {{-- Filter Resep --}}
            <section class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 bg-surface-container-lowest p-3 rounded-2xl shadow-sm border border-surface-container">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 px-1">
                    <a href="{{ route('bookmarks.favorit', request()->except('category')) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap
                              {{ !request('category') ? 'bg-primary text-white shadow-sm' : 'text-on-surface-variant hover:bg-surface-container' }}">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('bookmarks.favorit', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
                           class="px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap
                                  {{ request('category') === $cat->slug ? 'bg-primary text-white shadow-sm' : 'text-on-surface-variant hover:bg-surface-container' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('bookmarks.favorit') }}" class="shrink-0 flex items-center gap-2 px-1">
                    @foreach (request()->except('sort') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <div class="relative">
                        <select name="sort" onchange="this.form.submit()" class="appearance-none bg-surface-container-low text-primary text-xs font-bold py-2 pl-4 pr-10 rounded-full focus:outline-none cursor-pointer">
                            <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            <option value="time"   {{ request('sort') === 'time'   ? 'selected' : '' }}>Tercepat</option>
                            <option value="az"     {{ request('sort') === 'az'     ? 'selected' : '' }}>A-Z</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[16px]">expand_more</span>
                    </div>
                </form>
            </section>

            {{-- Tanda Bookmark / Info Tambahan --}}
            <div class="flex items-center justify-between mb-4 px-1">
                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-secondary font-bold">
                    <span class="material-symbols-outlined text-[16px]">bookmark</span>
                    Total {{ $bookmarks->total() }} resep tersimpan
                </div>
                <span class="text-[11px] text-outline">Diperbarui setiap saat</span>
            </div>

            {{-- Grid Resep --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-6 mb-12">
                @foreach ($bookmarks as $bookmark)
                    @php $recipe = $bookmark->recipe; @endphp
                    @if (!$recipe) @continue @endif
                    
                    <article class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col group border border-surface-container/50" data-bookmark-id="{{ $bookmark->id }}">
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                            <a href="{{ route('recipes.show', $recipe->slug) }}">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600' }}"
                                     alt="{{ $recipe->title }}"/>
                            </a>
                            <button type="button"
                                    class="remove-favorite-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md flex items-center justify-center text-error shadow-sm hover:scale-110 active:scale-95 transition-all z-10"
                                    data-bookmark-id="{{ $bookmark->id }}" title="Hapus dari koleksi">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                            </button>
                        </div>

                        <div class="p-3 sm:p-4 flex flex-col flex-1 justify-between gap-2">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-secondary uppercase tracking-wider font-bold">{{ $recipe->category->name ?? 'Umum' }}</span>
                                <a href="{{ route('recipes.show', $recipe->slug) }}">
                                    <h2 class="font-display text-sm sm:text-base font-bold text-primary group-hover:text-secondary transition line-clamp-2 leading-tight">
                                        {{ $recipe->title }}
                                    </h2>
                                </a>
                            </div>

                            <div class="pt-2 border-t border-surface-container mt-1 flex items-center justify-between text-[11px] text-on-surface-variant">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-secondary text-[14px]">schedule</span>
                                    <span>{{ $recipe->duration_minutes ?? '-' }}m</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-tertiary-container text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="font-bold">{{ $recipe->average_rating }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pagination Resep --}}
            @if ($bookmarks->hasPages())
                <div class="flex justify-center gap-2 mb-12">
                    {{-- Prev --}}
                    @if (!$bookmarks->onFirstPage())
                        <a href="{{ $bookmarks->previousPageUrl() }}" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container text-primary flex items-center justify-center hover:bg-surface-container transition shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </a>
                    @endif

                    {{-- Numbers --}}
                    @foreach ($bookmarks->getUrlRange(max(1, $bookmarks->currentPage() - 2), min($bookmarks->lastPage(), $bookmarks->currentPage() + 2)) as $page => $url)
                        @if ($page == $bookmarks->currentPage())
                            <span class="w-10 h-10 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-md transform scale-110">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition shadow-sm">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($bookmarks->hasMorePages())
                        <a href="{{ $bookmarks->nextPageUrl() }}" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container text-primary flex items-center justify-center hover:bg-surface-container transition shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </a>
                    @endif
                </div>
            @endif

        @else
            {{-- Empty State Resep --}}
            <div class="bg-surface-container-lowest rounded-3xl p-8 lg:p-16 text-center max-w-2xl mx-auto shadow-sm border border-surface-container flex flex-col items-center mb-12">
                <div class="w-24 h-24 rounded-full bg-secondary-container flex items-center justify-center mb-6 shadow-inner">
                    <span class="material-symbols-outlined text-[48px] text-secondary">bookmark_border</span>
                </div>
                <h2 class="font-display text-2xl text-primary font-bold mb-2">Belum Ada Resep Tersimpan</h2>
                <p class="text-sm text-on-surface-variant max-w-md mb-8 leading-relaxed">
                    Ketuk ikon simpan (bookmark) pada resep yang Anda suka, dan resep tersebut akan muncul di sini.
                </p>
                <a href="{{ route('recipes.daftar_resep') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-sm font-bold px-8 py-3.5 rounded-full shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px]">explore</span>
                    Jelajahi Resep
                </a>
            </div>
        @endif
    </div>

    {{-- ============================================ --}}
    {{-- TAB CONTENT: TIPS --}}
    {{-- ============================================ --}}
    <div id="tab-content-tips" class="tab-content">
        @if ($bookmarkedTips->count() > 0)
            {{-- Tanda Bookmark / Info Tambahan Tips --}}
            <div class="flex items-center justify-between mb-4 px-1">
                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-secondary font-bold">
                    <span class="material-symbols-outlined text-[16px]">bookmark</span>
                    Total {{ $bookmarkedTips->count() }} tips tersimpan
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6 mb-12">
                @foreach ($bookmarkedTips as $bm)
                    @php $tip = $bm->tip; @endphp
                    @if (!$tip) @continue @endif
                    
                    <article class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col group border border-surface-container/50" data-tipbookmark-id="{{ $bm->id }}">
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-surface-container">
                            <a href="{{ route('tips.detail_tips', $tip->slug) }}">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     src="{{ $tip->image ? Storage::url($tip->image) : 'https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=600' }}"
                                     alt="{{ $tip->title }}"/>
                            </a>
                            <button type="button"
                                    class="remove-tip-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md flex items-center justify-center text-primary shadow-sm hover:scale-110 active:scale-95 transition-all z-10"
                                    data-tipbookmark-id="{{ $bm->id }}" title="Hapus dari koleksi">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                            </button>
                        </div>

                        <div class="p-3 sm:p-4 flex flex-col flex-1 justify-between gap-2">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-secondary uppercase tracking-wider font-bold">Tips Dapur</span>
                                <a href="{{ route('tips.detail_tips', $tip->slug) }}">
                                    <h2 class="font-display text-sm sm:text-base font-bold text-primary group-hover:text-secondary transition line-clamp-2 leading-tight">
                                        {{ $tip->title }}
                                    </h2>
                                </a>
                            </div>

                            <div class="pt-2 border-t border-surface-container mt-1 flex items-center justify-between text-[11px] text-on-surface-variant">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-secondary text-[14px]">schedule</span>
                                    <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} mnt</span>
                                </div>
                                <span class="text-outline truncate max-w-[80px]">Oleh {{ $tip->user->name ?? 'Tim' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            {{-- Empty State Tips --}}
            <div class="bg-surface-container-lowest rounded-3xl p-8 lg:p-16 text-center max-w-2xl mx-auto shadow-sm border border-surface-container flex flex-col items-center mb-12">
                <div class="w-24 h-24 rounded-full bg-surface-container flex items-center justify-center mb-6 shadow-inner">
                    <span class="material-symbols-outlined text-[48px] text-outline">lightbulb</span>
                </div>
                <h2 class="font-display text-2xl text-primary font-bold mb-2">Belum Ada Tips Tersimpan</h2>
                <p class="text-sm text-on-surface-variant max-w-md mb-8 leading-relaxed">
                    Simpan panduan memasak dan tips dapur favorit Anda agar mudah ditemukan kembali saat dibutuhkan.
                </p>
                <a href="{{ route('tips.panduan') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-sm font-bold px-8 py-3.5 rounded-full shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                    Jelajahi Tips
                </a>
            </div>
        @endif
    </div>

    {{-- ============================================ --}}
    {{-- REKOMENDASI RESEP POPULER (BAGIAN BAWAH) --}}
    {{-- ============================================ --}}
        {{-- ============================================ --}}
    {{-- REKOMENDASI RESEP POPULER (BAGIAN BAWAH) --}}
    {{-- ============================================ --}}
    @if ($popularRecipes->count())
        <section class="mt-16 pt-10 border-t border-surface-container-high">
            {{-- Header Rekomendasi --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] sm:text-[11px] text-secondary uppercase tracking-widest font-bold">Kurasi Editorial</span>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold text-primary mt-1">
                        Resep Populer Untuk Anda
                    </h2>
                    <p class="text-sm text-on-surface-variant mt-0.5">
                        Mulai isi koleksi Anda dengan hidangan favorit komunitas koki kami.
                    </p>
                </div>
                
                {{-- Tombol Lihat Semua (Dibuat lebih terlihat) --}}
                <a href="{{ route('recipes.daftar_resep') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container text-primary text-sm font-bold transition-all shadow-sm shrink-0 group">
                    <span>Lihat Koleksi Lengkap</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($popularRecipes as $recipe)
                    <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between border border-surface-container/50">
                        <div>
                            {{-- Image --}}
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                                <a href="{{ route('recipes.show', $recipe->slug) }}">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600' }}"
                                         alt="{{ $recipe->title }}"/>
                                </a>

                                {{-- Difficulty Badge --}}
                                <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md text-primary text-[10px] uppercase tracking-wider font-bold shadow-sm">
                                    {{ $recipe->difficulty }}
                                </span>

                                {{-- Tombol Bookmark (BARU DITAMBAHKAN) --}}
                                @auth
                                    <button type="button" data-recipe-slug="{{ $recipe->slug }}"
                                            class="bookmark-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' {{ auth()->user()->bookmarks()->where('recipe_id', $recipe->id)->exists() ? 1 : 0 }};">bookmark</span>
                                    </button>
                                @else
                                    <a href="{{ route('login') }}?require_login=1" title="Masuk untuk menyimpan"
                                    class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                        <span class="material-symbols-outlined text-[18px]">bookmark_border</span>
                                    </a>
                                @endauth
                            </div>

                            {{-- Info --}}
                            <div class="p-3 sm:p-4 flex flex-col gap-1.5">
                                <div class="flex items-center justify-between text-[10px] text-secondary">
                                    <span class="flex items-center gap-1 text-tertiary-container font-bold">
                                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                        {{ $recipe->average_rating }}
                                    </span>
                                    <span class="flex items-center gap-1 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        {{ $recipe->duration_minutes ?? '-' }} mnt
                                    </span>
                                </div>

                                <a href="{{ route('recipes.show', $recipe->slug) }}">
                                    <h3 class="font-display text-sm sm:text-base font-bold text-primary group-hover:text-secondary transition line-clamp-2 leading-tight">
                                        {{ $recipe->title }}
                                    </h3>
                                </a>
                            </div>
                        </div>

                        <div class="px-3 sm:px-4 pb-3 sm:pb-4 pt-1 flex items-center justify-between">
                            <span class="text-[10px] text-secondary bg-secondary-container/50 px-2.5 py-1 rounded-full font-bold">
                                {{ $recipe->category->name ?? 'Umum' }}
                            </span>
                            <a href="{{ route('recipes.show', $recipe->slug) }}" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

</div>

{{-- Toast --}}
<div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 px-5 py-3.5 rounded-full bg-primary text-white shadow-xl"
     id="favToast">
    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
    <span class="text-sm font-semibold" id="favToastMsg">Aksi berhasil.</span>
</div>

@endsection

@push('scripts')
<script>
// ============ TAB SWITCHER ============
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    const btnResep = document.getElementById('tab-btn-resep');
    const btnTips = document.getElementById('tab-btn-tips');
    
    btnResep.className = 'px-6 py-3 rounded-full bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container border border-surface-container-high text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap';
    btnTips.className = 'px-6 py-3 rounded-full bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container border border-surface-container-high text-sm font-bold transition-all flex items-center gap-2 whitespace-nowrap';

    if (tab === 'resep') {
        document.getElementById('tab-content-resep').classList.add('active');
        btnResep.className = 'px-6 py-3 rounded-full bg-primary text-white text-sm font-bold transition-all shadow-sm flex items-center gap-2 whitespace-nowrap';
    } else {
        document.getElementById('tab-content-tips').classList.add('active');
        btnTips.className = 'px-6 py-3 rounded-full bg-primary text-white text-sm font-bold transition-all shadow-sm flex items-center gap-2 whitespace-nowrap';
    }
}

// ============ TOAST ============
function showFavToast(msg, icon = 'check_circle') {
    const t = document.getElementById('favToast');
    const m = document.getElementById('favToastMsg');
    if (!t) return;
    
    const iconEl = t.querySelector('.material-symbols-outlined');
    if(iconEl) iconEl.textContent = icon;

    m.textContent = msg;
    t.classList.remove('translate-y-24', 'opacity-0');
    t.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        t.classList.add('translate-y-24', 'opacity-0');
        t.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
}

// ============ HAPUS RESEP ============
document.querySelectorAll('.remove-favorite-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();

        const id = btn.dataset.bookmarkId;
        const card = btn.closest('article');
        
        try {
            const res = await fetch(`/bookmark/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) throw new Error('Gagal');

            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => {
                card.remove();
                showFavToast('Resep dihapus dari koleksi', 'bookmark_remove');
                
                if (document.querySelectorAll('.remove-favorite-btn').length === 0) {
                    window.location.reload();
                }
            }, 300);

        } catch (err) {
            console.error(err);
            showFavToast('Gagal menghapus resep.', 'error');
        }
    });
});

// ============ HAPUS TIPS ============
document.querySelectorAll('.remove-tip-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();

        const id = btn.dataset.tipbookmarkId;
        const card = btn.closest('article');
        
        try {
            const res = await fetch(`/bookmark/tip/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) throw new Error('Gagal');

            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => {
                card.remove();
                showFavToast('Tips dihapus dari koleksi', 'bookmark_remove');
                
                if (document.querySelectorAll('.remove-tip-btn').length === 0) {
                    window.location.reload();
                }
            }, 300);

        } catch (err) {
            console.error(err);
            showFavToast('Gagal menghapus tips.', 'error');
        }
    });
});
</script>
@endpush