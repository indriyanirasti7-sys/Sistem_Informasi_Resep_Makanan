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
            <!-- Admin Internal Notes Section -->
    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-surface-container-high pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">lock_person</span>
                </div>
                <div>
                    <h2 class="text-xl text-primary font-bold">Catatan Internal Staf Admin</h2>
                    <p class="text-sm text-on-surface-variant">Dokumentasi rahasia operasional untuk tim redaksi.</p>
                </div>
            </div>
        </div>
        
        <!-- History List -->
        <div class="flex flex-col gap-3" id="admin-notes-container">
            <!-- Note 1 -->
            <div class="p-4 rounded-xl bg-surface-container-low flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 font-bold text-xs">A</div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-sm font-bold text-primary">Admin</span>
                            <span class="px-2 py-0.5 rounded-full bg-primary-container text-white text-[10px]">Super Admin</span>
                            <span class="text-outline text-[11px]">• {{ now()->translatedFormat('d M Y') }}</span>
                        </div>
                        <p class="text-sm text-on-surface mt-1">Pengguna sangat aktif dan berwawasan luas dalam memberikan masukan teknik pembuatan bumbu dasar tradisional.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Note Form -->
        <div class="flex flex-col gap-3 pt-2">
            <label class="text-sm font-bold text-primary flex items-center gap-1.5" for="adminNoteInput">
                <span class="material-symbols-outlined text-[16px]">edit_note</span> Tambahkan Catatan Baru:
            </label>
            <textarea id="adminNoteInput" rows="3" placeholder="Tuliskan catatan administratif baru, verifikasi manual..."
                      class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface text-sm outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none"></textarea>
            <div class="flex items-center justify-between flex-wrap gap-3">
                <span class="text-[11px] text-outline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">info</span> Catatan akan dicatat bersama identitas Anda.
                </span>
                <button type="button" id="btnSaveNote" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition-all">
                    <span class="material-symbols-outlined text-[18px]">save</span> Simpan Catatan
                </button>
            </div>
        </div>
    </div>
        
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
        
                <!-- RIGHT COLUMN: Linimasa Aktivitas Terkini (7 cols) -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm flex flex-col h-full">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-surface-container-high">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">history</span>
                        </span>
                        <h2 class="text-lg text-primary font-bold">Linimasa Aktivitas</h2>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="relative pl-6 pt-6 flex flex-col gap-6 flex-1">
                    <div class="absolute left-2.5 top-8 bottom-4 w-0.5 bg-surface-container-highest"></div>
                    
                    <!-- Item 1 -->
                    <div class="relative flex items-start gap-4 group">
                        <div class="absolute -left-[22px] top-1 w-5 h-5 rounded-full bg-tertiary-fixed flex items-center justify-center ring-4 ring-surface-container-lowest">
                            <span class="w-2 h-2 rounded-full bg-tertiary-container"></span>
                        </div>
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-xs font-bold text-tertiary-container uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">bookmark</span> Menyimpan Resep
                                </span>
                                <span class="text-[11px] text-outline">Hari ini</span>
                            </div>
                            <p class="text-sm text-on-surface">Menyimpan resep <strong class="text-primary">Rendang Daging Sapi Karamel</strong> ke koleksi pribadi.</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="relative flex items-start gap-4 group">
                        <div class="absolute -left-[22px] top-1 w-5 h-5 rounded-full bg-secondary-fixed flex items-center justify-center ring-4 ring-surface-container-lowest">
                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        </div>
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-xs font-bold text-secondary uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">rate_review</span> Memberikan Ulasan
                                </span>
                                <span class="text-[11px] text-outline">Kemarin</span>
                            </div>
                            <div class="flex items-center gap-1 mb-1 text-tertiary-container">
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <p class="text-sm text-on-surface-variant italic border-l-2 border-secondary/40 pl-2">"Bumbu meresap sempurna dan tekstur daging sangat lembut!"</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="relative flex items-start gap-4 group">
                        <div class="absolute -left-[22px] top-1 w-5 h-5 rounded-full bg-primary-fixed flex items-center justify-center ring-4 ring-surface-container-lowest">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                        </div>
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">how_to_reg</span> Pendaftaran Akun
                                </span>
                                <span class="text-[11px] text-outline">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-on-surface">Berhasil membuat akun di portal L'Art de Cuisine.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

</div>
@endsection