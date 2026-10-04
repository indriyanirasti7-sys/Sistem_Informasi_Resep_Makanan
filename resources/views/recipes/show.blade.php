@extends('layouts.app')

@section('title', $recipe->title . " — L'Art de Cuisine")

@section('content')
<div class="flex flex-col w-full">

    {{-- Toast Notification --}}
    <div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-full shadow-lg"
         id="toastNotification">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <span class="text-sm font-semibold" id="toastMessage">Tautan berhasil disalin!</span>
    </div>

    <div class="max-w-[1280px] w-full mx-auto px-5 lg:px-12 py-6 flex flex-col gap-12">

        {{-- Breadcrumbs & Top Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-2">
            <nav class="flex items-center gap-2 text-sm text-on-surface-variant flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                <a href="{{ route('recipes.index') }}" class="hover:text-primary transition-colors">Daftar Resep</a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                @if ($recipe->category)
                    <a href="{{ route('recipes.index', ['category' => $recipe->category->slug]) }}"
                       class="hover:text-primary transition-colors">{{ $recipe->category->name }}</a>
                    <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                @endif
                <span class="text-primary font-semibold truncate max-w-[200px] md:max-w-none">{{ $recipe->title }}</span>
            </nav>

            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" onclick="window.print()"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-full text-xs font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    <span class="hidden sm:inline">Cetak</span>
                </button>

                <button type="button" id="bookmarkBtn"
                        data-recipe-id="{{ $recipe->id }}"
                        data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
                        onclick="toggleBookmark()"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-full text-xs font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-primary" id="bookmarkIcon"
                          style="font-variation-settings: 'FILL' {{ $isBookmarked ? 1 : 0 }};">
                        {{ $isBookmarked ? 'bookmark' : 'bookmark_border' }}
                    </span>
                    <span class="font-semibold" id="bookmarkCount">{{ $recipe->bookmarks()->count() }}</span>
                    <span class="hidden sm:inline">disimpan</span>
                </button>

                <a href="https://api.whatsapp.com/send?text=Lihat resep {{ urlencode($recipe->title) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-1.5 px-3 py-1.5 bg-[#25D366]/15 hover:bg-[#25D366]/25 text-[#128C7E] rounded-full text-xs font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>WhatsApp</span>
                </a>

                <button type="button" onclick="copyRecipeLink()"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-full text-xs font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                    <span>Salin Link</span>
                </button>
            </div>
        </div>

        {{-- HERO --}}
        @include('recipes.partials.hero', ['recipe' => $recipe])

        {{-- INGREDIENTS + STEPS --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start" id="recipeCoreSection">
            @include('recipes.partials.ingredients', ['recipe' => $recipe])
            @include('recipes.partials.steps', ['recipe' => $recipe])
        </div>

        {{-- REVIEWS --}}
        @include('recipes.partials.reviews', ['recipe' => $recipe, 'userRating' => $userRating])

        {{-- RELATED --}}
        @include('recipes.partials.related', ['related' => $related])

    </div>

    {{-- COOKING MODE MODAL --}}
    @include('recipes.partials.cooking_modal')

</div>
@endsection

@push('scripts')
    @include('recipes.partials.scripts', ['recipe' => $recipe])
@endpush