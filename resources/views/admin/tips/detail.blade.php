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
    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm flex flex-col gap-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-surface-container-high">
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

        <!-- Quick Metrics Strip -->
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

    <!-- Konten Utama akan ditambahkan di tahap berikutnya -->

</div>
@endsection