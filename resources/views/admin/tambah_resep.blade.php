@extends('admin.layout')

@section('title', 'Tambah Resep Baru — Admin L\'Art de Cuisine')
@section('breadcrumb', 'Tambah Resep Baru')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-4 mb-8 pt-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <nav class="flex items-center gap-1.5 text-xs text-on-surface-variant font-medium">
            <span class="hover:text-primary cursor-pointer">Portal Admin</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a href="{{ route('admin.recipes.index') }}" class="hover:text-primary cursor-pointer">Kelola Resep</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Tambah Resep Baru</span>
        </nav>

        <div class="flex items-center gap-2 bg-secondary-container/60 text-on-secondary-container px-4 py-1.5 rounded-full text-[11px] font-bold shadow-sm">
            <span class="material-symbols-outlined text-[16px] text-secondary">check_circle</span>
            <span>Draf Tersimpan Otomatis</span>
        </div>
    </div>

    <div>
        <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Tambah Resep Baru</h1>
        <p class="text-sm text-on-surface-variant max-w-3xl mt-1">
            Lengkapi formulir kurasi gastronomi dengan takaran presisi dan panduan naratif khas L'Art de Cuisine.
        </p>
    </div>
</header>

{{-- ========== FORM ========== --}}
<form method="POST" action="{{ route('admin.recipes.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6 pb-24">
    @csrf

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-error-container text-on-error-container text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- ========== KARTU 1: INFORMASI DASAR ========== --}}
    <section class="bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex items-center gap-3 pb-2">
            <span class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-base font-bold shadow-sm">1</span>
            <div>
                <h2 class="font-['Playfair_Display'] text-xl text-primary font-bold">Informasi Dasar Resep</h2>
                <p class="text-xs text-on-surface-variant">Identitas utama hidangan, klasifikasi menu kurasi, dan estetika fotografi saji.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Left: Text Inputs --}}
            <div class="lg:col-span-7 flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label for="title" class="text-sm font-bold text-primary">
                        Judul Resep <span class="text-error">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           placeholder="contoh: Rendang Daging Sapi Karamel Khas Minang"
                           class="w-full bg-surface-container-low text-on-surface placeholder:text-outline px-4 py-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 transition"/>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="category_id" class="text-sm font-bold text-primary">
                        Kategori Resep <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" name="category_id" required
                                class="w-full appearance-none bg-surface-container-low text-on-surface px-4 py-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer pr-10">
                            <option value="">— Pilih Kategori —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="description" class="text-sm font-bold text-primary">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Tuliskan pengantar menggugah selera, sejarah budaya hidangan, atau profil aroma khas rempah..."
                              class="w-full bg-surface-container-low text-on-surface placeholder:text-outline p-4 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40 resize-y">{{ old('description') }}</textarea>
                </div>
            </div>

            {{-- Right: Photo Upload --}}
            <div class="lg:col-span-5 flex flex-col gap-1.5">
                <label class="text-sm font-bold text-primary">Foto Utama</label>
                <div class="min-h-[260px] bg-surface-container-low/80 rounded-2xl p-4 flex flex-col justify-center items-center text-center border-2 border-dashed border-outline-variant">
                    <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-primary mb-3">
                        <span class="material-symbols-outlined text-[32px]">add_photo_alternate</span>
                    </div>
                    <label class="cursor-pointer">
                        <span class="px-5 py-2 rounded-full bg-primary text-white text-xs font-bold inline-block">
                            Pilih Foto
                        </span>
                        <input type="file" name="image" accept="image/*" class="hidden">
                    </label>
                    <p class="text-[11px] text-on-surface-variant mt-3">
                        Maks 5MB (JPG, PNG, WebP)<br>Rasio 16:9 disarankan
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== KARTU 2: DETAIL MASAK ========== --}}
    <section class="bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex items-center gap-3 pb-2">
            <span class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-base font-bold shadow-sm">2</span>
            <div>
                <h2 class="font-['Playfair_Display'] text-xl text-primary font-bold">Detail & Karakteristik</h2>
                <p class="text-xs text-on-surface-variant">Parameter teknis porsi, estimasi durasi dapur, kalori, dan tingkat kesulitan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Porsi --}}
            <div class="bg-surface-container-low/70 rounded-xl p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-secondary text-sm font-semibold">
                    <span class="material-symbols-outlined text-[20px]">room_service</span>
                    <span>Porsi Saji</span>
                </div>
                <input type="number" name="servings" value="{{ old('servings', 4) }}" min="1" max="50" required
                       class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-base text-center outline-none focus:ring-2 focus:ring-secondary/40"/>
            </div>

            {{-- Durasi --}}
            <div class="bg-surface-container-low/70 rounded-xl p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-secondary text-sm font-semibold">
                    <span class="material-symbols-outlined text-[20px]">hourglass_bottom</span>
                    <span>Durasi (Menit)</span>
                </div>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="1"
                       class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-base text-center outline-none focus:ring-2 focus:ring-secondary/40"/>
            </div>

            {{-- Kesulitan --}}
            <div class="bg-surface-container-low/70 rounded-xl p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-secondary text-sm font-semibold">
                    <span class="material-symbols-outlined text-[20px]">psychology</span>
                    <span>Kesulitan</span>
                </div>
                <select name="difficulty" required
                        class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-base text-center outline-none focus:ring-2 focus:ring-secondary/40 cursor-pointer">
                    <option value="Mudah" {{ old('difficulty') === 'Mudah' ? 'selected' : '' }}>Mudah</option>
                    <option value="Sedang" {{ old('difficulty') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Sulit" {{ old('difficulty') == 'Sulit' ? 'selected' : '' }}>Sulit</option>
                </select>
            </div>

            {{-- Kalori --}}
            <div class="bg-surface-container-low/70 rounded-xl p-4 flex flex-col gap-2">
                <div class="flex items-center gap-2 text-secondary text-sm font-semibold">
                    <span class="material-symbols-outlined text-[20px]">local_fire_department</span>
                    <span>Kalori</span>
                </div>
                <input type="number" name="calories" value="{{ old('calories', 400) }}" min="1"
                       class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-base text-center outline-none focus:ring-2 focus:ring-secondary/40"/>
            </div>
        </div>
    </section>

    {{-- ========== KARTU 3: BAHAN ========== --}}
    <section class="bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-base font-bold shadow-sm">3</span>
                <div>
                    <h2 class="font-['Playfair_Display'] text-xl text-primary font-bold">Bahan & Takaran</h2>
                    <p class="text-xs text-on-surface-variant">Pilih bahan dari database + tentukan jumlah.</p>
                </div>
            </div>
            <button type="button" onclick="addIngredientRow()"
                    class="self-start sm:self-auto flex items-center gap-2 px-4 py-2 rounded-full bg-secondary text-white text-xs font-bold hover:opacity-90 transition">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Baris
            </button>
        </div>

        <div class="flex flex-col gap-3" id="ingredients-container"></div>
    </section>

    {{-- ========== KARTU 4: LANGKAH ========== --}}
    <section class="bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-base font-bold shadow-sm">4</span>
                <div>
                    <h2 class="font-['Playfair_Display'] text-xl text-primary font-bold">Langkah Memasak</h2>
                    <p class="text-xs text-on-surface-variant">Uraikan instruksi langkah demi langkah.</p>
                </div>
            </div>
            <button type="button" onclick="addStepRow()"
                    class="self-start sm:self-auto flex items-center gap-2 px-4 py-2 rounded-full bg-primary-container text-white text-xs font-bold hover:bg-primary transition">
                <span class="material-symbols-outlined text-[18px]">add_task</span>
                Tambah Langkah
            </button>
        </div>

        <div class="flex flex-col gap-4" id="steps-container"></div>
    </section>

    {{-- ========== KARTU 5: PUBLIKASI ========== --}}
    <section class="bg-surface-container-lowest rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex items-center gap-3 pb-2">
            <span class="w-9 h-9 rounded-full bg-secondary text-white flex items-center justify-center text-base font-bold shadow-sm">5</span>
            <div>
                <h2 class="font-['Playfair_Display'] text-xl text-primary font-bold">Status Publikasi</h2>
                <p class="text-xs text-on-surface-variant">Tentukan visibilitas resep di portal.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-start gap-3 p-4 rounded-2xl bg-surface-container-low/50 hover:bg-surface-container-low cursor-pointer transition">
                <input type="radio" name="status" value="draft" {{ old('status') === 'draft' ? 'checked' : '' }}
                       class="mt-1 w-4 h-4 accent-[#5a3a22]"/>
                <div>
                    <span class="text-base text-primary font-bold block">Draf Internal</span>
                    <span class="text-xs text-on-surface-variant">Hanya dapat ditinjau admin.</span>
                </div>
            </label>

            <label class="flex items-start gap-3 p-4 rounded-2xl bg-surface-container-low hover:bg-surface-container-high/60 cursor-pointer transition shadow-sm">
                <input type="radio" name="status" value="published" {{ old('status', 'published') === 'published' ? 'checked' : '' }}
                       class="mt-1 w-4 h-4 accent-[#5a3a22]"/>
                <div>
                    <span class="text-base text-primary font-bold block">Terbitkan Sekarang</span>
                    <span class="text-xs text-on-surface-variant">Langsung tayang di etalase publik.</span>
                </div>
            </label>
        </div>
    </section>

    {{-- ========== STICKY ACTION BAR ========== --}}
    <aside class="fixed bottom-0 left-72 right-0 bg-surface-container-lowest/95 backdrop-blur-xl z-40 p-4 shadow-[0_-8px_24px_-4px_rgba(90,58,34,0.08)]">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4">
            <div class="flex items-center gap-2 text-on-surface-variant text-xs font-semibold">
                <span class="w-2.5 h-2.5 rounded-full bg-on-tertiary-container animate-pulse"></span>
                <span>Perubahan akan disimpan ke database</span>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.recipes.index') }}"
                   class="px-5 py-2.5 rounded-full bg-surface-container-high/60 hover:bg-surface-container-high text-primary text-sm font-bold transition">
                    Batal
                </a>
                <button type="submit" name="status" value="draft"
                        class="px-6 py-2.5 rounded-full bg-surface-container text-primary hover:bg-surface-container-high text-sm font-bold transition flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">save_as</span>
                    Simpan Draf
                </button>
                <button type="submit" name="status" value="published"
                        class="px-8 py-3 rounded-full bg-primary text-white hover:bg-primary-container text-sm font-bold transition shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">restaurant</span>
                    Publikasikan
                </button>
            </div>
        </div>
    </aside>
</form>

@endsection

@push('scripts')
<script>
// ============================================================
// BAHAN DINAMIS
// ============================================================
const ingredientsData = @json($ingredients->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'unit' => $i->unit]) ?? []);
let ingredientIdx = 0;

function addIngredientRow() {
    const c = document.getElementById('ingredients-container');
    const options = ingredientsData.map(i => `<option value="${i.id}">${i.name} (${i.unit})</option>`).join('');

    const row = document.createElement('div');
    row.className = 'ingredient-row grid grid-cols-1 md:grid-cols-12 gap-3 items-center bg-surface-container-low/40 p-3 rounded-xl';
    row.innerHTML = `
        <div class="md:col-span-6">
            <select name="ingredients[${ingredientIdx}][id]" required
                    class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-sm outline-none focus:ring-2 focus:ring-secondary/40">
                <option value="">— Pilih Bahan —</option>
                ${options}
            </select>
        </div>
        <div class="md:col-span-3">
            <input type="number" name="ingredients[${ingredientIdx}][amount]" step="0.01" min="0" required
                   placeholder="Jumlah"
                   class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-sm text-center outline-none focus:ring-2 focus:ring-secondary/40"/>
        </div>
        <div class="md:col-span-2">
            <input type="text" name="ingredients[${ingredientIdx}][unit]" placeholder="Satuan (opsional)"
                   class="w-full bg-surface-container-lowest text-on-surface px-4 py-2.5 rounded-full text-sm outline-none focus:ring-2 focus:ring-secondary/40"/>
        </div>
        <div class="md:col-span-1 flex justify-end">
            <button type="button" onclick="this.closest('.ingredient-row').remove()"
                    class="w-9 h-9 rounded-full bg-error-container/60 hover:bg-error text-error hover:text-white flex items-center justify-center transition">
                <span class="material-symbols-outlined text-[18px]">remove</span>
            </button>
        </div>
    `;
    c.appendChild(row);
    ingredientIdx++;
}

// ============================================================
// LANGKAH DINAMIS
// ============================================================
let stepIdx = 0;

function addStepRow() {
    const c = document.getElementById('steps-container');
    const num = stepIdx + 1;

    const row = document.createElement('div');
    row.className = 'step-card bg-surface-container-low/40 rounded-xl p-4 flex flex-col gap-3';
    row.innerHTML = `
        <div class="flex items-center justify-between">
            <span class="font-['Playfair_Display'] text-base text-primary font-bold">Langkah ${num}</span>
            <button type="button" onclick="this.closest('.step-card').remove()"
                    class="text-error hover:bg-error-container p-1 rounded-full transition">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
        </div>
        <textarea name="steps[${stepIdx}][instruction]" rows="3" required
                  placeholder="Tuliskan petunjuk teknik memasak, indikator kematangan visual..."
                  class="w-full bg-surface-container-lowest text-on-surface p-3 rounded-xl text-sm outline-none focus:ring-2 focus:ring-secondary/40"></textarea>
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-secondary text-[20px]">timer</span>
            <label class="text-xs font-bold text-primary">Timer (menit):</label>
            <input type="number" name="steps[${stepIdx}][duration_minutes]" min="1" placeholder="0"
                   class="w-20 bg-surface-container-low text-center text-sm rounded-full py-1.5 outline-none"/>
            <span class="text-[11px] text-outline">Kosongkan jika tanpa timer</span>
        </div>
    `;
    c.appendChild(row);
    stepIdx++;
}

// Tambah 1 bahan & 1 langkah default saat halaman dibuka
document.addEventListener('DOMContentLoaded', () => {
    addIngredientRow();
    addStepRow();
});
</script>
@endpush