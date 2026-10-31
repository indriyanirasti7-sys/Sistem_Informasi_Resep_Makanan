@extends('layouts.app')

@section('title', $tip->title . " — L'Art de Cuisine")

@push('styles')
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    /* Full-bleed image: keluar dari container utama untuk full width */
    .full-bleed {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }
</style>
@endpush

@section('content')

{{-- ========== HEADER / BREADCRUMB & TITLE ========== --}}
<section class="w-full max-w-[1000px] mx-auto px-5 lg:px-8 pt-8 pb-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-on-surface-variant text-[13px] font-medium mb-6 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
        <span class="text-outline">/</span>
        <a href="{{ route('tips.panduan') }}" class="hover:text-primary transition-colors">Tips Memasak</a>
        <span class="text-outline">/</span>
        <span class="text-primary font-semibold truncate max-w-[200px]">{{ $tip->title }}</span>
    </nav>

    {{-- Badges --}}
    <div class="flex items-center gap-2 flex-wrap mb-4">
        <span class="bg-primary text-white px-4 py-1 rounded-full text-[11px] tracking-wider uppercase font-bold">
            Tips Dapur
        </span>
        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[11px] font-bold">
            Panduan Kuliner
        </span>
    </div>

    {{-- Title --}}
    <h1 class="font-['Playfair_Display'] text-3xl lg:text-5xl text-primary tracking-tight leading-tight font-semibold mb-4">
        {{ $tip->title }}
    </h1>

    {{-- Excerpt --}}
    <p class="text-base lg:text-lg text-on-surface-variant italic leading-relaxed mb-6">
        "{{ Str::limit(strip_tags($tip->content), 200) }}"
    </p>

    {{-- Author Meta Bar --}}
    <div class="pt-5 flex flex-col md:flex-row md:items-center justify-between gap-5 border-t border-surface-container">

        <div class="flex items-center gap-4">
            @if ($tip->user)
                <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container shrink-0 shadow-sm">
                    <img class="w-full h-full object-cover"
                         src="{{ $tip->user->avatar ? Storage::url($tip->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($tip->user->name) . '&background=5a3a22&color=fff&bold=true' }}"
                         alt="{{ $tip->user->name }}"/>
                </div>
                <div class="flex flex-col">
                    <span class="text-base font-bold text-primary">{{ $tip->user->name }}</span>
                    <div class="flex items-center gap-2 text-xs text-on-surface-variant flex-wrap">
                        <span>{{ $tip->created_at->translatedFormat('d F Y') }}</span>
                        <span class="w-1 h-1 rounded-full bg-outline"></span>
                        <span>{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} mnt baca</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-2">
            <button type="button" onclick="toggleSave()" id="save-btn"
                    class="flex items-center gap-1.5 px-4 py-2 bg-surface-container hover:bg-surface-container-high rounded-full text-on-surface text-xs font-semibold transition shadow-sm">
                <span class="material-symbols-outlined text-[18px]" id="save-icon">bookmark_border</span>
                <span id="save-text">Simpan</span>
            </button>

            <button type="button"
                    onclick="navigator.clipboard.writeText(window.location.href); showTipToast('Tautan tersalin!')"
                    class="flex items-center gap-1.5 px-4 py-2 bg-surface-container hover:bg-surface-container-high rounded-full text-on-surface text-xs font-semibold transition shadow-sm">
                <span class="material-symbols-outlined text-[18px]">share</span>
                <span>Bagikan</span>
            </button>

            <button type="button" onclick="window.print()" title="Cetak"
                    class="flex items-center justify-center w-10 h-10 bg-surface-container hover:bg-surface-container-high rounded-full text-on-surface transition shadow-sm">
                <span class="material-symbols-outlined text-[18px]">print</span>
            </button>
        </div>
    </div>
</section>

{{-- ========== HERO IMAGE — FULL WIDTH ========== --}}
@if ($tip->image)
    <section class="full-bleed mb-12">
        <div class="relative w-full aspect-[16/9] max-h-[640px] overflow-hidden bg-surface-container-high">
            <img class="w-full h-full object-cover"
                 src="{{ Storage::url($tip->image) }}"
                 alt="{{ $tip->title }}"/>

            {{-- Overlay caption --}}
            <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent flex items-end">
                <div class="p-6 md:p-10 text-white max-w-[1000px] mx-auto w-full">
                    <span class="inline-block bg-primary-container/80 backdrop-blur-sm text-primary-fixed text-[11px] font-bold px-3 py-1 rounded-full mb-2">
                        Gambar Utama
                    </span>
                    <p class="text-sm md:text-base text-white max-w-2xl font-medium">
                        {{ $tip->title }} — Panduan lengkap dari tim dapur L'Art de Cuisine.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ========== MAIN CONTENT — FULL WIDTH, TANPA SIDEBAR ========== --}}
<main class="w-full max-w-[1000px] mx-auto px-5 lg:px-8 mb-16">
    <article class="flex flex-col gap-6">

        {{-- Content dengan Drop Cap --}}
        <div class="text-base lg:text-lg text-on-surface leading-relaxed">

            @php
                $content = e($tip->content);
                $firstChar = mb_substr($content, 0, 1);
                $rest = mb_substr($content, 1);
            @endphp

            <p>
                <span class="float-left font-['Playfair_Display'] text-[72px] leading-[62px] pr-4 pt-1 font-bold text-primary">
                    {{ $firstChar }}
                </span>
                {!! nl2br($rest) !!}
            </p>
        </div>

        {{-- Divider --}}
        <div class="w-full h-px bg-surface-container my-4"></div>

        {{-- Author Bio Card --}}
        @if ($tip->user)
            <section class="bg-surface-container p-6 lg:p-8 rounded-2xl shadow-sm flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-surface-container-high shrink-0 shadow-sm ring-4 ring-surface-bright">
                    <img class="w-full h-full object-cover"
                         src="{{ $tip->user->avatar ? Storage::url($tip->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($tip->user->name) . '&background=5a3a22&color=fff&bold=true&size=200' }}"
                         alt="{{ $tip->user->name }}"/>
                </div>
                <div class="flex flex-col gap-2 text-center sm:text-left flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <h3 class="font-['Playfair_Display'] text-xl text-primary font-bold">{{ $tip->user->name }}</h3>
                        <span class="text-[11px] text-on-secondary-container bg-secondary-container px-3 py-1 rounded-full inline-block self-center sm:self-auto font-bold">
                            Kontributor Tips
                        </span>
                    </div>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Kontributor tips & panduan kuliner di L'Art de Cuisine. Berdedikasi menghadirkan teknik presisi tingkat koki profesional ke dapur rumah tangga Anda.
                    </p>
                </div>
            </section>
        @endif

        {{-- Feedback Widget --}}
        <div class="bg-surface-container-low p-6 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <h4 class="font-['Playfair_Display'] text-lg text-primary font-bold">Apakah panduan ini bermanfaat?</h4>
                <p class="text-sm text-on-surface-variant">Bantu kami meningkatkan kualitas konten dapur redaksi.</p>
            </div>
            <div class="flex items-center gap-1" id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="rateArticle({{ $i }})" class="text-tertiary-fixed-dim hover:text-primary transition-transform hover:scale-110">
                        <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    </button>
                @endfor
            </div>
        </div>

        {{-- Back Button --}}
        <div class="text-center mt-4">
            <a href="{{ route('tips.panduan') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-surface-container hover:bg-surface-container-high text-primary text-sm font-bold transition">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Daftar Tips
            </a>
        </div>

    </article>
</main>

{{-- ========== RELATED TIPS ========== --}}
@if ($related->count())
    <section class="w-full bg-surface-container-high py-16">
        <div class="max-w-[1000px] mx-auto px-5 lg:px-8 flex flex-col gap-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-3">
                <div>
                    <span class="text-[11px] text-secondary font-bold uppercase tracking-wider">Eksplorasi Lanjutan</span>
                    <h2 class="font-['Playfair_Display'] text-2xl lg:text-3xl text-primary font-bold mt-1">
                        Panduan & Tips Pilihan Lainnya
                    </h2>
                </div>
                <a href="{{ route('tips.panduan') }}"
                   class="text-sm text-primary font-semibold hover:text-tertiary flex items-center gap-1 transition">
                    <span>Lihat Semua Tips</span>
                    <span class="material-symbols-outlined text-[18px]">east</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <a href="{{ route('tips.panduan', $item->slug) }}"
                       class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">

                        <div class="aspect-square w-full overflow-hidden bg-surface-container relative">
                            <img alt="{{ $item->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 src="{{ $item->image ? Storage::url($item->image) : 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800' }}"/>
                            <span class="absolute top-3 left-3 bg-primary-container text-white text-[11px] font-bold px-3 py-0.5 rounded-full shadow-sm">
                                Tips Dapur
                            </span>
                        </div>

                        <div class="p-5 flex flex-col flex-1 justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-1.5 text-xs text-on-surface-variant mb-2">
                                    <span>{{ ceil(str_word_count(strip_tags($item->content)) / 200) }} mnt baca</span>
                                </div>
                                <h3 class="font-['Playfair_Display'] text-base font-bold text-primary group-hover:text-tertiary transition-colors leading-snug line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="text-xs text-on-surface-variant mt-2 line-clamp-2">
                                    {{ Str::limit(strip_tags($item->content), 100) }}
                                </p>
                            </div>
                            <span class="text-xs text-primary font-semibold group-hover:underline flex items-center gap-1">
                                Baca Panduan <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Toast --}}
<div class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 px-5 py-3.5 rounded-full bg-primary text-white shadow-xl"
     id="tipToast">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    <span class="text-sm font-semibold" id="tipToastMsg">Berhasil.</span>
</div>

@endsection

@push('scripts')
<script>
function showTipToast(msg) {
    const t = document.getElementById('tipToast');
    const m = document.getElementById('tipToastMsg');
    if (!t) return;
    m.textContent = msg;
    t.classList.remove('translate-y-24', 'opacity-0');
    t.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        t.classList.add('translate-y-24', 'opacity-0');
        t.classList.remove('translate-y-0', 'opacity-100');
    }, 2500);
}

let isSaved = false;
function toggleSave() {
    isSaved = !isSaved;
    const icon = document.getElementById('save-icon');
    const text = document.getElementById('save-text');
    const btn = document.getElementById('save-btn');

    if (isSaved) {
        icon.textContent = 'bookmark';
        icon.style.fontVariationSettings = "'FILL' 1";
        text.textContent = 'Tersimpan';
        btn.classList.add('bg-primary', 'text-white');
        btn.classList.remove('bg-surface-container', 'text-on-surface');
        showTipToast('Tips disimpan');
    } else {
        icon.textContent = 'bookmark_border';
        icon.style.fontVariationSettings = "'FILL' 0";
        text.textContent = 'Simpan';
        btn.classList.remove('bg-primary', 'text-white');
        btn.classList.add('bg-surface-container', 'text-on-surface');
        showTipToast('Dihapus dari simpanan');
    }
}

function rateArticle(stars) {
    const container = document.getElementById('star-rating');
    const buttons = container.querySelectorAll('button');
    buttons.forEach((btn, index) => {
        const icon = btn.querySelector('.material-symbols-outlined');
        if (index < stars) {
            btn.classList.remove('text-tertiary-fixed-dim');
            btn.classList.add('text-primary');
            icon.style.fontVariationSettings = "'FILL' 1";
        } else {
            btn.classList.add('text-tertiary-fixed-dim');
            btn.classList.remove('text-primary');
            icon.style.fontVariationSettings = "'FILL' 0";
        }
    });
    showTipToast('Terima kasih! Rating ' + stars + ' bintang');
}
</script>
@endpush