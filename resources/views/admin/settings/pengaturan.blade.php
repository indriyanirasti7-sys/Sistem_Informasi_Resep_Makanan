@extends('admin.layout')

@section('title', 'Pengaturan — L\'Art de Cuisine')
@section('breadcrumb', 'Pengaturan')

@section('content')

<header class="flex flex-col gap-1.5 mb-8 pt-8">
    <div class="flex items-center gap-2 text-on-surface-variant text-[11px] tracking-wider uppercase mb-1">
        <span>Portal Admin</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span>L'Art de Cuisine</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Pengaturan</span>
    </div>
    <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Pengaturan</h1>
    <p class="text-sm text-on-surface-variant max-w-xl">
        Atur identitas situs dan akun administrator Anda dengan sentuhan estetika gastronomi khas L'Art de Cuisine.
    </p>
</header>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    {{-- KIRI: Navigasi Tab --}}
    <aside class="lg:col-span-3 w-full">
        <div class="bg-surface-container-lowest p-3 lg:p-4 rounded-3xl shadow-sm flex lg:flex-col gap-2 overflow-x-auto">
            <button class="tab-btn flex items-center gap-3 px-5 py-3 rounded-full font-label-lg text-label-lg transition-all whitespace-nowrap w-full text-left bg-primary-container text-surface-container-low shadow-sm font-semibold" id="tabBtn-umum" onclick="switchTab('umum')">
                <span class="material-symbols-outlined text-[20px]">tune</span>
                <span>Pengaturan Umum</span>
            </button>
            <button class="tab-btn flex items-center gap-3 px-5 py-3 rounded-full font-label-lg text-label-lg transition-all whitespace-nowrap w-full text-left text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface" id="tabBtn-profil" onclick="switchTab('profil')">
                <span class="material-symbols-outlined text-[20px]">person</span>
                <span>Profil Admin</span>
            </button>
            <button class="tab-btn flex items-center gap-3 px-5 py-3 rounded-full font-label-lg text-label-lg transition-all whitespace-nowrap w-full text-left text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface" id="tabBtn-keamanan" onclick="switchTab('keamanan')">
                <span class="material-symbols-outlined text-[20px]">security</span>
                <span>Keamanan</span>
            </button>
        </div>
    </aside>

    {{-- KANAN: Konten Tab --}}
    <section class="lg:col-span-9 w-full flex flex-col gap-8">
        
        {{-- TAB 1: UMUM --}}
        <div class="tab-panel flex flex-col gap-8" id="tabContent-umum">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
                <div class="xl:col-span-8 flex flex-col gap-8">
                    {{-- Seksi 1: Identitas Situs --}}
                    <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-6">
                        <div class="flex items-center gap-3 pb-1">
                            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                                <span class="material-symbols-outlined text-[18px]">domain</span>
                            </div>
                            <div>
                                <h2 class="font-display text-xl text-primary font-bold">Identitas Situs</h2>
                                <p class="text-sm text-on-surface-variant">Nama dan gambaran utama yang tampil pada seluruh platform.</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="inputSiteName">Nama Situs</label>
                            <input type="text" id="inputSiteName" oninput="updateHeaderPreview()" value="L'Art de Cuisine" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="inputSiteTagline">Tagline</label>
                            <input type="text" id="inputSiteTagline" oninput="updateHeaderPreview()" value="Inspirasi & Resep Kuliner" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                            <span class="text-[11px] text-on-surface-variant">Tampil di bawah nama situs pada header portal publik.</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-primary" for="inputSiteDesc">Deskripsi Singkat</label>
                                <span class="text-[11px] font-semibold text-secondary" id="charCounter">86 / 160</span>
                            </div>
                            <textarea id="inputSiteDesc" rows="3" maxlength="160" oninput="updateCharCount()" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none">Eksplorasi cita rasa haute cuisine berpadu dengan kekayaan rempah gastronomi Nusantara.</textarea>
                        </div>
                    </div>

                    {{-- Seksi 2: Logo & Favicon --}}
                    <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                                <span class="material-symbols-outlined text-[18px]">imagesmode</span>
                            </div>
                            <div>
                                <h2 class="font-display text-xl text-primary font-bold">Logo &amp; Favicon</h2>
                                <p class="text-sm text-on-surface-variant">Aset grafis identitas visual untuk header dan browser tab.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-3 p-5 rounded-2xl bg-surface-container-low">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-primary">Logo Situs</span>
                                    <span class="text-[11px] text-secondary bg-secondary-container px-2.5 py-0.5 rounded-full">Aktif</span>
                                </div>
                                <div class="relative w-full h-36 rounded-xl bg-surface-container-lowest flex flex-col items-center justify-center p-4 shadow-sm overflow-hidden group">
                                    <div class="flex flex-col items-center justify-center gap-1.5 transition-transform duration-300 group-hover:scale-105">
                                        <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewbox="0 0 100 100">
                                            <path d="M 50 10 C 26 10 12 28 12 52 C 12 74 30 88 50 88 C 70 88 88 74 88 52 C 88 32 76 16 60 12"></path>
                                            <path d="M 50 88 C 45 76 34 68 28 62"></path>
                                            <path d="M 38 78 C 32 84 24 84 20 80"></path>
                                            <path d="M 50 88 C 55 76 66 68 72 62"></path>
                                            <path d="M 62 78 C 68 84 76 84 80 80"></path>
                                            <path d="M 35 60 C 26 60 25 45 34 40 C 33 26 50 25 55 35 C 65 25 76 36 74 46 C 80 50 78 60 70 60 Z"></path>
                                            <path d="M 36 60 L 69 60 L 68 66 L 37 66 Z"></path>
                                            <path d="M 52 38 L 52 50"></path>
                                            <path d="M 48 38 L 48 45"></path>
                                            <path d="M 56 38 L 56 45"></path>
                                        </svg>
                                        <span class="font-display text-[13px] tracking-tight text-primary font-bold">L'Art de Cuisine</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 pt-1">
                                    <button class="flex-1 py-2 px-3 rounded-full bg-primary-container text-surface-container-low font-bold text-xs hover:bg-primary transition-all text-center" type="button">Ganti Logo</button>
                                    <button class="py-2 px-3 rounded-full text-error hover:bg-error-container font-bold text-xs transition-all" type="button">Hapus</button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 p-5 rounded-2xl bg-surface-container-low">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-primary">Favicon</span>
                                    <span class="text-[11px] text-on-surface-variant">32 × 32 px</span>
                                </div>
                                <div class="w-full h-36 rounded-xl bg-surface-container-lowest flex items-center justify-center p-4 shadow-sm">
                                    <div class="flex items-center gap-3 bg-surface-container-high px-4 py-2 rounded-xl">
                                        <div class="w-9 h-9 rounded-lg bg-primary-container flex items-center justify-center text-surface-container-low shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">restaurant</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[11px] text-primary font-bold leading-tight">Tab Browser</span>
                                            <span class="text-[10px] text-on-surface-variant">favicon.ico</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 pt-1">
                                    <button class="w-full py-2 px-4 rounded-full bg-surface-container-high text-primary hover:bg-surface-dim font-bold text-xs transition-all text-center" type="button">Ganti Favicon</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi Tab Umum --}}
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button class="px-7 py-3 rounded-full bg-transparent border border-primary-container text-primary text-sm font-bold hover:bg-primary/5 transition-all" type="button">Batal</button>
                        <button class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all" type="button">Simpan Pengaturan</button>
                    </div>
                </div>

                {{-- KOLOM KANAN: Live Preview Header --}}
                <div class="xl:col-span-4 sticky top-28 flex flex-col gap-4">
                    <div class="bg-surface-container-lowest p-6 rounded-3xl shadow-sm flex flex-col gap-4">
                        <div class="flex items-center justify-between pb-2">
                            <div class="flex items-center gap-2 text-primary font-bold">
                                <span class="material-symbols-outlined text-[20px] text-secondary">visibility</span>
                                <span class="text-base">Pratinjau Header</span>
                            </div>
                            <span class="text-[11px] text-secondary bg-secondary-container px-2.5 py-0.5 rounded-full font-bold">Live Synced</span>
                        </div>
                        <div class="rounded-2xl bg-surface-container-low p-4 shadow-inner flex flex-col gap-4">
                            <div class="flex items-center justify-between bg-surface-container px-3 py-1.5 rounded-full">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-error/60"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-tertiary-fixed-dim"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                </div>
                                <span class="text-[10px] text-on-surface-variant tracking-wider">https://lartdecuisine.id</span>
                            </div>
                            <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-surface-container-low shadow-sm">
                                            <span class="material-symbols-outlined text-[18px]">restaurant_menu</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-display text-[15px] font-bold text-primary leading-tight" id="previewHeaderTitle">L'Art de Cuisine</span>
                                            <span class="text-[10px] text-secondary font-medium tracking-wide" id="previewHeaderTagline">Inspirasi & Resep Kuliner</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-surface rounded-xl flex flex-col gap-1 shadow-sm">
                                <p class="text-[12px] text-on-surface-variant leading-relaxed line-clamp-3" id="previewHeaderDesc">
                                    Eksplorasi cita rasa haute cuisine berpadu dengan kekayaan rempah gastronomi Nusantara.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 2: PROFIL ADMIN --}}
        <div class="tab-panel hidden flex flex-col gap-8" id="tabContent-profil">
            <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-8 max-w-4xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                        </div>
                        <div>
                            <h2 class="font-display text-xl text-primary font-bold">Profil Administrator</h2>
                            <p class="text-sm text-on-surface-variant">Informasi identitas personal dan kredensial akses studio Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-2xl bg-surface-container-low">
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-full overflow-hidden shadow-sm ring-4 ring-surface-container-lowest flex items-center justify-center bg-primary">
                            <img alt="Avatar" class="w-full h-full object-cover" id="avatarImage" src="https://ui-avatars.com/api/?name=Chef+Antoine&background=5a3a22&color=fff&size=256"/>
                            <div class="hidden font-display text-3xl text-surface-container-low font-bold" id="avatarFallback">AL</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center sm:items-start gap-2 text-center sm:text-left flex-1">
                        <div class="flex flex-col">
                            <h3 class="font-display text-xl text-primary font-bold" id="profileNameDisplay">Chef Antoine Laurent</h3>
                            <span class="text-[11px] text-secondary font-semibold">antoine@lartdecuisine.id</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary">Nama Lengkap</label>
                        <input type="text" id="adminFullName" value="Chef Antoine Laurent" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none"/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary">Alamat Email</label>
                        <input type="email" id="adminEmail" value="antoine@lartdecuisine.id" class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3: KEAMANAN (VERSI 5) --}}
        <div class="tab-panel hidden flex flex-col gap-8" id="tabContent-keamanan">
            <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-8 max-w-3xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                    </div>
                    <div>
                        <h2 class="font-display text-xl text-primary font-bold">Keamanan &amp; Kata Sandi</h2>
                        <p class="text-sm text-on-surface-variant">Perbarui kata sandi untuk melindungi integritas portal gastronomi Anda.</p>
                    </div>
                </div>

                <form class="flex flex-col gap-6" onsubmit="event.preventDefault();">
                    
                    {{-- Kata Sandi Saat Ini --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="currentPassword">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input type="password" id="currentPassword" placeholder="Ketikkan sandi saat ini..." required
                                   class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                            <button type="button" onclick="togglePasswordVisibility('currentPassword', 'eyeIconCurrent')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]" id="eyeIconCurrent">visibility</span>
                            </button>
                        </div>
                    </div>

                    {{-- Kata Sandi Baru --%}
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="newPassword">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="newPassword" oninput="checkPasswordStrength(this.value)" placeholder="Minimal 8 karakter unik..." required
                                   class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                            <button type="button" onclick="togglePasswordVisibility('newPassword', 'eyeIconNew')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]" id="eyeIconNew">visibility</span>
                            </button>
                        </div>

                        {{-- Indikator Kekuatan Sandi --}}
                        <div class="flex flex-col gap-1.5 pt-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-on-surface-variant">Kekuatan Kata Sandi:</span>
                                <span class="text-[11px] font-bold text-on-surface-variant" id="strengthLabel">Belum diisi</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 h-2 w-full">
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg1"></div>
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg2"></div>
                                <div class="h-full rounded-full bg-surface-variant transition-colors" id="barSeg3"></div>
                            </div>
                        </div>

                        {{-- Checklist Persyaratan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                            <div class="flex items-center gap-1.5 text-on-surface-variant text-[11px]" id="req-len">
                                <span class="material-symbols-outlined text-[16px] text-outline" id="icon-len">radio_button_unchecked</span>
                                <span>Min. 8 karakter</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-on-surface-variant text-[11px]" id="req-num">
                                <span class="material-symbols-outlined text-[16px] text-outline" id="icon-num">radio_button_unchecked</span>
                                <span>Huruf &amp; angka</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-on-surface-variant text-[11px]" id="req-sym">
                                <span class="material-symbols-outlined text-[16px] text-outline" id="icon-sym">radio_button_unchecked</span>
                                <span>Simbol (!@#$)</span>
                            </div>
                        </div>
                    </div>

                    {{-- Konfirmasi Kata Sandi Baru --}}
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="confirmPassword" placeholder="Ulangi kata sandi baru..." required
                                   class="w-full pl-5 pr-12 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"/>
                            <button type="button" onclick="togglePasswordVisibility('confirmPassword', 'eyeIconConfirm')" class="absolute right-4 top-3.5 text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]" id="eyeIconConfirm">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high">
                        <button type="submit" class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all">Perbarui Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(tabKey) {
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
            btn.classList.add('text-on-surface-variant');
        });

        const selectedPanel = document.getElementById('tabContent-' + tabKey);
        const selectedBtn = document.getElementById('tabBtn-' + tabKey);

        if (selectedPanel && selectedBtn) {
            selectedPanel.classList.remove('hidden');
            selectedBtn.classList.remove('text-on-surface-variant');
            selectedBtn.classList.add('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
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
            label.className = 'text-[11px] font-bold text-on-surface-variant';
            return;
        }

        if (score === 1) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-error');
            label.innerText = 'Lemah'; label.className = 'text-[11px] font-bold text-error';
        } else if (score === 2) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-on-tertiary-container');
            seg2.classList.remove('bg-surface-variant'); seg2.classList.add('bg-on-tertiary-container');
            label.innerText = 'Sedang'; label.className = 'text-[11px] font-bold text-on-tertiary-container';
        } else if (score >= 3) {
            seg1.classList.remove('bg-surface-variant'); seg1.classList.add('bg-secondary');
            seg2.classList.remove('bg-surface-variant'); seg2.classList.add('bg-secondary');
            seg3.classList.remove('bg-surface-variant'); seg3.classList.add('bg-secondary');
            label.innerText = 'Kuat'; label.className = 'text-[11px] font-bold text-secondary';
        }
    }

    function updateReqUi(key, passed) {
        const icon = document.getElementById('icon-' + key);
        const row = document.getElementById('req-' + key);
        if (passed) {
            icon.innerText = 'check_circle';
            icon.className = 'material-symbols-outlined text-[16px] text-secondary';
            row.className = 'flex items-center gap-1.5 text-secondary text-[11px] font-semibold';
        } else {
            icon.innerText = 'radio_button_unchecked';
            icon.className = 'material-symbols-outlined text-[16px] text-outline';
            row.className = 'flex items-center gap-1.5 text-on-surface-variant text-[11px]';
        }
    }
</script>
@endpush