@extends('admin.layout')

@section('title', 'Tambah Resep — L\'Art de Cuisine')
@section('breadcrumb', 'Tambah Resep')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- Header --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        <div class="flex items-center gap-2 text-secondary">
            <span class="material-symbols-outlined text-lg">menu_book</span>
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Formulir Kurasi</span>
        </div>
        <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Tambah &amp; Kurasi Resep Baru</h1>
        <p class="text-sm text-on-surface-variant max-w-xl">
            Lengkapi detail sajian, takaran bahan presisi, dan tahapan instruksi memasak haute cuisine.
        </p>
    </header>

    <form id="recipeForm" action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

        {{-- SECTION 1: INFORMASI DASAR --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Judul --}}
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="title">Judul Resep Kuliner <span class="text-error">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           placeholder="Contoh: Bebek Betutu Gilimanuk Warisan Puri"
                           class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                </div>
                {{-- Kategori --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="category_id">Kategori Kuliner <span class="text-error">*</span></label>
                    <div class="relative">
                        <select id="category_id" name="category_id" required class="w-full appearance-none px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all pr-10 cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-3.5 text-outline pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-2">
                <label class="text-xs font-bold text-primary" for="description">Deskripsi Resep &amp; Filosofi Rasa</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Ceritakan latar belakang kuliner, profil aroma rempah, dan tekstur istimewa yang diharapkan..."
                          class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none placeholder:text-outline">{{ old('description') }}</textarea>
            </div>

            {{-- Porsi, Waktu, Kesulitan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="servings">Jumlah Porsi</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-[18px] text-outline">restaurant</span>
                        <input type="number" id="servings" name="servings" value="{{ old('servings', 1) }}" min="1" required
                               class="w-full pl-11 pr-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="duration_minutes">Estimasi Total Waktu (Menit)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-[18px] text-outline">schedule</span>
                        <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" required
                               class="w-full pl-11 pr-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary">Tingkat Kesulitan</label>
                    <div class="flex items-center gap-2 bg-surface-container-low p-1.5 rounded-2xl shadow-sm h-[46px]">
                        @foreach(['Mudah', 'Sedang', 'Sulit'] as $diff)
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="difficulty" value="{{ $diff }}" class="peer sr-only" @checked(old('difficulty', 'Mudah') == $diff)>
                                <div class="py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                    {{ $diff }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="flex flex-col gap-2 pt-2">
                <label class="text-xs font-bold text-primary">Foto Hasil Masakan</label>
                <div class="relative w-full h-32 rounded-2xl border-2 border-dashed border-outline-variant hover:border-secondary bg-surface-container-lowest flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                    <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                    <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                    <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-1 z-0">
                        <span class="material-symbols-outlined text-[28px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                        <span class="text-sm font-bold text-primary">Pilih foto atau seret ke area ini</span>
                        <span class="text-[11px] text-on-surface-variant">Format: JPG, PNG, WEBP (Maks. 5MB)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: BAHAN & TAKARAN (Dinamis) --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-surface-container-high pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[18px]">grocery</span>
                    </div>
                    <div>
                        <h2 class="font-display text-xl text-primary font-bold">Daftar Bahan &amp; Takaran</h2>
                        <p class="text-sm text-on-surface-variant">Tentukan komposisi bahan pokok, rempah, dan bumbu.</p>
                    </div>
                </div>
                <button type="button" onclick="addIngredient()" class="px-4 py-2 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold hover:bg-secondary/20 transition">
                    + Tambah Bahan
                </button>
            </div>

            <div id="ingredients-container" class="flex flex-col gap-3">
                {{-- Baris Bahan 1 --}}
                <div class="ingredient-row grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                    <div class="md:col-span-6">
                        <input type="text" name="ingredients[0][name]" placeholder="Nama bahan (contoh: Daging Sapi)" required
                               class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                    </div>
                    <div class="md:col-span-3">
                        <input type="number" step="any" name="ingredients[0][amount]" placeholder="Takaran (ex: 500)" required
                               class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                    </div>
                    <div class="md:col-span-2">
                        <select name="ingredients[0][unit]" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none appearance-none">
                            <option value="gram">gram (gr)</option>
                            <option value="ml">mililiter (ml)</option>
                            <option value="sdm">sendok makan (sdm)</option>
                            <option value="sdt">sendok teh (sdt)</option>
                            <option value="siung">siung</option>
                            <option value="batang">batang</option>
                            <option value="butir">butir</option>
                        </select>
                    </div>
                    <div class="md:col-span-1 flex justify-end">
                        <button type="button" onclick="removeRow(this)" class="w-9 h-9 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition">
                            <span class="material-symbols-outlined text-[18px]">remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: LANGKAH MEMASAK (Dinamis) --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-surface-container-high pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[18px]">skillet</span>
                    </div>
                    <div>
                        <h2 class="font-display text-xl text-primary font-bold">Tahapan &amp; Panduan Memasak</h2>
                        <p class="text-sm text-on-surface-variant">Uraikan langkah memasak berurutan dengan durasi timer praktis.</p>
                    </div>
                </div>
                <button type="button" onclick="addStep()" class="px-4 py-2 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold hover:bg-secondary/20 transition">
                    + Tambah Tahapan
                </button>
            </div>

            <div id="steps-container" class="flex flex-col gap-4">
                {{-- Langkah 1 --}}
                <div class="step-row relative bg-surface-container-low p-5 rounded-2xl flex flex-col md:flex-row gap-4 items-start">
                    <div class="flex flex-col items-center gap-1 w-10 shrink-0 pt-1">
                        <span class="step-number w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">1</span>
                    </div>
                    <div class="flex-1 flex flex-col sm:flex-row gap-3">
                        <textarea name="steps[0][instruction]" placeholder="Tuliskan instruksi detail langkah ini..." rows="2" required
                                  class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none resize-none"></textarea>
                        <div class="w-full sm:w-32 shrink-0">
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-2.5 text-[16px] text-outline">timer</span>
                                <input type="number" name="steps[0][duration_minutes]" placeholder="Menit" min="0"
                                       class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="removeRow(this)" class="absolute top-4 right-4 md:static w-8 h-8 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition shrink-0">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between pt-4">
            <button type="button" onclick="history.back()" class="text-sm font-bold text-on-surface-variant hover:text-primary transition">
                Kembali
            </button>
            <div class="flex items-center gap-3">
                <button type="submit" name="status" value="draft" class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
                    Simpan sebagai Draft
                </button>
                <button type="submit" name="status" value="published" class="px-6 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    Publikasikan Resep
                </button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    let ingredientIndex = 1;
    let stepIndex = 1;

    // --- FUNGSI TAMBAH BAHAN ---
    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        const newRow = document.createElement('div');
        newRow.className = 'ingredient-row grid grid-cols-1 md:grid-cols-12 gap-3 items-center';
        newRow.innerHTML = `
            <div class="md:col-span-6">
                <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="Nama bahan" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
            </div>
            <div class="md:col-span-3">
                <input type="number" step="any" name="ingredients[${ingredientIndex}][amount]" placeholder="Takaran" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
            </div>
            <div class="md:col-span-2">
                <select name="ingredients[${ingredientIndex}][unit]" class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none appearance-none">
                    <option value="gram">gram (gr)</option>
                    <option value="ml">mililiter (ml)</option>
                    <option value="sdm">sendok makan (sdm)</option>
                    <option value="sdt">sendok teh (sdt)</option>
                    <option value="siung">siung</option>
                    <option value="batang">batang</option>
                    <option value="butir">butir</option>
                </select>
            </div>
            <div class="md:col-span-1 flex justify-end">
                <button type="button" onclick="removeRow(this)" class="w-9 h-9 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        ingredientIndex++;
    }

    // --- FUNGSI TAMBAH LANGKAH ---
    function addStep() {
        const container = document.getElementById('steps-container');
        const newRow = document.createElement('div');
        newRow.className = 'step-row relative bg-surface-container-low p-5 rounded-2xl flex flex-col md:flex-row gap-4 items-start';
        newRow.innerHTML = `
            <div class="flex flex-col items-center gap-1 w-10 shrink-0 pt-1">
                <span class="step-number w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">?</span>
            </div>
            <div class="flex-1 flex flex-col sm:flex-row gap-3">
                <textarea name="steps[${stepIndex}][instruction]" placeholder="Tuliskan instruksi detail langkah ini..." rows="2" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none resize-none"></textarea>
                <div class="w-full sm:w-32 shrink-0">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-[16px] text-outline">timer</span>
                        <input type="number" name="steps[${stepIndex}][duration_minutes]" placeholder="Menit" min="0" class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                    </div>
                </div>
            </div>
            <button type="button" onclick="removeRow(this)" class="absolute top-4 right-4 md:static w-8 h-8 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition shrink-0">
                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>
        `;
        container.appendChild(newRow);
        stepIndex++;
        updateStepNumbers();
    }

    // --- FUNGSI HAPUS BARIS (Bahan / Langkah) ---
    function removeRow(button) {
        const row = button.closest('.ingredient-row') || button.closest('.step-row');
        if (row) {
            row.remove();
            updateStepNumbers();
        }
    }

    // --- UPDATE NOMOR LANGKAH OTOMATIS ---
    function updateStepNumbers() {
        const steps = document.querySelectorAll('#steps-container .step-number');
        steps.forEach((el, index) => {
            el.innerText = index + 1;
        });
    }

    // --- PREVIEW GAMBAR ---
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