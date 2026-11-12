@extends('admin.layout')

@section('title', 'Tambah Resep — Jelajah Rasa')
@section('breadcrumb', 'Tambah Resep')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- Header --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        <a href="{{ route('admin.recipes.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Resep
        </a>

        <div class="flex flex-col gap-1.5">
            <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Tambah & Kurasi Resep Baru</h1>
            <p class="text-sm text-on-surface-variant max-w-xl">
                Buat resep kuliner baru dengan detail bahan, takaran, langkah memasak, dan foto hasil masakan untuk ditampilkan.
            </p>
        </div>
    </header>

    <form id="recipeForm" action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

        {{-- ========== PESAN ERROR VALIDASI ========== --}}
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
        {{-- ============================================ --}}

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

            {{-- Porsi, Waktu, Kalori, Kesulitan (Grid 4 Kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2">
                {{-- Porsi --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="servings">Jumlah Porsi <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-[18px] text-outline">restaurant</span>
                        <input type="number" id="servings" name="servings" value="{{ old('servings', 1) }}" min="1" required
                               class="w-full pl-11 pr-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>
                </div>
                
                {{-- Waktu --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="duration_minutes">Total Waktu (Menit) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-[18px] text-outline">schedule</span>
                        <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" required
                               class="w-full pl-11 pr-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>
                </div>

                {{-- KALORI --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary" for="calories">Kalori (kkal)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-3 text-[18px] text-outline">local_fire_department</span>
                        <input type="number" id="calories" name="calories" value="{{ old('calories') }}" min="0"
                               class="w-full pl-11 pr-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all" placeholder="Contoh: 250"/>
                    </div>
                </div>

                {{-- Kesulitan --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-primary">Tingkat Kesulitan <span class="text-error">*</span></label>
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
                <label class="text-xs font-bold text-primary">Foto Hasil Masakan (Maks. 5MB)</label>
                <div class="relative w-full h-32 rounded-2xl border-2 border-dashed border-outline-variant hover:border-secondary bg-surface-container-lowest flex flex-col items-center justify-center cursor-pointer transition-colors overflow-hidden group">
                    <input type="file" id="image" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                    <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                    <div id="imagePlaceholder" class="flex flex-col items-center justify-center gap-1 z-0">
                        <span class="material-symbols-outlined text-[28px] text-primary group-hover:scale-110 transition-transform">add_photo_alternate</span>
                        <span class="text-sm font-bold text-primary">Pilih foto atau seret ke area ini</span>
                        <span class="text-[11px] text-on-surface-variant">Format: JPG, PNG, WEBP</span>
                    </div>
                </div>
                @error('image')
                    <span class="text-xs text-error font-semibold">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- SECTION 2: BAHAN & TAKARAN --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-surface-container-high pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[18px]">grocery</span>
                    </div>
                    <div>
                        <h2 class="font-display text-xl text-primary font-bold">Daftar Bahan &amp; Takaran <span class="text-error">*</span></h2>
                        <p class="text-sm text-on-surface-variant">Tentukan komposisi bahan pokok, rempah, dan bumbu.</p>
                    </div>
                </div>
                <button type="button" onclick="addIngredient()" class="px-4 py-2 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold hover:bg-secondary/20 transition">
                    + Tambah Bahan
                </button>
            </div>

            <div id="ingredients-container" class="flex flex-col gap-3">
                @php
                    $oldIngredients = old('ingredients', [['name' => '']]);
                @endphp
                @foreach($oldIngredients as $index => $ing)
                    <div class="ingredient-row flex gap-3 items-center">
                        <div class="flex-1">
                            <input type="text" name="ingredients[{{ $index }}][name]" value="{{ $ing['name'] ?? '' }}" placeholder="Contoh: Garam 1 sdt, atau Daging Sapi 500 gram" required
                                   class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                        </div>
                        <div class="w-12 shrink-0">
                            <button type="button" onclick="removeRow(this)" class="w-10 h-10 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition">
                                <span class="material-symbols-outlined text-[18px]">remove</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SECTION 3: LANGKAH MEMASAK --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between border-b border-surface-container-high pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[18px]">skillet</span>
                    </div>
                    <div>
                        <h2 class="font-display text-xl text-primary font-bold">Tahapan &amp; Panduan Memasak <span class="text-error">*</span></h2>
                        <p class="text-sm text-on-surface-variant">Uraikan langkah memasak berurutan dengan durasi timer praktis.</p>
                    </div>
                </div>
                <button type="button" onclick="addStep()" class="px-4 py-2 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold hover:bg-secondary/20 transition">
                    + Tambah Tahapan
                </button>
            </div>

            <div id="steps-container" class="flex flex-col gap-4">
                @php
                    $oldSteps = old('steps', [['instruction' => '', 'duration_minutes' => '']]);
                @endphp
                @foreach($oldSteps as $index => $step)
                    <div class="step-row relative bg-surface-container-low p-5 rounded-2xl flex flex-col md:flex-row gap-4 items-start">
                        <div class="flex flex-col items-center gap-1 w-10 shrink-0 pt-1">
                            <span class="step-number w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-1 flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <textarea name="steps[{{ $index }}][instruction]" placeholder="Tuliskan instruksi detail langkah ini..." rows="2" required
                                          class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none resize-none">{{ $step['instruction'] ?? '' }}</textarea>
                                <div class="w-full sm:w-32 shrink-0">
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-[16px] text-outline">timer</span>
                                        <input type="number" name="steps[{{ $index }}][duration_minutes]" value="{{ $step['duration_minutes'] ?? '' }}" placeholder="Menit" min="1"
                                               class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- UPLOAD GAMBAR STEP --}}
                            <div class="flex items-center gap-3">
                                <input type="file" name="steps[{{ $index }}][image]" accept="image/*" onchange="previewStepImage(event, 'preview-{{ $index }}')" class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-secondary-container file:text-on-secondary-container hover:file:bg-secondary/20 transition-all cursor-pointer"/>
                                <img id="preview-{{ $index }}" class="w-10 h-10 rounded-lg object-cover hidden shadow-sm">
                            </div>
                        </div>
                        <button type="button" onclick="removeRow(this)" class="absolute top-4 right-4 md:static w-8 h-8 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition shrink-0">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between pt-4 border-t border-surface-container-high mt-2">
            <button type="submit" name="status" value="draft" class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
                Simpan sebagai Draft
            </button>

            <div class="flex items-center gap-3">
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
    // Inisialisasi index berdasarkan jumlah data yang sudah ada di layar (jika error)
    let ingredientIndex = {{ count($oldIngredients) }};
    let stepIndex = {{ count($oldSteps) }};

    // FUNGSI TAMBAH BAHAN (Sudah disesuaikan jadi 1 kolom)
    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        const newRow = document.createElement('div');
        newRow.className = 'ingredient-row flex gap-3 items-center';
        newRow.innerHTML = `
            <div class="flex-1">
                <input type="text" name="ingredients[\${ingredientIndex}][name]" placeholder="Contoh: Garam 1 sdt, atau Daging Sapi 500 gram" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
            </div>
            <div class="w-12 shrink-0">
                <button type="button" onclick="removeRow(this)" class="w-10 h-10 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        ingredientIndex++;
    }

    // FUNGSI TAMBAH LANGKAH (Sudah ditambahkan upload gambar)
    function addStep() {
        const container = document.getElementById('steps-container');
        const newRow = document.createElement('div');
        newRow.className = 'step-row relative bg-surface-container-low p-5 rounded-2xl flex flex-col md:flex-row gap-4 items-start';
        newRow.innerHTML = `
            <div class="flex flex-col items-center gap-1 w-10 shrink-0 pt-1">
                <span class="step-number w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">?</span>
            </div>
            <div class="flex-1 flex flex-col gap-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <textarea name="steps[\${stepIndex}][instruction]" placeholder="Tuliskan instruksi detail langkah ini..." rows="2" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none resize-none"></textarea>
                    <div class="w-full sm:w-32 shrink-0">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[16px] text-outline">timer</span>
                            <input type="number" name="steps[\${stepIndex}][duration_minutes]" placeholder="Menit" min="1" class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-surface-container-lowest text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                        </div>
                    </div>
                </div>
                
                {{-- Upload Gambar Step --}}
                <div class="flex items-center gap-3">
                    <input type="file" name="steps[\${stepIndex}][image]" accept="image/*" onchange="previewStepImage(event, 'preview-new-\${stepIndex}')" class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-secondary-container file:text-on-secondary-container hover:file:bg-secondary/20 transition-all cursor-pointer"/>
                    <img id="preview-new-\${stepIndex}" class="w-10 h-10 rounded-lg object-cover hidden shadow-sm">
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

    function removeRow(button) {
        const row = button.closest('.ingredient-row') || button.closest('.step-row');
        if (row) {
            row.remove();
            updateStepNumbers();
        }
    }

    function updateStepNumbers() {
        const steps = document.querySelectorAll('#steps-container .step-number');
        steps.forEach((el, index) => {
            el.innerText = index + 1;
        });
    }

    // FUNGSI PREVIEW GAMBAR UTAMA
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

    // FUNGSI PREVIEW GAMBAR LANGKAH (BARU)
    function previewStepImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush