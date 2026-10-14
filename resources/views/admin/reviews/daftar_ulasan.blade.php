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

{{-- ========== LIST ULASAN (KERANGKA) ========== --}}
<section class="flex flex-col gap-4">
    @forelse ($reviews as $review)
        <article class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col">
                    <h3 class="font-bold text-primary">{{ $review->user->name ?? 'Anonim' }}</h3>
                    <span class="text-xs text-on-surface-variant">{{ $review->recipe->title ?? 'Resep dihapus' }}</span>
                </div>
                <span class="text-sm font-bold text-primary">{{ $review->rating }} / 5 ⭐</span>
            </div>
            <p class="text-sm text-on-surface mt-4">{{ $review->comment }}</p>
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