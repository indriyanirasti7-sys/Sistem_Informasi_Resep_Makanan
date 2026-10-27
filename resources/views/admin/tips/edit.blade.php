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

    <form method="POST" action="{{ route('admin.tips.update', $tip->id) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
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

    </form>
</div>

@endsection