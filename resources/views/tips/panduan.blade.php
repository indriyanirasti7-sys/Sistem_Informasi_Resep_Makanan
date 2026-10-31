@extends('layouts.app')

@section('title', 'Tips Memasak — L\'Art de Cuisine')

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
<div class="max-w-[1280px] mx-auto w-full px-5 lg:px-12 py-8 flex flex-col gap-12">

    {{-- ========== 1. BREADCRUMB & HEADER ========== --}}
    <section class="flex flex-col gap-4">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-on-surface-variant text-[11px] uppercase tracking-wider font-semibold">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
            <span class="text-primary font-bold">Tips Memasak</span>
        </nav>

        {{-- Title + Search --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-2xl flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 text-secondary text-[11px] uppercase tracking-widest font-bold">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                    Khasanah Teknik Kuliner
                </div>
                <h1 class="font-['Playfair_Display'] text-4xl lg:text-5xl text-primary tracking-tight font-semibold">
                    Tips Memasak & Panduan Kuliner
                </h1>
                <p class="text-base lg:text-lg text-on-surface-variant leading-relaxed">
                    Kuasai teknik esensial, singkap rahasia dapur para koki profesional, dan sempurnakan seni memasak Anda dengan panduan terkurasi.
                </p>
            </div>

            {{-- Search --}}
            <div class="w-full lg:w-96 shrink-0">
                <div class="relative flex items-center bg-surface-container-lowest rounded-full shadow-md p-1.5 transition focus-within:shadow-lg">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-primary shrink-0 ml-1">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input type="text" id="guide-search"
                           placeholder="Cari tips (misal: pisau, adonan, fond)..."
                           class="w-full bg-transparent px-4 py-2 text-on-surface placeholder:text-outline text-sm focus:outline-none"/>
                    <button type="button" id="search-clear-btn"
                            class="hidden pr-4 text-outline hover:text-primary transition">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    @if ($featured || $tips->count())

        {{-- ========== 2. FEATURED TIP HERO ========== --}}
        @if ($featured)
            <section class="relative w-full rounded-3xl overflow-hidden shadow-xl group">
                <div class="min-h-[480px] lg:min-h-[520px] w-full bg-cover bg-center relative flex flex-col justify-end p-6 md:p-12"
                     style="background-image: url('{{ $featured->image ? Storage::url($featured->image) : 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1400' }}');">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/65 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/80 via-primary/30 to-transparent hidden md:block"></div>

                    <div class="relative z-10 max-w-3xl flex flex-col gap-4 text-white">
                        <div class="inline-flex items-center gap-2 self-start px-4 py-1 bg-white/95 backdrop-blur-md rounded-full shadow-sm">
                            <span class="material-symbols-outlined text-secondary text-[16px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                            <span class="text-[11px] text-primary uppercase font-bold tracking-wider">Panduan Pilihan</span>
                        </div>

                        <h2 class="font-['Playfair_Display'] text-2xl lg:text-4xl font-bold leading-tight max-w-2xl drop-shadow-sm">
                            {{ $featured->title }}
                        </h2>

                        <p class="text-base lg:text-lg text-white/90 max-w-xl leading-relaxed line-clamp-2">
                            {{ Str::limit(strip_tags($featured->content), 180) }}
                        </p>

                        <div class="w-full flex flex-wrap items-center justify-between gap-4 pt-2">
                            <div class="flex flex-wrap items-center gap-4 text-white/80 text-[11px] font-semibold">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">schedule</span>
                                    <span>{{ ceil(str_word_count(strip_tags($featured->content)) / 200) }} min baca</span>
                                </div>
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-white/40"></span>
                                <span class="px-3 py-1 rounded-full bg-primary-container/80 text-primary-fixed font-bold">
                                    Teknik Fondasional
                                </span>
                                @if ($featured->user)
                                    <span class="hidden sm:inline-flex items-center gap-1 text-white">
                                        Oleh <strong class="font-bold">{{ $featured->user->name }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('tips.detail_tips', $featured->slug) }}"
                               class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-white text-primary text-sm font-bold rounded-full shadow-md hover:bg-surface-container-high hover:scale-105 transition-all">
                                <span>Baca Panduan Lengkap</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ========== 3. COUNTER ========== --}}
        <section class="flex items-center justify-between">
            <h3 class="font-['Playfair_Display'] text-xl text-primary font-semibold">Panduan Kuliner</h3>
            <span class="text-sm text-on-surface-variant font-medium" id="active-category-count">
                Menampilkan {{ $tips->count() }} artikel
            </span>
        </section>

        {{-- ========== 4. TIPS GRID ========== --}}
        <section>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tips-grid">
                @foreach ($tips as $tip)
                    <article class="tip-card flex flex-col bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:-translate-y-2 hover:shadow-xl transition-all duration-300 group cursor-pointer"
                             data-title="{{ strtolower($tip->title . ' ' . strip_tags($tip->content)) }}">

                        {{-- Image --}}
                        <a href="{{ route('tips.detail_tips', $tip->slug) }}" class="relative w-full aspect-square overflow-hidden bg-surface-container block">
                            <img alt="{{ $tip->title }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 src="{{ $tip->image ? Storage::url($tip->image) : 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800' }}"/>

                            <div class="absolute top-4 left-4">
                                <span class="px-4 py-1 bg-primary text-white rounded-full text-[11px] uppercase tracking-wider font-bold shadow-sm">
                                    Tips Dapur
                                </span>
                            </div>
                        </a>

                        {{-- Body --}}
                        <div class="p-6 flex flex-col flex-1 justify-between gap-4">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('tips.detail_tips', $tip->slug) }}">
                                    <h3 class="font-['Playfair_Display'] text-lg text-primary group-hover:text-primary-container transition leading-snug line-clamp-2">
                                        {{ $tip->title }}
                                    </h3>
                                </a>
                                <p class="text-sm text-on-surface-variant line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($tip->content), 140) }}
                                </p>
                            </div>

                            <div class="pt-2 flex items-center justify-between text-on-surface-variant text-[11px] font-semibold">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">schedule</span>
                                    <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} min baca</span>
                                </div>
                                <span class="font-medium text-secondary truncate max-w-[120px]">
                                    {{ $tip->user->name ?? 'Tim Dapur' }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Empty State (untuk search) --}}
            <div class="hidden flex-col items-center justify-center text-center p-12 bg-surface-container rounded-3xl mt-6"
                 id="no-results">
                <span class="material-symbols-outlined text-outline text-[48px] mb-3">menu_book</span>
                <h4 class="font-['Playfair_Display'] text-xl text-primary font-bold mb-2">Tidak Menemukan Panduan</h4>
                <p class="text-sm text-on-surface-variant max-w-md mb-6">
                    Coba kata kunci lain seperti "pisau", "mentega", atau "saus".
                </p>
                <button class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full shadow-sm hover:bg-primary-container transition"
                        id="reset-filter-btn">
                    Reset Pencarian
                </button>
            </div>
        </section>

        {{-- ========== 5. PAGINATION ========== --}}
        @if ($tips->hasPages())
            <section class="flex justify-center">
                <div class="flex items-center gap-1">
                    @if (!$tips->onFirstPage())
                        <a href="{{ $tips->previousPageUrl() }}"
                           class="w-10 h-10 rounded-full bg-surface-container text-primary flex items-center justify-center hover:bg-surface-container-high transition">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </a>
                    @endif

                    @foreach ($tips->getUrlRange(max(1, $tips->currentPage() - 2), min($tips->lastPage(), $tips->currentPage() + 2)) as $page => $url)
                        @if ($page == $tips->currentPage())
                            <span class="w-10 h-10 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="w-10 h-10 rounded-full text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($tips->hasMorePages())
                        <a href="{{ $tips->nextPageUrl() }}"
                           class="w-10 h-10 rounded-full bg-surface-container text-primary flex items-center justify-center hover:bg-surface-container-high transition">
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </section>
        @endif

    @else

        {{-- ========== EMPTY STATE (belum ada tips) ========== --}}
        <section class="my-8">
            <div class="bg-surface-container-lowest rounded-3xl p-8 lg:p-16 text-center max-w-3xl mx-auto shadow-sm flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-secondary-container flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[48px] text-secondary">lightbulb</span>
                </div>
                <h2 class="font-['Playfair_Display'] text-3xl text-primary font-bold mb-3">
                    Belum Ada Tips
                </h2>
                <p class="text-base text-on-surface-variant max-w-lg mb-8 leading-relaxed">
                    Tim dapur kami sedang menyiapkan panduan kuliner terbaik untuk Anda. Silakan kembali lagi nanti.
                </p>
                <a href="{{ route('recipes.index') }}"
                   class="inline-flex items-center gap-2 bg-primary-container hover:bg-primary text-white text-sm font-bold px-8 py-3.5 rounded-full shadow-md transition-all">
                    <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                    <span>Jelajahi Resep</span>
                </a>
            </div>
        </section>

    @endif

    {{-- ========== 6. CTA BUKU SAKU ========== --}}
    <section class="bg-surface-container rounded-3xl p-6 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-primary-container text-primary-fixed flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[32px]">menu_book</span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-[11px] text-secondary uppercase font-bold tracking-wider">Koleksi Buku Saku</span>
                <h4 class="font-['Playfair_Display'] text-xl text-primary font-semibold">Ingin Mengunduh Panduan Lengkap PDF?</h4>
                <p class="text-sm text-on-surface-variant">Dapatkan ringkasan suhu memanggang, panduan pisau, dan teknik kaldu klasik dalam format siap cetak.</p>
            </div>
        </div>
        <a href="#"
           class="px-6 py-2.5 bg-secondary text-white rounded-full text-sm font-bold hover:opacity-90 transition-all shadow-sm whitespace-nowrap">
            Unduh Buku Saku Dapur
        </a>
    </section>

</div>
@endsection

@push('scripts')
<script>
(function() {
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

        if (activeCountText) {
            activeCountText.textContent = `Menampilkan ${visibleCount} artikel`;
        }

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

    // Search input
    searchInput?.addEventListener('input', (e) => {
        searchQuery = e.target.value.trim();
        if (searchQuery.length > 0) {
            searchClearBtn?.classList.remove('hidden');
        } else {
            searchClearBtn?.classList.add('hidden');
        }
        filterCards();
    });

    // Clear
    searchClearBtn?.addEventListener('click', () => {
        searchInput.value = '';
        searchQuery = '';
        searchClearBtn.classList.add('hidden');
        filterCards();
        searchInput.focus();
    });

    // Reset
    resetFilterBtn?.addEventListener('click', () => {
        searchQuery = '';
        if (searchInput) searchInput.value = '';
        searchClearBtn?.classList.add('hidden');
        filterCards();
    });
})();
</script>
@endpush