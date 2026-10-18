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
                
                {{-- KOLOM KIRI: Form Umum --}}
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
                            <input type="text" id="inputSiteName" oninput="updateHeaderPreview()" value="L'Art de Cuisine"
                                   class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"
                                   placeholder="Masukkan nama situs..."/>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="inputSiteTagline">Tagline</label>
                            <input type="text" id="inputSiteTagline" oninput="updateHeaderPreview()" value="Inspirasi & Resep Kuliner"
                                   class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"
                                   placeholder="Contoh: Inspirasi & Resep Kuliner"/>
                            <span class="text-[11px] text-on-surface-variant">Tampil di bawah nama situs pada header portal publik.</span>
                        </div>

                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-primary" for="inputSiteDesc">Deskripsi Singkat</label>
                                <span class="text-[11px] font-semibold text-secondary" id="charCounter">86 / 160</span>
                            </div>
                            <textarea id="inputSiteDesc" rows="3" maxlength="160" oninput="updateCharCount()"
                                      class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all resize-none placeholder:text-outline">Eksplorasi cita rasa haute cuisine berpadu dengan kekayaan rempah gastronomi Nusantara.</textarea>
                            <span class="text-[11px] text-on-surface-variant">Dipakai di footer dan ringkasan cuplikan hasil pencarian Google.</span>
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
                            {{-- Box Logo --}}
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
                                <span class="text-[11px] text-on-surface-variant">PNG atau SVG, maks. 2 MB, transparan disarankan.</span>
                            </div>

                            {{-- Box Favicon --}}
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
                                <span class="text-[11px] text-on-surface-variant">PNG atau ICO, ukuran ideal 32x32 atau 64x64 piksel.</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi Bawah Tab Umum --}}
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
                        <p class="text-xs text-on-surface-variant">
                            Simulasi tampilan navigasi dan identitas publik portal yang diperbarui secara langsung saat Anda mengetik.
                        </p>

                        <div class="rounded-2xl bg-surface-container-low p-4 shadow-inner flex flex-col gap-4">
                            <div class="flex items-center justify-between bg-surface-container px-3 py-1.5 rounded-full">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-error/60"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-tertiary-fixed-dim"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                </div>
                                <span class="text-[10px] text-on-surface-variant tracking-wider">https://lartdecuisine.id</span>
                                <span class="material-symbols-outlined text-[14px] text-on-surface-variant">lock</span>
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
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-6 h-6 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined text-[13px]">search</span>
                                        </span>
                                        <span class="w-6 h-6 rounded-full bg-primary-container flex items-center justify-center text-surface-container-low">
                                            <span class="material-symbols-outlined text-[13px]">bookmark</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 pt-2 text-[11px] font-semibold text-on-surface-variant overflow-x-hidden">
                                    <span class="text-primary font-bold underline decoration-secondary decoration-2 underline-offset-4">Beranda</span>
                                    <span>Resep Pilihan</span>
                                    <span>Teknik Haute</span>
                                    <span>Koleksi</span>
                                </div>
                            </div>

                            <div class="p-3 bg-surface rounded-xl flex flex-col gap-1 shadow-sm">
                                <span class="text-[11px] font-bold text-secondary uppercase tracking-wider">Deskripsi Mesin Pencari</span>
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
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] bg-primary-container text-surface-container-low px-3 py-1 rounded-full font-bold shadow-sm">Super Admin</span>
                    </div>
                </div>

                {{-- Bagian Foto Profil --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-2xl bg-surface-container-low">
                    <div class="relative group">
                        <div class="w-28 h-28 rounded-full overflow-hidden shadow-sm ring-4 ring-surface-container-lowest flex items-center justify-center bg-primary">
                            <img alt="Avatar" class="w-full h-full object-cover" id="avatarImage" src="https://ui-avatars.com/api/?name=Chef+Antoine&background=5a3a22&color=fff&size=256"/>
                            <div class="hidden font-display text-3xl text-surface-container-low font-bold" id="avatarFallback">AL</div>
                        </div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-secondary text-on-secondary flex items-center justify-center shadow-md">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center sm:items-start gap-2 text-center sm:text-left flex-1">
                        <div class="flex flex-col">
                            <h3 class="font-display text-xl text-primary font-bold" id="profileNameDisplay">Chef Antoine Laurent</h3>
                            <span class="text-[11px] text-secondary font-semibold">antoine@lartdecuisine.id • Bergabung sejak 10 Jan 2026</span>
                        </div>
                        <div class="flex items-center gap-2.5 mt-2">
                            <button class="px-5 py-2 rounded-full bg-primary-container text-surface-container-low text-xs font-bold hover:bg-primary transition-all" type="button">Ganti Foto</button>
                            <button class="px-4 py-2 rounded-full text-on-surface-variant hover:bg-surface-container-high text-xs font-bold transition-all" onclick="toggleAvatarFallback()" type="button">Gunakan Inisial</button>
                        </div>
                    </div>
                </div>

                {{-- Form Detail Profil --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="adminFullName">Nama Lengkap</label>
                        <input type="text" id="adminFullName" oninput="document.getElementById('profileNameDisplay').innerText = this.value" value="Chef Antoine Laurent"
                               class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary" for="adminEmail">Alamat Email</label>
                        <input type="email" id="adminEmail" value="antoine@lartdecuisine.id"
                               class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary">Peran Akses</label>
                        <div class="flex items-center justify-between px-5 py-3 rounded-2xl bg-surface-container text-on-surface-variant text-sm cursor-not-allowed">
                            <span>Super Administrator</span>
                            <span class="material-symbols-outlined text-[18px] text-outline">lock</span>
                        </div>
                        <span class="text-[11px] text-on-surface-variant">Hak akses tertinggi untuk manajemen portal.</span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-primary">Status Keanggotaan</label>
                        <div class="flex items-center justify-between px-5 py-3 rounded-2xl bg-surface-container text-on-surface-variant text-sm cursor-not-allowed">
                            <span>Terdaftar: 10 Jan 2026</span>
                            <span class="material-symbols-outlined text-[18px] text-secondary">check_circle</span>
                        </div>
                        <span class="text-[11px] text-on-surface-variant">Akun diverifikasi resmi.</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high">
                    <button class="px-8 py-3 rounded-full bg-primary-container text-surface-container-low text-sm font-bold hover:bg-primary shadow-sm transition-all" type="button">Simpan Profil</button>
                </div>
            </div>
        </div>

        {{-- TAB 3: KEAMANAN (Placeholder) --}}
        <div class="tab-panel hidden flex flex-col gap-6" id="tabContent-keamanan">
            <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-sm text-center">
                <p class="text-on-surface-variant">Form Keamanan akan tampil di sini (Commit 5).</p>
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

    function updateHeaderPreview() {
        const siteName = document.getElementById('inputSiteName').value.trim() || "L'Art de Cuisine";
        const siteTagline = document.getElementById('inputSiteTagline').value.trim() || "Inspirasi & Resep Kuliner";
        const siteDesc = document.getElementById('inputSiteDesc').value.trim() || "Portal Kuliner Gastronomi.";

        document.getElementById('previewHeaderTitle').innerText = siteName;
        document.getElementById('previewHeaderTagline').innerText = siteTagline;
        document.getElementById('previewHeaderDesc').innerText = siteDesc;
    }

    function updateCharCount() {
        const descInput = document.getElementById('inputSiteDesc');
        const counter = document.getElementById('charCounter');
        const length = descInput.value.length;
        counter.innerText = length + ' / 160';
        updateHeaderPreview();
    }

    function toggleAvatarFallback() {
        const img = document.getElementById('avatarImage');
        const fallback = document.getElementById('avatarFallback');
        if (img.classList.contains('hidden')) {
            img.classList.remove('hidden');
            fallback.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            fallback.classList.remove('hidden');
        }
    }
</script>
@endpush