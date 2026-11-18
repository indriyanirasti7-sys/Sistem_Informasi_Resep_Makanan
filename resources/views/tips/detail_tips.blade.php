@extends('layouts.app')

@section('title', $tip->title . " — Griya Rasa")

@push('styles')
<style>
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endpush

@section('content')

<div class="w-full bg-surface-container-low/30 pb-16">
    {{-- ========== HEADER / BREADCRUMB & TITLE ========== --}}
    {{-- ✅ max-w DIPERLEBAR DARI 900px MENJADI 1100px --}}
    <section class="w-full max-w-[1100px] mx-auto px-5 lg:px-8 pt-10 lg:pt-12 pb-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-on-surface-variant text-[12px] sm:text-[13px] font-semibold mb-8 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
            <span class="opacity-50">/</span>
            <a href="{{ route('tips.panduan') }}" class="hover:text-primary transition-colors">Tips Memasak</a>
            <span class="opacity-50">/</span>
            <span class="text-primary truncate max-w-[200px]">{{ $tip->title }}</span>
        </nav>

        {{-- Badges --}}
        <div class="flex items-center gap-2 flex-wrap mb-5">
            <span class="bg-primary text-white px-4 py-1.5 rounded-full text-[10px] sm:text-[11px] tracking-widest uppercase font-bold shadow-sm">
                Tips Dapur
            </span>
            <span class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full text-[10px] sm:text-[11px] font-bold shadow-sm">
                Panduan Kuliner
            </span>
        </div>

        {{-- Title --}}
        <h1 class="font-['Playfair_Display'] text-3xl sm:text-4xl lg:text-5xl text-primary tracking-tight leading-[1.15] font-bold mb-5">
            {{ $tip->title }}
        </h1>

        {{-- Excerpt --}}
        <p class="text-base sm:text-lg text-on-surface-variant italic leading-relaxed mb-8 border-l-4 border-secondary pl-4">
            "{{ Str::limit(strip_tags($tip->content), 200) }}"
        </p>

        {{-- Author Meta Bar & Action Buttons --}}
        <div class="pt-6 flex flex-col md:flex-row md:items-center justify-between gap-6 border-t border-surface-container-high">

            {{-- Sisi Kiri: Info Penulis --}}
            <div class="flex items-center gap-4">
                @if ($tip->user)
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-surface-container shrink-0 shadow-sm ring-2 ring-surface-container-high">
                        <img class="w-full h-full object-cover"
                             src="{{ $tip->user->avatar ? Storage::url($tip->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($tip->user->name) . '&background=5a3a22&color=fff&bold=true' }}"
                             alt="{{ $tip->user->name }}"/>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-primary">{{ $tip->user->name }}</span>
                        <div class="flex items-center gap-2 text-[11px] text-on-surface-variant flex-wrap mt-0.5">
                            <span>{{ $tip->created_at->translatedFormat('d F Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-outline"></span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">schedule</span> {{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} mnt baca</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sisi Kanan: Tombol Aksi --}}
            <div class="grid grid-cols-2 md:flex md:items-center gap-2 w-full md:w-auto mt-2 md:mt-0">                {{-- Tombol Simpan --}}
                <button type="button" onclick="toggleSave()" id="save-btn"
                        class="w-full justify-center flex items-center gap-1.5 px-3 py-2.5 bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container rounded-full text-on-surface text-xs font-bold transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]" id="save-icon">bookmark_border</span>
                    <span id="save-text">Simpan</span>
                </button>

                {{-- Tombol Bagikan --}}
                <button type="button" id="share-btn" onclick="shareArticle()"
                        class="w-full justify-center flex items-center gap-1.5 px-3 py-2.5 bg-surface-container-lowest border border-surface-container-high hover:bg-surface-container rounded-full text-on-surface text-xs font-bold transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                    <span>Bagikan</span>
                </button>

            </div>
        </div>
    </section>

    {{-- ========== HERO IMAGE (MELENGKUNG & LEBAR) ========== --}}
    @if ($tip->image)
        {{-- ✅ max-w DIPERLEBAR DAN GAMBAR DIBERI ROUNDED-3XL --}}
        <section class="w-full max-w-[1100px] mx-auto px-5 lg:px-8 mb-12">
            {{-- Hapus trik full-bleed, ganti dengan container max-w-1100 dan rounded-3xl --}}
            <div class="relative w-full h-[300px] sm:h-[400px] md:h-[450px] rounded-3xl overflow-hidden shadow-lg bg-surface-container-high">
                <img class="w-full h-full object-cover object-center"
                     src="{{ Storage::url($tip->image) }}"
                     alt="{{ $tip->title }}"/>

                {{-- Overlay caption --}}
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent flex items-end">
                    <div class="p-6 md:p-10 text-white w-full">
                        <span class="inline-block bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">
                            Sorotan Visual
                        </span>
                        <p class="text-sm md:text-base text-white/90 max-w-2xl font-medium italic">
                            "{{ $tip->title }} — Panduan lengkap dari tim dapur Jelajah Rasa."
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ========== MAIN CONTENT ========== --}}
    {{-- ✅ max-w DIPERLEBAR MENJADI 1100px AGAR TEKS TIDAK TERLALU SEMPIT --}}
    {{-- ========== MAIN CONTENT ========== --}}
    <main class="w-full max-w-[1100px] mx-auto px-5 lg:px-8 mb-16">
        <article class="flex flex-col gap-8">

            {{-- Content dengan render HTML yang benar menggunakan {!! !!} --}}
            <div class="prose max-w-none text-[15px] sm:text-[17px] text-on-surface leading-[1.8] text-justify">
                {!! $tip->content !!}
            </div>

            {{-- Divider --}}
            <div class="w-full h-px bg-surface-container-high my-2"></div>

            {{-- Author Bio Card --}}
            @if ($tip->user)
                <section class="bg-surface-container-lowest border border-surface-container-high p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden bg-surface-container shrink-0 shadow-inner ring-4 ring-surface-container">
                        <img class="w-full h-full object-cover"
                             src="{{ $tip->user->avatar ? Storage::url($tip->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($tip->user->name) . '&background=5a3a22&color=fff&bold=true&size=200' }}"
                             alt="{{ $tip->user->name }}"/>
                    </div>
                    <div class="flex flex-col gap-2 text-center sm:text-left flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <h3 class="font-['Playfair_Display'] text-xl sm:text-2xl text-primary font-bold">{{ $tip->user->name }}</h3>
                            <span class="text-[10px] tracking-wider uppercase text-on-secondary-container bg-secondary-container px-3 py-1 rounded-full inline-block self-center sm:self-auto font-bold">
                                Kontributor Redaksi
                            </span>
                        </div>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Kontributor tips & panduan kuliner di Jelajah Rasa. Berdedikasi menghadirkan teknik presisi tingkat koki profesional ke dapur rumah tangga Anda.
                        </p>
                    </div>
                </section>
            @endif

            {{-- Feedback Widget --}}
            <div class="bg-secondary-container/30 border border-secondary/20 p-6 sm:p-8 rounded-3xl flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left mt-4">
                <div>
                    <h4 class="font-['Playfair_Display'] text-xl text-primary font-bold">Apakah panduan ini bermanfaat?</h4>
                    <p class="text-sm text-on-surface-variant mt-1">Bantu kami meningkatkan kualitas konten dapur redaksi.</p>
                </div>
                <div class="flex items-center gap-1.5" id="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="rateArticle({{ $i }})" class="text-outline-variant hover:text-tertiary-container transition-transform hover:scale-110">
                            <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        </button>
                    @endfor
                </div>
            </div>

            {{-- Back Button --}}
            <div class="text-center mt-8">
                <a href="{{ route('tips.panduan') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-surface-container hover:bg-surface-container-high text-primary text-sm font-bold transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Daftar Tips
                </a>
            </div>

        </article>
    </main>
</div>

{{-- ========== RELATED TIPS (HORIZONTAL SCROLL) ========== --}}
@if ($related->count())
    <section class="w-full bg-surface-container-high py-16 border-t border-surface-container-highest">
        {{-- ✅ max-w Diperlebar agar sejajar dengan konten utama --}}
        <div class="max-w-[1100px] mx-auto px-5 lg:px-8 flex flex-col gap-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] sm:text-[11px] text-secondary font-bold uppercase tracking-widest">Eksplorasi Lanjutan</span>
                    <h2 class="font-['Playfair_Display'] text-2xl sm:text-3xl text-primary font-bold mt-1">
                        Panduan Pilihan Lainnya
                    </h2>
                </div>
                <a href="{{ route('tips.panduan') }}"
                   class="text-sm text-primary font-bold hover:text-secondary flex items-center gap-1.5 transition group">
                    <span>Lihat Semua Tips</span>
                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            {{-- Container Scroll Horizontal --}}
            <div class="flex items-stretch gap-4 sm:gap-6 overflow-x-auto snap-x snap-mandatory pb-4 no-scrollbar scroll-smooth cursor-grab active:cursor-grabbing">
                @foreach ($related as $item)
                    <a href="{{ route('tips.detail_tips', $item->slug) }}"
                       class="snap-start shrink-0 w-[260px] sm:w-[300px] bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col group border border-surface-container/50">

                        <div class="aspect-[4/3] w-full overflow-hidden bg-surface-container relative">
                            <img alt="{{ $item->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 src="{{ $item->image ? Storage::url($item->image) : 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800' }}"/>
                            <span class="absolute top-3 left-3 bg-surface-container-lowest/90 backdrop-blur-md text-primary text-[10px] uppercase tracking-wider font-bold px-3 py-1 rounded-full shadow-sm">
                                Tips Dapur
                            </span>
                        </div>

                        <div class="p-5 sm:p-6 flex flex-col flex-1 justify-between gap-4">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-outline text-[10px] sm:text-[11px] font-medium">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">schedule</span> {{ ceil(str_word_count(strip_tags($item->content)) / 200) }} mnt</span>
                                    <span>•</span>
                                    <span class="truncate">Oleh {{ $item->user?->name ?? 'Tim Dapur' }}</span>
                                </div>
                                <h3 class="font-['Playfair_Display'] text-base sm:text-lg text-primary group-hover:text-secondary transition-colors leading-snug line-clamp-2 font-bold">
                                    {{ $item->title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant mt-1 line-clamp-2">
                                    {{ Str::limit(strip_tags($item->content), 100) }}
                                </p>
                            </div>
                            
                            <div class="pt-3 border-t border-surface-container-high/60 flex items-center justify-between text-[11px] font-bold text-primary group-hover:text-secondary transition-colors">
                                <span>Baca Panduan</span>
                                <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
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
        btn.classList.add('bg-primary', 'text-white', 'border-primary');
        btn.classList.remove('bg-surface-container-lowest', 'text-on-surface', 'border-surface-container-high');
        showTipToast('Tips disimpan');
    } else {
        icon.textContent = 'bookmark_border';
        icon.style.fontVariationSettings = "'FILL' 0";
        text.textContent = 'Simpan';
        btn.classList.remove('bg-primary', 'text-white', 'border-primary');
        btn.classList.add('bg-surface-container-lowest', 'text-on-surface', 'border-surface-container-high');
        showTipToast('Dihapus dari simpanan');
    }
}

function rateArticle(stars) {
    const container = document.getElementById('star-rating');
    const buttons = container.querySelectorAll('button');
    buttons.forEach((btn, index) => {
        const icon = btn.querySelector('.material-symbols-outlined');
        if (index < stars) {
            btn.classList.remove('text-outline-variant');
            btn.classList.add('text-tertiary-container');
            icon.style.fontVariationSettings = "'FILL' 1";
        } else {
            btn.classList.add('text-outline-variant');
            btn.classList.remove('text-tertiary-container');
            icon.style.fontVariationSettings = "'FILL' 0";
        }
    });
    showTipToast('Terima kasih! Rating ' + stars + ' bintang');
}
function shareArticle() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $tip->title }}',
            url: window.location.href
        }).catch(console.error);
    } else {
        navigator.clipboard.writeText(window.location.href)
            .then(() => showTipToast('Tautan berhasil disalin!'))
            .catch(() => showTipToast('Gagal menyalin tautan.'));
    }
}
</script>
@endpush