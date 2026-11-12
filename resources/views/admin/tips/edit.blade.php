@extends('admin.layout')

@section('title', 'Edit Tips — Jelajah Rasa')
@section('breadcrumb', 'Edit Tips')

@section('content')

<div class="w-full mx-auto pb-12">
    
    {{-- ========== HEADER ========== --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.tips.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Tips
        </a>

        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[28px] text-primary">edit_document</span>
                <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">
                    Edit Tips: {{ $tip->title }}
                </h1>
            </div>
        </div>
        <p class="text-sm text-on-surface-variant mt-1">
            Perbarui panduan, artikel, atau catatan koki Anda untuk dibagikan kepada pengunjung.
        </p>
    </header>

    <form method="POST" action="{{ route('admin.tips.update', $tip->slug) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-error-container text-on-error-container text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <!-- SECTION 1: Basic Tip Information -->
        <section class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm flex flex-col gap-5">
            <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">edit_note</span>
                    </div>
                    <h2 class="text-lg text-primary font-bold">Informasi Dasar Tips</h2>
                </div>
            </div>

            <!-- Tip Title -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-primary flex items-center justify-between" for="title">
                    <span>Judul Tips <span class="text-error">*</span></span>
                </label>
                <input type="text" id="title" name="title" required value="{{ old('title', $tip->title) }}"
                       class="w-full bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all text-sm font-medium"/>
            </div>

            <!-- Meta Selector Row: Category & Difficulty -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                <!-- Kategori Dropdown -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-primary">Kategori Rubrik</label>
                    <div class="relative">
                        <select name="category" class="w-full appearance-none bg-surface-container-low text-on-surface px-4 py-3 rounded-2xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all cursor-pointer">
                            <option value="knife-skills" {{ old('category', $tip->category ?? '') == 'knife-skills' ? 'selected' : '' }}>Knife Skills (Teknik Pisau)</option>
                            <option value="sauces" {{ old('category', $tip->category ?? '') == 'sauces' ? 'selected' : '' }}>Saus Dasar</option>
                            <option value="baking" {{ old('category', $tip->category ?? '') == 'baking' ? 'selected' : '' }}>Pastry & Bakery</option>
                            <option value="plating" {{ old('category', $tip->category ?? '') == 'plating' ? 'selected' : '' }}>Plating Art</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">expand_more</span>
                    </div>
                </div>

                <!-- Tingkat Kesulitan -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-primary">Tingkat Keahlian</label>
                    <div class="flex items-center gap-2 bg-surface-container-low p-1.5 rounded-2xl shadow-sm h-[46px]">
                        <input type="radio" name="difficulty" id="pemula" value="Pemula" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Pemula' ? 'checked' : '' }}>
                        <label for="pemula" class="flex-1 text-center py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Pemula</label>

                        <input type="radio" name="difficulty" id="menengah" value="Menengah" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Menengah' ? 'checked' : '' }}>
                        <label for="menengah" class="flex-1 text-center py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Menengah</label>

                        <input type="radio" name="difficulty" id="mahir" value="Mahir" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Mahir' ? 'checked' : '' }}>
                        <label for="mahir" class="flex-1 text-center py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Mahir</label>
                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="flex flex-col gap-1.5 pt-2">
                <label class="text-xs font-bold text-primary" for="summary">Ringkasan Singkat / Lead-in Artikel</label>
                <textarea id="summary" name="summary" rows="3" class="w-full bg-surface-container-low text-on-surface p-4 rounded-2xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all resize-none">{{ old('summary', $tip->summary ?? '') }}</textarea>
            </div>
        </section>

        <!-- SECTION 2: Featured Media Management Area -->
        <section class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm flex flex-col gap-5">
            <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">photo_library</span>
                    </div>
                    <h2 class="text-lg text-primary font-bold">Manajemen Foto &amp; Sampul Utama</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <!-- Current Active Image Card -->
                <div class="lg:col-span-6 flex flex-col rounded-2xl overflow-hidden bg-surface-container-low p-3 gap-3 shadow-sm">
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden group bg-surface-container">
                        @if($tip->image)
                            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$tip->image) }}" alt="{{ $tip->title }}"/>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-outline">
                                <span class="material-symbols-outlined text-[48px]">image_not_supported</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-[11px] text-center text-on-surface-variant font-semibold">Foto Saat Ini</span>
                </div>

                <!-- Dropzone Replace Media -->
                <div class="lg:col-span-6 relative flex flex-col justify-center items-center p-6 rounded-2xl bg-surface-container-lowest hover:bg-surface-container-low transition-colors text-center cursor-pointer shadow-sm group border-2 border-dashed border-outline-variant hover:border-secondary h-full">
                    <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                    <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10 rounded-2xl"/>
                    
                    <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center text-primary-container mb-3 group-hover:scale-110 transition-transform shadow-sm z-0">
                        <span class="material-symbols-outlined text-[28px]">cloud_upload</span>
                    </div>
                    <span class="text-sm text-primary font-bold z-0">Unggah Foto Pengganti</span>
                    <p class="text-xs text-on-surface-variant mt-1.5 max-w-xs leading-normal z-0">
                        Biarkan kosong jika tidak ingin mengubah foto. Maks. 5 MB.
                    </p>
                </div>
            </div>
        </section>

        <!-- SECTION 3: Rich Text Editor -->
        <section class="bg-surface-container-lowest rounded-3xl shadow-sm flex flex-col overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">article</span>
                    </div>
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
            </div>

            <!-- Textarea -->
            <textarea name="content" rows="16" required
                      class="w-full p-6 text-sm text-on-surface leading-relaxed outline-none resize-y bg-transparent focus:ring-0 border-0"
                      placeholder="Tuliskan isi panduan di sini...">{{ old('content', $tip->content) }}</textarea>
        </section>

        <!-- Grid for Status & Author -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Status Publikasi -->
            <section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-surface-container-high pb-3">
                    <h3 class="text-base text-primary font-bold">Status Publikasi</h3>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-surface-container-low">
                        <div class="flex flex-col">
                            <span class="text-sm text-primary font-bold">Visibilitas Publik</span>
                            <span class="text-xs text-on-surface-variant">Tampil di portal umum</span>
                        </div>
                        {{-- Toggle switch untuk indikator visual saja, status di-handle oleh tombol submit di bawah --}}
                        <div class="relative inline-flex items-center cursor-default">
                            <div class="w-11 h-6 bg-surface-container-high rounded-full peer-checked:bg-secondary transition-colors {{ (old('status', $tip->status) === 'published') ? 'bg-secondary' : '' }}"></div>
                            <div class="absolute left-[2px] top-[2px] bg-white border-gray-300 border rounded-full h-5 w-5 transition-transform {{ (old('status', $tip->status) === 'published') ? 'translate-x-full border-white' : '' }}"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Penulis Kurator -->
            <section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-surface-container-high pb-3">
                    <h3 class="text-base text-primary font-bold">Penulis / Kurator Ahli</h3>
                </div>
                <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low">
                    <div class="w-11 h-11 rounded-full bg-primary flex items-center justify-center text-on-primary shrink-0 shadow-sm font-bold text-lg">
                        {{ substr($tip->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-sm text-primary font-bold truncate block">{{ $tip->user->name ?? 'Anonim' }}</span>
                        <span class="text-xs text-secondary truncate block">Super Admin</span>
                    </div>
                </div>
            </section>
        </div>

        <!-- ACTIONS (KIRI DRAFT, KANAN PUBLISH) -->
        <div class="flex items-center justify-between pt-4 border-t border-surface-container-high mt-2">
            
            {{-- Kiri Bawah: Simpan Draft --}}
            <button type="submit" name="status" value="draft" class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan sebagai Draft
            </button>

            {{-- Kanan Bawah: Perbarui & Publikasikan --}}
            <div class="flex items-center gap-3">
                <button type="submit" name="status" value="published" class="px-6 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    Simpan & Publikasikan
                </button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        
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