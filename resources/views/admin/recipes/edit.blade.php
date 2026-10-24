@extends('admin.layout')

@section('title', 'Edit Resep — L\'Art de Cuisine')
@section('breadcrumb', 'Edit Resep')

@section('content')

<div class="max-w-5xl mx-auto pb-12 pt-6">
    
    {{-- Header --}}
    <header class="flex flex-col gap-1 mb-6">
        <div class="flex items-center gap-2 text-secondary mb-1">
            <span class="material-symbols-outlined text-lg">menu_book</span>
            <span class="text-[10px] uppercase tracking-widest font-bold">Portal Kuliner Gastronomi</span>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[28px] text-primary">edit_document</span>
                <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">Edit Resep: {{ $recipe->title }}</h1>
            </div>
        </div>
        <p class="text-sm text-on-surface-variant mt-1">Perbarui detail sajian, takaran bahan, dan tahapan instruksi memasak.</p>
    </header>

    <form method="POST" action="{{ route('admin.recipes.update', $recipe->id) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-error-container text-on-error-container text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        {{-- CARD UTAMA --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-8">

            {{-- 1. INFORMASI DASAR --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2 pb-2 border-b border-surface-container-high">
                    <span class="material-symbols-outlined text-primary text-[20px]">info</span>
                    <h2 class="text-lg font-bold text-primary">Informasi Dasar Hidangan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2 flex flex-col gap-1.5">
                        <label for="title" class="text-xs font-bold text-primary">Judul Resep Kuliner <span class="text-error">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $recipe->title) }}" required
                               class="w-full bg-surface-container-low px-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="category_id" class="text-xs font-bold text-primary">Kategori Kuliner <span class="text-error">*</span></label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required
                                    class="w-full appearance-none bg-surface-container-low px-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer pr-10">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $recipe->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline text-[18px]">expand_more</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="description" class="text-xs font-bold text-primary">Deskripsi Resep & Filosofi Rasa</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full bg-surface-container-low p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 resize-none">{{ old('description', $recipe->description) }}</textarea>
                </div>
            </div>
            
        </div>
    </form>
</div>

            {{-- 2. DETAIL MASAK & FOTO --}}
            <div class="flex flex-col gap-4">
                {{-- Porsi, Waktu, Kesulitan --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-2">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Jumlah Porsi Saji</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">room_service</span>
                            <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}" min="1" required
                                   class="w-full bg-surface-container-low pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Estimasi Total Waktu (Menit)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">schedule</span>
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $recipe->duration_minutes) }}" min="1" required
                                   class="w-full bg-surface-container-low pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Tingkat Kesulitan</label>
                        <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-xl">
                            @foreach(['Mudah', 'Sedang', 'Sulit'] as $diff)
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="difficulty" value="{{ $diff }}" class="peer sr-only" {{ old('difficulty', $recipe->difficulty) == $diff ? 'checked' : '' }}>
                                    <div class="py-2 rounded-lg text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                        {{ $diff }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="flex flex-col gap-1.5 pt-2">
                    <label class="text-xs font-bold text-primary">Foto Hasil Masakan (Biarkan kosong jika tidak diubah)</label>
                    <div class="relative w-full h-32 rounded-xl bg-surface-container-lowest border border-dashed border-outline-variant flex items-center justify-between px-6 cursor-pointer overflow-hidden group">
                        <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                        
                        {{-- Tampilkan gambar lama jika ada --}}
                        <img id="imagePreview" class="{{ $recipe->image ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10" src="{{ $recipe->image ? asset('storage/'.$recipe->image) : '' }}"/>
                        
                        <div id="imagePlaceholder" class="{{ $recipe->image ? 'hidden' : '' }} flex items-center gap-4 z-0">
                            <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[24px]">add_photo_alternate</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-primary">Klik untuk ganti foto</span>
                                <span class="text-[11px] text-on-surface-variant">Format: JPG, PNG, WebP (Maks. 5MB)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection