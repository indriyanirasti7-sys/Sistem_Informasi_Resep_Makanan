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

            {{-- Baris Atas: Info Pengulas + Bintang --}}
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">

                {{-- Pengulas --}}
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

                {{-- Bintang --}}
                <div class="flex items-center gap-0.5 self-end sm:self-auto">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-[20px] {{ $i <= $rating ? 'text-tertiary-container' : 'text-surface-container-highest' }}"
                              style="font-variation-settings: 'FILL' 1;">star</span>
                    @endfor
                </div>
            </div>

            {{-- Komentar --}}
            <p class="text-sm text-on-surface leading-relaxed">
                “{{ $review->comment }}”
            </p>

            {{-- Pill Resep --}}
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

{{-- Pagination --}}
@if ($reviews->hasPages())
    <div class="mt-6 pt-4 border-t border-surface-container-high">
        {{ $reviews->links() }}
    </div>
@endif

@endsection 