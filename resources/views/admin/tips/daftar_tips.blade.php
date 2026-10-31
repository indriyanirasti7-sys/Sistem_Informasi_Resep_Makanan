@extends('admin.layout')

@section('title', 'Kelola Tips — L\'Art de Cuisine')
@section('breadcrumb', 'Kelola Tips')

@section('content')



{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined text-lg">menu_book</span>
                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Pustaka Tips Kuliner</span>
            </div>
            <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Kelola Tips</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Kelola artikel tips, panduan memasak, dan catatan koki untuk memperkaya pengetahuan pengunjung portal gastronomi.
            </p>
        </div>

        <a href="{{ route('admin.tips.create') }}"
           class="group inline-flex items-center gap-2.5 px-6 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:rotate-90">add</span>
            <span>Tambah Tips</span>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-2">
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Tips</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $totalTips }}</span>
                    <span class="text-xs text-on-surface-variant">artikel</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Semua tips terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">menu_book</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Tips Bulan Ini</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $tipsThisMonth }}</span>
                    <span class="text-xs text-on-surface-variant">baru</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Dipublikasikan bulan ini</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">auto_awesome</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Kontributor Teratas</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-xl text-primary font-bold truncate">{{ $topAuthorName }}</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">{{ $topAuthorCount }} artikel ditulis</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-container/70 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">workspace_premium</span>
            </div>
        </div>
    </div>
</header>

{{-- ========== GRID TIPS ========== --}}
<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

    @forelse ($tips as $tip)
        <article
            class="group bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col"
            data-tip-id="{{ $tip->id }}"
            data-tip-title="{{ $tip->title }}"
            data-tip-slug="{{ $tip->slug }}"
            data-tip-content="{{ $tip->content }}"
            data-tip-image="{{ $tip->image }}"
            data-update-url="{{ route('admin.tips.update', $tip->id) }}"
            data-delete-url="{{ route('admin.tips.destroy', $tip->id) }}">

            {{-- Thumbnail --}}
            <div class="relative aspect-[16/9] bg-surface-container overflow-hidden">
                @if ($tip->image)
                    <img src="{{ asset('storage/' . $tip->image) }}"
                         alt="{{ $tip->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-secondary-container/60 to-primary-fixed/40 text-secondary">
                        <span class="material-symbols-outlined text-[56px]">menu_book</span>
                    </div>
                @endif

                {{-- Tanggal badge --}}
                <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-sm text-on-surface-variant text-[11px] font-bold shadow-sm">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    {{ optional($tip->created_at)->translatedFormat('d M Y') }}
                </span>
            </div>

            {{-- Body --}}
            <div class="flex flex-col gap-3 p-6 flex-1">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="font-display text-xl text-primary font-bold leading-snug line-clamp-2 group-hover:text-tertiary-container transition">
                        {{ $tip->title }}
                    </h2>

                    <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.tips.edit', $tip->slug) }}"
                           class="p-2 rounded-full text-on-surface-variant hover:text-primary hover:bg-surface-container transition"
                           title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <button type="button"
                                class="delete-btn p-2 rounded-full text-error hover:bg-error-container/60 transition"
                                title="Hapus">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>

                <code class="text-[11px] text-on-surface-variant bg-surface-container-low px-2.5 py-1 rounded-full w-fit">
                    /tips/{{ $tip->slug }}
                </code>

                <p class="text-sm text-on-surface-variant leading-relaxed line-clamp-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($tip->content), 140) }}
                </p>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-5 pt-3 border-t border-surface-container-high/60 flex items-center justify-between">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="w-7 h-7 rounded-full bg-secondary/15 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined text-[16px]">person</span>
                    </div>
                    <span class="text-xs text-on-surface-variant truncate">
                        {{ optional($tip->user)->name ?? 'Anonim' }}
                    </span>
                </div>

                <a href="{{ route('admin.tips.detail', $tip->slug) }}"
                   class="inline-flex items-center gap-1 text-primary hover:text-tertiary-container text-xs font-bold transition">
                    <span>Baca</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </article>
    @empty
        {{-- Empty state --}}
        <div class="md:col-span-2 xl:col-span-3 bg-surface-container-lowest rounded-3xl p-16 shadow-sm flex flex-col items-center text-center">
            <div class="w-20 h-20 rounded-full bg-surface-container-high flex items-center justify-center text-outline">
                <span class="material-symbols-outlined text-[36px]">menu_book</span>
            </div>
            <h3 class="font-display text-2xl text-primary font-bold mt-5">Belum Ada Tips</h3>
            <p class="text-sm text-on-surface-variant max-w-md mt-2">
                Mulai bagikan pengetahuan kuliner dengan menulis artikel tips pertama Anda.
            </p>
            <a href="{{ route('admin.tips.create') }}"
               class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Tulis Tips Pertama</span>
            </a>
        </div>
    @endforelse

    {{-- Kartu placeholder tambah tips --}}
    @if ($tips->count() > 0)
        <a href="{{ route('admin.tips.create') }}"
           class="group bg-surface-container-high/40 hover:bg-surface-container-high/70 rounded-3xl p-6 flex flex-col items-center justify-center text-center transition-all duration-300 min-h-[320px] border-2 border-dashed border-outline-variant/40 hover:border-secondary/50">
            <div class="w-16 h-16 rounded-full bg-surface-container-lowest text-primary flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:bg-primary-container group-hover:text-white transition-all duration-300">
                <span class="material-symbols-outlined text-[32px]">add</span>
            </div>
            <h3 class="font-display text-xl text-primary font-bold mt-4">Tambah Tips Baru</h3>
            <p class="text-sm text-on-surface-variant max-w-xs mt-2">
                Bagikan wawasan gastronomi, teknik memasak, atau catatan dapur Anda.
            </p>
            <span class="mt-4 inline-flex items-center gap-1 text-primary text-xs font-bold group-hover:underline">
                <span>Buka Formulir</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </span>
        </a>
    @endif
</section>

{{-- Pagination --}}
@if (method_exists($tips, 'hasPages') && $tips->hasPages())
    <div class="mt-8 pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <span class="text-xs text-on-surface-variant">
            Menampilkan <strong class="text-primary font-bold">{{ $tips->firstItem() }}-{{ $tips->lastItem() }}</strong>
            dari <strong class="text-primary font-bold">{{ $tips->total() }}</strong> tips
        </span>

        <div class="flex items-center gap-1.5">
            @if (!$tips->onFirstPage())
                <a href="{{ $tips->previousPageUrl() }}"
                   class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                    ← Sebelumnya
                </a>
            @endif

            @foreach ($tips->getUrlRange(max(1, $tips->currentPage() - 2), min($tips->lastPage(), $tips->currentPage() + 2)) as $page => $url)
                @if ($page == $tips->currentPage())
                    <span class="w-8 h-8 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-sm">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="w-8 h-8 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold flex items-center justify-center transition">{{ $page }}</a>
                @endif
            @endforeach

            @if ($tips->hasMorePages())
                <a href="{{ $tips->nextPageUrl() }}"
                   class="px-3.5 py-1.5 rounded-full text-on-surface-variant hover:bg-surface-container text-xs font-bold transition">
                    Berikutnya →
                </a>
            @endif
        </div>
    </div>
@endif

{{-- ============================================================
     MODAL: Konfirmasi Hapus Tips
     ============================================================ --}}
<div id="deleteConfirmModal"
     class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-md w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col items-center text-center">

        <div class="w-16 h-16 rounded-full bg-error-container text-error flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-[32px]">warning</span>
        </div>

        <h3 class="font-display text-2xl text-primary font-bold">Hapus Tips Ini?</h3>
        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
            Artikel <strong class="text-primary font-bold" id="deleteTargetTitle">—</strong>
            akan dihapus permanen dari portal. Tindakan ini tidak dapat dibatalkan.
        </p>

        <form method="POST" action="{{ route('admin.tips.destroy', $tip->slug) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tips ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-error hover:bg-error-container/60 rounded-full transition" title="Hapus Tips">
                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>
        </form>
    </div>
</div>

{{-- Toast --}}
<div id="toastSuccess"
     class="fixed bottom-6 right-6 z-50 bg-primary-container text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-2.5 transition-all transform translate-y-24 opacity-0 pointer-events-none">
    <span class="material-symbols-outlined text-[20px] text-secondary-fixed">check_circle</span>
    <span class="text-sm font-bold" id="toastMessage">Berhasil!</span>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const deleteModal   = document.getElementById('deleteConfirmModal');
    const deleteForm    = document.getElementById('deleteForm');
    const deleteTarget  = document.getElementById('deleteTargetTitle');
    const cancelDelete  = document.getElementById('cancelDeleteBtn');

    function openDeleteModal(card) {
        deleteTarget.textContent = card.dataset.tipTitle;
        deleteForm.action = card.dataset.deleteUrl;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    /* Delegasi tombol hapus — aman untuk elemen dinamis */
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            const card = btn.closest('article');
            if (card) openDeleteModal(card);
        }
    });

    cancelDelete.addEventListener('click', closeDeleteModal);

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    /* Flash message dari server */
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