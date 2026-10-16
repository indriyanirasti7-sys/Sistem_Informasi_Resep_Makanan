@extends('admin.layout')

@section('title', 'Ulasan & Rating — L\'Art de Cuisine')
@section('breadcrumb', 'Ulasan')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col gap-1.5 max-w-2xl">
        <div class="flex items-center gap-2 text-secondary">
            <span class="material-symbols-outlined text-lg">rate_review</span>
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Moderasi &amp; Feedback Komunitas</span>
        </div>
        <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Ulasan &amp; Rating</h1>
        <p class="text-sm text-on-surface-variant">
            Pantau komentar pengunjung pada setiap resep dan kelola reputasi kurasi masakan.
        </p>
    </div>

    {{-- ========== STAT CARDS ========== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mt-2">

        {{-- Card 1: Total Ulasan --}}
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex flex-col gap-3">
            <div class="flex items-start justify-between">
                <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Total Ulasan</span>
                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">rate_review</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <span class="font-display text-3xl text-primary font-bold">{{ number_format($totalReviews, 0, ',', '.') }}</span>
                <span class="text-xs text-on-surface-variant">Tercatat di seluruh buku resep</span>
            </div>
        </div>

        {{-- Card 2: Rata-rata Rating --}}
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex flex-col gap-3">
            <div class="flex items-start justify-between">
                <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Rata-rata Rating</span>
                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-tertiary-container">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-3xl text-primary font-bold">{{ $averageRating }}</span>
                    <span class="text-sm text-on-surface-variant">/ 5.0</span>
                </div>
                <span class="text-xs text-on-surface-variant">Dari {{ $totalReviews }} penilaian</span>
            </div>
        </div>

        {{-- Card 3: Ulasan Bintang 5 --}}
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex flex-col gap-3">
            <div class="flex items-start justify-between">
                <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Ulasan Bintang 5</span>
                <div class="w-10 h-10 rounded-full bg-secondary-container/60 flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[20px]">sentiment_very_satisfied</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-3xl text-primary font-bold">{{ number_format($fiveStarCount, 0, ',', '.') }}</span>
                    <span class="text-xs font-bold text-secondary">{{ $fiveStarPercent }}%</span>
                </div>
                <span class="text-xs text-on-surface-variant">Tingkat kepuasan rasa</span>
            </div>
        </div>

        {{-- Card 4: Butuh Perhatian --}}
        <div class="bg-error-container/40 p-5 rounded-2xl shadow-sm flex flex-col gap-3">
            <div class="flex items-start justify-between">
                <span class="text-[11px] uppercase tracking-wider text-error font-bold">Bintang 1-2</span>
                <div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center text-error">
                    <span class="material-symbols-outlined text-[20px]">report_problem</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-baseline gap-2">
                    <span class="font-display text-3xl text-error font-bold">{{ $attentionCount }}</span>
                    <span class="text-[10px] font-bold text-white bg-error px-2 py-0.5 rounded-full">Perlu Tindakan</span>
                </div>
                <span class="text-xs text-error/80">Perlu respons kurator &amp; uji resep</span>
            </div>
        </div>
    </div>
</header>

{{-- ========== FILTER & SEARCH ========== --}}
<section class="bg-surface-container-low rounded-3xl p-4 shadow-sm mb-5">
    <form method="GET" action="{{ route('admin.reviews.index') }}"
          class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

        {{-- Search --}}
        <div class="md:col-span-5 relative flex items-center">
            <span class="material-symbols-outlined absolute left-4 text-[20px] text-on-surface-variant pointer-events-none">search</span>
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari komentar, pengguna, atau resep..."
                   class="w-full pl-11 pr-4 py-2.5 rounded-full bg-surface-container-lowest text-on-surface placeholder:text-on-surface-variant/70 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
        </div>

        {{-- Filter Bintang --}}
        <div class="md:col-span-2 relative">
            <select name="rating" onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-2.5 pr-9 rounded-full bg-surface-container-lowest text-on-surface text-xs font-bold cursor-pointer shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                <option value="all" @selected(request('rating', 'all') === 'all')>Semua Bintang</option>
                <option value="5" @selected(request('rating') === '5')>⭐ 5 Sempurna</option>
                <option value="4" @selected(request('rating') === '4')>⭐ 4 Sangat Baik</option>
                <option value="3" @selected(request('rating') === '3')>⭐ 3 Cukup</option>
                <option value="2" @selected(request('rating') === '2')>⭐ 2 Perlu Perbaikan</option>
                <option value="1" @selected(request('rating') === '1')>⭐ 1 Kurang Puas</option>
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
        </div>

        {{-- Filter Resep --}}
        <div class="md:col-span-3 relative">
            <select name="recipe_id" onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-2.5 pr-9 rounded-full bg-surface-container-lowest text-on-surface text-xs font-bold cursor-pointer shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                <option value="all" @selected(request('recipe_id', 'all') === 'all')>
                    Semua Resep ({{ $recipesForFilter->count() }})
                </option>
                @foreach ($recipesForFilter as $r)
                    <option value="{{ $r->id }}" @selected(request('recipe_id') == $r->id)>
                        {{ \Illuminate\Support\Str::limit($r->title, 40) }}
                    </option>
                @endforeach
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
        </div>

        {{-- Reset --}}
        <div class="md:col-span-2 flex justify-end">
            <a href="{{ route('admin.reviews.index') }}"
               class="w-full py-2.5 px-4 rounded-full bg-surface-container-high hover:bg-surface-container text-on-surface text-xs font-bold flex items-center justify-center gap-1.5 transition">
                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                <span>Reset</span>
            </a>
        </div>

        {{-- Sort (baris terpisah di bawah) --}}
        <div class="md:col-span-12 flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-t border-surface-container-high/60">
            <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px]">sort</span>
                <span>Urutkan:</span>
            </div>

            <div class="relative min-w-[200px]">
                <select name="sort" onchange="this.form.submit()"
                        class="w-full appearance-none px-4 py-2 pr-9 rounded-full bg-surface-container-lowest text-on-surface text-xs font-bold cursor-pointer shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                    <option value="newest" @selected(request('sort', 'newest') === 'newest')>Paling Baru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Paling Lama</option>
                    <option value="rating_high" @selected(request('sort') === 'rating_high')>Rating Tertinggi</option>
                    <option value="rating_low" @selected(request('sort') === 'rating_low')>Rating Terendah</option>
                </select>
                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
            </div> 
        </div>
    </form>

    {{-- Counter hasil filter --}}
    <div class="flex items-center justify-between pt-3 px-2">
        <span class="text-xs text-on-surface-variant">
            Menampilkan <strong class="text-primary font-bold">{{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }}</strong>
            dari <strong class="text-primary font-bold">{{ number_format($reviews->total(), 0, ',', '.') }}</strong> ulasan
        </span>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-secondary"></span>
            <span class="text-[11px] text-on-surface-variant font-medium">Auto-sinkron kurasi aktif</span>
        </div>
    </div>
</section>

{{-- ========== PANEL DISTRIBUSI BINTANG ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm mb-5">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        {{-- Kiri: Skor Besar --}}
        <div class="lg:col-span-5 flex flex-col items-center lg:items-start text-center lg:text-left gap-3 lg:pr-8 lg:border-r border-surface-container-high">
            <span class="text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">
                Kualitas Gastronomi Terpadu
            </span>
            <div class="flex items-baseline gap-2">
                <span class="font-display text-6xl text-primary leading-none font-bold">{{ $averageRating }}</span>
                <span class="text-2xl text-on-surface-variant">/ 5.0</span>
            </div>
            <div class="flex items-center gap-1 text-tertiary-container">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">star</span>
                @endfor
            </div>
            <span class="text-sm font-bold text-primary">
                {{ number_format($totalReviews, 0, ',', '.') }} Penilaian Global
            </span>
            <div class="inline-flex items-center gap-2 bg-secondary-container px-4 py-1.5 rounded-full mt-1">
                <span class="material-symbols-outlined text-secondary text-[18px]">thumb_up</span>
                <span class="text-xs font-bold text-secondary">
                    {{ $fiveStarPercent }}% pengunjung kasih bintang 5
                </span>
            </div>
        </div>

        {{-- Kanan: Bar Chart Distribusi --}}
        <div class="lg:col-span-7 flex flex-col gap-3">
            @foreach ([5, 4, 3, 2, 1] as $star)
                @php
                    $count   = $distribution[$star]['count'];
                    $percent = $distribution[$star]['percent'];

                    // Warna bar beda-beda per tingkat bintang
                    $barColor = match($star) {
                        5 => 'bg-tertiary-container',
                        4 => 'bg-tertiary-fixed-dim',
                        3 => 'bg-secondary-fixed-dim',
                        2 => 'bg-primary-fixed-dim',
                        1 => 'bg-error',
                    };
                @endphp

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1 w-24 shrink-0">
                        <span class="text-xs font-bold text-on-surface">{{ $star }} Bintang</span>
                        <span class="material-symbols-outlined text-tertiary-container text-[14px]"
                              style="font-variation-settings: 'FILL' 1;">star</span>
                    </div>

                    <div class="flex-1 h-3 rounded-full bg-surface-container overflow-hidden">
                        <div class="h-full rounded-full {{ $barColor }} transition-all duration-500"
                             style="width: {{ $percent }}%;"></div>
                    </div>

                    <div class="w-24 text-right flex justify-end gap-1 shrink-0">
                        <span class="text-xs font-bold text-on-surface">{{ number_format($count, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-on-surface-variant">({{ $percent }}%)</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== LIST ULASAN ========== --}}
<section class="flex flex-col gap-4">
    @forelse ($reviews as $review)
        @php
            $user = $review->user;
            $isAdmin = $user && $user->role === 'admin';
            $isVerified = $user && !is_null($user->email_verified_at);
            $initials = collect(explode(' ', $user->name ?? 'Anonim'))
                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                            ->take(2)
                            ->join('');
            $rating = (int) $review->rating;
        @endphp

        <article class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col gap-4 {{ $rating <= 2 ? 'border-l-4 border-error' : '' }}">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 rounded-full {{ $isAdmin ? 'bg-primary-fixed text-primary' : 'bg-secondary-container text-secondary' }} flex items-center justify-center font-bold text-sm shrink-0">
                        {{ $initials }}
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-primary">{{ $user->name ?? 'Anonim' }}</h3>

                            @if ($isVerified)
                                <span class="inline-flex items-center gap-1 bg-secondary-container px-2 py-0.5 rounded-full text-secondary text-[10px] font-bold">
                                    <span class="material-symbols-outlined text-[12px]">verified</span>
                                    Terverifikasi
                                </span>
                            @endif

                            @if ($isAdmin)
                                <span class="inline-flex items-center gap-1 bg-primary-container px-2 py-0.5 rounded-full text-white text-[10px] font-bold">
                                    <span class="material-symbols-outlined text-[12px]">shield</span>
                                    Admin
                                </span>
                            @endif
                        </div>

                        <span class="text-xs text-on-surface-variant">
                            {{ $isAdmin ? 'Kepala Kurator Gastronomi' : 'Anggota Komunitas' }}
                            •
                            {{ $review->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                {{-- Bintang + Tombol Hapus --}}
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-[20px] {{ $i <= $rating ? 'text-tertiary-container' : 'text-surface-container-highest' }}"
                                style="font-variation-settings: 'FILL' 1;">star</span>
                        @endfor
                    </div>

                    @if ($rating <= 2)
                        <span class="inline-flex items-center gap-1 bg-error-container px-2.5 py-0.5 rounded-full text-error text-[10px] font-bold">
                            <span class="material-symbols-outlined text-[12px]">notification_important</span>
                            Perlu Tanggapan
                        </span>
                    @endif

                    <button type="button"
                            class="delete-btn w-9 h-9 rounded-full bg-surface-container hover:bg-error-container text-on-surface-variant hover:text-error flex items-center justify-center transition"
                            data-author="{{ $user->name ?? 'Anonim' }}"
                            data-recipe="{{ $review->recipe->title ?? 'Resep dihapus' }}"
                            data-comment="{{ $review->comment }}"
                            data-delete-url="{{ route('admin.reviews.destroy', $review->id) }}"
                            title="Hapus Ulasan">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            </div>

            <p class="text-sm text-on-surface leading-relaxed">
                “{{ $review->comment }}”
            </p>

            <div class="flex items-center justify-between flex-wrap gap-2 pt-1">
                <div class="inline-flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-full">
                    <span class="material-symbols-outlined text-[16px] text-primary">restaurant_menu</span>
                    <span class="text-xs font-bold text-primary">
                        {{ $review->recipe->title ?? 'Resep dihapus' }}
                    </span>
                </div>
            </div>
        </article>
        @empty
            <div class="bg-surface-container-low rounded-3xl p-16 shadow-sm flex flex-col items-center text-center gap-5">
                <div class="w-20 h-20 rounded-full bg-surface-container-high flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[40px]">chat_bubble_outline</span>
                </div>
                <div class="flex flex-col gap-2 max-w-md">
                    <h3 class="font-display text-2xl text-primary font-bold">Belum Ada Ulasan</h3>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Ketika pengunjung memberikan penilaian rasa pada katalog resep, seluruh ulasan akan terdata otomatis di sini.
                    </p>
                </div>
                <button type="button"
                        class="mt-2 inline-flex items-center gap-2 bg-surface-container-lowest text-primary hover:bg-surface-container px-6 py-2.5 rounded-full text-xs font-bold shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">content_copy</span>
                    <span>Salin Tautan Ulasan Publik</span>
                </button>
            </div>
        @endforelse
</section>

@if ($reviews->hasPages())
    <div class="mt-6 pt-4 border-t border-surface-container-high">
        {{ $reviews->links() }}
    </div>
@endif

{{-- ========== MODAL: Konfirmasi Hapus Ulasan ========== --}}
<div id="deleteReviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-inverse-surface/40 backdrop-blur-sm hidden">
    <div class="bg-surface-container-lowest rounded-3xl p-8 max-w-lg w-full shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col gap-5">

        {{-- Header --}}
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-error-container text-error flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">delete_forever</span>
            </div>
            <div class="flex flex-col gap-1">
                <h3 class="font-display text-2xl text-primary font-bold">Hapus Ulasan Ini?</h3>
                <p class="text-sm text-on-surface-variant">
                    Apakah Anda yakin ingin menghapus ulasan dari
                    <strong class="text-on-surface" id="modalAuthorName">Pengguna</strong>?
                    Tindakan ini permanen dan skor rata-rata resep
                    <strong class="text-on-surface" id="modalRecipeName">Resep</strong>
                    akan dihitung ulang otomatis.
                </p>
            </div>
        </div>

        {{-- Preview Kutipan Komentar --}}
        <div class="p-4 rounded-2xl bg-surface-container-low flex flex-col gap-2">
            <span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">
                Kutipan Komentar yang Dihapus
            </span>
            <p class="text-sm italic text-on-surface leading-relaxed" id="modalCommentQuote">
                “Komentar yang dipilih akan muncul di sini...”
            </p>
        </div>

        {{-- Action Buttons --}}
        <form id="deleteReviewForm" method="POST" action="" class="flex items-center justify-end gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" id="cancelDeleteReviewBtn"
                    class="px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant hover:text-primary text-sm font-bold transition">
                Batal
            </button>
            <button type="submit"
                    class="px-6 py-2.5 rounded-full bg-error text-white text-sm font-bold shadow-sm hover:opacity-90 transition">
                Ya, Hapus Ulasan
            </button>
        </form>
    </div>
</div>

{{-- ========== TOAST ========== --}}
<div id="toastSuccess"
     class="fixed bottom-6 right-6 z-50 bg-primary-container text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-2.5 transition-all transform translate-y-24 opacity-0 pointer-events-none">
    <span class="material-symbols-outlined text-[20px] text-secondary-fixed">check_circle</span>
    <span class="text-sm font-bold" id="toastMessage">Berhasil!</span>
</div>

@endsection

@push('scripts')
<script>
(function () {
    /* ===== Modal Hapus Ulasan ===== */
    const deleteModal  = document.getElementById('deleteReviewModal');
    const deleteForm   = document.getElementById('deleteReviewForm');
    const modalAuthor  = document.getElementById('modalAuthorName');
    const modalRecipe  = document.getElementById('modalRecipeName');
    const modalComment = document.getElementById('modalCommentQuote');
    const cancelBtn    = document.getElementById('cancelDeleteReviewBtn');

    function openDeleteModal(data) {
        modalAuthor.textContent  = data.author;
        modalRecipe.textContent  = data.recipe;
        modalComment.textContent = '“' + data.comment + '”';
        deleteForm.action = data.deleteUrl;

        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => openDeleteModal({
            author:    btn.dataset.author,
            recipe:    btn.dataset.recipe,
            comment:   btn.dataset.comment,
            deleteUrl: btn.dataset.deleteUrl,
        }));
    });

    cancelBtn.addEventListener('click', closeDeleteModal);

    /* Escape menutup modal */
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    /* Flash message dari server → tampilkan toast */
    @if (session('success'))
        (function () {
            const toast = document.getElementById('toastSuccess');
            document.getElementById('toastMessage').textContent = @json(session('success'));
            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            }, 3200);
        })();
    @endif
})();
</script>
@endpush