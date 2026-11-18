@extends('layouts.app')

@section('title', 'Tips Memasak — Jelajah Rasa')

@push('styles')
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    .tip-card.hidden { display: none !important; }
</style>
@endpush

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-12 pt-8 lg:pt-12 pb-20 bg-surface-container-low/30">    
    {{-- ========== 1. BREADCRUMB & HEADER ========== --}}
    <section class="flex flex-col gap-8 mb-16">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-on-surface-variant text-[11px] sm:text-xs uppercase tracking-wider font-bold">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-[14px] opacity-50">chevron_right</span>
            <span class="text-primary">Tips Memasak</span>
        </nav>

        {{-- Title & Search --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
            <div class="max-w-2xl flex flex-col gap-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-secondary-container/50 border border-secondary/20 text-secondary w-fit">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    <span class="text-[10px] sm:text-xs uppercase tracking-widest font-bold">Khasanah Teknik Kuliner</span>
                </div>
                <h1 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-primary tracking-tight font-bold leading-[1.15]">
                    Tips Memasak & <span class="italic text-secondary">Panduan Kuliner</span>
                </h1>
                <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
                    Kuasai teknik esensial, singkap rahasia dapur para koki profesional, dan sempurnakan seni memasak Anda dengan panduan terkurasi.
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="w-full lg:w-96 shrink-0">
                <div class="relative flex items-center bg-surface-container-lowest rounded-full shadow-sm border border-surface-container p-1.5 focus-within:ring-2 focus-within:ring-secondary/50 transition-all">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary shrink-0 ml-1">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input type="text" id="guide-search"
                           placeholder="Cari tips (misal: pisau, adonan)..."
                           class="w-full bg-transparent px-4 py-2 text-on-surface placeholder:text-outline text-sm focus:outline-none"/>
                    <button type="button" id="search-clear-btn"
                            class="hidden pr-4 text-outline hover:text-error transition">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    @if ($featured || $tips->count())

        {{-- ========== 2. FEATURED TIP HERO ========== --}}
        @if ($featured)
            @php
                // Path Gambar Featured Tips (Mendukung Storage / Public / Uploads)
                $featuredImagePath = 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1400';
                if ($featured->image) {
                    $cleanFeatured = str_replace(['storage/', 'uploads/tips/', 'uploads/'], '', $featured->image);
                    if (file_exists(public_path('storage/' . $cleanFeatured))) {
                        $featuredImagePath = asset('storage/' . $cleanFeatured);
                    } elseif (file_exists(public_path('storage/tips/' . $cleanFeatured))) {
                        $featuredImagePath = asset('storage/tips/' . $cleanFeatured);
                    } elseif (file_exists(public_path('uploads/' . $cleanFeatured))) {
                        $featuredImagePath = asset('uploads/' . $cleanFeatured);
                    } else {
                        $featuredImagePath = asset('storage/' . $featured->image);
                    }
                }

                // Path Avatar Penulis Featured
                $featuredAvatar = null;
                if ($featured->user?->avatar) {
                    $cleanAvatar = str_replace(['storage/', 'uploads/avatars/', 'avatars/'], '', $featured->user->avatar);
                    if (file_exists(public_path('storage/avatars/' . $cleanAvatar))) {
                        $featuredAvatar = asset('storage/avatars/' . $cleanAvatar);
                    } elseif (file_exists(public_path('storage/' . $featured->user->avatar))) {
                        $featuredAvatar = asset('storage/' . $featured->user->avatar);
                    } else {
                        $featuredAvatar = asset('storage/avatars/' . $cleanAvatar);
                    }
                } else {
                    $featuredAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($featured->user?->name ?? 'Chef') . '&background=5a3a22&color=fff&bold=true';
                }
            @endphp

            <section class="relative w-full rounded-[2rem] overflow-hidden shadow-2xl group mb-16">
                <div class="relative w-full aspect-[4/3] sm:aspect-[16/9] lg:aspect-[21/9] min-h-[400px] bg-surface-container">
                    <img src="{{ $featuredImagePath }}" 
                         alt="{{ $featured->title }}" 
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/50 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/80 via-primary/20 to-transparent hidden md:block"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:p-14">
                        <div class="relative z-10 max-w-3xl flex flex-col gap-5 text-white">
                            <div class="inline-flex items-center gap-2 self-start px-4 py-1.5 bg-white/20 backdrop-blur-md border border-white/30 rounded-full shadow-sm">
                                <span class="material-symbols-outlined text-primary-fixed text-[16px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                                <span class="text-[10px] sm:text-[11px] text-white uppercase font-bold tracking-widest">Panduan Pilihan Redaksi</span>
                            </div>

                            <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold leading-tight max-w-3xl drop-shadow-md">
                                {{ $featured->title }}
                            </h2>

                            <p class="text-sm sm:text-base text-white/80 max-w-2xl leading-relaxed line-clamp-2">
                                {{ Str::limit(strip_tags($featured->content), 180) }}
                            </p>

                            <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 mt-2 border-t border-white/20">
                                <div class="flex flex-wrap items-center gap-4 text-white/90 text-[11px] sm:text-xs font-semibold">
                                    <span class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[18px] text-secondary-fixed">schedule</span>
                                        {{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} min baca
                                    </span>
                                    <span class="hidden sm:inline-block w-1.5 h-1.5 rounded-full bg-white/40"></span>
                                    @if ($featured->user)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full overflow-hidden bg-white/20 shrink-0">
                                                <img class="w-full h-full object-cover" src="{{ $featuredAvatar }}" alt="{{ $featured->user->name }}">
                                            </div>
                                            <span>{{ $featured->user->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('tips.detail_tips', $featured->slug) }}"
                                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-primary text-xs sm:text-sm font-bold rounded-full shadow-lg hover:bg-secondary hover:text-white transition-all shrink-0">
                                    <span>Baca Panduan</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ========== 3. COUNTER ========== --}}
        <section class="flex items-center justify-between mb-8">
            <h3 class="font-['Playfair_Display'] text-2xl sm:text-3xl text-primary font-bold">Katalog Panduan</h3>
            <span class="text-xs sm:text-sm text-on-surface-variant font-semibold" id="active-category-count">
                Menampilkan {{ $tips->count() }} artikel
            </span>
        </section>

        {{-- ========== 4. TIPS GRID (2 KOLOM DI HP) ========== --}}
        <section class="mb-16">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-8">
                @foreach ($tips as $tip)
                    @php
                        // Path Gambar Tips
                        $tipImagePath = 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800';
                        if ($tip->image) {
                            $cleanTipImg = str_replace(['storage/', 'uploads/tips/', 'uploads/'], '', $tip->image);
                            if (file_exists(public_path('storage/' . $cleanTipImg))) {
                                $tipImagePath = asset('storage/' . $cleanTipImg);
                            } elseif (file_exists(public_path('storage/tips/' . $cleanTipImg))) {
                                $tipImagePath = asset('storage/tips/' . $cleanTipImg);
                            } elseif (file_exists(public_path('uploads/' . $cleanTipImg))) {
                                $tipImagePath = asset('uploads/' . $cleanTipImg);
                            } else {
                                $tipImagePath = asset('storage/' . $tip->image);
                            }
                        }

                        // Path Avatar User / Kurator Tips
                        $tipAvatar = null;
                        if ($tip->user?->avatar) {
                            $cleanTipAvatar = str_replace(['storage/', 'uploads/avatars/', 'avatars/'], '', $tip->user->avatar);
                            if (file_exists(public_path('storage/avatars/' . $cleanTipAvatar))) {
                                $tipAvatar = asset('storage/avatars/' . $cleanTipAvatar);
                            } elseif (file_exists(public_path('storage/' . $tip->user->avatar))) {
                                $tipAvatar = asset('storage/' . $tip->user->avatar);
                            } else {
                                $tipAvatar = asset('storage/avatars/' . $cleanTipAvatar);
                            }
                        } else {
                            $tipAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($tip->user?->name ?? 'Chef') . '&background=5a3a22&color=fff&bold=true';
                        }
                    @endphp

                    <article class="tip-card flex flex-col bg-surface-container-lowest rounded-2xl sm:rounded-[1.5rem] overflow-hidden shadow-sm hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group border border-surface-container/60"
                             data-title="{{ strtolower($tip->title . ' ' . strip_tags($tip->content)) }}">

                        {{-- Image --}}
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                            <a href="{{ route('tips.detail_tips', $tip->slug) }}" class="block w-full h-full">
                                <img alt="{{ $tip->title }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     src="{{ $tipImagePath }}"/>
                            </a>

                            <div class="absolute top-2 left-2 sm:top-4 sm:left-4 z-10">
                                <span class="px-2.5 py-1 sm:px-4 sm:py-1.5 bg-surface-container-lowest/90 backdrop-blur-md text-primary rounded-full text-[9px] sm:text-[10px] uppercase tracking-widest font-bold shadow-sm">
                                    Tips Dapur
                                </span>
                            </div>

                            {{-- TOMBOL SIMPAN TIPS --}}
                            @auth
                                <button type="button" data-tip-slug="{{ $tip->slug }}"
                                        class="save-tip-btn absolute top-2 right-2 sm:top-4 sm:right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' {{ auth()->user()->hasSavedTip($tip->id) ? 1 : 0 }};">bookmark</span>
                                </button>
                            @else
                                <a href="{{ route('login') }}?require_login=1" title="Masuk untuk menyimpan"
                                class="absolute top-2 right-2 sm:top-4 sm:right-4 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                    <span class="material-symbols-outlined text-[18px]">bookmark_border</span>
                                </a>
                            @endauth
                        </div>

                        {{-- Body --}}
                        <div class="p-3 sm:p-6 lg:p-8 flex flex-col flex-1 justify-between gap-3 sm:gap-6">
                            <div class="flex flex-col gap-1.5 sm:gap-3">
                                <a href="{{ route('tips.detail_tips', $tip->slug) }}">
                                    <h3 class="font-['Playfair_Display'] text-sm sm:text-lg lg:text-xl text-primary group-hover:text-secondary transition leading-snug line-clamp-2 font-bold">
                                        {{ $tip->title }}
                                    </h3>
                                </a>
                                <p class="text-[11px] sm:text-sm text-on-surface-variant line-clamp-2 sm:line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($tip->content), 140) }}
                                </p>
                            </div>

                            <div class="pt-2 sm:pt-4 border-t border-surface-container-high/60 flex items-center justify-between text-on-surface-variant text-[9px] sm:text-[11px] font-semibold">
                                <div class="flex items-center gap-1 sm:gap-1.5">
                                    <span class="material-symbols-outlined text-[13px] sm:text-[16px] text-secondary">schedule</span>
                                    <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} min</span>
                                </div>
                                <div class="flex items-center gap-1.5 sm:gap-2 max-w-[90px] sm:max-w-[140px]">
                                    <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden bg-surface-container shrink-0 shadow-sm">
                                        <img class="w-full h-full object-cover" src="{{ $tipAvatar }}" alt="{{ $tip->user->name ?? 'Tim Dapur' }}"/>
                                    </div>
                                    <span class="truncate">{{ $tip->user->name ?? 'Tim Dapur' }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Empty State (untuk search) --}}
            <div class="hidden flex-col items-center justify-center text-center p-12 bg-surface-container-lowest rounded-3xl mt-8 border border-surface-container"
                 id="no-results">
                <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-outline text-[40px]">search_off</span>
                </div>
                <h4 class="font-['Playfair_Display'] text-2xl text-primary font-bold mb-2">Tidak Menemukan Panduan</h4>
                <p class="text-sm text-on-surface-variant max-w-md mb-6">
                    Coba kata kunci lain seperti "pisau", "adonan", atau "saus".
                </p>
                <button class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-full shadow-md hover:bg-primary-container transition"
                        id="reset-filter-btn">
                    Reset Pencarian
                </button>
            </div>
        </section>

        {{-- ========== 5. PAGINATION ========== --}}
        @if ($tips->hasPages())
            <section class="flex justify-center mb-16">
                <div class="flex items-center gap-2">
                    {{-- Tombol Previous --}}
                    @if (!$tips->onFirstPage())
                        <a href="{{ $tips->previousPageUrl() }}"
                           class="w-10 h-10 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface flex items-center justify-center hover:bg-surface-container transition shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </a>
                    @else
                        <span class="w-10 h-10 rounded-full bg-surface-container-low border border-outline-variant/30 text-outline flex items-center justify-center opacity-40 cursor-not-allowed shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </span>
                    @endif

                    {{-- Nomor Halaman --}}
                    <div class="flex items-center gap-1.5">
                        @foreach ($tips->getUrlRange(max(1, $tips->currentPage() - 2), min($tips->lastPage(), $tips->currentPage() + 2)) as $page => $url)
                            @if ($page == $tips->currentPage())
                                <span class="w-10 h-10 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-md">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="w-10 h-10 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition shadow-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    {{-- Tombol Next --}}
                    @if ($tips->hasMorePages())
                        <a href="{{ $tips->nextPageUrl() }}"
                           class="w-10 h-10 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface flex items-center justify-center hover:bg-surface-container transition shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                    @else
                        <span class="w-10 h-10 rounded-full bg-surface-container-low border border-outline-variant/30 text-outline flex items-center justify-center opacity-40 cursor-not-allowed shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </span>
                    @endif
                </div>
            </section>
        @endif

    @else

        {{-- ========== EMPTY STATE (belum ada tips) ========== --}}
        <section class="my-8">
            <div class="bg-surface-container-lowest rounded-[2rem] p-8 lg:p-16 text-center max-w-3xl mx-auto shadow-sm border border-surface-container flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-secondary-container flex items-center justify-center mb-6 shadow-inner">
                    <span class="material-symbols-outlined text-[48px] text-secondary">lightbulb</span>
                </div>
                <h2 class="font-['Playfair_Display'] text-3xl text-primary font-bold mb-3">
                    Belum Ada Tips
                </h2>
                <p class="text-base text-on-surface-variant max-w-lg mb-8 leading-relaxed">
                    Tim dapur kami sedang menyiapkan panduan kuliner terbaik untuk Anda. Silakan kembali lagi nanti.
                </p>
                <a href="{{ route('recipes.daftar_resep') }}"
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-white text-sm font-bold px-8 py-3.5 rounded-full shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                    <span>Jelajahi Resep</span>
                </a>
            </div>
        </section>

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
let toastTimer;
function showToast(message, icon = 'check_circle') {
    const toast = document.getElementById('toastNotification');
    const msg = document.getElementById('toastMessage');
    const ic = document.getElementById('toastIcon');
    if (!toast) return;
    msg.textContent = message;
    ic.textContent = icon;
    toast.classList.remove('translate-y-24', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-24', 'opacity-0');
    }, 2800);
}

document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // 1. FITUR PENCARIAN
    // ==========================================
    const searchInput = document.getElementById('guide-search');
    const searchClearBtn = document.getElementById('search-clear-btn');
    const tipCards = document.querySelectorAll('.tip-card');
    const noResults = document.getElementById('no-results');
    const activeCountText = document.getElementById('active-category-count');
    const resetFilterBtn = document.getElementById('reset-filter-btn');

    let searchQuery = '';

    function filterCards() {
        let visibleCount = 0;
        tipCards.forEach((card) => {
            const titleData = card.getAttribute('data-title') || '';
            const matches = !searchQuery || titleData.includes(searchQuery.toLowerCase());

            if (matches) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        if (activeCountText) activeCountText.textContent = `Menampilkan ${visibleCount} artikel`;
        if (noResults) {
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                noResults.classList.add('flex');
            } else {
                noResults.classList.add('hidden');
                noResults.classList.remove('flex');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim();
            if (searchQuery.length > 0) {
                searchClearBtn?.classList.remove('hidden');
            } else {
                searchClearBtn?.classList.add('hidden');
            }
            filterCards();
        });
    }

    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            searchClearBtn.classList.add('hidden');
            filterCards();
            searchInput?.focus();
        });
    }

    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', () => {
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            searchClearBtn?.classList.add('hidden');
            filterCards();
        });
    }

    // ==========================================
    // 2. FITUR SIMPAN TIPS (AJAX)
    // ==========================================
    document.querySelectorAll('.save-tip-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (btn.disabled) return;

            const tipSlug = btn.getAttribute('data-tip-slug');
            const icon = btn.querySelector('.material-symbols-outlined');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');

            if (!csrfMeta) {
                showToast('CSRF token tidak ditemukan di layout', 'error');
                return;
            }

            btn.disabled = true;
            try {
                const res = await fetch(`/tips/${tipSlug}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfMeta.content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                });

                if (res.status === 401) {
                    showToast('Masuk dulu untuk menyimpan tips.', 'login');
                    return;
                }
                if (!res.ok) throw new Error('Gagal');

                const data = await res.json();

                if (data.status === 'added') {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.classList.remove('text-outline');
                    btn.classList.add('text-primary');
                    showToast('Tips disimpan!', 'bookmark_added');
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.classList.remove('text-primary');
                    btn.classList.add('text-outline');
                    showToast('Tips dihapus dari simpanan', 'bookmark_remove');
                }
            } catch (err) {
                console.error('Gagal menyimpan tips:', err);
                showToast('Gagal menyimpan. Coba lagi.', 'error');
            } finally {
                btn.disabled = false;
            }
        });
    });
});
</script>
@endpush