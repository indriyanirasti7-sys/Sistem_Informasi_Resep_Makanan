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

        <!-- Konten akan ditambahkan di tahap selanjutnya -->

    </form>
</div>

@endsection