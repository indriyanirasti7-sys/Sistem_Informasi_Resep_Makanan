@extends('admin.layout')

@section('title', 'Detail User — Griya Rasa')
@section('breadcrumb', 'Detail User')

@section('content')

<div class="w-full mx-auto pb-12">

    {{-- ========== HEADER ========== --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Data User
        </a>

        {{-- JUDUL --}}
        <div class="flex items-center gap-2 mt-2">
            <span class="material-symbols-outlined text-[28px] text-primary">badge</span>
            <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">
                Detail Pengguna: {{ $user->name }}
            </h1>
        </div>

        <p class="text-sm text-on-surface-variant mt-1">
            Tinjau informasi profil dan statistik interaksi pengguna.
        </p>
    </header>

    <!-- User Profile Header Master Card -->
    <div class="bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm mb-6 relative overflow-hidden">
        <!-- Ornamen Background -->
        <div class="absolute -right-20 -top-24 w-80 h-80 rounded-full bg-surface-container-low/40 pointer-events-none blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-8">
            
            <!-- Kiri: Avatar & Info -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="relative shrink-0">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full p-1 bg-gradient-to-tr from-primary via-secondary to-primary-fixed-dim shadow-sm overflow-hidden">
                        @php
                            $avatarClean = null;
                            if ($user->avatar) {
                                $avatarClean = str_replace(['uploads/avatars/', 'uploads/', 'storage/avatars/', 'storage/', 'avatars/'], '', $user->avatar);
                            }
                        @endphp

                        @if ($avatarClean && file_exists(public_path('uploads/avatars/' . $avatarClean)))
                            <img src="{{ asset('uploads/avatars/' . $avatarClean) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @elseif ($avatarClean && file_exists(public_path('uploads/' . $avatarClean)))
                            <img src="{{ asset('uploads/' . $avatarClean) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-surface-container flex items-center justify-center text-4xl font-bold text-primary">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="absolute bottom-1 right-1 w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center shadow-md border-2 border-surface-container-lowest" title="Akun Terverifikasi">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                </div>
                
                <div class="flex flex-col gap-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="font-display text-3xl text-primary tracking-tight font-bold">{{ $user->name }}</h2>
                        <span class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant text-[10px] font-bold tracking-wider">#USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="px-3 py-1 rounded-full bg-surface-container-low text-primary-container text-xs flex items-center gap-1.5 font-bold shadow-sm">
                            <span class="material-symbols-outlined text-[16px] text-secondary">workspace_premium</span>
                            Peran: {{ ucfirst($user->role) }}
                        </span>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Status: Aktif
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-2 text-on-surface-variant text-sm font-medium">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-outline">mail</span>
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Statistik Cepat (3 Card) -->
            <div class="grid grid-cols-3 gap-2 sm:gap-4 shrink-0 mt-4 xl:mt-0">
                <!-- Card Koleksi Resep -->
                <div class="bg-surface-container-low p-3 sm:p-4 rounded-2xl flex flex-col xl:flex-row items-center gap-2 xl:gap-4 border border-surface-container-high shadow-sm min-w-[100px] xl:min-w-[150px]">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary shrink-0">
                        <span class="material-symbols-outlined text-[18px] sm:text-[24px]">bookmark</span>
                    </div>
                    <div class="flex flex-col text-center xl:text-left">
                        <span class="text-2xl xl:text-3xl font-display font-bold text-primary leading-none">{{ $user->bookmarks_count ?? 0 }}</span>
                        <span class="text-[9px] sm:text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-1">Resep</span>
                    </div>
                </div>
                <!-- Card Ulasan Rasa -->
                <div class="bg-surface-container-low p-3 sm:p-4 rounded-2xl flex flex-col xl:flex-row items-center gap-2 xl:gap-4 border border-surface-container-high shadow-sm min-w-[100px] xl:min-w-[150px]">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-tertiary-container/15 flex items-center justify-center text-tertiary-container shrink-0">
                        <span class="material-symbols-outlined text-[18px] sm:text-[24px]">rate_review</span>
                    </div>
                    <div class="flex flex-col text-center xl:text-left">
                        <span class="text-2xl xl:text-3xl font-display font-bold text-primary leading-none">{{ $user->ratings_count ?? 0 }}</span>
                        <span class="text-[9px] sm:text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-1">Ulasan</span>
                    </div>
                </div>
                <!-- Card Tips Disimpan -->
                <div class="bg-surface-container-low p-3 sm:p-4 rounded-2xl flex flex-col xl:flex-row items-center gap-2 xl:gap-4 border border-surface-container-high shadow-sm min-w-[100px] xl:min-w-[150px]">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-primary/15 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px] sm:text-[24px]">lightbulb</span>
                    </div>
                    <div class="flex flex-col text-center xl:text-left">
                        <span class="text-2xl xl:text-3xl font-display font-bold text-primary leading-none">{{ $user->tip_bookmarks_count ?? 0 }}</span>
                        <span class="text-[9px] sm:text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-1">Tips</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Two-Column User Details & Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        
        <!-- LEFT COLUMN: Account Details & Preferences (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            
            <!-- Box 1: Informasi Akun & Metadata -->
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between pb-3 border-b border-surface-container-high">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                        </span>
                        <h2 class="text-lg text-primary font-bold">Informasi Akun</h2>
                    </div>
                </div>
                
                <div class="flex flex-col gap-3 text-sm">
                    <div class="p-3.5 rounded-2xl bg-surface-container-low flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-outline">calendar_today</span>
                            <span>Tanggal Pendaftaran</span>
                        </div>
                        <span class="font-semibold text-on-surface text-right">{{ $user->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-surface-container-low flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[18px] text-outline">verified</span>
                            <span>Status Email</span>
                        </div>
                        <div class="text-right flex items-center gap-2">
                            @if ($user->email_verified_at)
                                <span class="font-bold text-secondary">Terverifikasi</span>
                            @else
                                <span class="font-bold text-error">Belum Verifikasi</span>
                                <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2.5 py-1 bg-primary text-white text-xs font-bold rounded-full hover:bg-primary-container transition">
                                        Verifikasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Ringkasan Interaksi -->
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center gap-2.5 pb-3 border-b border-surface-container-high">
                    <span class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[18px]">local_dining</span>
                    </span>
                    <h2 class="text-lg text-primary font-bold">Interaksi & Preferensi</h2>
                </div>
                
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-surface-container-low p-3 rounded-2xl flex flex-col items-center">
                        <span class="material-symbols-outlined text-[20px] text-tertiary-container mb-1">bookmark</span>
                        <span class="text-lg font-bold text-primary">{{ $user->bookmarks_count ?? 0 }}</span>
                        <span class="text-[10px] text-on-surface-variant font-semibold leading-tight mt-1">Resep<br>Disimpan</span>
                    </div>
                    <div class="bg-surface-container-low p-3 rounded-2xl flex flex-col items-center">
                        <span class="material-symbols-outlined text-[20px] text-secondary mb-1">rate_review</span>
                        <span class="text-lg font-bold text-primary">{{ $user->ratings_count ?? 0 }}</span>
                        <span class="text-[10px] text-on-surface-variant font-semibold leading-tight mt-1">Ulasan<br>Diberikan</span>
                    </div>
                    <div class="bg-surface-container-low p-3 rounded-2xl flex flex-col items-center">
                        <span class="material-symbols-outlined text-[20px] text-primary mb-1">lightbulb</span>
                        <span class="text-lg font-bold text-primary">{{ $user->tip_bookmarks_count ?? 0 }}</span>
                        <span class="text-[10px] text-on-surface-variant font-semibold leading-tight mt-1">Tips<br>Disimpan</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- RIGHT COLUMN: Linimasa Aktivitas Terkini (7 cols) -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm flex flex-col h-full">
                
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
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-2xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[11px] font-bold text-tertiary-container uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">bookmark</span> Menyimpan Resep
                                </span>
                                <span class="text-[11px] text-outline font-semibold">Hari ini</span>
                            </div>
                            <p class="text-sm text-on-surface">Menyimpan resep <strong class="text-primary">Rendang Daging Sapi Karamel</strong> ke koleksi pribadi.</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="relative flex items-start gap-4 group">
                        <div class="absolute -left-[22px] top-1 w-5 h-5 rounded-full bg-secondary-fixed flex items-center justify-center ring-4 ring-surface-container-lowest">
                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        </div>
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-2xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[11px] font-bold text-secondary uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">rate_review</span> Memberikan Ulasan
                                </span>
                                <span class="text-[11px] text-outline font-semibold">Kemarin</span>
                            </div>
                            <div class="flex items-center gap-1 mb-2 text-tertiary-container">
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
                        <div class="flex-1 bg-surface-container-low/70 p-4 rounded-2xl">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[11px] font-bold text-primary uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">how_to_reg</span> Pendaftaran Akun
                                </span>
                                <span class="text-[11px] text-outline font-semibold">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <p class="text-sm text-on-surface">Berhasil membuat akun di portal Griya Rasa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========== BOTTOM ACTIONS (KANAN BAWAH) ========== --}}
    <div class="flex items-center justify-between pt-6 border-t border-surface-container-high mt-2">
        
        {{-- Kiri Bawah: Kembali --}}
        <a href="{{ route('admin.users.index') }}"
           class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
            Batal 
        </a>

        {{-- Kanan Bawah: Aksi Modifikasi --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Tangguhkan Akun --}}
            <button type="button" id="btnSuspend" class="flex items-center gap-2 px-6 py-3 rounded-full bg-error-container text-error text-sm font-bold hover:bg-error hover:text-white transition-all">
                <span class="material-symbols-outlined text-[18px]">block</span>
                Tangguhkan Akun
            </button>

            {{-- Tombol Ubah Peran --}}
            <button type="button" id="btnRoleModal" class="flex items-center gap-2 px-8 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                Ubah Peran
            </button>
        </div>
    </div>

</div>

<!-- ============================================== -->
<!-- MODAL: Ubah Peran (Role)                       -->
<!-- ============================================== -->
<div id="roleModal" class="fixed inset-0 bg-inverse-surface/40 backdrop-blur-sm z-50 items-center justify-center p-4 hidden">
    <div class="bg-surface-container-lowest max-w-lg w-full rounded-3xl p-6 sm:p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col gap-6">
        <div class="flex items-center justify-between pb-2 border-b border-surface-container-high">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[22px]">manage_accounts</span>
                </span>
                <div>
                    <h3 class="text-xl text-primary font-bold">Ubah Peran Pengguna</h3>
                    <p class="text-xs text-outline">Kelola izin untuk {{ $user->name }}</p>
                </div>
            </div>
            <button type="button" id="btnCloseModal" class="w-8 h-8 rounded-full hover:bg-surface-container flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="flex flex-col gap-4">
            @csrf @method('PUT')
            <div class="flex flex-col gap-3 text-sm">
                <label class="flex items-center gap-3 p-4 rounded-2xl bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                    <input type="radio" name="role" value="user" class="w-4 h-4 accent-primary" {{ $user->role === 'user' ? 'checked' : '' }}>
                    <div class="flex-1">
                        <p class="font-bold text-primary">User (Griya Rasa)</p>
                        <p class="text-xs text-on-surface-variant">Dapat menyimpan resep, memberi ulasan, mengunggah foto kreasi.</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-2xl bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
                    <input type="radio" name="role" value="admin" class="w-4 h-4 accent-primary" {{ $user->role === 'admin' ? 'checked' : '' }}>
                    <div class="flex-1">
                        <p class="font-bold text-primary">Admin Gastronomi</p>
                        <p class="text-xs text-on-surface-variant">Akses penuh pengelolaan artikel, kategori resep, dan direktori pengguna.</p>
                    </div>
                </label>
            </div>
            
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high mt-2">
                <button type="button" id="btnCancelModal" class="px-6 py-2.5 rounded-full text-on-surface-variant font-bold text-sm hover:bg-surface-container transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-full bg-primary text-white font-bold text-sm shadow-sm hover:bg-primary-container transition-colors">Terapkan Peran</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL: Konfirmasi Tangguhkan Akun              -->
<!-- ============================================== -->
<div id="suspendModal" class="fixed inset-0 bg-inverse-surface/40 backdrop-blur-sm z-50 items-center justify-center p-4 hidden">
    <div class="bg-surface-container-lowest max-w-md w-full rounded-3xl p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col items-center text-center">
        <div class="w-16 h-16 rounded-full bg-error-container text-error flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-[32px]">warning</span>
        </div>

        <h3 class="font-display text-2xl text-primary font-bold">Tangguhkan Akun?</h3>
        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
            Akun <strong class="text-primary font-bold">{{ $user->name }}</strong> tidak akan bisa mengakses portal sementara waktu.
        </p>

        <div class="flex items-center gap-3 mt-8 w-full">
            <button type="button" id="btnCancelSuspend" class="flex-1 py-2.5 rounded-full bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition">
                Batal
            </button>
            <button type="button" id="btnConfirmSuspend" class="flex-1 py-2.5 rounded-full bg-error text-white font-bold text-sm hover:bg-error/90 transition">
                Ya, Tangguhkan
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Modal Ubah Peran ---
        const roleModal = document.getElementById('roleModal');
        const btnRole = document.getElementById('btnRoleModal');
        const btnClose = document.getElementById('btnCloseModal');
        const btnCancel = document.getElementById('btnCancelModal');

        if (btnRole && roleModal) {
            btnRole.addEventListener('click', () => {
                roleModal.classList.remove('hidden');
                roleModal.classList.add('flex');
            });
        }
        function closeRoleModal() { 
            if (roleModal) {
                roleModal.classList.add('hidden'); 
                roleModal.classList.remove('flex'); 
            }
        }
        if (btnClose) btnClose.addEventListener('click', closeRoleModal);
        if (btnCancel) btnCancel.addEventListener('click', closeRoleModal);

        // --- Modal Tangguhkan Akun ---
        const suspendModal = document.getElementById('suspendModal');
        const btnSuspend = document.getElementById('btnSuspend');
        const btnCancelSuspend = document.getElementById('btnCancelSuspend');
        const btnConfirmSuspend = document.getElementById('btnConfirmSuspend');

        if (btnSuspend && suspendModal) {
            btnSuspend.addEventListener('click', () => {
                suspendModal.classList.remove('hidden');
                suspendModal.classList.add('flex');
            });
        }
        function closeSuspendModal() {
            if (suspendModal) {
                suspendModal.classList.add('hidden');
                suspendModal.classList.remove('flex');
            }
        }
        if (btnCancelSuspend) btnCancelSuspend.addEventListener('click', closeSuspendModal);

        if (btnConfirmSuspend) {
            btnConfirmSuspend.addEventListener('click', () => {
                // Simulasi aksi penangguhan
                btnSuspend.classList.remove('bg-error-container', 'text-error');
                btnSuspend.classList.add('bg-surface-container-highest', 'text-outline');
                btnSuspend.innerHTML = '<span class="material-symbols-outlined text-[18px]">check_circle</span> Ditangguhkan';
                closeSuspendModal();
            });
        }
    });
</script>
@endpush