@extends('admin.layout')

@section('title', 'Tambah Tips Baru — L\'Art de Cuisine')
@section('breadcrumb', 'Tambah Tips')

@section('content')

<div class="flex flex-col w-full pb-12 pt-6">
    
    <!-- Top Header Section & Status -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 mb-4">
        <div class="flex flex-col max-w-2xl">
            <div class="flex items-center gap-1.5 text-[11px] text-secondary mb-1 font-semibold">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                    Admin Portal
                </span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('admin.tips.index') }}" class="text-on-surface-variant hover:text-primary transition">Kelola Tips</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-primary font-bold">Tambah Tips Baru</span>
            </div>
            <h1 class="font-display text-3xl text-primary tracking-tight font-bold">Tambah Tips Baru</h1>
            <p class="text-sm text-on-surface-variant mt-1 leading-relaxed">
                Tulis panduan teknik dapur, kiat gastronomi, atau artikel kuliner mendalam dengan format artikel editorial standar haute cuisine.
            </p>
        </div>
        
        <!-- Live Sync & Auto-save Status Pill -->
        <div class="flex flex-wrap items-center gap-3 bg-surface-container-low px-4 py-2.5 rounded-full shadow-sm self-start md:self-auto">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-secondary"></span>
                </span>
                <span class="text-xs font-semibold text-secondary">Sistem Aktif</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tips.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-error-container text-on-error-container text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

                <!-- Card A: Basic Information -->
        <section class="bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-sm flex flex-col gap-5">
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
                <label class="text-sm font-bold text-primary flex items-center justify-between" for="title">
                    <span>Judul Tips Gastronomi <span class="text-error">*</span></span>
                </label>
                <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="Contoh: Teknik Dasar Memotong Bawang dengan Aman"
                       class="w-full bg-surface-container-low text-on-surface px-4 py-3 rounded-xl outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all text-sm font-medium"/>
            </div>

            <!-- Category & Skill Level Split -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-primary" for="category">Kategori Rubrik <span class="text-error">*</span></label>
                    <div class="relative">
                        <select id="category" name="category" class="w-full appearance-none bg-surface-container-low text-on-surface px-4 py-3 rounded-xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all cursor-pointer">
                            <option value="knife-skills">Knife Skills (Teknik Pisau Dapur)</option>
                            <option value="baking-hacks">Baking &amp; Patisserie Hacks</option>
                            <option value="kitchen-safety">Kitchen Safety &amp; Ergonomics</option>
                            <option value="prep-storage">Food Prep, Marinade &amp; Storage</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-[20px]">unfold_more</span>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-primary">Tingkat Keahlian</label>
                    <div class="flex items-center gap-2 pt-1">
                        <input type="radio" name="difficulty" id="pemula" value="Pemula" class="peer sr-only" checked>
                        <label for="pemula" class="flex-1 text-center py-2 rounded-full text-xs font-semibold bg-surface-container-low text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Pemula</label>

                        <input type="radio" name="difficulty" id="menengah" value="Menengah" class="peer sr-only">
                        <label for="menengah" class="flex-1 text-center py-2 rounded-full text-xs font-semibold bg-surface-container-low text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Menengah</label>

                        <input type="radio" name="difficulty" id="mahir" value="Mahir" class="peer sr-only">
                        <label for="mahir" class="flex-1 text-center py-2 rounded-full text-xs font-semibold bg-surface-container-low text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Mahir</label>
                    </div>
                </div>
            </div>

            <!-- Short Summary -->
            <div class="flex flex-col gap-1.5 pt-2">
                <label class="text-sm font-bold text-primary" for="summary">Ringkasan Singkat / Lead-in Artikel</label>
                <textarea id="summary" name="summary" rows="3" placeholder="Tuliskan hook pembuka artikel kuliner yang menggugah selera..."
                          class="w-full bg-surface-container-low text-on-surface p-4 rounded-xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all resize-none">{{ old('summary') }}</textarea>
            </div>
        </section>

        <!-- Card B: Featured Image Upload -->
        <section class="bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-sm flex flex-col gap-5">
            <div class="flex items-center gap-3 border-b border-surface-container-high pb-4">
                <span class="p-2 bg-surface-container rounded-full text-primary">
                    <span class="material-symbols-outlined text-[20px]">image</span>
                </span>
                <div>
                    <h2 class="text-lg text-primary font-bold">Foto Sampul &amp; Visual Utama</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Gambar utama dengan resolusi tinggi untuk banner pembuka</p>
                </div>
            </div>

            <div class="relative w-full h-64 rounded-xl bg-surface-container-lowest border-2 border-dashed border-outline-variant hover:border-secondary flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-2 z-0">
                    <span class="material-symbols-outlined text-[36px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                    <span class="text-sm font-bold text-primary">Pilih foto atau seret ke area ini</span>
                    <span class="text-[11px] text-on-surface-variant">Format: WebP, PNG, JPG (Maks. 5MB)</span>
                </div>
            </div>
        </section>
        
                <!-- Card C: Article Content -->
        <section class="bg-surface-container-lowest rounded-2xl shadow-sm flex flex-col overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-surface-container rounded-full text-primary">
                        <span class="material-symbols-outlined text-[20px]">article</span>
                    </span>
                    <div>
                        <h2 class="text-lg text-primary font-bold">Isi Artikel Tips</h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">Gunakan format teks kaya untuk menyusun naskah panduan kuliner</p>
                    </div>
                </div>
            </div>

            <!-- Dummy Toolbar -->
            <div class="p-3 bg-surface-container-high/40 flex flex-wrap items-center gap-2 border-b border-surface-container-high">
                <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center bg-surface-container-lowest text-primary font-bold shadow-sm hover:bg-surface-container"><span class="text-xs">B</span></button>
                <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container"><span class="text-xs italic">I</span></button>
                <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container"><span class="text-xs underline">U</span></button>
                <div class="h-5 w-px bg-outline-variant mx-1"></div>
                <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container"><span class="material-symbols-outlined text-[18px]">format_list_bulleted</span></button>
                <button type="button" class="w-8 h-8 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-surface-container"><span class="material-symbols-outlined text-[18px]">format_quote</span></button>
                <button type="button" class="px-3 h-8 rounded-full flex items-center gap-1 bg-secondary-container text-on-secondary-container text-xs font-bold ml-auto"><span class="material-symbols-outlined text-[16px]">lightbulb</span> Kiat Koki</button>
            </div>

            <!-- Textarea for Content -->
            <textarea name="content" rows="15" required placeholder="Mulai tulis artikel panduan Anda di sini..." 
                      class="w-full p-6 text-sm text-on-surface leading-relaxed outline-none resize-y bg-transparent focus:ring-0 border-0">{{ old('content') }}</textarea>
            
            <div class="px-6 py-3 bg-surface-container-low/40 flex items-center justify-between text-on-surface-variant text-[11px]">
                <span>Format: Rich Editorial Text</span>
                <span class="flex items-center gap-1 text-secondary font-semibold"><span class="material-symbols-outlined text-[14px]">spellcheck</span> Koreksi Bahasa Aktif</span>
            </div>
        </section>

    </form>
</div>

@endsection