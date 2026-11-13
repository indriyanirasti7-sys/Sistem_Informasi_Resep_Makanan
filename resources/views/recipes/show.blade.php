@extends('layouts.app')

@section('title', $recipe->title . " — Griya Rasa")

@section('content')
<div class="flex flex-col w-full relative">
    
    {{-- Ambient Background Glow --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-fixed/20 rounded-full blur-[100px] pointer-events-none -z-10"></div>
    <div class="absolute top-96 right-0 w-96 h-96 bg-secondary-fixed/20 rounded-full blur-[100px] pointer-events-none -z-10"></div>

    {{-- Toast Notification --}}
    <div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-2 px-5 py-3 bg-primary text-white rounded-full shadow-2xl"
         id="toastNotification">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        <span class="text-sm font-semibold" id="toastMessage">Tautan berhasil disalin!</span>
    </div>

    <div class="max-w-[1280px] w-full mx-auto px-5 lg:px-12 pt-28 lg:pt-32 pb-12 flex flex-col gap-6">
    
        {{-- ============================================================ --}}
        {{-- BREADCRUMB & ACTION BUTTONS --}}
        {{-- ============================================================ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs sm:text-sm text-on-surface-variant flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span class="material-symbols-outlined text-[14px] opacity-50">chevron_right</span>
                <a href="{{ route('recipes.daftar_resep') }}" class="hover:text-primary transition-colors">Resep</a>
                <span class="material-symbols-outlined text-[14px] opacity-50">chevron_right</span>
                @if ($recipe->category)
                    <a href="{{ route('recipes.daftar_resep', ['category' => $recipe->category->slug]) }}" class="hover:text-primary transition-colors">
                        {{ $recipe->category->name }}
                    </a>
                    <span class="material-symbols-outlined text-[14px] opacity-50">chevron_right</span>
                @endif
                <span class="text-primary font-bold truncate max-w-[150px] sm:max-w-none">{{ $recipe->title }}</span>
            </nav>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-3 md:flex md:items-center gap-2 w-full md:w-auto mt-2 md:mt-0">
                
                {{-- Tombol Simpan --}}
                <button type="button" id="bookmarkBtn"
                        data-recipe-id="{{ $recipe->id }}"
                        data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
                        onclick="toggleBookmark()"
                        class="w-full justify-center flex items-center gap-1.5 px-3 py-2.5 bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container text-on-surface rounded-full text-[11px] sm:text-xs font-bold transition shadow-sm group">
                    <span class="material-symbols-outlined text-[18px] text-primary" id="bookmarkIcon"
                          style="font-variation-settings: 'FILL' {{ $isBookmarked ? 1 : 0 }};">
                        {{ $isBookmarked ? 'bookmark' : 'bookmark_border' }}
                    </span>
                    <span class="hidden sm:inline ml-1" id="bookmarkText">Simpan</span>
                    <span class="hidden sm:inline ml-1" id="bookmarkCount">({{ $recipe->bookmarks()->count() }})</span>
                </button>

                {{-- Tombol Bagikan (Menu Share Bawaan HP) --}}
                <button type="button" onclick="shareRecipe()" title="Bagikan Resep"
                        class="w-full justify-center flex items-center gap-1.5 px-3 py-2.5 bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container rounded-full text-on-surface text-[11px] sm:text-xs font-bold transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                    <span class="hidden sm:inline">Bagikan</span>
                </button>

                {{-- Tombol Cetak --}}
                <button type="button" onclick="window.print()" title="Cetak Resep"
                        class="w-full justify-center flex items-center gap-1.5 px-3 py-2.5 bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container rounded-full text-on-surface text-[11px] sm:text-xs font-bold transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    <span class="hidden sm:inline">Cetak</span>
                </button>
                
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MAIN CONTENT AREA --}}
        {{-- ============================================================ --}}
        
        {{-- HERO SECTION --}}
        @include('recipes.partials.hero', ['recipe' => $recipe])

        {{-- INGREDIENTS + STEPS --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start mt-4" id="recipeCoreSection">
            @include('recipes.partials.ingredients', ['recipe' => $recipe])
            @include('recipes.partials.steps', ['recipe' => $recipe])
        </div>

        {{-- REVIEWS --}}
        <div class="mt-4">
            @include('recipes.partials.reviews', ['recipe' => $recipe, 'userRating' => $userRating])
        </div>

        {{-- RELATED (JAMUAN RESEP TERKAIT) --}}
        @include('recipes.partials.related', ['related' => $related])

    </div> {{-- PENUTUP max-w-[1280px] --}}

    {{-- COOKING MODE MODAL --}}
    @include('recipes.partials.cooking_modal')

    {{-- MODAL LOGIN PROMPT --}}
    <div id="loginPromptModal" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-[100] flex items-center justify-center p-4 hidden">
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 shadow-2xl max-w-sm w-full text-center flex flex-col items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary-fixed/30 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center text-secondary relative z-10 shadow-inner">
                <span class="material-symbols-outlined text-[32px]">lock</span>
            </div>
            <div class="relative z-10">
                <h3 class="font-display text-2xl font-bold text-primary mb-2">Harus Login Dulu</h3>
                <p class="text-sm text-on-surface-variant leading-relaxed">Silakan masuk ke akun Anda untuk menyimpan resep favorit ini ke koleksi pribadi.</p>
            </div>
            <div class="flex items-center gap-3 w-full mt-2 relative z-10">
                <button type="button" onclick="document.getElementById('loginPromptModal').classList.add('hidden')" 
                        class="flex-1 px-4 py-2.5 rounded-full bg-surface-container text-primary text-sm font-bold hover:bg-surface-container-high transition">
                    Batal
                </button>
                <a href="{{ route('login') }}" 
                   class="flex-1 px-4 py-2.5 rounded-full bg-primary text-white text-sm font-bold hover:bg-primary-container transition shadow-md">
                    Ke Login
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Fungsi Toast
function showToast(msg) {
    const t = document.getElementById('toastNotification');
    const m = document.getElementById('toastMessage');
    if (!t) return;
    m.textContent = msg;
    t.classList.remove('translate-y-24', 'opacity-0');
    t.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        t.classList.add('translate-y-24', 'opacity-0');
        t.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
}

// Fitur Bagikan (Share via HP)
function shareRecipe() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $recipe->title }}',
            text: 'Lihat resep lezat ini di Griya Rasa!',
            url: window.location.href
        }).catch((error) => console.log('Error sharing', error));
    } else {
        // Jika dibuka di Desktop (yang tidak mendukung menu Share HP), salin link
        navigator.clipboard.writeText(window.location.href)
            .then(() => showToast('Tautan resep berhasil disalin!'))
            .catch(() => showToast('Gagal menyalin tautan.'));
    }
}

// Fitur Simpan Resep (AJAX)
async function toggleBookmark() {
    const btn = document.getElementById('bookmarkBtn');
    if (!btn) return;

    const recipeId = btn.getAttribute('data-recipe-id');
    const icon = document.getElementById('bookmarkIcon');
    const text = document.getElementById('bookmarkText');
    const countSpan = document.getElementById('bookmarkCount');

    try {
        const res = await fetch(`/bookmark/${recipeId}`, { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });
        
        if (res.status === 401) {
            document.getElementById('loginPromptModal').classList.remove('hidden');
            return;
        }

        const data = await res.json();

        if (data.status === 'added') {
            btn.setAttribute('data-bookmarked', 'true');
            icon.textContent = 'bookmark';
            icon.style.fontVariationSettings = "'FILL' 1";
            if(text) text.textContent = 'Tersimpan';
            if(countSpan) countSpan.textContent = `(${parseInt(countSpan.textContent.replace(/\D/g,'')) + 1})`;
            showToast('Resep berhasil disimpan!');
        } else {
            btn.setAttribute('data-bookmarked', 'false');
            icon.textContent = 'bookmark_border';
            icon.style.fontVariationSettings = "'FILL' 0";
            if(text) text.textContent = 'Simpan';
            if(countSpan) countSpan.textContent = `(${Math.max(0, parseInt(countSpan.textContent.replace(/\D/g,'')) - 1)})`;
            showToast('Resep dihapus dari simpanan.');
        }
    } catch (err) {
        console.error(err);
    }
}
</script>
@endpush