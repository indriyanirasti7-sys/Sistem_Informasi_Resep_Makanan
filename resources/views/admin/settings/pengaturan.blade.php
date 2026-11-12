@extends('admin.layout')

@section('title', 'Pengaturan — Jelajah Rasa')
@section('breadcrumb', 'Pengaturan')

@section('content')

<header class="flex flex-col gap-1.5 mb-8 pt-8">
    <div class="flex items-center gap-2 text-on-surface-variant text-[11px] tracking-wider uppercase mb-1">
        <span>Portal Admin</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span>Jelajah Rasa</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Pengaturan</span>
    </div>
    <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Pengaturan</h1>
    <p class="text-sm text-on-surface-variant max-w-xl">
        Atur identitas situs dan akun administrator Anda dengan sentuhan estetika gastronomi khas Jelajah Rasa.
    </p>
</header>

{{-- NOTIFIKASI SUKSES --}}
@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-secondary-container text-on-secondary-container font-bold text-sm flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
@endif

{{-- NOTIFIKASI ERROR --}}
@if ($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-error-container text-on-error-container text-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-col w-full gap-6">

    {{-- MENU TAB --}}
    <div class="bg-surface-container-lowest p-2 lg:p-3 rounded-3xl shadow-sm flex flex-wrap sm:flex-nowrap gap-2 w-full">
        <button class="tab-btn flex flex-1 items-center justify-center gap-2 px-5 py-3 rounded-2xl font-label-lg text-label-lg transition-all whitespace-nowrap bg-primary-container text-surface-container-low shadow-sm font-semibold" id="tabBtn-umum" onclick="switchTab('umum')">
            <span class="material-symbols-outlined text-[20px]">tune</span>
            <span>Pengaturan Umum</span>
        </button>
        <button class="tab-btn flex flex-1 items-center justify-center gap-2 px-5 py-3 rounded-2xl font-label-lg text-label-lg transition-all whitespace-nowrap text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface" id="tabBtn-profil" onclick="switchTab('profil')">
            <span class="material-symbols-outlined text-[20px]">person</span>
            <span>Profil Admin</span>
        </button>
        <button class="tab-btn flex flex-1 items-center justify-center gap-2 px-5 py-3 rounded-2xl font-label-lg text-label-lg transition-all whitespace-nowrap text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface" id="tabBtn-keamanan" onclick="switchTab('keamanan')">
            <span class="material-symbols-outlined text-[20px]">security</span>
            <span>Keamanan</span>
        </button>
    </div>

    {{-- KONTEN TAB --}}
    <div class="w-full flex flex-col gap-8">
        
        {{-- ========================================== --}}
        {{-- TAB 1: UMUM (FORM SIMPAN PENGATURAN)       --}}
        {{-- ========================================== --}}
        <div class="tab-panel flex flex-col gap-8 w-full" id="tabContent-umum">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="flex flex-col gap-8 w-full">
                @csrf
                @method('PUT')

                {{-- Seksi 1: Identitas Situs --}}
                <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-6 w-full">
                    <div class="flex items-center gap-3 pb-1">
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                            <span class="material-symbols-outlined text-[22px]">domain</span>
                        </div>
                        <div>
                            <h2 class="font-display text-2xl text-primary font-bold">Identitas Situs</h2>
                            <p class="text-sm text-on-surface-variant">Nama dan gambaran utama yang tampil pada seluruh platform.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        {{-- TAGLINE --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="site_tagline">Tagline</label>
                            <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings['tagline'] ?? 'Inspirasi & Resep Kuliner') }}" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-primary" for="site_description">Deskripsi Singkat</label>
                                <span class="text-[11px] font-semibold text-secondary" id="charCounter">0 / 160</span>
                            </div>
                            <textarea id="site_description" name="site_description" rows="3" maxlength="160" oninput="updateCharCount()" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none">{{ old('site_description', $settings['description'] ?? 'Eksplorasi cita rasa haute cuisine berpadu dengan kekayaan rempah gastronomi Nusantara.') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="submit" class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- ========================================== --}}
        {{-- TAB 2: PROFIL ADMIN                        --}}
        {{-- ========================================== --}}
        <div class="tab-panel hidden flex-col gap-8 w-full" id="tabContent-profil">
            <form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data" class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-8 w-full">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[22px]">badge</span>
                    </div>
                    <div>
                        <h2 class="font-display text-2xl text-primary font-bold">Profil Administrator</h2>
                        <p class="text-sm text-on-surface-variant">Perbarui nama, email, dan foto profil akun Anda.</p>
                    </div>
                </div>

                {{-- KARTU PROFIL (DESAIN BARU) --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-surface-container-low to-surface-container-lowest border border-surface-container-high shadow-sm relative overflow-hidden">
                    
                    {{-- Ornamen Background --}}
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-primary-fixed/20 rounded-full blur-3xl pointer-events-none"></div>

                    {{-- Sisi Kiri: Avatar & Info Utama --}}
                    <div class="flex flex-col sm:flex-row items-center gap-6 z-10 w-full lg:w-auto">
                        {{-- Avatar & Tombol Edit --}}
                        <div class="relative shrink-0 group">
                            <div class="w-24 h-24 rounded-full overflow-hidden shadow-md ring-4 ring-surface-container-lowest flex items-center justify-center bg-primary">
                                <img id="avatarPreview" src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            {{-- Tombol Upload Avatar --}}
                            <label for="avatar" class="absolute bottom-1 right-1 w-8 h-8 bg-secondary text-white rounded-full flex items-center justify-center cursor-pointer shadow-md hover:bg-primary transition-colors border-2 border-surface-container-lowest">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            </label>
                        </div>

                        {{-- Teks Nama & Email --}}
                        <div class="flex flex-col text-center sm:text-left">
                            <span class="text-2xl font-bold text-primary font-display">{{ Auth::user()->name }}</span>
                            <span class="text-sm text-on-surface-variant font-medium mt-0.5">{{ Auth::user()->email }}</span>
                            <span class="inline-flex items-center justify-center sm:justify-start gap-1.5 mt-3 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold w-fit mx-auto sm:mx-0">
                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                {{ Auth::user()->role === 'admin' ? 'Super Admin' : 'User' }}
                            </span>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Info Tambahan (Mengisi Ruang Kosong) --}}
                    <div class="flex items-center gap-6 z-10 border-t lg:border-t-0 lg:border-l border-surface-container-high pt-5 lg:pt-0 lg:pl-8 w-full lg:w-auto justify-center lg:justify-start">
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase tracking-wider text-outline font-bold mb-1">Bergabung Sejak</span>
                            <span class="text-sm font-bold text-primary">{{ Auth::user()->created_at->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase tracking-wider text-outline font-bold mb-1">Status Akun</span>
                            <span class="text-sm font-bold text-secondary flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span> Aktif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Input Form --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="email">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high">
                    <button type="submit" class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- ========================================== --}}
        {{-- TAB 3: KEAMANAN (FORM GANTI PASSWORD)      --}}
        {{-- ========================================== --}}
        <div class="tab-panel hidden flex-col gap-8 w-full" id="tabContent-keamanan">
            <form action="{{ route('admin.settings.password') }}" method="POST" class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-8 w-full">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[22px]">lock_reset</span>
                    </div>
                    <div>
                        <h2 class="font-display text-2xl text-primary font-bold">Keamanan &amp; Kata Sandi</h2>
                        <p class="text-sm text-on-surface-variant">Perbarui kata sandi untuk melindungi integritas portal Anda.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start w-full">
                    {{-- KOLOM KIRI: Input Password --}}
                    <div class="flex flex-col gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="current_password">Kata Sandi Saat Ini</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" placeholder="Ketikkan sandi saat ini..." required
                                       class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                                <button type="button" onclick="togglePasswordVisibility('current_password', 'eyeIconCurrent')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIconCurrent">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="new_password">Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" oninput="checkPasswordStrength(this.value)" placeholder="Minimal 8 karakter unik..." required
                                       class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                                <button type="button" onclick="togglePasswordVisibility('new_password', 'eyeIconNew')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIconNew">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi kata sandi baru..." required
                                       class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                                <button type="button" onclick="togglePasswordVisibility('new_password_confirmation', 'eyeIconConfirm')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIconConfirm">visibility</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-start gap-3 pt-4 border-t border-surface-container-high">
                            <button type="submit" class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all w-full sm:w-auto flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">lock</span>
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Indikator Kekuatan --}}
                    <div class="bg-surface-container-low p-6 rounded-2xl border border-surface-container-high h-full flex flex-col justify-center">
                        <h3 class="font-bold text-primary mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">shield</span>
                            Panduan Keamanan
                        </h3>
                        
                        <div class="flex flex-col gap-2 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-[12px] text-on-surface-variant font-semibold">Kekuatan Kata Sandi:</span>
                                <span class="text-[12px] font-bold text-on-surface-variant" id="strengthLabel">Belum diisi</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 h-2 w-full">
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg1"></div>
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg2"></div>
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg3"></div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm" id="req-len">
                                <span class="material-symbols-outlined text-[20px] text-outline" id="icon-len">radio_button_unchecked</span>
                                <span>Minimal 8 karakter</span>
                            </div>
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm" id="req-num">
                                <span class="material-symbols-outlined text-[20px] text-outline" id="icon-num">radio_button_unchecked</span>
                                <span>Kombinasi huruf &amp; angka</span>
                            </div>
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm" id="req-sym">
                                <span class="material-symbols-outlined text-[20px] text-outline" id="icon-sym">radio_button_unchecked</span>
                                <span>Mengandung simbol (!@#$)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Set tab default saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        updateCharCount();
        
        // Cek jika ada error pada form password, tetap buka tab keamanan
        @if($errors->has('current_password') || $errors->has('new_password'))
            switchTab('keamanan');
        @endif
    });

    function switchTab(tabKey) {
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('hidden'));
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('flex'));
        
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
            btn.classList.add('text-on-surface-variant');
        });

        const selectedPanel = document.getElementById('tabContent-' + tabKey);
        const selectedBtn = document.getElementById('tabBtn-' + tabKey);

        if (selectedPanel && selectedBtn) {
            selectedPanel.classList.remove('hidden');
            selectedPanel.classList.add('flex');
            selectedBtn.classList.remove('text-on-surface-variant');
            selectedBtn.classList.add('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
        }
    }

    // Preview Foto Profil
    function previewAvatar(event) {
        const input = event.target;
        const preview = document.getElementById('avatarPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerText = 'visibility_off';
        } else {
            input.type = 'password';
            icon.innerText = 'visibility';
        }
    }

    function updateCharCount() {
        const desc = document.getElementById('site_description');
        const counter = document.getElementById('charCounter');
        if(desc && counter) {
            counter.innerText = `${desc.value.length} / 160`;
        }
    }

    function checkPasswordStrength(val) {
        const lenCheck = val.length >= 8;
        const numCheck = /[a-zA-Z]/.test(val) && /[0-9]/.test(val);
        const symCheck = /[^a-zA-Z0-9]/.test(val);

        updateReqUi('len', lenCheck);
        updateReqUi('num', numCheck);
        updateReqUi('sym', symCheck);

        let score = 0;
        if (lenCheck) score++;
        if (numCheck) score++;
        if (symCheck) score++;

        const seg1 = document.getElementById('barSeg1');
        const seg2 = document.getElementById('barSeg2');
        const seg3 = document.getElementById('barSeg3');
        const label = document.getElementById('strengthLabel');

        seg1.className = 'h-full rounded-full transition-colors bg-surface-variant';
        seg2.className = 'h-full rounded-full transition-colors bg-surface-variant';
        seg3.className = 'h-full rounded-full transition-colors bg-surface-variant';

        if (val.length === 0) {
            label.innerText = 'Belum diisi';
            label.className = 'text-[12px] font-bold text-on-surface-variant';
            return;
        }

        if (score === 1) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-error');
            label.innerText = 'Lemah'; label.className = 'text-[12px] font-bold text-error';
        } else if (score === 2) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-on-tertiary-container');
            seg2.classList.remove('bg-surface-variant'); seg2.classList.add('bg-on-tertiary-container');
            label.innerText = 'Sedang'; label.className = 'text-[12px] font-bold text-on-tertiary-container';
        } else if (score >= 3) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-secondary');
            seg2.classList.remove('bg-surface-variant'); seg2.classList.add('bg-secondary');
            seg3.classList.remove('bg-surface-variant'); seg3.classList.add('bg-secondary');
            label.innerText = 'Kuat'; label.className = 'text-[12px] font-bold text-secondary';
        }
    }

    function updateReqUi(key, passed) {
        const icon = document.getElementById('icon-' + key);
        const row = document.getElementById('req-' + key);
        if (passed) {
            icon.innerText = 'check_circle';
            icon.className = 'material-symbols-outlined text-[20px] text-secondary';
            row.className = 'flex items-center gap-2 text-secondary text-sm font-semibold';
        } else {
            icon.innerText = 'radio_button_unchecked';
            icon.className = 'material-symbols-outlined text-[20px] text-outline';
            row.className = 'flex items-center gap-2 text-on-surface-variant text-sm';
        }
    }
</script>
@endpush