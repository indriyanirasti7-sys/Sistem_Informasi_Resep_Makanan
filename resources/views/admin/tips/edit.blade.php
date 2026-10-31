@extends('admin.layout')

@section('title', 'Edit Tips — L\'Art de Cuisine')
@section('breadcrumb', 'Edit Tips')

@section('content')

<div class="flex flex-col w-full pb-28 pt-6">
    
    <!-- Top Navigation & Global Tip Status -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-2 text-on-surface-variant text-xs font-semibold">
                <span class="hover:text-primary transition-colors cursor-pointer">Portal Admin</span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('admin.tips.index') }}" class="hover:text-primary transition-colors cursor-pointer">Kelola Tips</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-primary font-bold">Edit Tips</span>
            </nav>
            <h1 class="font-display text-3xl text-primary tracking-tight mt-1 font-bold">Ubah Panduan Kuliner</h1>
        </div>
        
        <!-- Status & ID Pill Bar -->
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2.5 px-4 py-2 rounded-full bg-surface-container shadow-sm">
                <span class="flex h-2.5 w-2.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-secondary"></span>
                </span>
                <span class="text-xs text-primary font-bold tracking-wide">Status: {{ ucfirst($tip->status ?? 'Draft') }}</span>
                <span class="text-outline text-xs">•</span>
                <span class="text-xs text-on-surface-variant font-medium">#TIP-{{ str_pad($tip->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </div>

    <!-- Metadata & Revision Banner -->
    <div class="w-full bg-surface-container-low rounded-2xl p-4 sm:p-5 mb-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed shrink-0 shadow-sm">
                <span class="material-symbols-outlined text-[20px]">history_edu</span>
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="text-sm text-primary font-bold">Terakhir diperbarui oleh {{ $tip->user->name ?? 'Admin' }}</span>
                </div>
                <p class="text-xs text-on-surface-variant mt-0.5">{{ $tip->updated_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>

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
        <section class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">edit_note</span>
                    </div>
                    <h2 class="text-xl text-primary font-bold">Informasi Dasar Tips</h2>
                </div>
            </div>

            <!-- Tip Title -->
            <div class="flex flex-col gap-2">
                <label class="text-sm text-primary font-bold" for="title">Judul Tips <span class="text-error">*</span></label>
                <input type="text" id="title" name="title" required value="{{ old('title', $tip->title) }}"
                       class="w-full px-5 py-3.5 rounded-2xl bg-surface-container-low text-primary text-lg focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all shadow-sm"/>
            </div>

            <!-- Meta Selector Row: Category & Difficulty -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Kategori Dropdown -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-primary font-bold">Kategori Kuliner</label>
                    <div class="relative">
                        <select name="category" class="w-full appearance-none px-4 py-3 rounded-2xl bg-surface-container-low text-primary text-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all shadow-sm pr-10 cursor-pointer">
                            <option value="knife-skills" {{ old('category', $tip->category ?? '') == 'knife-skills' ? 'selected' : '' }}>Knife Skills</option>
                            <option value="sauces" {{ old('category', $tip->category ?? '') == 'sauces' ? 'selected' : '' }}>Saus Dasar</option>
                            <option value="baking" {{ old('category', $tip->category ?? '') == 'baking' ? 'selected' : '' }}>Pastry & Bakery</option>
                            <option value="plating" {{ old('category', $tip->category ?? '') == 'plating' ? 'selected' : '' }}>Plating Art</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">unfold_more</span>
                    </div>
                </div>

                <!-- Tingkat Kesulitan -->
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-primary font-bold">Tingkat Kesulitan</label>
                    <div class="flex items-center gap-1.5 p-1 rounded-2xl bg-surface-container-low">
                        <input type="radio" name="difficulty" id="pemula" value="Pemula" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Pemula' ? 'checked' : '' }}>
                        <label for="pemula" class="flex-1 text-center py-2 rounded-xl text-xs font-semibold bg-surface-container text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Pemula</label>

                        <input type="radio" name="difficulty" id="menengah" value="Menengah" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Menengah' ? 'checked' : '' }}>
                        <label for="menengah" class="flex-1 text-center py-2 rounded-xl text-xs font-semibold bg-surface-container text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Menengah</label>

                        <input type="radio" name="difficulty" id="mahir" value="Mahir" class="peer sr-only" {{ old('difficulty', $tip->difficulty ?? '') == 'Mahir' ? 'checked' : '' }}>
                        <label for="mahir" class="flex-1 text-center py-2 rounded-xl text-xs font-semibold bg-surface-container text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white cursor-pointer transition-all">Mahir</label>
                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="flex flex-col gap-2">
                <label class="text-sm text-primary font-bold" for="summary">Ringkasan Utama (Lead Text)</label>
                <textarea id="summary" name="summary" rows="3" class="w-full p-4 rounded-2xl bg-surface-container-low text-primary text-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none shadow-sm">{{ old('summary', $tip->summary ?? '') }}</textarea>
            </div>
        </section>

                <!-- SECTION 2: Featured Media Management Area -->
        <section class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">photo_library</span>
                    </div>
                    <h2 class="text-xl text-primary font-bold">Manajemen Foto &amp; Sampul Utama</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <!-- Current Active Image Card -->
                <div class="lg:col-span-7 flex flex-col rounded-2xl overflow-hidden bg-surface-container-low p-3 gap-3 shadow-sm">
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden group bg-surface-container">
                        @if($tip->image)
                            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$tip->image) }}" alt="{{ $tip->title }}"/>
                        @else
                            <div class="flex items-center justify-center w-full h-full text-outline">
                                <span class="material-symbols-outlined text-[48px]">image_not_supported</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dropzone Replace Media -->
                <div class="lg:col-span-5 relative flex flex-col justify-center items-center p-6 rounded-2xl bg-surface-container-lowest hover:bg-surface-container-low transition-colors text-center cursor-pointer shadow-sm group border border-dashed border-outline-variant hover:border-secondary">
                    <input type="file" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                    <img id="imagePreview" class="hidden absolute inset-0 w-full h-full object-cover z-10 rounded-2xl"/>
                    
                    <div class="w-14 h-14 rounded-full bg-surface-container flex items-center justify-center text-primary-container mb-3 group-hover:scale-110 transition-transform shadow-sm z-0">
                        <span class="material-symbols-outlined text-[28px]">cloud_upload</span>
                    </div>
                    <span class="text-sm text-primary font-semibold z-0">Unggah Foto Pengganti</span>
                    <p class="text-xs text-on-surface-variant mt-1.5 max-w-xs leading-normal z-0">
                        Biarkan kosong jika tidak ingin mengubah foto. Maks. 5 MB.
                    </p>
                </div>
            </div>
        </section>

                <!-- SECTION 3: Rich Text Editor -->
        <section class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-surface-container-high">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">article</span>
                    </div>
                    <h2 class="text-xl text-primary font-bold">Isi Artikel Tips</h2>
                </div>
            </div>

            <!-- Rich Text Editor Toolbar (UI Saja) -->
            <div class="flex flex-wrap items-center gap-1.5 p-2 rounded-2xl bg-surface-container-low shadow-sm">
                <button class="w-8 h-8 rounded-lg bg-surface-container-lowest text-primary font-bold shadow-sm flex items-center justify-center hover:bg-surface-container-high transition-colors" type="button"><span class="material-symbols-outlined text-[18px]">format_bold</span></button>
                <button class="w-8 h-8 rounded-lg text-on-surface-variant flex items-center justify-center hover:bg-surface-container-high hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined text-[18px]">format_italic</span></button>
                <button class="w-8 h-8 rounded-lg text-on-surface-variant flex items-center justify-center hover:bg-surface-container-high hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined text-[18px]">format_underlined</span></button>
                <div class="h-5 w-px bg-surface-variant mx-1"></div>
                <button class="w-8 h-8 rounded-lg text-on-surface-variant flex items-center justify-center hover:bg-surface-container-high hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined text-[18px]">format_list_bulleted</span></button>
                <button class="w-8 h-8 rounded-lg text-on-surface-variant flex items-center justify-center hover:bg-surface-container-high hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined text-[18px]">format_quote</span></button>
            </div>

            <!-- Editable Canvas -->
            <textarea name="content" rows="16" required
                      class="w-full p-6 rounded-2xl bg-surface-container-low text-primary text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-y shadow-sm"
                      placeholder="Tuliskan isi panduan di sini...">{{ old('content', $tip->content) }}</textarea>
        </section>

                <!-- Grid for Status & Author (Dipindah ke Bawah) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Status Publikasi -->
            <section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-surface-container-high pb-3">
                    <h3 class="text-lg text-primary font-bold">Status Publikasi</h3>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-surface-container-low">
                        <div class="flex flex-col">
                            <span class="text-sm text-primary font-semibold">Visibilitas Publik</span>
                            <span class="text-xs text-on-surface-variant">Tampil di portal umum</span>
                        </div>
                        <input type="checkbox" name="status" value="published" class="sr-only peer" {{ old('status', $tip->status) === 'published' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-surface-container-high peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary cursor-pointer relative"></div>
                    </div>
                </div>
            </section>

            <!-- Penulis Kurator -->
            <section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-surface-container-high pb-3">
                    <h3 class="text-lg text-primary font-bold">Penulis &amp; Kurator</h3>
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

        <!-- Sticky Action Bar -->
        <div class="sticky bottom-6 z-30 w-full mt-4">
            <div class="bg-surface-container-lowest/95 backdrop-blur-md p-4 md:px-6 rounded-full shadow-[0_16px_40px_-6px_rgba(90,58,34,0.14)] flex flex-wrap items-center justify-between gap-3 border border-surface-container-high">
                
                <a href="{{ route('admin.tips.index') }}" class="flex items-center gap-1.5 px-4 py-2.5 rounded-full text-on-surface-variant hover:text-error hover:bg-error-container transition-all text-xs font-bold">
                    Batal & Kembali
                </a>
                
                <div class="flex items-center gap-3">
                    <button type="submit" name="status" value="draft" class="flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-surface-container text-primary hover:bg-surface-container-high transition-all text-xs font-bold">
                        <span class="material-symbols-outlined text-[18px]">archive</span>
                        Beralih ke Draf
                    </button>
                    <button type="submit" name="status" value="published" class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary text-white hover:bg-primary-container transition-all text-sm font-bold shadow-md">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Perubahan
                    </button>
                </div>
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


