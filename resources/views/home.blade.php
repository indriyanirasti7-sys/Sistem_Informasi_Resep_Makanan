@extends('layouts.app')

@section('title', "Griya Rasa — Inspirasi & Resep Kuliner")

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
<div class="flex flex-col w-full">

    {{-- 1. HERO CAROUSEL --}}
    @php
        $heroRecipes = $featured->take(3);
        $heroDishes = $heroRecipes->map(function ($r) {
            return [
                'id'         => $r->id,
                'title'      => $r->title,
                'url'        => route('recipes.show', $r->slug),
                'desc'       => $r->description,
                'time'       => $r->formatted_duration ?? ($r->duration_minutes . ' mnt'),
                'servings'   => $r->servings . ' Porsi',
                'difficulty' => $r->difficulty,
                'calories'   => $r->calories ? $r->calories . ' kkal' : '-',
                'image'      => $r->image ? Storage::url($r->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop',
                'ingredients'=> $r->ingredients->take(5)->pluck('name'),
            ];
        })->values();
    @endphp

    <section class="w-full px-5 lg:px-12 pt-28 lg:pt-32 pb-12">
        <div class="relative rounded-[2.5rem] p-6 lg:p-12 shadow-2xl overflow-hidden text-white">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" alt="Background Masakan" class="absolute inset-0 w-full h-full object-cover z-0" />
            <div class="absolute inset-0 bg-secondary/90 z-0"></div>
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/20 rounded-full blur-3xl pointer-events-none z-0"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-primary-fixed/10 rounded-full blur-3xl pointer-events-none z-0"></div>

            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-8 items-center z-10">
                <div class="flex flex-col items-start gap-4 z-10">
                    
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 shadow-sm border border-white/10">
                        <span class="material-symbols-outlined text-[18px] text-primary-fixed" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        <span class="text-[11px] uppercase tracking-wider text-white font-bold">Resep Unggulan Hari Ini</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed"></span>
                        <span class="text-[11px] text-primary-fixed font-bold" id="hero-carousel-index">1 / {{ max($heroDishes->count(), 1) }}</span>
                    </div>

                    <div class="min-h-[110px] lg:min-h-[140px] flex items-center">
                        <h1 class="font-display text-4xl lg:text-5xl xl:text-[64px] text-white transition-opacity duration-300 font-bold leading-[1.1] tracking-tight drop-shadow-md" id="hero-title">
                            {{ $heroDishes[0]['title'] ?? 'Belum ada resep' }}
                        </h1>
                    </div>

                    <p class="text-base lg:text-lg text-white/90 max-w-lg transition-opacity duration-300 leading-relaxed drop-shadow-sm" id="hero-desc">
                        {{ $heroDishes[0]['desc'] ?? '' }}
                    </p>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full max-w-xl pt-2">
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-primary-fixed text-[22px]">timer</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase text-white/60 font-bold">Waktu</span>
                                <span class="text-xs text-white font-bold truncate" id="hero-time">{{ $heroDishes[0]['time'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-primary-fixed text-[22px]">group</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase text-white/60 font-bold">Porsi</span>
                                <span class="text-xs text-white font-bold truncate" id="hero-servings">{{ $heroDishes[0]['servings'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-tertiary-fixed text-[22px]" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase text-white/60 font-bold">Tingkat</span>
                                <span class="text-xs text-white font-bold truncate" id="hero-difficulty">{{ $heroDishes[0]['difficulty'] ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-white/10 border border-white/10 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-error text-[22px]">local_fire_department</span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase text-white/60 font-bold">Kalori</span>
                                <span class="text-xs text-white font-bold truncate" id="hero-calories">{{ $heroDishes[0]['calories'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 w-full pt-2">
                        <span class="text-[11px] uppercase tracking-wider text-white/70 font-bold">Bahan Kunci Pilihan</span>
                        <div class="flex flex-wrap items-center gap-2" id="hero-ingredients">
                            @foreach (($heroDishes[0]['ingredients'] ?? collect()) as $ing)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-white text-xs font-medium backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed"></span>{{ $ing }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-4">
                        <a href="{{ route('recipes.daftar_resep') }}"
                        class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-primary-fixed text-primary text-sm font-bold shadow-lg hover:bg-white transition-all transform hover:-translate-y-0.5">
                            <span>Lihat Resep Lengkap</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                        
                        {{-- ✅ TOMBOL MULAI MASAK (BUKA MODAL) --}}
                        <button type="button" onclick="openCookingModal()"
                                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white/10 border border-white/20 text-white text-sm font-bold shadow-sm hover:bg-white/20 backdrop-blur-md transition-all">
                            <span class="material-symbols-outlined text-primary-fixed text-[22px]" style="font-variation-settings: 'FILL' 1;">skillet</span>
                            <span>Mulai Memasak</span>
                        </button>
                    </div>
                </div>

                <div class="relative flex flex-col items-center justify-center mt-10 lg:mt-0 lg:translate-x-6">
                    <div class="relative w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] lg:w-[450px] lg:h-[450px] flex items-center justify-center">
                        <svg class="absolute inset-0 w-full h-full text-white/10 fill-current transition-transform duration-700 ease-out" id="hero-blob" viewBox="0 0 500 500">
                            <path d="M428.5,310Q407,370,351,408.5Q295,447,233.5,436.5Q172,426,121.5,386.5Q71,347,56.5,285Q42,223,80.5,166Q119,109,178,77.5Q237,46,303.5,67.5Q370,89,410,144.5Q450,200,428.5,310Z"></path>
                        </svg>

                        <div class="relative w-[260px] h-[260px] sm:w-[340px] sm:h-[340px] lg:w-[380px] lg:h-[380px] rounded-full p-2 bg-white/10 border border-white/20 backdrop-blur-md shadow-[0_20px_50px_-12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-700 ease-out" id="dish-rotate-wrapper">
                            <img id="hero-plate-image" class="w-full h-full object-cover rounded-full shadow-inner select-none transition-opacity duration-300"
                                src="{{ $heroDishes[0]['image'] ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop' }}"
                                alt="{{ $heroDishes[0]['title'] ?? '' }}" />
                            <div class="absolute bottom-6 right-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6 z-20">
                        <button id="carousel-prev" type="button" class="w-11 h-11 rounded-full bg-white/10 border border-white/20 shadow-sm hover:bg-white/20 text-white flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </button>
                        <div class="flex items-center gap-2 p-1.5 rounded-full bg-white/10 border border-white/10">
                            @foreach ($heroDishes as $i => $dish)
                                <button type="button" class="carousel-dot transition-all {{ $i === 0 ? 'w-8 h-2.5 rounded-full bg-white' : 'w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white' }}" data-dish="{{ $i }}"></button>
                            @endforeach
                        </div>
                        <button id="carousel-next" type="button" class="w-11 h-11 rounded-full bg-white/10 border border-white/20 shadow-sm hover:bg-white/20 text-white flex items-center justify-center transition-all">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. CATEGORIES --}}
    <section class="w-full bg-surface-container/60 py-10">
        <div class="w-full px-5 lg:px-12 flex flex-col gap-6">
            <div class="flex flex-row items-end justify-between gap-3 mb-2">
                <div class="flex flex-col gap-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 md:px-3.5 md:py-1.5 rounded-full bg-secondary-container/50 border border-secondary/20 text-secondary w-fit">
                        <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                        <span class="text-[9px] md:text-xs uppercase tracking-widest font-bold">Inspirasi Sesi Santap</span>
                    </div>
                    <h2 class="font-display text-2xl md:text-4xl lg:text-5xl font-bold text-primary leading-tight">
                        Kategori <span class="italic text-secondary">Pilihan</span>
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($categories as $cat)
                    <a href="{{ route('recipes.daftar_resep', ['category' => $cat->slug]) }}"
                       class="group relative flex flex-col justify-end w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                        @if($cat->image)
                            <img src="{{ Storage::url($cat->image) }}" alt="{{ $cat->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=800&auto=format&fit=crop" alt="{{ $cat->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10 group-hover:from-black/90 transition-colors duration-300"></div>
                        <div class="relative z-10 p-4 md:p-5 flex flex-col text-left">
                            <span class="text-base md:text-xl font-bold text-white leading-tight">{{ $cat->name }}</span>
                            <span class="text-[11px] md:text-xs text-white/80 font-medium mt-1">{{ $cat->recipes_count ?? 0 }} Resep</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. POPULAR RECIPES --}}
    <section class="w-full px-5 lg:px-12 py-12 flex flex-col gap-8">
        <div class="flex flex-row items-end justify-between gap-3">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 md:px-3.5 md:py-1.5 rounded-full bg-secondary-container/50 border border-secondary/20 text-secondary w-fit">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    <span class="text-[9px] md:text-xs uppercase tracking-widest font-bold">Telah Dicoba Ribuan Koki</span>
                </div>
                <h2 class="font-display text-2xl md:text-4xl lg:text-5xl font-bold text-primary leading-tight">
                    Resep <span class="italic text-secondary">Terpopuler</span>
                </h2>
            </div>
            <a href="{{ route('recipes.daftar_resep') }}" class="inline-flex items-center gap-1 md:gap-2 px-4 py-2 md:px-6 md:py-3 rounded-full border border-outline-variant hover:bg-surface-container text-primary text-[11px] md:text-sm font-bold transition-all shrink-0 group">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px] md:text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6" id="recipe-grid">
            @include('recipes.partials.recipe_items', ['recipes' => $latest])
        </div>
    </section>

    {{-- 4. SMART PANTRY --}}
    <section id="asisten-kulkas" class="w-full px-5 lg:px-12 py-8">
        <div class="relative rounded-3xl bg-surface-container-high p-6 lg:p-10 overflow-hidden shadow-sm">
            <div class="absolute -right-16 -bottom-16 w-80 h-80 rounded-full bg-secondary-fixed/20 pointer-events-none -z-0"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-primary-container text-surface-bright flex items-center justify-center shrink-0 shadow-md">
                            <span class="material-symbols-outlined text-[32px]">kitchen</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] md:text-[11px] uppercase tracking-wider text-secondary font-bold">Asisten Kuliner Cerdas</span>
                            <h2 class="font-display text-xl md:text-2xl font-semibold text-primary">Punya Bahan Apa di Kulkas Hari Ini?</h2>
                            <p class="text-sm text-on-surface-variant max-w-2xl mt-1">Pilih bahan-bahan yang sudah Anda miliki di dapur, dan kami akan merekomendasikan hidangan lezat.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-start md:self-auto bg-surface-container-lowest px-4 py-2 rounded-full shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                        <span class="text-xs font-bold text-primary" id="pantry-counter">0 bahan dipilih</span>
                        <button id="pantry-clear" type="button" class="text-[11px] text-outline hover:text-error transition-colors underline ml-2">Kosongkan</button>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2.5" id="pantry-chips-container">
                    @php
                        $pantryOptions = $ingredients ?? collect(['Telur Ayam', 'Daging Ayam', 'Bawang Putih', 'Tahu & Tempe', 'Udang Segar', 'Tomat Segar', 'Kentang', 'Brokoli Hijau', 'Nasi Putih', 'Jamur Tiram', 'Santan Kelapa', 'Cabai Merah']);
                    @endphp
                    @foreach ($pantryOptions as $ing)
                        <button type="button" data-active="false" class="pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-secondary-fixed/40 shadow-sm transition-all">
                            <span class="material-symbols-outlined text-[18px] text-outline">add</span>
                            <span>{{ is_string($ing) ? $ing : $ing->name }}</span>
                        </button>
                    @endforeach
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-surface-container-highest">
                    <div class="flex items-center gap-2 text-on-surface-variant text-xs sm:text-sm">
                        <span class="material-symbols-outlined text-[18px] text-secondary">info</span>
                        <span>Tersedia <strong>18 resep lezat</strong> yang cocok dengan kombinasi bahan Anda.</span>
                    </div>
                    <button type="button" id="btn-search-pantry" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-primary-container text-surface-bright text-sm font-bold shadow-md hover:bg-primary hover:shadow-lg transition-all">
                        <span class="material-symbols-outlined text-[20px] text-on-tertiary-container">auto_fix_high</span>
                        <span>Cari Resep dari Bahan Ini</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. TIPS --}}
    <section class="w-full px-5 lg:px-12 py-12 flex flex-col gap-8">
        <div class="flex flex-row items-end justify-between gap-3">
            <div class="flex flex-col gap-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 md:px-3.5 md:py-1.5 rounded-full bg-secondary-container/50 border border-secondary/20 text-secondary w-fit">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    <span class="text-[9px] md:text-xs uppercase tracking-widest font-bold">Wawasan Gastronomi</span>
                </div>
                <h2 class="font-display text-2xl md:text-4xl lg:text-5xl font-bold text-primary leading-tight">
                    Tips <span class="italic text-secondary">&amp; Rahasia Dapur</span>
                </h2>
            </div>
            <a href="{{ route('tips.panduan') }}" class="inline-flex items-center gap-1 md:gap-2 px-4 py-2 md:px-6 md:py-3 rounded-full border border-outline-variant hover:bg-surface-container text-primary text-[11px] md:text-sm font-bold transition-all shrink-0 group">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px] md:text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        <div id="tips-container" class="flex items-stretch gap-4 lg:gap-6 overflow-x-auto snap-x snap-mandatory pb-4 no-scrollbar scroll-smooth cursor-grab active:cursor-grabbing">
            @forelse ($tips as $tip)
                <article class="snap-start shrink-0 w-[280px] sm:w-[320px] flex flex-col bg-surface-container-lowest rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="relative w-full aspect-[16/10] overflow-hidden bg-surface-container">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             src="{{ $tip->image ? Storage::url($tip->image) : 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $tip->title }}" />
                        @auth
                            <button type="button" data-tip-slug="{{ $tip->slug }}" class="save-tip-btn absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' {{ auth()->user()->hasSavedTip($tip->id) ? 1 : 0 }};">bookmark</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}?require_login=1" title="Masuk untuk menyimpan" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                                <span class="material-symbols-outlined text-[18px]">bookmark_border</span>
                            </a>
                        @endauth
                        <div class="absolute bottom-3 left-3 px-3 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md text-[10px] text-primary font-bold">Tips Dapur</div>
                    </div>
                    <div class="p-5 flex flex-col flex-1 justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-outline text-[10px] font-medium">
                                <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} mnt baca</span>
                                <span>•</span>
                                <span class="truncate">Oleh {{ $tip->user?->name ?? 'Tim Dapur' }}</span>
                            </div>
                            <a href="{{ route('tips.detail_tips', $tip->slug) }}">
                                <h3 class="font-display text-base font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 leading-snug">{{ $tip->title }}</h3>
                            </a>
                            <p class="text-xs text-on-surface-variant line-clamp-2 mt-1">{{ Str::limit(strip_tags($tip->content), 100) }}</p>
                        </div>
                        <a href="{{ route('tips.detail_tips', $tip->slug) }}" class="pt-3 border-t border-surface-container flex items-center justify-between text-[11px] font-bold text-primary group-hover:text-secondary transition-colors">
                            <span>Baca Selengkapnya</span>
                            <span class="material-symbols-outlined text-[16px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="w-full text-center py-10 text-sm text-on-surface-variant">Belum ada tips.</div>
            @endforelse
        </div>        
    </section>

</div>

{{-- ✅ 1. INCLUDE MODAL DI SINI --}}
@include('recipes.partials.cooking_modal')

@endsection

@push('scripts')
<script>
(function () {
    // 1. HERO CAROUSEL
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

            const ings = Array.isArray(data.ingredients) ? data.ingredients : [];
            heroIngredients.innerHTML = ings.map(ing => `
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-white text-xs font-medium backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed"></span>${ing}
                </span>
            `).join('');

            carouselDots.forEach((dot, dIndex) => {
                dot.className = dIndex === index
                    ? 'carousel-dot w-8 h-2.5 rounded-full bg-white transition-all'
                    : 'carousel-dot w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white transition-all';
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

    // 2. BOOKMARK RESEP
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const recipeSlug = btn.getAttribute('data-recipe-slug');
            const icon = btn.querySelector('.material-symbols-outlined');
            const isFilled = icon.style.fontVariationSettings?.includes("'FILL' 1");
            try {
                const res = await fetch(`/bookmark/${recipeSlug}`, {
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
                    btn.classList.remove('text-primary');
                    btn.classList.add('text-outline');
                } else {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.classList.remove('text-outline');
                    btn.classList.add('text-primary');
                }
            } catch (err) { console.error(err); }
        });
    });

    // 3. PANTRY CHIPS
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
                chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-secondary-fixed/40 shadow-sm transition-all';
                icon.textContent = 'add';
                icon.className = 'material-symbols-outlined text-[18px] text-outline';
            } else {
                chip.setAttribute('data-active', 'true');
                chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-secondary text-on-secondary text-xs font-bold shadow-sm transition-all';
                icon.textContent = 'check_circle';
                icon.className = 'material-symbols-outlined text-[18px]';
            }
            updatePantryCount();
        });
    });

    pantryClear?.addEventListener('click', () => {
        pantryChips.forEach(chip => {
            chip.setAttribute('data-active', 'false');
            chip.className = 'pantry-chip flex items-center gap-2 px-4 py-2 rounded-full bg-surface-container-lowest text-on-surface text-xs font-semibold hover:bg-secondary-fixed/40 shadow-sm transition-all';
            const icon = chip.querySelector('.material-symbols-outlined');
            icon.textContent = 'add';
            icon.className = 'material-symbols-outlined text-[18px] text-outline';
        });
        updatePantryCount();
    });

    // 4. SEARCH FROM PANTRY
    const btnSearchPantry = document.getElementById('btn-search-pantry');
    if (btnSearchPantry) {
        btnSearchPantry.addEventListener('click', () => {
            const activeChips = document.querySelectorAll('.pantry-chip[data-active="true"]');
            let selectedIngredients = [];
            activeChips.forEach(chip => {
                const text = chip.querySelector('span:last-child').innerText.trim();
                selectedIngredients.push(text);
            });
            if (selectedIngredients.length === 0) {
                alert('Silakan pilih minimal 1 bahan di kulkas Anda terlebih dahulu!');
                return;
            }
            const baseUrl = "{{ route('recipes.daftar_resep') }}";
            const queryString = "?ingredients=" + encodeURIComponent(selectedIngredients.join(','));
            window.location.href = baseUrl + queryString;
        });
    }

    // 5. SIMPAN TIPS
    document.querySelectorAll('.save-tip-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            const tipSlug = btn.getAttribute('data-tip-slug');
            const icon = btn.querySelector('.material-symbols-outlined');
            const isFilled = icon.style.fontVariationSettings?.includes("'FILL' 1");
            try {
                const res = await fetch(`/tips/${tipSlug}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                if (!res.ok) throw new Error('Gagal');
                const data = await res.json();
                if (data.status === 'added') {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.classList.remove('text-outline');
                    btn.classList.add('text-primary');
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.classList.remove('text-primary');
                    btn.classList.add('text-outline');
                }
            } catch (err) { console.error(err); }
        });
    });
})();

// ✅ 2. FUNGSI MODAL DARI HALAMAN BERANDA
function openCookingModal() {
    const modal = document.getElementById('cookingModalOverlay');
    if (!modal) return;

    // Ambil data resep dari carousel
    const activeDish = typeof dishes !== 'undefined' ? dishes[currentDishIndex] : null;
    
    if (activeDish) {
        // Ubah judul di modal
        const modalTitle = modal.querySelector('.text-base.font-bold.text-white');
        if (modalTitle) modalTitle.textContent = activeDish.title;
        
        // Tampilkan instruksi (karena data detail tidak ada, kita tampilkan info)
        const titleEl = document.getElementById('modalInstructionTitle');
        const detailEl = document.getElementById('modalInstructionDetail');
        if (titleEl) titleEl.textContent = activeDish.title;
        if (detailEl) detailEl.textContent = "Ini adalah mode memasak untuk resep " + activeDish.title + ". Karena Anda membukanya dari Beranda, langkah detail tidak ditampilkan. Silakan buka halaman detail resep untuk melihat langkah lengkap.";
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeCookingModal() {
    const modal = document.getElementById('cookingModalOverlay');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}
</script>
@endpush