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
        <div class="tab-panel flex flex-col gap-6" id="tabContent-umum">
            <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-sm text-center">
                <p class="text-on-surface-variant">Form Pengaturan Umum akan tampil di sini (Commit 2 & 3).</p>
            </div>
        </div>

        {{-- TAB 2: PROFIL --}}
        <div class="tab-panel hidden flex flex-col gap-6" id="tabContent-profil">
            <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-sm text-center">
                <p class="text-on-surface-variant">Form Profil Admin akan tampil di sini (Commit 4).</p>
            </div>
        </div>

        {{-- TAB 3: KEAMANAN --}}
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
        // Sembunyikan semua panel
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('hidden'));
        
        // Reset semua tombol ke style non-aktif
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
            btn.classList.add('text-on-surface-variant');
        });

        // Tampilkan panel & tombol yang dipilih
        const selectedPanel = document.getElementById('tabContent-' + tabKey);
        const selectedBtn = document.getElementById('tabBtn-' + tabKey);

        if (selectedPanel && selectedBtn) {
            selectedPanel.classList.remove('hidden');
            selectedBtn.classList.remove('text-on-surface-variant');
            selectedBtn.classList.add('bg-primary-container', 'text-surface-container-low', 'font-semibold', 'shadow-sm');
        }
    }
</script>
@endpush