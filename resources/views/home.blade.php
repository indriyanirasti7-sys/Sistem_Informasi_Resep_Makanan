@extends('layouts.app')

@section('title', "L'Art de Cuisine — Inspirasi & Resep Kuliner")

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="flex flex-col w-full">

    {{-- AMBIENT BACKGROUNDS --}}
    <div class="relative w-full overflow-hidden">
        <div class="absolute -top-24 -left-20 w-[540px] h-[540px] bg-secondary-fixed/30 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse" style="animation-duration: 9s;"></div>
        <div class="absolute top-80 -right-28 w-[620px] h-[620px] bg-primary-fixed/30 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-[1600px] left-1/3 w-[500px] h-[500px] bg-secondary-container/25 rounded-full blur-3xl pointer-events-none -z-10"></div>

        {{-- ============================================================ --}}
        {{-- 1. HERO CAROUSEL --}}
        {{-- ============================================================ --}}
        @php
            $heroRecipes = $featured->take(3);
            $heroDishes = $heroRecipes->map(function ($r) {
                return [
                    'id'         => $r->id,
                    'title'      => $r->title,
                    'url'        => route('recipes.show', $r->slug),
                    'desc'       => $r->description,
                    'time'       => $r->formatted_duration,
                    'servings'   => $r->servings . ' Porsi',
                    'difficulty' => $r->difficulty,
                    'calories'   => $r->calories ? $r->calories . ' kkal' : '-',
                    'image'      => $r->image ? Storage::url($r->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800',
                    'ingredients'=> $r->ingredients->take(5)->pluck('name'),
                ];
            })->values();
        @endphp

        <section class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pt-space-lg lg:pt-space-xl pb-space-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-6 flex flex-col items-start gap-space-md z-10">
                    <div class="inline-flex items-center gap-space-xs px-4 py-1.5 rounded-full bg-surface-container-high shadow-sm">
                        <span class="material-symbols-outlined text-[18px] text-on-tertiary-container" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Resep Unggulan Hari Ini</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        <span class="font-label-sm text-label-sm text-secondary font-bold" id="hero-carousel-index">1 / {{ max($heroDishes->count(), 1) }}</span>
                    </div>

                    <div class="min-h-[110px] lg:min-h-[140px] flex items-center">
                        <h1 class="font-headline-lg text-headline-lg lg:text-display text-primary transition-opacity duration-300" id="hero-title">
                            {{ $heroDishes[0]['title'] ?? 'Belum ada resep' }}
                        </h1>
                    </div>

                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl transition-opacity duration-300" id="hero-desc">
                        {{ $heroDishes[0]['desc'] ?? '' }}
                    </p>

                    {{-- Meta Chips --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-space-xs w-full max-w-xl pt-space-xs">
                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container-lowest shadow-sm">
                            <span class="material-symbols-outlined text-secondary text-[22px]">timer</span>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-sm text-[10px] uppercase text-outline">Waktu</span>
                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate" id="hero-time">{{ $heroDishes[0]['time'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container-lowest shadow-sm">
                            <span class="material-symbols-outlined text-secondary text-[22px]">group</span>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-sm text-[10px] uppercase text-outline">Porsi</span>
                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate" id="hero-servings">{{ $heroDishes[0]['servings'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container-lowest shadow-sm">
                            <span class="material-symbols-outlined text-on-tertiary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-sm text-[10px] uppercase text-outline">Tingkat</span>
                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate" id="hero-difficulty">{{ $heroDishes[0]['difficulty'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container-lowest shadow-sm">
                            <span class="material-symbols-outlined text-error text-[22px]">local_fire_department</span>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-sm text-[10px] uppercase text-outline">Kalori</span>
                                <span class="font-label-md text-label-md text-on-surface font-semibold truncate" id="hero-calories">{{ $heroDishes[0]['calories'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Ingredients --}}
                    <div class="flex flex-col gap-2 w-full pt-space-xs">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">Bahan Kunci Pilihan</span>
                        <div class="flex flex-wrap items-center gap-2" id="hero-ingredients">
                            @foreach (($heroDishes[0]['ingredients'] ?? collect()) as $ing)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface text-body-sm font-body-sm shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>{{ $ing }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap items-center gap-space-sm pt-space-sm">
                        <a href="{{ $heroDishes[0]['url'] ?? '#' }}"
                           class="inline-flex items-center gap-3 px-7 py-3.5 rounded-full bg-primary-container text-surface-bright font-label-lg text-label-lg shadow-md hover:bg-primary hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <span>Lihat Resep Lengkap</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                        <button type="button"
                                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-surface-container-lowest text-primary font-label-lg text-label-lg shadow-sm hover:bg-secondary-fixed/40 transition-all">
                            <span class="material-symbols-outlined text-secondary text-[22px]" style="font-variation-settings: 'FILL' 1;">skillet</span>
                            <span>Mulai Memasak</span>
                        </button>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-6 relative flex flex-col items-center justify-center mt-8 lg:mt-0">
                    <div class="relative w-[340px] h-[340px] sm:w-[460px] sm:h-[460px] flex items-center justify-center">
                        <svg class="absolute inset-0 w-full h-full text-secondary-fixed fill-current transition-transform duration-700 ease-out" id="hero-blob" viewBox="0 0 500 500">
                            <path d="M428.5,310Q407,370,351,408.5Q295,447,233.5,436.5Q172,426,121.5,386.5Q71,347,56.5,285Q42,223,80.5,166Q119,109,178,77.5Q237,46,303.5,67.5Q370,89,410,144.5Q450,200,428.5,310Z"></path>
                        </svg>

                        <div class="absolute -top-4 right-10 w-12 h-12 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center shadow-md animate-bounce" style="animation-duration: 4s;">
                            <span class="text-xl">🌿</span>
                        </div>
                        <div class="absolute bottom-6 left-6 w-11 h-11 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center shadow-md animate-bounce" style="animation-duration: 5s;">
                            <span class="text-lg">🌶️</span>
                        </div>
                        <div class="absolute -bottom-2 right-16 w-10 h-10 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center shadow-md animate-pulse">
                            <span class="text-base">🧄</span>
                        </div>

                        <div class="absolute -top-12 z-20 flex gap-4 pointer-events-none opacity-40">
                            <span class="w-1.5 h-16 bg-gradient-to-t from-surface-dim to-transparent rounded-full blur-[2px] animate-pulse" style="animation-duration: 2.2s;"></span>
                            <span class="w-1.5 h-20 bg-gradient-to-t from-surface-dim to-transparent rounded-full blur-[2px] animate-pulse" style="animation-duration: 1.8s; animation-delay: 0.4s;"></span>
                            <span class="w-1.5 h-14 bg-gradient-to-t from-surface-dim to-transparent rounded-full blur-[2px] animate-pulse" style="animation-duration: 2.6s; animation-delay: 0.8s;"></span>
                        </div>

                        <div class="relative w-[280px] h-[280px] sm:w-[380px] sm:h-[380px] rounded-full p-2 bg-surface-container-lowest shadow-[0_20px_50px_-12px_rgba(90,58,34,0.22)] z-10 transition-transform duration-700 ease-out" id="dish-rotate-wrapper">
                            <img id="hero-plate-image"
                                 class="w-full h-full object-cover rounded-full shadow-inner select-none transition-opacity duration-300"
                                 src="{{ $heroDishes[0]['image'] ?? 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                                 alt="{{ $heroDishes[0]['title'] ?? '' }}" />

                            <div class="absolute bottom-4 right-4 bg-surface-container-lowest/95 backdrop-blur-md px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-[20px]" style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                                <span class="font-label-sm text-label-sm font-bold text-primary">Rekomendasi Chef</span>
                            </div>
                        </div>
                    </div>

                    {{-- Carousel Controls --}}
                    <div class="flex items-center gap-space-md mt-space-lg z-20">
                        <button id="carousel-prev" type="button" aria-label="Hidangan Sebelumnya"
                                class="w-11 h-11 rounded-full bg-surface-container-lowest shadow-sm hover:bg-secondary-fixed/50 hover:shadow-md text-primary flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>

                        <div class="flex items-center gap-2 p-1.5 rounded-full bg-surface-container-high">
                            @foreach ($heroDishes as $i => $dish)
                                <button type="button" aria-label="Pilih {{ $dish['title'] }}"
                                        class="carousel-dot transition-all {{ $i === 0 ? 'w-8 h-2.5 rounded-full bg-primary-container' : 'w-2.5 h-2.5 rounded-full bg-outline-variant hover:bg-primary' }}"
                                        data-dish="{{ $i }}"></button>
                            @endforeach
                        </div>

                        <button id="carousel-next" type="button" aria-label="Hidangan Berikutnya"
                                class="w-11 h-11 rounded-full bg-surface-container-lowest shadow-sm hover:bg-secondary-fixed/50 hover:shadow-md text-primary flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================================================ --}}
        {{-- 2. CATEGORIES --}}
        {{-- ============================================================ --}}
        <section class="w-full bg-surface-container/60 py-space-2xl">
            <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin flex flex-col gap-space-lg">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm">
                    <div class="flex flex-col gap-1">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">Inspirasi Setiap Sesi Santap</span>
                        <h2 class="font-headline-md text-headline-md font-semibold text-primary">Kategori Kuliner Pilihan</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Temukan resep sempurna untuk setiap momen, selera makan, dan kebutuhan gizi keluarga.</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button id="cat-scroll-left" type="button" class="w-10 h-10 rounded-full bg-surface-container-lowest shadow-sm hover:bg-secondary-fixed/50 text-primary flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        </button>
                        <button id="cat-scroll-right" type="button" class="w-10 h-10 rounded-full bg-surface-container-lowest shadow-sm hover:bg-secondary-fixed/50 text-primary flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <div id="category-container" class="flex items-center gap-space-lg overflow-x-auto pb-4 pt-2 no-scrollbar scroll-smooth">
                    @foreach ($categories as $i => $cat)
                        @php $isActive = $i === 1; // Highlight default seperti desain asli @endphp
                        <a href="{{ route('recipes.daftar_resep', ['category' => $cat->slug]) }}"
                           class="category-card flex flex-col items-center gap-space-sm group cursor-pointer shrink-0 transition-transform hover:-translate-y-1"
                           data-cat="{{ $cat->slug }}">
                            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full p-1.5 transition-all
                                        {{ $isActive ? 'bg-secondary shadow-[0_4px_20px_-2px_rgba(85,100,59,0.35)]' : 'bg-surface-container-lowest group-hover:shadow-md' }}">
                                <div class="w-full h-full rounded-full bg-surface-container flex items-center justify-center text-3xl">
                                    <span class="material-symbols-outlined text-primary text-[42px]">{{ $cat->icon ?? 'restaurant' }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="font-title-md text-title-md {{ $isActive ? 'font-bold text-secondary' : 'font-semibold text-primary group-hover:text-secondary' }} transition-colors">
                                    {{ $cat->name }}
                                </span>
                                <span class="font-label-sm text-label-sm {{ $isActive ? 'px-2.5 py-0.5 rounded-full bg-secondary/15 text-secondary font-semibold' : 'text-outline' }}">
                                    {{ $cat->recipes_count ?? 0 }}+ Resep
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================ --}}
        {{-- 3. POPULAR RECIPES --}}
        {{-- ============================================================ --}}
        <section class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-2xl flex flex-col gap-space-xl">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">Telah Dicoba Ribuan Koki Rumahan</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md font-semibold text-primary">Resep Terpopuler Minggu Ini</h2>
                </div>

                <div class="flex items-center gap-1.5 p-1.5 rounded-full bg-surface-container-high overflow-x-auto no-scrollbar">
                    <button type="button" data-filter="all" class="popular-filter-btn px-4 py-1.5 rounded-full bg-primary-container text-surface-bright font-label-md text-label-md shadow-sm transition-all">Semua</button>
                    <button type="button" data-filter="cepat" class="popular-filter-btn px-4 py-1.5 rounded-full text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all">Paling Cepat</button>
                    <button type="button" data-filter="keluarga" class="popular-filter-btn px-4 py-1.5 rounded-full text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all">Keluarga</button>
                    <button type="button" data-filter="sehat" class="popular-filter-btn px-4 py-1.5 rounded-full text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all">Sehat &amp; Rendah Kalori</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
                @forelse ($latest as $recipe)
                    @php
                        $isQuick   = $recipe->duration_minutes && $recipe->duration_minutes <= 30;
                        $isFamily  = $recipe->servings >= 4;
                        $isHealthy = $recipe->calories && $recipe->calories <= 400;
                        $tags = trim(($isQuick ? 'cepat ' : '') . ($isFamily ? 'keluarga ' : '') . ($isHealthy ? 'sehat' : ''));

                        $badgeClass = match ($recipe->difficulty) {
                            'Mudah' => 'bg-secondary-container text-on-secondary-container',
                            'Sedang' => 'bg-primary-fixed text-primary',
                            'Sulit' => 'bg-error-container text-on-error-container',
                            default => 'bg-surface-container-high text-on-surface',
                        };
                    @endphp
                    <div class="group flex flex-col bg-surface-container-lowest rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden"
                         data-category-tag="{{ $tags }}">
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                            <a href="{{ route('recipes.show', $recipe->slug) }}">
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                                     alt="{{ $recipe->title }}" />
                            </a>
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full {{ $badgeClass }} font-label-sm text-label-sm font-bold shadow-sm">
                                {{ $recipe->difficulty }}
                            </span>
                            @auth
                                <button type="button" data-recipe-id="{{ $recipe->id }}"
                                        class="bookmark-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-surface/90 backdrop-blur-md text-outline hover:text-error flex items-center justify-center shadow-sm transition-colors">
                                    <span class="material-symbols-outlined text-[19px]">favorite</span>
                                </button>
                            @endauth
                        </div>
                        <div class="p-5 flex flex-col flex-1 justify-between gap-space-sm">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between text-body-sm font-body-sm text-outline">
                                    <span>{{ $recipe->category->name ?? 'Umum' }}</span>
                                    <div class="flex items-center gap-1 text-on-tertiary-container font-semibold">
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                        <span>{{ $recipe->average_rating }} <span class="text-outline font-normal">({{ $recipe->rating_count }})</span></span>
                                    </div>
                                </div>
                                <a href="{{ route('recipes.show', $recipe->slug) }}">
                                    <h3 class="font-title-md text-title-md font-semibold text-primary group-hover:text-secondary transition-colors line-clamp-2">
                                        {{ $recipe->title }}
                                    </h3>
                                </a>
                            </div>
                            <div class="pt-3 flex items-center justify-between border-t border-surface-container">
                                <div class="flex items-center gap-1.5 text-on-surface-variant font-label-sm text-label-sm">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                                    <span>{{ $recipe->duration_minutes ? $recipe->duration_minutes . ' mnt' : '-' }}</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline">Oleh {{ $recipe->user->name ?? 'Anonim' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 text-on-surface-variant">
                        Belum ada resep yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ============================================================ --}}
        {{-- 4. SMART PANTRY --}}
        {{-- ============================================================ --}}
        <section class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-xl">
            <div class="relative rounded-xl bg-surface-container-high p-space-lg lg:p-space-2xl overflow-hidden shadow-sm">
                <div class="absolute -right-16 -bottom-16 w-80 h-80 rounded-full bg-secondary-fixed/20 pointer-events-none -z-0"></div>
                <div class="relative z-10 flex flex-col gap-space-lg">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-primary-container text-surface-bright flex items-center justify-center shrink-0 shadow-md">
                                <span class="material-symbols-outlined text-[32px]">kitchen</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">Asisten Kuliner Cerdas</span>
                                <h2 class="font-headline-md text-headline-md font-semibold text-primary">Punya Bahan Apa di Kulkas Hari Ini?</h2>
                                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                                    Pilih bahan-bahan yang sudah Anda miliki di dapur, dan kami akan merekomendasikan hidangan lezat berimbang tanpa perlu belanja ekstra.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 self-start md:self-auto bg-surface-container-lowest px-4 py-2 rounded-full shadow-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                            <span class="font-label-md text-label-md font-bold text-primary" id="pantry-counter">0 bahan dipilih</span>
                            <button id="pantry-clear" type="button" class="font-label-sm text-label-sm text-outline hover:text-error transition-colors underline ml-2">Kosongkan</button>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2.5 pt-space-xs" id="pantry-chips-container">
                        @php
                            $pantryOptions = $ingredients ?? collect([
                                'Telur Ayam', 'Daging Ayam', 'Bawang Putih',
                                'Tahu & Tempe', 'Udang Segar', 'Tomat Segar',
                                'Kentang', 'Brokoli Hijau', 'Nasi Putih',
                                'Jamur Tiram', 'Santan Kelapa', 'Cabai Merah',
                            ]);
                        @endphp
                        @foreach ($pantryOptions as $ing)
                            <button type="button" data-active="false"
                                    class="pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface font-label-md text-label-md hover:bg-secondary-fixed/40 shadow-sm transition-all">
                                <span class="material-symbols-outlined text-[18px] text-outline">add</span>
                                <span>{{ is_string($ing) ? $ing : $ing->name }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-space-md pt-space-sm border-t border-surface-container-highest">
                        <div class="flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm">
                            <span class="material-symbols-outlined text-[18px] text-secondary">info</span>
                            <span>Tersedia <strong>18 resep lezat</strong> yang cocok dengan kombinasi bahan Anda.</span>
                        </div>
                        <button type="button"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-primary-container text-surface-bright font-label-lg text-label-lg shadow-md hover:bg-primary hover:shadow-lg transition-all">
                            <span class="material-symbols-outlined text-[20px] text-on-tertiary-container">auto_fix_high</span>
                            <span>Cari Resep dari Bahan Ini</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================================================ --}}
        {{-- 5. TIPS --}}
        {{-- ============================================================ --}}
        <section class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-2xl flex flex-col gap-space-xl">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm">
                <div class="flex flex-col gap-1">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">Wawasan Gastronomi</span>
                    <h2 class="font-headline-md text-headline-md font-semibold text-primary">Tips &amp; Rahasia Dapur</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Panduan praktis dari chef berpengalaman untuk memasak lebih percaya diri dan konsisten.</p>
                </div>
                <a href="{{ route('tips.panduan') }}" class="inline-flex items-center gap-1 font-label-md text-label-md text-secondary hover:text-primary font-bold transition-colors">
                    <span>Lihat Semua Artikel Tips</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                @forelse ($tips as $tip)
                    <article class="flex flex-col bg-surface-container-lowest rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group">
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-surface-container">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 src="{{ $tip->image ? Storage::url($tip->image) : 'https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=800' }}"
                                 alt="{{ $tip->title }}" />
                            <div class="absolute bottom-3 left-3 px-3 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md font-label-sm text-label-sm text-primary font-bold">
                                Tips Dapur
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1 justify-between gap-space-md">
                            <div class="flex flex-col gap-space-xs">
                                <div class="flex items-center gap-2 text-outline font-label-sm text-label-sm">
                                    <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} mnt baca</span>
                                    <span>•</span>
                                    <span>Oleh {{ $tip->user->name ?? 'Tim Dapur' }}</span>
                                </div>
                                <a href="{{ route('tips.panduan', $tip->slug) }}">
                                    <h3 class="font-title-md text-title-md font-semibold text-primary group-hover:text-secondary transition-colors">
                                        {{ $tip->title }}
                                    </h3>
                                </a>
                                <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">
                                    {{ Str::limit(strip_tags($tip->content), 140) }}
                                </p>
                            </div>
                            <a href="{{ route('tips.detail_tips', $tip->slug) }}"
                               class="pt-2 flex items-center gap-1 font-label-md text-label-md text-primary group-hover:text-secondary font-semibold transition-colors">
                                <span>Baca Selengkapnya</span>
                                <span class="material-symbols-outlined text-[16px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-12 text-on-surface-variant">
                        Belum ada tips.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ============================================================ --}}
        {{-- 6. CHEF QUOTE --}}
        {{-- ============================================================ --}}
        <section class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin pb-space-2xl">
            <div class="p-space-lg lg:p-space-xl rounded-xl bg-surface-container text-center flex flex-col items-center justify-center gap-space-sm relative overflow-hidden">
                <span class="material-symbols-outlined text-secondary/30 text-[64px] absolute -top-2 left-6 pointer-events-none select-none">format_quote</span>
                <p class="font-headline-sm text-headline-sm font-display italic text-primary max-w-2xl relative z-10">
                    "Memasak bukanlah sekadar mengikuti resep, melainkan percakapan intim antara kearifan rempah warisan dan sentuhan cinta di setiap suapan."
                </p>
                <span class="font-label-md text-label-md uppercase tracking-wider text-secondary font-bold relative z-10">
                    — Chef Aruna Adiputra • Pendiri L'Art de Cuisine
                </span>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    // ===========================================================
    // 1. HERO CAROUSEL — data dari server (Blade), interaksi di JS
    // ===========================================================
    const dishes = @json($heroDishes);

    let currentDishIndex = 0;
    let autoRotateTimer = null;
    let currentDegree = 0;

    const heroTitle       = document.getElementById('hero-title');
    const heroDesc        = document.getElementById('hero-desc');
    const heroTime        = document.getElementById('hero-time');
    const heroServings    = document.getElementById('hero-servings');
    const heroDifficulty  = document.getElementById('hero-difficulty');
    const heroCalories    = document.getElementById('hero-calories');
    const heroIngredients = document.getElementById('hero-ingredients');
    const heroPlateImage  = document.getElementById('hero-plate-image');
    const dishWrapper     = document.getElementById('dish-rotate-wrapper');
    const heroIndexLabel  = document.getElementById('hero-carousel-index');
    const carouselDots    = document.querySelectorAll('.carousel-dot');
    const heroLink        = document.querySelector('a[href*="/resep/"]');

    if (dishes.length === 0) return;

    function updateHeroDish(index, direction = 1) {
        currentDishIndex = index;
        const data = dishes[index];

        currentDegree += (direction * 45);
        if (dishWrapper) dishWrapper.style.transform = `rotate(${currentDegree}deg)`;

        heroTitle.style.opacity = '0';
        heroDesc.style.opacity = '0';
        heroPlateImage.style.opacity = '0.3';

        setTimeout(() => {
            heroTitle.textContent       = data.title;
            heroDesc.textContent        = data.desc || '';
            heroTime.textContent        = data.time || '-';
            heroServings.textContent    = data.servings || '-';
            heroDifficulty.textContent  = data.difficulty || '-';
            heroCalories.textContent    = data.calories || '-';
            heroIndexLabel.textContent  = `${index + 1} / ${dishes.length}`;
            heroPlateImage.src          = data.image;
            heroPlateImage.alt          = data.title;
            if (heroLink) heroLink.href = data.url;

            const ings = Array.isArray(data.ingredients) ? data.ingredients : [];
            heroIngredients.innerHTML = ings.map(ing => `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-on-surface text-body-sm font-body-sm shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>${ing}
                </span>
            `).join('');

            carouselDots.forEach((dot, dIndex) => {
                dot.className = dIndex === index
                    ? 'carousel-dot w-8 h-2.5 rounded-full bg-primary-container transition-all'
                    : 'carousel-dot w-2.5 h-2.5 rounded-full bg-outline-variant hover:bg-primary transition-all';
            });

            heroTitle.style.opacity = '1';
            heroDesc.style.opacity = '1';
            heroPlateImage.style.opacity = '1';
        }, 250);
    }

    const nextDish = () => updateHeroDish((currentDishIndex + 1) % dishes.length, 1);
    const prevDish = () => updateHeroDish((currentDishIndex - 1 + dishes.length) % dishes.length, -1);

    function startAutoRotate() {
        stopAutoRotate();
        autoRotateTimer = setInterval(nextDish, 6500);
    }
    function stopAutoRotate() {
        if (autoRotateTimer) clearInterval(autoRotateTimer);
    }

    document.getElementById('carousel-next')?.addEventListener('click', () => { nextDish(); startAutoRotate(); });
    document.getElementById('carousel-prev')?.addEventListener('click', () => { prevDish(); startAutoRotate(); });
    carouselDots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            const targetIndex = parseInt(e.currentTarget.getAttribute('data-dish') || '0', 10);
            updateHeroDish(targetIndex, targetIndex > currentDishIndex ? 1 : -1);
            startAutoRotate();
        });
    });
    startAutoRotate();

    // ===========================================================
    // 2. CATEGORY SCROLL
    // ===========================================================
    const categoryContainer = document.getElementById('category-container');
    document.getElementById('cat-scroll-left')?.addEventListener('click', () => {
        categoryContainer.scrollBy({ left: -260, behavior: 'smooth' });
    });
    document.getElementById('cat-scroll-right')?.addEventListener('click', () => {
        categoryContainer.scrollBy({ left: 260, behavior: 'smooth' });
    });

    // ===========================================================
    // 3. BOOKMARK TOGGLE (AJAX ke server)
    // ===========================================================
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();

            const recipeId = btn.getAttribute('data-recipe-id');
            const icon = btn.querySelector('.material-symbols-outlined');
            const isFilled = icon.style.fontVariationSettings?.includes("'FILL' 1");

            try {
                const res = await fetch(`/bookmark/${recipeId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                if (!res.ok) throw new Error('Gagal');

                if (isFilled) {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.classList.remove('text-error');
                    btn.classList.add('text-outline');
                } else {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.classList.remove('text-outline');
                    btn.classList.add('text-error');
                }
            } catch (err) {
                console.error(err);
            }
        });
    });

    // ===========================================================
    // 4. POPULAR FILTER
    // ===========================================================
    const filterBtns  = document.querySelectorAll('.popular-filter-btn');
    const recipeCards = document.querySelectorAll('[data-category-tag]');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.className = 'popular-filter-btn px-4 py-1.5 rounded-full text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all';
            });
            btn.className = 'popular-filter-btn px-4 py-1.5 rounded-full bg-primary-container text-surface-bright font-label-md text-label-md shadow-sm transition-all';

            const filter = btn.getAttribute('data-filter');
            recipeCards.forEach(card => {
                const tags = card.getAttribute('data-category-tag') || '';
                card.style.display = (filter === 'all' || tags.includes(filter)) ? 'flex' : 'none';
            });
        });
    });

    // ===========================================================
    // 5. PANTRY CHIPS
    // ===========================================================
    const pantryChips   = document.querySelectorAll('.pantry-chip');
    const pantryCounter = document.getElementById('pantry-counter');
    const pantryClear   = document.getElementById('pantry-clear');

    function updatePantryCount() {
        const activeCount = document.querySelectorAll('.pantry-chip[data-active="true"]').length;
        if (pantryCounter) pantryCounter.textContent = `${activeCount} bahan dipilih`;
    }

    pantryChips.forEach(chip => {
        chip.addEventListener('click', () => {
            const isActive = chip.getAttribute('data-active') === 'true';
            const icon = chip.querySelector('.material-symbols-outlined');

            if (isActive) {
                chip.setAttribute('data-active', 'false');
                chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface font-label-md text-label-md hover:bg-secondary-fixed/40 shadow-sm transition-all';
                icon.textContent = 'add';
                icon.className = 'material-symbols-outlined text-[18px] text-outline';
            } else {
                chip.setAttribute('data-active', 'true');
                chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-secondary text-on-secondary font-label-md text-label-md shadow-sm transition-all';
                icon.textContent = 'check_circle';
                icon.className = 'material-symbols-outlined text-[18px]';
            }
            updatePantryCount();
        });
    });

    pantryClear?.addEventListener('click', () => {
        pantryChips.forEach(chip => {
            chip.setAttribute('data-active', 'false');
            chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface font-label-md text-label-md hover:bg-secondary-fixed/40 shadow-sm transition-all';
            const icon = chip.querySelector('.material-symbols-outlined');
            icon.textContent = 'add';
            icon.className = 'material-symbols-outlined text-[18px] text-outline';
        });
        updatePantryCount();
    });

})();
</script>
@endpush