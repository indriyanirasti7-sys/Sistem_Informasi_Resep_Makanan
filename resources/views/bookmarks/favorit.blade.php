@extends('layouts.app')

@section('title', 'Resep Favorit Saya — L\'Art de Cuisine')

@push('styles')
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .scrollbar-none::-webkit-scrollbar { display: none; }
    .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
<div class="w-full max-w-[1280px] mx-auto px-5 lg:px-12 pt-6 pb-16">

    {{-- ========== HEADER ========== --}}
    <header class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-8">
        <div class="flex flex-col gap-2 max-w-2xl">
            <div class="inline-flex items-center gap-2 self-start px-3 py-1 rounded-full bg-secondary-container/70 text-on-secondary-container text-[11px] uppercase tracking-wider font-bold">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                Koleksi Pribadi Anda
            </div>
            <h1 class="font-['Playfair_Display'] text-4xl lg:text-5xl font-semibold text-primary tracking-tight">
                Resep Favorit Saya
            </h1>
            <p class="text-base lg:text-lg text-on-surface-variant">
                Semua resep yang Anda simpan, siap dimasak kapan saja untuk hidangan istimewa keluarga.
            </p>
        </div>

        <div class="shrink-0">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-surface-container-lowest shadow-sm">
                <span class="material-symbols-outlined {{ $bookmarks->total() > 0 ? 'text-error' : 'text-outline' }} text-[20px]" style="font-variation-settings: 'FILL' 1;">
                    favorite
                </span>
                <span class="text-sm font-bold text-primary">{{ $bookmarks->total() }} resep tersimpan</span>
            </div>
        </div>
    </header>

    @if ($bookmarks->total() > 0)

        {{-- ============================================ --}}
        {{-- ADA FAVORIT → TAMPILKAN GRID --}}
        {{-- ============================================ --}}

        {{-- Filter Bar --}}
        <section class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-8 p-2 rounded-full bg-surface-container-low/70 backdrop-blur-sm">
            <div class="flex items-center gap-1 overflow-x-auto no-scrollbar py-1 px-1">
                <a href="{{ route('bookmarks.favorit', request()->except('category')) }}"
                   class="px-5 py-2 rounded-full text-xs font-bold transition whitespace-nowrap
                          {{ !request('category') ? 'bg-primary-container text-white shadow-sm' : 'bg-surface-container text-on-surface-variant hover:text-primary' }}">
                    Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('bookmarks.favorit', array_merge(request()->except('category'), ['category' => $cat->slug])) }}"
                       class="px-5 py-2 rounded-full text-xs font-bold transition whitespace-nowrap
                              {{ request('category') === $cat->slug ? 'bg-primary-container text-white shadow-sm' : 'bg-surface-container text-on-surface-variant hover:text-primary' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('bookmarks.favorit') }}" class="shrink-0 flex items-center gap-2 px-2">
                @foreach (request()->except('sort') as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <div class="flex items-center gap-1 bg-surface-container-lowest px-3 py-1.5 rounded-full shadow-sm">
                    <span class="material-symbols-outlined text-outline text-[18px]">swap_vert</span>
                    <select name="sort" onchange="this.form.submit()"
                            class="bg-transparent text-xs font-bold text-primary focus:outline-none cursor-pointer pr-1">
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Terbaru Disimpan</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="time"   {{ request('sort') === 'time'   ? 'selected' : '' }}>Tercepat Dimasak</option>
                        <option value="az"     {{ request('sort') === 'az'     ? 'selected' : '' }}>Abjad A-Z</option>
                    </select>
                </div>
            </form>
        </section>

        {{-- Grid Favorit --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach ($bookmarks as $bookmark)
                @php $recipe = $bookmark->recipe; @endphp
                @if (!$recipe) @continue @endif
                @php
                    $diffColor = match($recipe->difficulty) {
                        'Mudah'  => 'bg-secondary-container text-on-secondary-container',
                        'Sedang' => 'bg-tertiary-fixed text-on-tertiary-fixed',
                        'Sulit'  => 'bg-tertiary-fixed-dim text-on-tertiary-fixed',
                        default  => 'bg-surface-container-high text-on-surface',
                    };
                @endphp

                <article class="bg-surface-container-lowest rounded-3xl p-3 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group"
                         data-bookmark-id="{{ $bookmark->id }}">

                    <div>
                        <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden bg-surface-container">
                            <a href="{{ route('recipes.show', $recipe->slug) }}">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600' }}"
                                     alt="{{ $recipe->title }}"/>
                            </a>

                            <div class="absolute top-3 left-3 px-3 py-1 rounded-full {{ $diffColor }} text-[11px] font-bold shadow-sm">
                                {{ $recipe->difficulty }}
                            </div>

                            <button type="button"
                                    class="remove-favorite-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center text-error shadow-sm hover:scale-110 active:scale-95 transition-all"
                                    data-bookmark-id="{{ $bookmark->id }}"
                                    aria-label="Hapus dari favorit">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                            </button>
                        </div>

                        <div class="px-2 pt-3 flex flex-col gap-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-secondary uppercase tracking-wider font-bold">
                                    {{ $recipe->category->name ?? 'Umum' }}
                                </span>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-on-tertiary-container text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="text-[11px] text-primary font-bold">{{ $recipe->average_rating }}</span>
                                    <span class="text-[10px] text-outline">({{ $recipe->rating_count }})</span>
                                </div>
                            </div>

                            <a href="{{ route('recipes.show', $recipe->slug) }}">
                                <h2 class="font-['Playfair_Display'] text-base font-semibold text-primary group-hover:text-primary-container transition line-clamp-2 leading-snug">
                                    {{ $recipe->title }}
                                </h2>
                            </a>
                        </div>
                    </div>

                    <div class="px-2 pt-3">
                        <div class="w-full h-px bg-surface-variant/70 mb-3"></div>

                        <div class="flex items-center justify-between text-xs text-on-surface-variant mb-2">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-secondary text-[16px]">schedule</span>
                                <span>{{ $recipe->duration_minutes ?? '-' }} mnt</span>
                            </div>
                            <span class="font-medium text-primary truncate max-w-[100px]">
                                {{ $recipe->user->name ?? 'Tim Dapur' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-1 text-outline text-[10px]">
                            <span class="material-symbols-outlined text-[14px] text-outline-variant">bookmark</span>
                            <span>Disimpan {{ $bookmark->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        {{-- Pagination --}}
        @if ($bookmarks->hasPages())
            <div class="flex justify-center gap-1 mb-12">
                @if (!$bookmarks->onFirstPage())
                    <a href="{{ $bookmarks->previousPageUrl() }}"
                       class="w-10 h-10 rounded-full bg-surface-container text-primary flex items-center justify-center hover:bg-surface-container-high transition">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    </a>
                @endif

                @foreach ($bookmarks->getUrlRange(max(1, $bookmarks->currentPage() - 2), min($bookmarks->lastPage(), $bookmarks->currentPage() + 2)) as $page => $url)
                    @if ($page == $bookmarks->currentPage())
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

                @if ($bookmarks->hasMorePages())
                    <a href="{{ $bookmarks->nextPageUrl() }}"
                       class="w-10 h-10 rounded-full bg-surface-container text-primary flex items-center justify-center hover:bg-surface-container-high transition">
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                @endif
            </div>
        @endif

    @else

        {{-- ============================================ --}}
        {{-- KOSONG → EMPTY STATE CANTIK --}}
        {{-- ============================================ --}}

        <section class="my-8">
            <div class="bg-surface-container-lowest/80 backdrop-blur-md rounded-3xl p-8 lg:p-16 text-center max-w-3xl mx-auto shadow-sm flex flex-col items-center">

                {{-- Illustration --}}
                <div class="relative w-36 h-36 md:w-44 md:h-44 flex items-center justify-center mb-6">
                    <div class="absolute inset-0 rounded-full bg-secondary-container/50 animate-pulse"></div>
                    <div class="relative w-28 h-28 md:w-36 md:h-36 rounded-full bg-secondary-container flex items-center justify-center shadow-md">
                        {{-- SVG Plate & Heart --}}
                        <svg class="w-20 h-20 md:w-24 md:h-24 text-secondary" fill="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" opacity="0.6" r="44" stroke="currentColor" stroke-dasharray="3 3" stroke-width="2.5"></circle>
                            <circle cx="50" cy="50" opacity="0.85" r="38" stroke="currentColor" stroke-width="2"></circle>
                            <circle cx="50" cy="50" fill="currentColor" fill-opacity="0.12" r="30"></circle>
                            <path d="M50 63.5C50 63.5 35 52.8 35 42C35 37 38.8 33 43.5 33C46.5 33 48.8 34.6 50 36.5C51.2 34.6 53.5 33 56.5 33C61.2 33 65 37 65 42C65 52.8 50 63.5 50 63.5Z"
                                  fill="none" stroke="#5a3a22" stroke-linejoin="round" stroke-width="2.5"></path>
                        </svg>
                        <span class="absolute -top-1 right-2 text-primary font-['Playfair_Display'] text-xl select-none">✦</span>
                    </div>
                </div>

                <h2 class="font-['Playfair_Display'] text-3xl lg:text-4xl font-bold text-primary mb-3">
                    Belum Ada Resep Favorit
                </h2>
                <p class="text-base lg:text-lg text-on-surface-variant max-w-lg mb-8 leading-relaxed">
                    Ketuk ikon hati pada resep yang Anda suka, dan semuanya akan tersimpan rapi di sini untuk memudahkan Anda saat memasak.
                </p>

                <a href="{{ route('recipes.daftar_resep') }}"
                   class="inline-flex items-center gap-2 bg-primary-container hover:bg-primary text-white text-sm font-bold px-8 py-3.5 rounded-full shadow-md hover:shadow-lg transition-all group">
                    <span class="material-symbols-outlined text-[20px] group-hover:rotate-45 transition-transform duration-300">explore</span>
                    <span>Jelajahi Resep Sekarang</span>
                </a>
            </div>
        </section>

        {{-- ============================================ --}}
        {{-- REKOMENDASI "RESEP POPULER UNTUK ANDA" --}}
        {{-- ============================================ --}}
        @if ($popularRecipes->count())
            <section class="mt-16">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-2">
                    <div>
                        <span class="text-[11px] text-secondary uppercase tracking-widest font-semibold">Kurasi Editorial Mingguan</span>
                        <h2 class="font-['Playfair_Display'] text-2xl font-bold text-primary mt-1">
                            Resep Populer Untuk Anda
                        </h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Mulai isi koleksi Anda dengan hidangan favorit komunitas koki kami.
                        </p>
                    </div>
                    <a href="{{ route('recipes.daftar_resep') }}"
                       class="inline-flex items-center gap-1 text-sm text-secondary hover:text-on-surface transition-colors font-semibold">
                        <span>Lihat Koleksi Lengkap</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($popularRecipes as $recipe)
                        <article class="group bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                            <div>
                                {{-- Image --}}
                                <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container-high">
                                    <a href="{{ route('recipes.show', $recipe->slug) }}">
                                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                             src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600' }}"
                                             alt="{{ $recipe->title }}"/>
                                    </a>

                                    {{-- Difficulty Badge --}}
                                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-white/95 backdrop-blur-sm text-primary text-[11px] font-semibold shadow-sm">
                                        {{ $recipe->difficulty }}
                                    </span>

                                    {{-- Save Button --}}
                                    <button type="button"
                                            class="save-btn absolute top-3 right-3 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-outline hover:text-error hover:bg-white shadow-sm transition-all"
                                            data-recipe-id="{{ $recipe->id }}"
                                            data-title="{{ $recipe->title }}"
                                            aria-label="Simpan ke favorit">
                                        <span class="material-symbols-outlined text-[20px] heart-icon">favorite_border</span>
                                    </button>
                                </div>

                                {{-- Info --}}
                                <div class="p-4 flex flex-col gap-2">
                                    <div class="flex items-center gap-2 text-[11px] text-secondary">
                                        <span class="flex items-center gap-0.5 text-on-tertiary-container font-semibold">
                                            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                            {{ $recipe->average_rating }}
                                        </span>
                                        <span>•</span>
                                        <span class="flex items-center gap-1 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            {{ $recipe->duration_minutes ?? '-' }} mnt
                                        </span>
                                        <span>•</span>
                                        <span class="text-on-surface-variant">{{ $recipe->servings }} Porsi</span>
                                    </div>

                                    <a href="{{ route('recipes.show', $recipe->slug) }}">
                                        <h3 class="font-['Playfair_Display'] text-base font-semibold text-primary group-hover:text-tertiary-container transition line-clamp-2">
                                            {{ $recipe->title }}
                                        </h3>
                                    </a>

                                    <p class="text-xs text-on-surface-variant line-clamp-2">
                                        {{ Str::limit($recipe->description, 90) }}
                                    </p>
                                </div>
                            </div>

                            <div class="px-4 pb-4 pt-1 flex items-center justify-between">
                                <span class="text-[11px] text-secondary bg-secondary-container/50 px-2.5 py-1 rounded-full">
                                    {{ $recipe->category->name ?? 'Umum' }}
                                </span>
                                <a href="{{ route('recipes.show', $recipe->slug) }}"
                                   class="material-symbols-outlined text-outline group-hover:translate-x-1 transition-transform">arrow_right_alt</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

    @endif

    {{-- ============================================ --}}
    {{-- CTA BAWAH --}}
    {{-- ============================================ --}}
    @if ($bookmarks->total() > 0)
        <section class="mt-16">
            <div class="bg-secondary-container/60 rounded-3xl p-6 lg:p-10 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="flex items-center gap-4 z-10">
                    <div class="w-14 h-14 rounded-full bg-surface-container-lowest text-secondary flex items-center justify-center shrink-0 shadow-sm">
                        <span class="material-symbols-outlined text-[28px]">explore</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary">Belum menemukan yang cocok?</h3>
                        <p class="text-sm text-on-secondary-container">Jelajahi ratusan kreasi resep autentik dan teknik dapur profesional lainnya.</p>
                    </div>
                </div>

                <a href="{{ route('recipes.daftar_resep') }}"
                   class="z-10 shrink-0 inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-primary-container hover:bg-primary text-white text-sm font-bold shadow-md transition-all group">
                    <span>Jelajahi Daftar Resep</span>
                    <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>

                <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-secondary-fixed/50 blur-2xl pointer-events-none"></div>
            </div>
        </section>
    @endif

</div>

{{-- Toast --}}
<div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 px-5 py-3.5 rounded-full bg-primary text-white shadow-xl"
     id="favToast">
    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
    <span class="text-sm font-semibold" id="favToastMsg">Aksi berhasil.</span>
</div>

@endsection

@push('scripts')
<script>
function showFavToast(msg) {
    const t = document.getElementById('favToast');
    const m = document.getElementById('favToastMsg');
    if (!t) return;
    m.textContent = msg;
    t.classList.remove('translate-y-24', 'opacity-0');
    t.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        t.classList.add('translate-y-24', 'opacity-0');
        t.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
}

/* ============ REMOVE FAVORITE (dari grid favorit) ============ */
document.querySelectorAll('.remove-favorite-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();

        const id = btn.dataset.bookmarkId;
        const card = btn.closest('article');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!csrfToken) {
            showFavToast('Error: CSRF token tidak ditemukan');
            return;
        }

        try {
            const res = await fetch(`/bookmark/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
            });

            // Baca response text dulu (untuk debug kalau bukan JSON)
            const text = await res.text();
            let data = {};
            try { data = JSON.parse(text); } catch (e) { /* bukan JSON */ }

            if (!res.ok) {
                console.error('Response error:', res.status, text);
                showFavToast(data.message || `Gagal (${res.status})`);
                return;
            }

            // Sukses — animasi hapus
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => {
                card.remove();
                showFavToast('Resep dihapus dari favorit');

                // Reload kalau kartu habis
                if (document.querySelectorAll('.remove-favorite-btn').length === 0) {
                    window.location.reload();
                }
            }, 300);

        } catch (err) {
            console.error('Fetch error:', err);
            showFavToast('Gagal menghapus. Cek Console (F12).');
        }
    });
});

/* ============ SAVE (dari rekomendasi) ============ */
document.querySelectorAll('.save-btn').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();
        e.stopPropagation();
        const id = btn.dataset.recipeId;
        const icon = btn.querySelector('.heart-icon');
        const title = btn.dataset.title;

        try {
            const res = await fetch(`/bookmark/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();

            if (data.status === 'added') {
                icon.style.fontVariationSettings = "'FILL' 1";
                icon.classList.add('text-error');
                icon.classList.remove('text-outline');
                showFavToast(`"${title}" disimpan ke favorit`);
                setTimeout(() => window.location.reload(), 1200);
            } else {
                icon.style.fontVariationSettings = "'FILL' 0";
                icon.classList.remove('text-error');
                icon.classList.add('text-outline');
                showFavToast(`"${title}" dihapus dari favorit`);
            }
        } catch (err) {
            console.error(err);
            showFavToast('Gagal. Coba lagi.');
        }
    });
});
</script>
@endpush