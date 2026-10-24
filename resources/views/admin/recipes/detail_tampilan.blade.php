@extends('admin.layout')

@section('title', 'Detail Resep — L\'Art de Cuisine')
@section('breadcrumb', 'Detail Resep')

@section('content')

<div class="w-full pb-space-2xl pt-6">

    <!-- Top Bar: Breadcrumb Navigation & Action Suite -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md mb-6">
        <div class="flex items-center flex-wrap gap-2 text-on-surface-variant text-xs">
            <span class="hover:text-primary cursor-pointer">Portal Admin</span>
            <span class="text-outline-variant">/</span>
            <a href="{{ route('admin.recipes.index') }}" class="hover:text-primary cursor-pointer">Kelola Resep</a>
            <span class="text-outline-variant">/</span>
            <span class="text-primary font-bold bg-surface-container-high px-3 py-1 rounded-full text-[11px]">Detail Resep (#RCP-{{ str_pad($recipe->id, 4, '0', STR_PAD_LEFT) }})</span>
        </div>
        
        <div class="flex items-center flex-wrap gap-3">
            <a href="{{ route('admin.recipes.index') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-surface-container-lowest text-primary text-xs font-bold shadow-sm hover:bg-surface-container transition-all">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Daftar</span>
            </a>
            
            <form method="POST" action="{{ route('admin.recipes.destroy', $recipe->id) }}" onsubmit="return confirm('Hapus resep ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-error-container text-error text-xs font-bold hover:bg-error hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    <span>Hapus</span>
                </button>
            </form>

            <a href="{{ route('admin.recipes.edit', $recipe->id) }}" class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary text-white text-xs font-bold shadow-sm hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined text-[18px]">edit_note</span>
                <span>Edit Resep</span>
            </a>
        </div>
    </div>

    <!-- Recipe Metadata & Status Banner -->
    <div class="bg-surface-container-lowest rounded-xl p-5 shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 items-center">
            <!-- Status Badge & ID -->
            <div class="xl:col-span-1 flex flex-col gap-2">
                <div class="flex items-center gap-2 px-3 py-1 rounded-full {{ $recipe->status === 'published' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container text-on-surface-variant' }} text-[11px] font-bold w-fit">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $recipe->status === 'published' ? 'bg-secondary' : 'bg-outline' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $recipe->status === 'published' ? 'bg-secondary' : 'bg-outline' }}"></span>
                    </span>
                    <span>{{ $recipe->status === 'published' ? 'Dipublikasikan (Live)' : 'Draf' }}</span>
                </div>
            </div>

            <!-- Created Date -->
            <div class="flex flex-col">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Tanggal Dibuat</span>
                <span class="text-on-surface text-sm font-semibold mt-0.5">{{ $recipe->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

            <!-- Last Updated -->
            <div class="flex flex-col">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Terakhir Diperbarui</span>
                <span class="text-on-surface text-sm font-semibold mt-0.5">{{ $recipe->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

            <!-- Author / Curator -->
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">
                    {{ substr($recipe->user->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-1">
                        <span class="text-primary text-xs font-bold truncate">{{ $recipe->user->name ?? 'Anonim' }}</span>
                        <span class="material-symbols-outlined text-secondary text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                    <span class="text-outline text-[10px] truncate">{{ $recipe->user->email ?? 'email@domain.com' }}</span>
                </div>
            </div>

            <!-- Visibility Status -->
            <div class="flex flex-col xl:items-end">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Kategori</span>
                <div class="flex items-center gap-1.5 text-secondary text-xs mt-0.5 font-bold">
                    <span class="material-symbols-outlined text-[16px]">category</span>
                    <span>{{ $recipe->category->name ?? 'Tanpa Kategori' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Column (Full Width) -->
    <div class="w-full flex flex-col gap-6 mb-6">
        
        <!-- 1. Featured Visual & Title Narrative -->
        <div class="bg-surface-container-lowest rounded-xl p-6 sm:p-8 shadow-sm flex flex-col">
            <!-- Hero Visual Frame -->
            <div class="relative w-full h-80 sm:h-96 rounded-lg overflow-hidden bg-surface-container-high mb-6 group">
                @if($recipe->image)
                    <img class="w-full h-full object-cover object-center group-hover:scale-[1.02] transition-transform duration-700" src="{{ asset('storage/'.$recipe->image) }}" alt="{{ $recipe->title }}"/>
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined text-[64px]">image_not_supported</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-transparent to-transparent"></div>
            </div>

            <!-- Recipe Title -->
            <h1 class="font-['Playfair_Display'] text-3xl sm:text-4xl text-primary tracking-tight mb-3 font-bold">
                {{ $recipe->title }}
            </h1>

            <!-- Culinary Philosophy & Long Description -->
            <div class="bg-surface-container-low rounded-lg p-5 text-on-surface-variant text-sm leading-relaxed mt-2">
                <p>{!! nl2br(e($recipe->description)) !!}</p>
            </div>
        </div>

                <!-- 2. Spesifikasi Dapur (Full Width Grid) -->
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-surface-container-high">
                <span class="material-symbols-outlined text-secondary text-[22px]">restaurant</span>
                <h2 class="font-['Playfair_Display'] text-lg text-primary font-bold">Spesifikasi Dapur</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="flex flex-col bg-surface-container-low p-3 rounded-lg">
                    <span class="text-on-surface-variant text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">timer</span> Total Waktu</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->duration_minutes }} Menit</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-3 rounded-lg">
                    <span class="text-on-surface-variant text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">group</span> Kapasitas</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->servings }} Orang</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-3 rounded-lg">
                    <span class="text-on-surface-variant text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">speed</span> Kesulitan</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->difficulty }}</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-3 rounded-lg">
                    <span class="text-on-surface-variant text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">local_fire_department</span> Kalori</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->calories ? $recipe->calories . ' kkal' : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- 3. Bahan & Takaran -->
        <div class="bg-surface-container-lowest rounded-xl p-6 sm:p-8 shadow-sm flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 gap-3 border-b border-surface-container-high mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">grocery</span>
                    </div>
                    <div>
                        <h2 class="font-['Playfair_Display'] text-2xl text-primary font-bold leading-tight">Bahan &amp; Takaran Presisi</h2>
                        <p class="text-xs text-on-surface-variant">Daftar komposisi tervalidasi standar dapur kurator</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 bg-surface-container-high px-4 py-1.5 rounded-full text-on-surface-variant text-xs">
                    <span class="material-symbols-outlined text-secondary text-[18px]">scale</span>
                    <span>Dikalibrasi untuk <strong class="text-primary">{{ $recipe->servings }} Porsi</strong></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($recipe->recipeIngredients as $ri)
                    <div class="bg-surface-container-low rounded-lg p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-[18px] mt-0.5">check_circle</span>
                        <div class="text-sm">
                            <span class="font-bold text-primary">{{ $ri->amount }} {{ $ri->unit ?? $ri->ingredient->unit }}</span>
                            <span class="text-on-surface-variant block mt-0.5">{{ $ri->ingredient->name ?? 'Bahan' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

                <!-- 4. Step-by-Step Cooking Instructions -->
        <div class="bg-surface-container-lowest rounded-xl p-6 sm:p-8 shadow-sm flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-surface-container-high mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">skillet</span>
                    </div>
                    <div>
                        <h2 class="font-['Playfair_Display'] text-2xl text-primary font-bold leading-tight">Instruksi &amp; Tahapan Memasak</h2>
                        <p class="text-xs text-on-surface-variant">Protokol teknis langkah demi langkah</p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col gap-4">
                @foreach($recipe->steps as $step)
                    <div class="bg-surface-container-low rounded-lg p-4 flex flex-col sm:flex-row gap-4 items-start">
                        <div class="flex sm:flex-col items-center justify-between w-full sm:w-20 gap-2 shrink-0">
                            <span class="w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center">
                                {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($step->duration_minutes)
                                <span class="px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[10px] font-bold">
                                    {{ $step->duration_minutes }} Mnt
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-col min-w-0 mt-2 sm:mt-0">
                            <p class="text-sm text-on-surface-variant leading-relaxed">
                                {{ $step->instruction }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection