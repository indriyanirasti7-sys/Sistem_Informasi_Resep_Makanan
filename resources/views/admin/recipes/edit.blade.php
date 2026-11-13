@extends('admin.layout')

@section('title', 'Edit Resep — Griya Rasa')
@section('breadcrumb', 'Edit Resep')

@section('content')

<div class="w-full mx-auto pb-12 pt-6">
    
    {{-- Header --}}
    <header class="flex flex-col gap-1 mb-6">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.recipes.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-2 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Resep
        </a>

        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[28px] text-primary">edit_document</span>
                <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">Edit Resep: {{ $recipe->title }}</h1>
            </div>
        </div>
        <p class="text-sm text-on-surface-variant mt-1">Perbarui detail sajian, takaran bahan, dan tahapan instruksi memasak.</p>
    </header>

    <form method="POST" action="{{ route('admin.recipes.update', $recipe->slug) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-error-container text-on-error-container text-sm shadow-sm">
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
                               class="w-full bg-surface-container-low px-4 py-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="category_id" class="text-xs font-bold text-primary">Kategori Kuliner <span class="text-error">*</span></label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required
                                    class="w-full appearance-none bg-surface-container-low px-4 py-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer pr-10">
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
            
            {{-- 2. DETAIL MASAK & FOTO --}}
            <div class="flex flex-col gap-4">
                {{-- Grid 4 Kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 pt-2">
                    {{-- Porsi --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Jumlah Porsi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">room_service</span>
                            <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}" min="1" required
                                   class="w-full bg-surface-container-low pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                    {{-- Waktu --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Total Waktu (Menit)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">schedule</span>
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $recipe->duration_minutes) }}" min="1" required
                                   class="w-full bg-surface-container-low pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                    {{-- KALORI --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Kalori (kkal)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">local_fire_department</span>
                            <input type="number" name="calories" value="{{ old('calories', $recipe->calories) }}" min="0"
                                   class="w-full bg-surface-container-low pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                    {{-- Kesulitan --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-primary">Tingkat Kesulitan</label>
                        <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-xl h-[42px]">
                            @foreach(['Mudah', 'Sedang', 'Sulit'] as $diff)
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="difficulty" value="{{ $diff }}" class="peer sr-only" {{ old('difficulty', $recipe->difficulty) == $diff ? 'checked' : '' }}>
                                    <div class="py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                        {{ $diff }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- STATUS PUBLIKASI --}}
                <div class="flex flex-col gap-1.5 pt-2">
                    <label class="text-xs font-bold text-primary">Status Publikasi <span class="text-error">*</span></label>
                    <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-xl w-full md:w-1/3">
                        @foreach(['draft' => 'Draft', 'published' => 'Published'] as $val => $label)
                            <label class="flex-1 text-center cursor-pointer">
                                <input type="radio" name="status" value="{{ $val }}" class="peer sr-only" {{ old('status', $recipe->status) == $val ? 'checked' : '' }} required>
                                <div class="py-2 rounded-lg text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="flex flex-col gap-1.5 pt-2">
                    <label class="text-xs font-bold text-primary">Foto Hasil Masakan (Biarkan kosong jika tidak diubah)</label>
                    
                    <div class="relative w-full h-48 rounded-xl bg-surface-container-lowest border border-dashed border-outline-variant flex items-center justify-between px-6 cursor-pointer overflow-hidden group">
                        {{-- Input File --}}
                        <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-30" onchange="previewImage(event)">
                        
                        {{-- Gambar Lama / Placeholder --}}
                        @if($recipe->image)
                            <img id="imagePreview" src="{{ asset('storage/'.$recipe->image) }}" class="absolute inset-0 w-full h-full object-cover z-10"/>
                            <div id="imagePlaceholder" class="hidden items-center gap-4 z-0">
                        @else
                            <img id="imagePreview" src="" class="hidden absolute inset-0 w-full h-full object-cover z-10"/>
                            <div id="imagePlaceholder" class="flex items-center gap-4 z-0">
                        @endif
                        
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

            {{-- 3. DAFTAR BAHAN --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">grocery</span>
                        <h2 class="text-lg font-bold text-primary">Daftar Bahan & Takaran Presisi</h2>
                    </div>
                    <button type="button" onclick="addIngredientRow()" class="px-4 py-1.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold hover:bg-secondary/20 transition flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add</span> Tambah Baris Bahan
                    </button>
                </div>
                
                <div class="flex flex-col gap-2" id="ingredients-container">
                    @foreach($recipe->recipeIngredients as $index => $ri)
                        <div class="ingredient-row flex gap-3 items-center">
                            <div class="flex-1">
                                <input type="text" name="ingredients[{{ $index }}][name]" value="{{ $ri->ingredient->name ?? '' }}" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
                            </div>
                            <div class="w-12 shrink-0">
                                <button type="button" onclick="this.closest('.ingredient-row').remove()" class="w-10 h-10 rounded-full bg-error-container/60 text-error hover:bg-error hover:text-white flex items-center justify-center transition">
                                    <span class="material-symbols-outlined text-[18px]">remove</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 4. LANGKAH MEMASAK --}}
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">skillet</span>
                        <h2 class="text-lg font-bold text-primary">Tahapan & Panduan Memasak Naratif</h2>
                    </div>
                    <button type="button" onclick="addStepRow()" class="px-4 py-1.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold hover:bg-secondary/20 transition flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add</span> Tambah Tahapan
                    </button>
                </div>

                <div class="flex flex-col gap-3" id="steps-container">
                    @foreach($recipe->steps as $index => $step)
                        <div class="step-card bg-surface-container-low/40 rounded-xl p-4 flex flex-col gap-3 relative">
                            <div class="flex items-center gap-2 w-fit bg-surface-container-high px-3 py-1 rounded-md">
                                <span class="step-label text-[11px] font-bold text-primary">Langkah {{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 flex flex-col gap-3">
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <textarea name="steps[{{ $index }}][instruction]" rows="2" required class="w-full flex-1 bg-surface-container-lowest p-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 resize-none">{{ $step->instruction }}</textarea>
                                    <div class="w-full md:w-32 shrink-0">
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-outline text-[16px]">timer</span>
                                            <input type="number" name="steps[{{ $index }}][duration_minutes]" value="{{ $step->duration_minutes }}" placeholder="Timer (Menit)" min="0" class="w-full bg-surface-container-lowest pl-8 pr-3 py-2 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- UPLOAD GAMBAR STEP (EDIT) --}}
                                <div class="flex items-center gap-3">
                                    <input type="file" name="steps[{{ $index }}][image]" accept="image/*" onchange="previewStepImage(event, 'preview-edit-{{ $index }}')" class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-secondary-container file:text-on-secondary-container hover:file:bg-secondary/20 transition-all cursor-pointer"/>
                                    <img id="preview-edit-{{ $index }}" src="{{ $step->image ? asset('storage/'.$step->image) : '' }}" class="w-10 h-10 rounded-lg object-cover {{ $step->image ? '' : 'hidden' }} shadow-sm">
                                </div>
                            </div>
                            <button type="button" onclick="this.closest('.step-card').remove(); updateStepNumbers();" class="absolute top-4 right-4 text-error hover:bg-error-container p-1.5 rounded-full transition">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

        </div> {{-- Penutup CARD UTAMA --}}

        {{-- FOOTER ACTIONS --}}
        <div class="flex items-center justify-end pt-2">
            <div class="flex items-center gap-3">
                <button type="submit" class="px-8 py-2.5 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Perbarui Resep
                </button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    // Mulai index dari jumlah data yang sudah ada agar tidak bentrok
    let ingredientIdx = {{ count($recipe->recipeIngredients) }};
    let stepIdx = {{ count($recipe->steps) }};

    // JS TAMBAH BAHAN (Disesuaikan dengan HTML 1 kolom)
    function addIngredientRow() {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.className = 'ingredient-row flex gap-3 items-center';
        row.innerHTML = `
            <div class="flex-1">
                <input type="text" name="ingredients[\${ingredientIdx}][name]" placeholder="Contoh: Garam 1 sdt, atau Daging Sapi 500 gram" required class="w-full px-4 py-2.5 rounded-xl bg-surface-container-low text-sm focus:ring-2 focus:ring-secondary/40 outline-none"/>
            </div>
            <div class="w-12 shrink-0">
                <button type="button" onclick="this.closest('.ingredient-row').remove()" class="w-10 h-10 rounded-full bg-error-container/50 text-error hover:bg-error-container flex items-center justify-center transition">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
            </div>
        `;
        container.appendChild(row);
        ingredientIdx++;
    }

    // JS TAMBAH LANGKAH (Ditambahkan Upload Gambar)
    function addStepRow() {
        const container = document.getElementById('steps-container');
        const num = stepIdx + 1;
        const row = document.createElement('div');
        row.className = 'step-card bg-surface-container-low/40 rounded-xl p-4 flex flex-col gap-3 relative';
        row.innerHTML = `
            <div class="flex items-center gap-2 w-fit bg-surface-container-high px-3 py-1 rounded-md">
                <span class="step-label text-[11px] font-bold text-primary">Langkah \${num}</span>
            </div>
            <div class="flex-1 flex flex-col gap-3">
                <div class="flex flex-col md:flex-row gap-3 items-start">
                    <textarea name="steps[\${stepIdx}][instruction]" rows="2" required placeholder="Tuliskan instruksi detail langkah ini..." class="w-full flex-1 bg-surface-container-lowest p-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 resize-none"></textarea>
                    <div class="w-full md:w-32 shrink-0">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-outline text-[16px]">timer</span>
                            <input type="number" name="steps[\${stepIdx}][duration_minutes]" placeholder="Timer (Menit)" min="0" class="w-full bg-surface-container-lowest pl-8 pr-3 py-2 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
                        </div>
                    </div>
                </div>
                
                {{-- Upload Gambar Step Baru --}}
                <div class="flex items-center gap-3">
                    <input type="file" name="steps[\${stepIdx}][image]" accept="image/*" onchange="previewStepImage(event, 'preview-new-\${stepIdx}')" class="block w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-secondary-container file:text-on-secondary-container hover:file:bg-secondary/20 transition-all cursor-pointer"/>
                    <img id="preview-new-\${stepIdx}" class="w-10 h-10 rounded-lg object-cover hidden shadow-sm">
                </div>
            </div>
            <button type="button" onclick="this.closest('.step-card').remove(); updateStepNumbers();" class="absolute top-4 right-4 text-error hover:bg-error-container p-1.5 rounded-full transition">
                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>
        `;
        container.appendChild(row);
        stepIdx++;
        updateStepNumbers();
    }

    function updateStepNumbers() {
        const steps = document.querySelectorAll('#steps-container .step-label');
        steps.forEach((el, index) => { el.innerText = 'Langkah ' + (index + 1); });
    }

    // Preview Foto Utama
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

    // Preview Foto Langkah (BARU)
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