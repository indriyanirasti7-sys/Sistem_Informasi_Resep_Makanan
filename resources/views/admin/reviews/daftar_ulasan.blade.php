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

        <article class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col gap-4">

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

                <div class="flex items-center gap-0.5 self-end sm:self-auto">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-[20px] {{ $i <= $rating ? 'text-tertiary-container' : 'text-surface-container-highest' }}"
                              style="font-variation-settings: 'FILL' 1;">star</span>
                    @endfor
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
        <div class="bg-surface-container-lowest rounded-3xl p-16 text-center shadow-sm">
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[32px]">chat_bubble_outline</span>
                </div>
                <h3 class="font-display text-xl text-primary font-bold">Belum Ada Ulasan</h3>
                <p class="text-sm text-on-surface-variant max-w-md">
                    Ulasan dari pengunjung akan muncul di sini.
                </p>
            </div>
        </div>
    @endforelse
</section>

@if ($reviews->hasPages())
    <div class="mt-6 pt-4 border-t border-surface-container-high">
        {{ $reviews->links() }}
    </div>
@endif

@endsection