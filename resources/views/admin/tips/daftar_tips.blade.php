@extends('admin.layout')

@section('title', 'Kelola Tips — Griya Rasa')
@section('breadcrumb', 'Kelola Tips')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1.5">
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Kelola Tips</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Tambahkan, edit, dan hapus artikel tips kuliner untuk membagikan pengetahuan dan pengalaman memasak kepada pengunjung.
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

{{-- ========== TABEL TIPS ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm overflow-hidden mb-8">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-surface-container-low/60 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl text-center w-20">Foto</th>
                    <th class="py-3.5 px-4 text-center min-w-[250px]">Judul Tips</th>
                    <th class="py-3.5 px-4 text-center">Penulis</th>
                    <th class="py-3.5 px-4 text-center">Tanggal Dibuat</th>
                    <th class="py-3.5 px-4 text-center rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($tips as $tip)
                    <tr class="hover:bg-surface-container-low/40 transition group">
                        
                        {{-- Foto Tips (Dengan Penanganan Lokal & Hosting) --}}
                        <td class="py-4 px-4">
                            <div class="flex justify-center">
                                <div class="w-14 h-14 rounded-xl overflow-hidden shadow-sm bg-surface-container shrink-0">
                                    @php
                                        $tipImg = null;
                                        if ($tip->image) {
                                            $cleanTipImg = str_replace(['storage/', 'uploads/tips/', 'uploads/'], '', $tip->image);
                                            if (file_exists(public_path('storage/' . $tip->image))) {
                                                $tipImg = asset('storage/' . $tip->image);
                                            } elseif (file_exists(public_path('storage/' . $cleanTipImg))) {
                                                $tipImg = asset('storage/' . $cleanTipImg);
                                            } elseif (file_exists(public_path('storage/tips/' . $cleanTipImg))) {
                                                $tipImg = asset('storage/tips/' . $cleanTipImg);
                                            } elseif (file_exists(public_path('uploads/' . $cleanTipImg))) {
                                                $tipImg = asset('uploads/' . $cleanTipImg);
                                            } else {
                                                $tipImg = asset('storage/' . $tip->image);
                                            }
                                        }
                                    @endphp

                                    @if ($tipImg)
                                        <img src="{{ $tipImg }}"
                                             alt="{{ $tip->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-secondary-container/60 to-primary-fixed/40 text-secondary">
                                            <span class="material-symbols-outlined text-[24px]">menu_book</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Judul --}}
                        <td class="py-4 px-4">
                            <div class="flex flex-col items-center text-center">
                                <span class="text-base text-primary font-bold group-hover:text-tertiary-container transition line-clamp-1">
                                    {{ $tip->title }}
                                </span>
                                <span class="text-[11px] text-on-surface-variant bg-surface-container-low px-2 py-0.5 rounded-full w-fit mt-1">
                                    /tips/{{ $tip->slug }}
                                </span>
                            </div>
                        </td>

                        {{-- Penulis (Avatar & Nama sesuai akun login/relasi) --}}
                        <td class="py-4 px-4 whitespace-nowrap">
                            @php
                                $author = $tip->user;
                                $authorAvatar = null;
                                if ($author && $author->avatar) {
                                    $cleanAuthorAvatar = str_replace(['storage/', 'uploads/avatars/', 'avatars/'], '', $author->avatar);
                                    if (file_exists(public_path('storage/' . $author->avatar))) {
                                        $authorAvatar = asset('storage/' . $author->avatar);
                                    } elseif (file_exists(public_path('storage/' . $cleanAuthorAvatar))) {
                                        $authorAvatar = asset('storage/' . $cleanAuthorAvatar);
                                    } elseif (file_exists(public_path('storage/avatars/' . $cleanAuthorAvatar))) {
                                        $authorAvatar = asset('storage/avatars/' . $cleanAuthorAvatar);
                                    } elseif (file_exists(public_path('uploads/' . $cleanAuthorAvatar))) {
                                        $authorAvatar = asset('uploads/' . $cleanAuthorAvatar);
                                    } else {
                                        $authorAvatar = asset('storage/' . $author->avatar);
                                    }
                                }
                                $authorInitials = collect(explode(' ', $author->name ?? 'A'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                            @endphp

                            <div class="flex items-center justify-center gap-2.5">
                                <div class="w-8 h-8 rounded-full overflow-hidden bg-secondary/15 flex items-center justify-center text-secondary shrink-0 shadow-sm font-bold text-xs">
                                    @if($authorAvatar)
                                        <img src="{{ $authorAvatar }}" alt="{{ $author->name ?? 'Anonim' }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $authorInitials }}
                                    @endif
                                </div>
                                <span class="text-sm font-semibold text-on-surface">{{ $author->name ?? 'Anonim' }}</span>
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td class="py-4 px-4 whitespace-nowrap">
                            <span class="text-xs text-on-surface-variant font-semibold">
                                {{ optional($tip->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                {{-- Tombol Lihat (Baca) --}}
                                <a href="{{ route('admin.tips.detail', $tip->slug) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Baca">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.tips.edit', $tip->slug) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                
                                {{-- Tombol Hapus (Memanggil Modal) --}}
                                <button type="button"
                                        class="delete-btn p-2 text-error hover:bg-error-container/60 rounded-full transition" title="Hapus"
                                        data-title="{{ $tip->title }}"
                                        data-url="{{ route('admin.tips.destroy', $tip->id) }}">
                                    <span class="material-symbols-outlined text-[19px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">menu_book</span>
                                </div>
                                <h3 class="font-display text-xl text-primary font-bold">Belum Ada Tips</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Mulai bagikan pengetahuan kuliner dengan menulis artikel tips pertama Anda.
                                </p>
                                <a href="{{ route('admin.tips.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Tambah Tips
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================================== --}}
    {{-- PAGINATION                                 --}}
    {{-- ========================================== --}}
    @if (method_exists($tips, 'hasPages') && $tips->hasPages())
        <div class="mt-8 pt-6 flex flex-col items-center justify-center gap-4 border-t border-surface-container">
            
            <div class="flex items-center gap-1.5">
                {{-- Prev --}}
                @if ($tips->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-full text-outline/50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $tips->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($tips->getUrlRange(max(1, $tips->currentPage() - 2), min($tips->lastPage(), $tips->currentPage() + 2)) as $page => $url)
                    @if ($page == $tips->currentPage())
                        <span class="w-9 h-9 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-md transform scale-110">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="w-9 h-9 rounded-full text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($tips->hasMorePages())
                    <a href="{{ $tips->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-full text-outline/50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </span>
                @endif
            </div>

            <span class="text-[11px] text-on-surface-variant font-medium">
                Menampilkan <strong class="text-primary">{{ $tips->firstItem() }}-{{ $tips->lastItem() }}</strong>
                dari <strong class="text-primary">{{ $tips->total() }}</strong> tips
            </span>
        </div>
    @endif
</section>

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

        <div class="flex items-center gap-3 mt-8 w-full">
            {{-- Tombol Batal --}}
            <button type="button" id="cancelDeleteBtn" class="flex-1 py-2.5 rounded-full bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition">
                Batal
            </button>
            
            {{-- Form Hapus (Action diisi oleh JS) --}}
            <form id="deleteForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 rounded-full bg-error text-white font-bold text-sm hover:bg-error/90 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
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

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    /* Event Listener untuk Tombol Hapus di Tabel */
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
            deleteTarget.textContent = btn.dataset.title;
            deleteForm.action = btn.dataset.url;
            
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
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