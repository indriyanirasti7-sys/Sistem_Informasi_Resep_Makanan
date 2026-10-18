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
                
                {{-- KOLOM KIRI: Form --}}
                <div class="xl:col-span-8 flex flex-col gap-6">
                    <div class="bg-surface-container-lowest p-6 lg:p-8 rounded-3xl shadow-sm flex flex-col gap-6">
                        
                        {{-- Header Section --}}
                        <div class="flex items-center gap-3 pb-1">
                            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                                <span class="material-symbols-outlined text-[18px]">domain</span>
                            </div>
                            <div>
                                <h2 class="font-display text-xl text-primary font-bold">Identitas Situs</h2>
                                <p class="text-sm text-on-surface-variant">Nama dan gambaran utama yang tampil pada seluruh platform.</p>
                            </div>
                        </div>

                        {{-- Input: Nama Situs --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="inputSiteName">Nama Situs</label>
                            <input type="text" id="inputSiteName" oninput="updateHeaderPreview()" value="L'Art de Cuisine"
                                   class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"
                                   placeholder="Masukkan nama situs..."/>
                        </div>

                        {{-- Input: Tagline --}}
                        <div class="flex flex-col gap-2">
                            <label class="text-xs font-bold text-primary" for="inputSiteTagline">Tagline</label>
                            <input type="text" id="inputSiteTagline" oninput="updateHeaderPreview()" value="Inspirasi & Resep Kuliner"
                                   class="w-full px-5 py-3 rounded-2xl bg-surface-container-low text-on-surface text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all placeholder:text-outline"
                                   placeholder="Contoh: Inspirasi & Resep Kuliner"/>
                            <span class="text-[11px] text-on-surface-variant">Tampil di bawah nama situs pada header portal publik.</span>
                        </div>

                        {{-- Input: Deskripsi Singkat --}}
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

                        {{-- Mockup Browser --}}
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

                            {{-- Mockup Header Content --}}
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

                            {{-- Mockup Description --}}
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

        {{-- TAB 2: PROFIL (Placeholder) --}}
        <div class="tab-panel hidden flex flex-col gap-6" id="tabContent-profil">
            <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-sm text-center">
                <p class="text-on-surface-variant">Form Profil Admin akan tampil di sini (Commit 4).</p>
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
    // Tab switching
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

    // Live Header Preview
    function updateHeaderPreview() {
        const siteName = document.getElementById('inputSiteName').value.trim() || "L'Art de Cuisine";
        const siteTagline = document.getElementById('inputSiteTagline').value.trim() || "Inspirasi & Resep Kuliner";
        const siteDesc = document.getElementById('inputSiteDesc').value.trim() || "Portal Kuliner Gastronomi.";

        document.getElementById('previewHeaderTitle').innerText = siteName;
        document.getElementById('previewHeaderTagline').innerText = siteTagline;
        document.getElementById('previewHeaderDesc').innerText = siteDesc;
    }

    // Character Counter
    function updateCharCount() {
        const descInput = document.getElementById('inputSiteDesc');
        const counter = document.getElementById('charCounter');
        const length = descInput.value.length;
        counter.innerText = length + ' / 160';
        updateHeaderPreview();
    }
</script>
@endpush