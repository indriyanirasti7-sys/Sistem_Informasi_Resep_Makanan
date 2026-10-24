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

@endsection