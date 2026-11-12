@extends('admin.layout')

@section('title', 'Kelola Kategori — Jelajah Rasa')
@section('breadcrumb', 'Kelola Kategori')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1.5">
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Kelola Kategori</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Atur klasifikasi menu kuliner: sarapan, makan siang, dessert, dan lainnya untuk memudahkan navigasi pengunjung.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="group inline-flex items-center gap-2.5 px-6 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:rotate-90">add</span>
            <span>Tambah Kategori</span>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-2">
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Kategori</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $categories->total() }}</span>
                    <span class="text-xs text-on-surface-variant">kategori</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Semua kategori terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">category</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Kategori Terpakai</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">
                        {{ $categories->where('recipes_count', '>', 0)->count() }}
                    </span>
                    <span class="text-xs text-on-surface-variant">aktif</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Kategori dengan resep</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">check_circle</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total Resep</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">
                        {{ $categories->sum('recipes_count') }}
                    </span>
                    <span class="text-xs text-on-surface-variant">resep</span>
                </div>
                <span class="text-xs text-on-surface-variant/80 mt-0.5">Terdistribusi di semua kategori</span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-container/70 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">restaurant_menu</span>
            </div>
        </div>
    </div>
</header>

{{-- ========== TABEL KATEGORI ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm overflow-hidden">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-surface-container-low/60 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl w-20 text-center">Foto</th>
                    <th class="py-3.5 px-4 text-center">Nama Kategori</th>
                    <th class="py-3.5 px-4 text-center">Slug</th>
                    <th class="py-3.5 px-4 text-center">Jumlah Resep</th>
                    <th class="py-3.5 px-4 text-center">Dibuat</th>
                    <th class="py-3.5 px-4 text-center rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($categories as $category)
                    <tr class="hover:bg-surface-container-low/40 transition group">
                        
                        {{-- FOTO / ICON --}}
                        <td class="py-4 px-4">
                            <div class="flex justify-center">
                                @if($category->image)
                                    <img src="{{ asset('storage/'.$category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary shadow-sm">
                                        <span class="material-symbols-outlined text-[24px]">
                                            {{ $category->icon ?? 'restaurant' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Nama Kategori --}}
                        <td class="py-4 px-4">
                            <span class="text-base font-bold text-primary group-hover:text-tertiary-container transition block">
                                {{ $category->name }}
                            </span>
                        </td>

                        {{-- Slug --}}
                        <td class="py-4 px-4">
                            <div class="flex justify-center">
                                <code class="text-xs bg-surface-container-low px-2.5 py-1 rounded-full text-on-surface-variant inline-block">
                                    {{ $category->slug }}
                                </code>
                            </div>
                        </td>

                        {{-- Jumlah Resep --}}
                        <td class="py-4 px-4">
                            <div class="flex justify-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/70 text-on-secondary-container text-[11px] font-bold">
                                    <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                    {{ $category->recipes_count }} resep
                                </span>
                            </div>
                        </td>

                        {{-- Dibuat --}}
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ $category->created_at->translatedFormat('d M Y') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.categories.show', $category->slug) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                   class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                
                                {{-- TOMBOL HAPUS --}}
                                <button type="button"
                                        class="delete-category-btn p-2 text-error hover:bg-error-container/60 rounded-full transition" 
                                        title="Hapus"
                                        data-title="{{ $category->name }}"
                                        data-url="{{ route('admin.categories.destroy', $category->slug) }}">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">category</span>
                                </div>
                                <h3 class="font-display text-xl text-primary font-bold">Belum Ada Kategori</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Mulai buat kategori pertama untuk klasifikasi resep.
                                </p>
                                <a href="{{ route('admin.categories.create') }}"
                                   class="mt-2 inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Tambah Kategori
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================================== --}}
    {{-- PAGINATION (DIPERBARUI SEPERTI RESEP)      --}}
    {{-- ========================================== --}}
    @if ($categories->hasPages())
        <div class="mt-8 pt-6 flex flex-col items-center justify-center gap-4 border-t border-surface-container">
            
            <div class="flex items-center gap-1.5">
                {{-- Prev --}}
                @if ($categories->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-full text-outline/50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($categories->getUrlRange(max(1, $categories->currentPage() - 2), min($categories->lastPage(), $categories->currentPage() + 2)) as $page => $url)
                    @if ($page == $categories->currentPage())
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
                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}"
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
                Menampilkan <strong class="text-primary">{{ $categories->firstItem() }}-{{ $categories->lastItem() }}</strong>
                dari <strong class="text-primary">{{ $categories->total() }}</strong> kategori
            </span>
        </div>
    @endif
</section>

{{-- ============================================================
     MODAL: Konfirmasi Hapus Kategori
     ============================================================ --}}
<div id="deleteCategoryModal"
     class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-md w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col items-center text-center">

        <div class="w-16 h-16 rounded-full bg-error-container text-error flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-[32px]">warning</span>
        </div>

        <h3 class="font-display text-2xl text-primary font-bold">Hapus Kategori Ini?</h3>
        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
            Kategori <strong class="text-primary font-bold" id="deleteCategoryTitle">—</strong>
            akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex items-center gap-3 mt-8 w-full">
            {{-- Tombol Batal --}}
            <button type="button" id="cancelDeleteCategoryBtn" class="flex-1 py-2.5 rounded-full bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition">
                Batal
            </button>
            
            {{-- Form Hapus (Action diisi oleh JS) --}}
            <form id="deleteCategoryForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 rounded-full bg-error text-white font-bold text-sm hover:bg-error/90 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const deleteModal  = document.getElementById('deleteCategoryModal');
    const deleteForm   = document.getElementById('deleteCategoryForm');
    const deleteTarget = document.getElementById('deleteCategoryTitle');
    const cancelDelete = document.getElementById('cancelDeleteCategoryBtn');

    function openDeleteModal(btn) {
        // Ambil data dari tombol yang diklik
        deleteTarget.textContent = btn.dataset.title;
        deleteForm.action = btn.dataset.url;
        
        // Tampilkan Modal
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    // Delegasi Event Listener untuk Tombol Hapus
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.delete-category-btn');
        if (btn) {
            openDeleteModal(btn);
        }
    });

    // Tombol Batal & Tombol ESC
    cancelDelete.addEventListener('click', closeDeleteModal);
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // Klik di luar area modal untuk menutup
    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) closeDeleteModal();
    });
})();
</script>
@endpush