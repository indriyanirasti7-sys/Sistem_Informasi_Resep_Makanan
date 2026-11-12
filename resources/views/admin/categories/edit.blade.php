@extends('admin.layout')

@section('title', 'Edit Kategori — Jelajah Rasa')
@section('breadcrumb', 'Edit Kategori')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- ========== HEADER ========== --}}
    <header class="flex flex-col gap-1 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Kategori
        </a>

        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[28px] text-primary">edit_document</span>
                <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">
                    Edit Kategori: {{ $category->name }}
                </h1>
            </div>
        </div>
        <p class="text-sm text-on-surface-variant mt-1">
            Perbarui nama, slug, deskripsi, atau foto visual kategori. Perubahan akan langsung tampil di beranda.
        </p>
    </header>

    {{-- ========== GRID UTAMA ========== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        
        {{-- KOLOM KIRI: FORM UTAMA --}}
        <div class="lg:col-span-2">
            {{-- PERHATIKAN: Tambahkan enctype="multipart/form-data" --}}
            <form id="editCategoryForm" method="POST" action="{{ route('admin.categories.update', $category->slug) }}" enctype="multipart/form-data" class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm flex flex-col gap-6">
                @csrf
                @method('PUT')

                {{-- HIDDEN INPUT UNTUK IKON (Sebagai fallback) --}}
                <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', $category->icon ?? 'restaurant') }}"/>

                {{-- Nama --}}
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-xs font-bold text-primary uppercase tracking-wider">
                        Nama Kategori <span class="text-error">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $category->name) }}"
                           class="w-full bg-surface-container-low px-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                    @error('name')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label for="slug" class="text-xs font-bold text-primary uppercase tracking-wider">
                            Slug URL
                        </label>
                        <span class="text-[11px] text-secondary">Otomatis dari nama</span>
                    </div>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-sm text-on-surface-variant">/kategori/</span>
                        <input type="text" id="slug" name="slug" required readonly
                               value="{{ old('slug', $category->slug) }}"
                               class="w-full bg-surface-container px-4 py-3 rounded-2xl text-on-surface-variant pl-24 pr-4 text-sm outline-none cursor-not-allowed"/>
                    </div>
                </div>

                {{-- UPLOAD FOTO --}}
                <div class="flex flex-col gap-2 pt-2">
                    <label class="text-xs font-bold text-primary uppercase tracking-wider">Foto Kategori (Biarkan kosong jika tidak diubah)</label>
                    <div class="relative w-full h-48 rounded-2xl border-2 border-dashed border-outline-variant hover:border-secondary bg-surface-container-lowest flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                        <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                        
                        {{-- Preview Gambar Lama / Baru --}}
                        <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover z-10 {{ $category->image ? '' : 'hidden' }}" src="{{ $category->image ? asset('storage/'.$category->image) : '' }}"/>
                        
                        <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-1 z-0 {{ $category->image ? 'hidden' : '' }}">
                            <span class="material-symbols-outlined text-[32px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                            <span class="text-sm font-bold text-primary mt-1">Klik untuk ganti foto</span>
                            <span class="text-[11px] text-on-surface-variant">Format: JPG, PNG, WEBP (Maks. 2MB)</span>
                        </div>
                    </div>
                    @error('image')
                        <span class="text-xs text-error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="text-[11px] text-on-surface-variant mt-2">
                    Dibuat pada {{ $category->created_at->translatedFormat('d M Y') }}
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: PREVIEW & DANGER ZONE --}}
        <div class="flex flex-col gap-5">

            {{-- Live Preview --}}
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm sticky top-28">
                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Pratinjau Kartu</span>

                <div class="mt-4 flex flex-col items-center text-center gap-4">
                    
                    {{-- Preview Foto / Ikon --}}
                    <div class="w-24 h-24 rounded-full bg-surface-container-high flex items-center justify-center text-outline shrink-0 overflow-hidden shadow-sm border border-surface-container-high relative">
                        <img id="previewImage" class="w-full h-full object-cover {{ $category->image ? '' : 'hidden' }}" src="{{ $category->image ? asset('storage/'.$category->image) : '' }}" alt="Preview">
                        <span class="material-symbols-outlined text-[36px] {{ $category->image ? 'hidden' : '' }}" id="previewIconPlaceholder">
                            {{ $category->icon ?? 'image' }}
                        </span>
                    </div>

                    <div class="flex flex-col min-w-0 w-full">
                        <span class="font-display text-xl text-primary font-bold truncate" id="previewName">
                            {{ $category->name }}
                        </span>
                        <code class="text-[11px] text-on-surface-variant truncate bg-surface-container-low py-1 px-3 rounded-full w-fit mx-auto mt-1" id="previewSlug">
                            /kategori/{{ $category->slug }}
                        </code>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-error-container/30 rounded-3xl p-6 shadow-sm border border-error-container">
                <span class="text-[11px] uppercase tracking-widest text-error font-bold">Zona Berbahaya</span>
                <p class="text-xs text-on-surface-variant mt-2">
                    Menghapus kategori ini akan memindahkan resep di dalamnya ke status <em>Uncategorized</em>.
                </p>

                <form method="POST" action="{{ route('admin.categories.destroy', $category->slug) }}"
                      onsubmit="return confirm('Hapus kategori {{ $category->name }}?')" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-error text-white text-sm font-bold rounded-full hover:opacity-90 transition">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        <span>Hapus Kategori</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ========== ACTIONS (KIRI BATAL, KANAN SIMPAN) ========== --}}
    <div class="flex items-center justify-between pt-4 border-t border-surface-container-high mt-2">
        
        {{-- Kiri Bawah: Batal --}}
        <a href="{{ route('admin.categories.index') }}"
           class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
            Batal
        </a>

        {{-- Kanan Bawah: Simpan --}}
        <div class="flex items-center gap-3">
            <button type="submit" form="editCategoryForm"
                    class="group inline-flex items-center gap-2.5 px-8 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Perbarui Kategori</span>
            </button>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
(function () {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    const prevName  = document.getElementById('previewName');
    const prevSlug  = document.getElementById('previewSlug');

    function slugify(t) {
        return (t || '').toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
    }

    // Live Preview Nama & Slug
    nameInput.addEventListener('input', e => {
        prevName.textContent = e.target.value || 'Nama Kategori';
        const s = slugify(e.target.value);
        slugInput.value = s;
        prevSlug.textContent = '/kategori/' + s;
    });
})();

// Fungsi Preview Gambar saat diedit
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');
    const previewImageCard = document.getElementById('previewImage');
    const previewIconCard = document.getElementById('previewIconPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Update kotak upload di kiri
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            
            // Update live preview di kanan
            previewImageCard.src = e.target.result;
            previewImageCard.classList.remove('hidden');
            previewIconCard.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush