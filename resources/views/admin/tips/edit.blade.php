@extends('admin.layout')

@section('title', 'Edit Tips — Griya Rasa')
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

    <form id="editTipForm" method="POST" action="{{ route('admin.tips.update', $tip->slug) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
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

            <!-- Tingkat Kesulitan -->
            <div class="flex flex-col gap-1.5 pt-2">
                <label class="text-xs font-bold text-primary">Tingkat Keahlian</label>
                <div class="flex items-center gap-2 bg-surface-container-low p-1.5 rounded-2xl shadow-sm h-[46px]">
                    @foreach (['Pemula', 'Menengah', 'Mahir'] as $level)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="difficulty" value="{{ $level }}" class="peer sr-only"
                                {{ old('difficulty', $tip->level ?? $tip->difficulty ?? $tip->tingkat ?? '') === $level ? 'checked' : '' }}>
                            <span class="block text-center py-1.5 rounded-xl text-xs font-semibold text-on-surface-variant peer-checked:bg-secondary peer-checked:text-white transition-all">{{ $level }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="flex flex-col gap-1.5 pt-2">
                <label class="text-xs font-bold text-primary" for="summary">Ringkasan Singkat / Lead-in Artikel</label>
                <textarea id="summary" name="summary" rows="3" maxlength="300" class="w-full bg-surface-container-low text-on-surface p-4 rounded-2xl text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/40 transition-all resize-none">{{ old('summary', $tip->summary ?? '') }}</textarea>
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
                <!-- Current Active Image Card (DENGAN LOKAL STORAGE) -->
                @php
                    $tipImg = null;
                    if ($tip->image) {
                        $cleanTipImg = str_replace(['storage/', 'uploads/tips/', 'uploads/'], '', $tip->image);
                        if (file_exists(public_path('storage/' . $tip->image))) {
                            $tipImg = asset('storage/' . $tip->image);
                        } elseif (file_exists(public_path('storage/' . $cleanTipImg))) {
                            $tipImg = asset('storage/' . $cleanTipImg);
                        } elseif (file_exists(public_path('storage/tips/' . $cleanTipImg))) {
                            $tipImg = asset('storage/tips/' . $cleanTipImg);
                        } elseif (file_exists(public_path('uploads/' . $cleanTipImg))) {
                            $tipImg = asset('uploads/' . $cleanTipImg);
                        } else {
                            $tipImg = asset('storage/' . $tip->image);
                        }
                    }
                @endphp

                <div class="lg:col-span-6 flex flex-col rounded-2xl overflow-hidden bg-surface-container-low p-3 gap-3 shadow-sm">
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden group bg-surface-container">
                        @if($tipImg)
                            <img class="w-full h-full object-cover" src="{{ $tipImg }}" alt="{{ $tip->title }}"/>
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

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
            <style>
                .ql-toolbar.ql-snow { border:0; border-bottom:1px solid #efe7d9; background:rgba(239,231,217,.4); padding:10px 16px; }
                .ql-container.ql-snow { border:0; font-family:inherit; font-size:15px; }
                .ql-editor { min-height:380px; padding:24px; line-height:1.75; color:#1e1b12; }
                .ql-editor h2 { font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:700; color:#41240e; margin:1.2em 0 .5em; }
                .ql-editor h3 { font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700; color:#41240e; margin:1.1em 0 .4em; }
                .ql-editor p  { margin-bottom:.8em; }
                .ql-editor ul, .ql-editor ol { padding-left:1.2em; margin-bottom:.8em; }
                .ql-editor blockquote { border-left:4px solid #55643b; padding-left:1em; color:#50443d; font-style:italic; }
            </style>

            <!-- Editor teks kaya -->
            <div id="editor"></div>
            <input type="hidden" name="content" id="content" value="{{ old('content', $tip->content) }}">
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
                        <div class="relative inline-flex items-center cursor-default">
                            <div class="w-11 h-6 bg-surface-container-high rounded-full peer-checked:bg-secondary transition-colors {{ (old('status', $tip->status) === 'published') ? 'bg-secondary' : '' }}"></div>
                            <div class="absolute left-[2px] top-[2px] bg-white border-gray-300 border rounded-full h-5 w-5 transition-transform {{ (old('status', $tip->status) === 'published') ? 'translate-x-full border-white' : '' }}"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Penulis Kurator (SESUAI USER YANG LOGIN DENGAN LOKAL STORAGE AVATAR) -->
            @php
                $currUser = auth()->user() ?? $tip->user;
                $currAvatar = null;
                if ($currUser && $currUser->avatar) {
                    $cleanCurrAvatar = str_replace(['storage/', 'uploads/avatars/', 'avatars/'], '', $currUser->avatar);
                    if (file_exists(public_path('storage/' . $currUser->avatar))) {
                        $currAvatar = asset('storage/' . $currUser->avatar);
                    } elseif (file_exists(public_path('storage/' . $cleanCurrAvatar))) {
                        $currAvatar = asset('storage/' . $cleanCurrAvatar);
                    } elseif (file_exists(public_path('storage/avatars/' . $cleanCurrAvatar))) {
                        $currAvatar = asset('storage/avatars/' . $cleanCurrAvatar);
                    } elseif (file_exists(public_path('uploads/' . $cleanCurrAvatar))) {
                        $currAvatar = asset('uploads/' . $cleanCurrAvatar);
                    } else {
                        $currAvatar = asset('storage/' . $currUser->avatar);
                    }
                }
                $currInitials = collect(explode(' ', $currUser->name ?? 'A'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
            @endphp

            <section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-surface-container-high pb-3">
                    <h3 class="text-base text-primary font-bold">Penulis / Kurator Ahli</h3>
                </div>
                <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-surface-container-low">
                    <div class="w-11 h-11 rounded-full overflow-hidden bg-primary flex items-center justify-center text-white shrink-0 shadow-sm font-bold text-lg">
                        @if($currAvatar)
                            <img src="{{ $currAvatar }}" alt="{{ $currUser->name ?? 'Kurator' }}" class="w-full h-full object-cover">
                        @else
                            {{ $currInitials }}
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-sm text-primary font-bold truncate block">{{ $currUser->name ?? 'Anonim' }}</span>
                        <span class="text-xs text-secondary truncate block">Super Admin / Kurator</span>
                    </div>
                </div>
            </section>
        </div>

        <!-- ACTIONS -->
        <div class="flex items-center justify-between pt-4 border-t border-surface-container-high mt-2">
            <button type="submit" name="status" value="draft" class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan sebagai Draft
            </button>

            <div class="flex items-center gap-3">
                <button type="submit" name="status" value="published" class="px-6 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    Simpan & Publikasikan
                </button>
            </div>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
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

    document.addEventListener('DOMContentLoaded', function () {
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tuliskan isi panduan di sini...',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'link'],
                    ['clean']
                ]
            }
        });

        const contentInput = document.getElementById('content');

        function syncContent() {
            const isEmpty = quill.getText().trim().length === 0;
            contentInput.value = isEmpty ? '' : quill.root.innerHTML;
        }

        const initial = @json(old('content', $tip->content));
        if (initial) {
            quill.clipboard.dangerouslyPasteHTML(initial);
            syncContent();
        }

        quill.on('text-change', syncContent);

        const form = document.getElementById('editTipForm');
        if (form) {
            form.addEventListener('submit', syncContent);
        }
    });
</script>

@endsection