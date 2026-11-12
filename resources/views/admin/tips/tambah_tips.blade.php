@extends('admin.layout')

@section('title', 'Tambah Tips — Jelajah Rasa')
@section('breadcrumb', 'Tambah Tips')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- Header --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.tips.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Tips
        </a>

        <div class="flex flex-col gap-1.5">
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Tambah Tips Baru</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Tulis panduan teknik dapur, kiat gastronomi, atau artikel kuliner mendalam dengan format artikel editorial standar.
            </p>
        </div>
    </header>

    {{-- FORM UTAMA --}}
    <form id="tipsForm" method="POST" action="{{ route('admin.tips.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

        {{-- PESAN ERROR JIKA GAGAL SIMPAN --}}
        @if ($errors->any())
            <div class="p-5 rounded-2xl bg-error-container text-on-error-container text-sm shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <span class="material-symbols-outlined">error</span>
                    Gagal Menyimpan! Periksa kembali isian Anda:
                </div>
                <ul class="list-disc list-inside pl-2 space-y-1">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <!-- Card A: Basic Information -->
        <section class="bg-surface-container-lowest p-6 md:p-8 rounded-3xl shadow-sm flex flex-col gap-5">
            <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-surface-container rounded-full text-primary">
                        <span class="material-symbols-outlined text-[20px]">edit_note</span>
                    </span>
                    <div>
                        <h2 class="text-lg text-primary font-bold">Informasi Dasar Tips</h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">Tentukan tajuk, rubrik gastronomi, dan tingkat kemahiran pembaca</p>
                    </div>
                </div>
            </div>

            <!-- Title Field -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-primary flex items-center justify-between" for="title">
                    <span>Judul Tips Gastronomi <span class="text-error">*</span></span>
                </label>
                <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="Contoh: Teknik Dasar Memotong Bawang dengan Aman"
                       class="w-full bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all text-sm font-medium"/>
            </div>

            <!-- Category & Skill Level Split -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-primary" for="category">Kategori Rubrik <span class="text-error">*</span></label>
                    <div class="relative">
                        <select id="category" name="category" required class="w-full appearance-none bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="knife-skills" {{ old('category') == 'knife-skills' ? 'selected' : '' }}>Knife Skills (Teknik Pisau Dapur)</option>
                            <option value="baking-hacks" {{ old('category') == 'baking-hacks' ? 'selected' : '' }}>Baking &amp; Patisserie Hacks</option>
                            <option value="kitchen-safety" {{ old('category') == 'kitchen-safety' ? 'selected' : '' }}>Kitchen Safety &amp; Ergonomics</option>
                            <option value="prep-storage" {{ old('category') == 'prep-storage' ? 'selected' : '' }}>Food Prep, Marinade &amp; Storage</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-[20px]">unfold_more</span>
                    </div>
                </div>

                {{-- PERBAIKAN RADIO BUTTON: Menggunakan metode Label Wrapper --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-primary">Tingkat Keahlian <span class="text-error">*</span></label>
                    <div class="flex items-center gap-2 bg-surface-container-low p-1.5 rounded-2xl shadow-sm h-[46px]">
                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="difficulty" value="Pemula" class="peer sr-only" {{ old('difficulty') == 'Pemula' ? 'checked' : '' }} required>
                            <div class="py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                Pemula
                            </div>
                        </label>

                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="difficulty" value="Menengah" class="peer sr-only" {{ old('difficulty') == 'Menengah' ? 'checked' : '' }}>
                            <div class="py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                Menengah
                            </div>
                        </label>

                        <label class="flex-1 text-center cursor-pointer">
                            <input type="radio" name="difficulty" value="Mahir" class="peer sr-only" {{ old('difficulty') == 'Mahir' ? 'checked' : '' }}>
                            <div class="py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                Mahir
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Short Summary -->
            <div class="flex flex-col gap-1.5 pt-2">
                <label class="text-xs font-bold text-primary" for="summary">Ringkasan Singkat / Lead-in Artikel</label>
                <textarea id="summary" name="summary" rows="3" placeholder="Tuliskan hook pembuka artikel kuliner yang menggugah selera..."
                          class="w-full bg-surface-container-low text-on-surface p-4 rounded-2xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all resize-none">{{ old('summary') }}</textarea>
            </div>
        </section>

        <!-- Card B: Featured Image Upload -->
        <section class="bg-surface-container-lowest p-6 md:p-8 rounded-3xl shadow-sm flex flex-col gap-5">
            <div class="flex items-center gap-3 border-b border-surface-container-high pb-4">
                <span class="p-2 bg-surface-container rounded-full text-primary">
                    <span class="material-symbols-outlined text-[20px]">image</span>
                </span>
                <div>
                    <h2 class="text-lg text-primary font-bold">Foto Sampul &amp; Visual Utama</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Gambar utama dengan resolusi tinggi untuk banner pembuka</p>
                </div>
            </div>

            <div class="relative w-full h-64 rounded-2xl bg-surface-container-lowest border-2 border-dashed border-outline-variant hover:border-secondary flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-2 z-0">
                    <span class="material-symbols-outlined text-[36px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                    <span class="text-sm font-bold text-primary">Pilih foto atau seret ke area ini</span>
                    <span class="text-[11px] text-on-surface-variant">Format: WebP, PNG, JPG (Maks. 5MB)</span>
                </div>
            </div>
        </section>
        
        <!-- Card C: Article Content (TinyMCE Editor) -->
        <section class="bg-surface-container-lowest rounded-3xl shadow-sm flex flex-col overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-surface-container rounded-full text-primary">
                        <span class="material-symbols-outlined text-[20px]">article</span>
                    </span>
                    <div>
                        <h2 class="text-lg text-primary font-bold">Isi Artikel Tips <span class="text-error">*</span></h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">Gunakan format teks kaya untuk menyusun naskah panduan kuliner</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <textarea name="content" id="editor-content" rows="15" placeholder="Mulai tulis artikel panduan Anda di sini..." 
                          class="w-full text-sm text-on-surface leading-relaxed outline-none resize-y bg-transparent focus:ring-0 border-0">{{ old('content') }}</textarea>
            </div>
            
            <div class="px-6 py-3 bg-surface-container-low/40 flex items-center justify-between text-on-surface-variant text-[11px]">
                <span>Format: Rich Editorial Text</span>
                <span class="flex items-center gap-1 text-secondary font-semibold"><span class="material-symbols-outlined text-[14px]">spellcheck</span> Koreksi Bahasa Aktif</span>
            </div>
        </section>
                
        <!-- ACTIONS (KIRI DRAFT, KANAN PUBLISH) -->
        <div class="flex items-center justify-between pt-4 border-t border-surface-container-high mt-2">
            
            {{-- Kiri Bawah: Simpan Draft --}}
            <button type="submit" name="status" value="draft" class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan sebagai Draft
            </button>

            {{-- Kanan Bawah: Publikasikan --}}
            <div class="flex items-center gap-3">
                <button type="submit" name="status" value="published" class="px-6 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    Publikasikan Tips
                </button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // 1. Inisialisasi TinyMCE
    tinymce.init({
        selector: '#editor-content',
        height: 500,
        menubar: false,
        plugins: 'lists link image table code help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image | code',
        content_style: 'body { font-family:Plus Jakarta Sans,sans-serif; font-size:14px; color: #41240e; background-color: transparent; }',
        skin: 'oxide'
    });

    // 2. Paksa TinyMCE menyimpan teks ke textarea sebelum form disubmit
    document.getElementById('tipsForm').addEventListener('submit', function() {
        tinymce.triggerSave(); 
    });

    // 3. Preview Image Upload
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('imagePlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush