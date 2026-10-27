@extends('admin.layout')

@section('title', 'Detail Tips — L\'Art de Cuisine')
@section('breadcrumb', 'Detail Tips')

@section('content')

<div class="flex flex-col w-full max-w-[1280px] mx-auto pb-12 pt-6 gap-6">

    <!-- 1. Top Admin Action & Breadcrumb Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-1.5 text-xs text-on-surface-variant font-semibold flex-wrap">
            <span class="hover:text-primary transition-colors cursor-pointer">Portal Admin</span>
            <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
            <a href="{{ route('admin.tips.index') }}" class="hover:text-primary transition-colors cursor-pointer">Kelola Tips</a>
            <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
            <span class="text-primary font-bold">Detail Tip (#TIP-{{ str_pad($tip->id, 4, '0', STR_PAD_LEFT) }})</span>
        </div>
        
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.tips.index') }}" class="flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-surface-container-lowest text-primary hover:bg-surface-container-high transition-all shadow-sm text-xs font-bold">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali</span>
            </a>
            
            <a href="{{ route('admin.tips.edit', $tip->slug) }}" class="flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-primary-container text-white hover:bg-primary transition-all shadow-sm text-xs font-bold">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span>Edit Tips</span>
            </a>

            <form method="POST" action="{{ route('admin.tips.destroy', $tip->slug) }}" onsubmit="return confirm('Hapus tips ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="p-2.5 rounded-full bg-error-container text-error hover:bg-error hover:text-white transition-all shadow-sm" title="Hapus">
                    <span class="material-symbols-outlined text-[20px]">delete</span>
                </button>
            </form>
        </div>
    </div>

    <!-- 2. Metadata & Status Banner -->
    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex flex-col gap-5">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-surface-container-high">
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                    </span>
                    {{ $tip->status === 'published' ? 'Dipublikasikan (Live)' : 'Draf' }}
                </div>
                
                <span class="px-3 py-1.5 rounded-full bg-surface-container-low text-primary text-xs font-bold">
                    Kategori: Umum
                </span>
                
                <span class="px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant text-xs">
                    Tingkat: <strong class="text-primary">Pemula</strong>
                </span>
            </div>

            <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-full">
                <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">
                    {{ substr($tip->user->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-primary leading-tight">{{ $tip->user->name ?? 'Anonim' }}</span>
                    <span class="text-[10px] text-on-surface-variant leading-tight">{{ $tip->user->email ?? '' }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Metrics Strip (Dipindah ke dalam Banner) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-surface-container-low rounded-xl p-3 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Tanggal Dibuat</span>
                <span class="text-sm text-primary font-bold mt-0.5">{{ $tip->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
            <div class="bg-surface-container-low rounded-xl p-3 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Terakhir Diperbarui</span>
                <span class="text-sm text-primary font-bold mt-0.5">{{ $tip->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
            <div class="bg-surface-container-low rounded-xl p-3 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Waktu Baca</span>
                <span class="text-sm text-secondary font-bold mt-0.5">{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} Menit Baca</span>
            </div>
        </div>
    </div>

    <!-- 3. Area Konten Utama -->
    <div class="w-full flex flex-col gap-6">
        
        <!-- A. Hero Image & Title -->
        <article class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
            
            <!-- Hero Image -->
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-sm group bg-surface-container">
                @if($tip->image)
                    <img src="{{ asset('storage/'.$tip->image) }}" alt="{{ $tip->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined text-[64px]">image_not_supported</span>
                    </div>
                @endif
            </div>

            <!-- Title & Lead-in -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                    <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Panduan Teknik Fundamental Dapur</span>
                </div>
                
                <h1 class="font-display text-3xl sm:text-4xl text-primary font-bold leading-tight">
                    {{ $tip->title }}
                </h1>

                <div class="bg-surface-container-low rounded-xl p-5 text-on-surface-variant italic text-sm leading-relaxed border-l-4 border-secondary">
                    "{{ Str::limit(strip_tags($tip->content), 200) }}"
                </div>
            </div>
        </article>

        <!-- B. Isi Artikel & Tags -->
        <article class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
            
            <div class="prose prose-sm sm:prose-base max-w-none text-on-surface leading-relaxed">
                {!! nl2br(e($tip->content)) !!}
            </div>

            <!-- Tags -->
            <div class="flex flex-col gap-2 pt-6 border-t border-surface-container-high">
                <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Taksonomi & Kata Kunci Meta:</span>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#KnifeSkills</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#KeamananDapur</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#MiseEnPlace</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#GastronomiDasar</span>
                </div>
            </div>
        </article>

    </div>

</div>
@endsection