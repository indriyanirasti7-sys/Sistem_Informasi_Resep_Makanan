@extends('admin.layout')

@section('title', 'Detail User — L\'Art de Cuisine')
@section('breadcrumb', 'Detail User')

@section('content')

<div class="flex flex-col w-full pb-12 pt-6">

    <!-- Top Admin Action & Breadcrumb Navigation Bar -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-on-surface-variant text-xs font-semibold">
                <span class="hover:text-primary transition-colors cursor-pointer">Portal Admin</span>
                <span class="text-outline-variant">/</span>
                <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors cursor-pointer">Data User</a>
                <span class="text-outline-variant">/</span>
                <span class="text-primary">Detail Profil Pengguna</span>
            </div>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-[10px] uppercase tracking-widest text-secondary font-bold px-2 py-0.5 rounded-full bg-secondary-container/40">ID Klien</span>
                <span class="text-sm font-semibold text-on-surface-variant font-mono">#USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- Quick Action Pills -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-surface-container-lowest text-primary text-xs font-bold shadow-sm hover:bg-surface-container transition-all">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>Kembali ke Data User</span>
            </a>
            <button type="button" id="btnRoleModal" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary-container text-white text-xs font-bold shadow-sm hover:bg-primary transition-all">
                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                <span>Ubah Peran / Role</span>
            </button>
            <button type="button" id="btnSuspend" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-error-container/60 text-error text-xs font-bold hover:bg-error-container transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">block</span>
                <span>Tangguhkan Akun</span>
            </button>
        </div>
    </div>

    <!-- User Profile Header Master Card -->
    <div class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm mb-6 relative overflow-hidden">
        <div class="absolute -right-20 -top-24 w-80 h-80 rounded-full bg-surface-container-low/40 pointer-events-none blur-3xl"></div>
        <div class="absolute right-32 top-8 opacity-[0.03] pointer-events-none hidden md:block">
            <span class="material-symbols-outlined text-[160px] text-primary">restaurant_menu</span>
        </div>
        
        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-8">
            <!-- Left Avatar & Persona -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="relative shrink-0">
                    <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-tr from-primary via-secondary to-primary-fixed-dim shadow-sm">
                        <div class="w-full h-full rounded-full bg-surface-container flex items-center justify-center text-4xl font-bold text-primary">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="absolute bottom-1 right-1 w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center shadow-md" title="Akun Terverifikasi">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                </div>
                
                <div class="flex flex-col gap-1.5">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="font-display text-3xl text-primary tracking-tight font-bold">{{ $user->name }}</h1>
                        <span class="px-3 py-1 rounded-full bg-surface-container-low text-primary-container text-xs flex items-center gap-1.5 font-medium shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-secondary">workspace_premium</span>
                            Peran: {{ ucfirst($user->role) }}
                        </span>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Status: Aktif
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-1 text-on-surface-variant text-xs">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-outline">mail</span>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Fast Engagement Counters -->
            <div class="flex items-center gap-4 bg-surface-container-low p-4 rounded-2xl shrink-0">
                <div class="text-center px-3">
                    <p class="text-2xl text-primary font-bold">{{ $user->bookmarks_count ?? 0 }}</p>
                    <p class="text-[11px] text-on-surface-variant mt-0.5">Koleksi Resep</p>
                </div>
                <div class="h-10 w-px bg-outline-variant/30"></div>
                <div class="text-center px-3">
                    <p class="text-2xl text-primary font-bold">{{ $user->ratings_count ?? 0 }}</p>
                    <p class="text-[11px] text-on-surface-variant mt-0.5">Ulasan Rasa</p>
                </div>
            </div>
        </div>
    </div>

        <!-- Two-Column User Details & Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        
        <!-- LEFT COLUMN: Account Details & Preferences (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            
            <!-- Box 1: Informasi Akun & Metadata -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                        </span>
                        <h2 class="text-lg text-primary font-bold">Informasi Akun</h2>
                    </div>
                </div>
                
                <div class="flex flex-col gap-3 text-sm">
                    <div class="p-3 rounded-xl bg-surface-container-low/50 flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-outline">calendar_today</span>
                            <span>Tanggal Pendaftaran</span>
                        </div>
                        <span class="font-semibold text-on-surface text-right">{{ $user->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="p-3 rounded-xl bg-surface-container-low/50 flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-outline">verified</span>
                            <span>Status Email</span>
                        </div>
                        <div class="text-right">
                            <span class="font-semibold text-secondary block">{{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Ringkasan Interaksi -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center gap-2.5 pb-2 border-b border-surface-container-high">
                    <span class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">local_dining</span>
                    </span>
                    <h2 class="text-lg text-primary font-bold">Interaksi & Preferensi</h2>
                </div>
                
                <div class="grid grid-cols-2 gap-3 text-center">
                    <div class="bg-surface-container-low p-3 rounded-xl flex flex-col items-center">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-container mb-1">bookmark</span>
                        <span class="text-lg font-bold text-primary">{{ $user->bookmarks_count ?? 0 }}</span>
                        <span class="text-[11px] text-on-surface-variant">Resep Disimpan</span>
                    </div>
                    <div class="bg-surface-container-low p-3 rounded-xl flex flex-col items-center">
                        <span class="material-symbols-outlined text-[20px] text-secondary mb-1">rate_review</span>
                        <span class="text-lg font-bold text-primary">{{ $user->ratings_count ?? 0 }}</span>
                        <span class="text-[11px] text-on-surface-variant">Ulasan Diberikan</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- RIGHT COLUMN akan ditambahkan di tahap 3 -->
    </div>

</div>
@endsection