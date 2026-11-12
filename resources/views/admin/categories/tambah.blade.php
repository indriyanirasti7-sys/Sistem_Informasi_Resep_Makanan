@extends('admin.layout')

@section('title', 'Tambah Kategori — Jelajah Rasa')
@section('breadcrumb', 'Tambah Kategori')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- Header --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Kategori
        </a>

        <div class="flex flex-col gap-1.5">
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Tambah Kategori Baru</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Definisikan klasifikasi menu baru untuk memperkaya taksonomi kuliner di portal Jelajah Rasa.
            </p>
        </div>
    </header>

    {{-- FORM UTAMA --}}
    <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        @csrf
        
        {{-- Hidden Input untuk Ikon (Cadangan) --}}
        <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', 'restaurant') }}"/>

        {{-- Kolom Kiri: Form Input --}}
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm flex flex-col gap-6">
            
            {{-- Nama Kategori --}}
            <div class="flex flex-col gap-2">
                <label for="name" class="text-xs font-bold text-primary uppercase tracking-wider">
                    Nama Kategori <span class="text-error">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Hidangan Pembuka"
                       class="w-full bg-surface-container-low px-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                @error('name')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <label for="slug" class="text-xs font-bold text-primary uppercase tracking-wider">
                        Slug URL <span class="text-error">*</span>
                    </label>
                    <span class="text-[11px] text-secondary">Otomatis dari nama</span>
                </div>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-sm text-on-surface-variant">/kategori/</span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                           class="w-full bg-surface-container-low pl-24 pr-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                </div>
                @error('slug')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- UPLOAD FOTO --}}
            <div class="flex flex-col gap-2 pt-2">
                <label class="text-xs font-bold text-primary uppercase tracking-wider">Foto Kategori</label>
                <div class="relative w-full h-48 rounded-2xl border-2 border-dashed border-outline-variant hover:border-secondary bg-surface-container-lowest flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                    <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                    
                    <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                    
                    <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-1 z-0">
                        <span class="material-symbols-outlined text-[32px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                        <span class="text-sm font-bold text-primary mt-1">Pilih foto atau seret ke area ini</span>
                        <span class="text-[11px] text-on-surface-variant">Format: JPG, PNG, WEBP (Maks. 2MB)</span>
                    </div>
                </div>
                @error('image')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <label class="flex items-center gap-3 cursor-pointer select-none w-fit mt-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                       class="w-4 h-4 rounded accent-secondary"/>
                <span class="text-sm text-on-surface-variant font-semibold">Tampilkan kategori ini di beranda</span>
            </label>
        </div>

        {{-- Kolom Kanan: Live Preview --}}
        <div class="flex flex-col gap-5">

            {{-- Live Preview --}}
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm sticky top-28">
                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Pratinjau Kartu</span>

                <div class="mt-4 flex flex-col items-center text-center gap-4">
                    
                    {{-- Preview Foto --}}
                    <div class="w-24 h-24 rounded-full bg-surface-container-high flex items-center justify-center text-outline shrink-0 overflow-hidden shadow-sm border border-surface-container-high relative">
                        <img id="previewImage" class="hidden w-full h-full object-cover" src="" alt="Preview">
                        <span class="material-symbols-outlined text-[36px]" id="previewIconPlaceholder">image</span>
                    </div>

                    <div class="flex flex-col min-w-0 w-full">
                        <span class="font-display text-xl text-primary font-bold truncate" id="previewName">
                            Nama Kategori
                        </span>
                        <code class="text-[11px] text-on-surface-variant truncate bg-surface-container-low py-1 px-3 rounded-full w-fit mx-auto mt-1" id="previewSlug">/kategori/</code>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTIONS (KIRI BATAL, KANAN SIMPAN) --}}
        <div class="lg:col-span-3 flex items-center justify-between pt-6 border-t border-surface-container-high mt-2">
            
            {{-- Kiri Bawah: Batal --}}
            <a href="{{ route('admin.categories.index') }}"
               class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
                Batal
            </a>

            {{-- Kanan Bawah: Simpan --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="group inline-flex items-center gap-2.5 px-8 py-3 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput  = document.getElementById('name');
    const slugInput  = document.getElementById('slug');
    const prevName   = document.getElementById('previewName');
    const prevSlug   = document.getElementById('previewSlug');

    // Fungsi Slugify
    function slugify(t) {
        return (t || '').toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
    }

    // Event Nama
    if (nameInput) {
        nameInput.addEventListener('input', e => {
            const v = e.target.value;
            prevName.textContent = v || 'Nama Kategori';
            const s = slugify(v);
            slugInput.value = s;
            prevSlug.textContent = '/kategori/' + s;
        });
    }

    // Event Upload Gambar
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePlaceholder');
            const previewImageCard = document.getElementById('previewImage');
            const previewIconCard = document.getElementById('previewIconPlaceholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Update kotak upload
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    if (placeholder) placeholder.classList.add('hidden');
                    
                    // Update live preview di kanan
                    if (previewImageCard) {
                        previewImageCard.src = e.target.result;
                        previewImageCard.classList.remove('hidden');
                    }
                    if (previewIconCard) previewIconCard.classList.add('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        });
    }
});
</script>
@endpush