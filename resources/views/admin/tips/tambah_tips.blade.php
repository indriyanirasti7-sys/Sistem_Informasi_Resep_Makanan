@extends('admin.layout')

@section('title', 'Tambah Tips Baru — L\'Art de Cuisine')
@section('breadcrumb', 'Tambah Tips')

@section('content')

<div class="flex flex-col w-full pb-12 pt-6">
    
    <!-- Top Header Section & Status -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 mb-4">
        <div class="flex flex-col max-w-2xl">
            <div class="flex items-center gap-1.5 text-[11px] text-secondary mb-1 font-semibold">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                    Admin Portal
                </span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('admin.tips.index') }}" class="text-on-surface-variant hover:text-primary transition">Kelola Tips</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-primary font-bold">Tambah Tips Baru</span>
            </div>
            <h1 class="font-display text-3xl text-primary tracking-tight font-bold">Tambah Tips Baru</h1>
            <p class="text-sm text-on-surface-variant mt-1 leading-relaxed">
                Tulis panduan teknik dapur, kiat gastronomi, atau artikel kuliner mendalam dengan format artikel editorial standar haute cuisine.
            </p>
        </div>
        
        <!-- Live Sync & Auto-save Status Pill -->
        <div class="flex flex-wrap items-center gap-3 bg-surface-container-low px-4 py-2.5 rounded-full shadow-sm self-start md:self-auto">
            <div class="flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-secondary"></span>
                </span>
                <span class="text-xs font-semibold text-secondary">Sistem Aktif</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tips.store') }}" enctype="multipart/form-data" class="flex flex-col gap-6">
        @csrf

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