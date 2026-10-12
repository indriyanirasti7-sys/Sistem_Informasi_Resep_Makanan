@extends('admin.layout')

@section('title', 'Tambah Kategori — L\'Art de Cuisine')
@section('breadcrumb', 'Tambah Kategori')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col gap-3">
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center gap-1.5 text-on-surface-variant hover:text-primary text-xs font-bold w-fit transition">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Kembali ke Daftar Kategori</span>
        </a>

        <div class="flex items-center gap-2 text-secondary">
            <span class="material-symbols-outlined text-lg">category</span>
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Inventaris Gastronomi</span>
        </div>

        <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Tambah Kategori Baru</h1>
        <p class="text-sm text-on-surface-variant max-w-xl">
            Definisikan klasifikasi menu baru untuk memperkaya taksonomi kuliner di portal L'Art de Cuisine.
        </p>
    </div>
</header>

{{-- ========== FORM CARD ========== --}}
<section class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Kolom Kiri: Form --}}
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-col gap-6">
            @csrf

            {{-- Nama Kategori --}}
            <div class="flex flex-col gap-2">
                <label for="name" class="text-xs font-bold text-primary uppercase tracking-wider">
                    Nama Kategori <span class="text-error">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Hidangan Pembuka"
                       class="w-full bg-surface-container-low px-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                @error('name')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <label for="slug" class="text-xs font-bold text-primary uppercase tracking-wider">
                        Slug URL <span class="text-error">*</span>
                    </label>
                    <span class="text-[11px] text-secondary">Otomatis dari nama</span>
                </div>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-sm text-on-surface-variant">/kategori/</span>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                           class="w-full bg-surface-container-low pl-24 pr-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                </div>
                @error('slug')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-2">
                <label for="description" class="text-xs font-bold text-primary uppercase tracking-wider">
                    Deskripsi Singkat
                </label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Jelaskan karakteristik racikan dan waktu penyajian..."
                          class="w-full bg-surface-container-low px-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <label class="flex items-center gap-3 cursor-pointer select-none w-fit">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))
                       class="w-4 h-4 rounded accent-secondary"/>
                <span class="text-sm text-on-surface-variant">Tampilkan kategori ini di beranda</span>
            </label>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-surface-container-high/60">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-2.5 rounded-full text-sm font-bold text-on-surface-variant hover:bg-surface-container transition">
                    Batal
                </a>
                <button type="submit"
                        class="group inline-flex items-center gap-2.5 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Kolom Kanan: Icon Picker + Preview --}}
    <div class="flex flex-col gap-5">

        {{-- Live Preview --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Pratinjau Kartu</span>

            <div class="mt-4 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-secondary/15 flex items-center justify-center text-secondary shrink-0">
                    <span class="material-symbols-outlined text-[32px]" id="previewIcon">restaurant</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-display text-xl text-primary font-bold truncate" id="previewName">
                        Nama Kategori
                    </span>
                    <code class="text-[11px] text-on-surface-variant truncate" id="previewSlug">/kategori/</code>
                </div>
            </div>

            <p class="text-xs text-on-surface-variant mt-4 line-clamp-2" id="previewDesc">
                Deskripsi kategori akan muncul di sini.
            </p>
        </div>

        {{-- Icon Picker --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
            <label class="text-xs font-bold text-primary uppercase tracking-wider">Ikon Visual</label>
            <p class="text-[11px] text-on-surface-variant mt-1 mb-3">Pilih ikon yang mewakili kategori.</p>

            <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', 'restaurant') }}" form="icon-form"/>

            <div class="grid grid-cols-4 gap-2" id="iconPicker">
                @foreach (['restaurant','bakery_dining','dinner_dining','cookie','icecream','local_cafe','spa','lunch_dining','ramen_dining','local_bar','kitchen','emoji_food_beverage'] as $icon)
                    <button type="button" data-icon="{{ $icon }}"
                            class="icon-choice aspect-square rounded-2xl flex items-center justify-center transition-all
                                   {{ old('icon','restaurant') === $icon
                                        ? 'bg-primary text-white shadow-sm'
                                        : 'bg-surface-container text-on-surface-variant hover:bg-secondary-container/60 hover:text-secondary' }}">
                        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Hidden form agar icon input bisa submit bersama form utama --}}
<form id="icon-form" method="POST" action="{{ route('admin.categories.store') }}" class="hidden">@csrf</form>

@endsection

@push('scripts')
<script>
(function () {
    const nameInput  = document.getElementById('name');
    const slugInput  = document.getElementById('slug');
    const descInput  = document.getElementById('description');
    const iconInput  = document.getElementById('iconInput');

    const prevName   = document.getElementById('previewName');
    const prevSlug   = document.getElementById('previewSlug');
    const prevDesc   = document.getElementById('previewDesc');
    const prevIcon   = document.getElementById('previewIcon');

    const iconBtns   = document.querySelectorAll('.icon-choice');

    function slugify(t) {
        return (t || '').toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
    }

    nameInput.addEventListener('input', e => {
        const v = e.target.value;
        prevName.textContent = v || 'Nama Kategori';
        const s = slugify(v);
        slugInput.value = s;
        prevSlug.textContent = '/kategori/' + s;
    });

    slugInput.addEventListener('input', e => {
        prevSlug.textContent = '/kategori/' + slugify(e.target.value);
    });

    descInput.addEventListener('input', e => {
        prevDesc.textContent = e.target.value || 'Deskripsi kategori akan muncul di sini.';
    });

    iconBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.dataset.icon;
            iconInput.value = icon;
            prevIcon.textContent = icon;

            iconBtns.forEach(b => {
                b.className = b.dataset.icon === icon
                    ? 'icon-choice aspect-square rounded-2xl flex items-center justify-center transition-all bg-primary text-white shadow-sm'
                    : 'icon-choice aspect-square rounded-2xl flex items-center justify-center transition-all bg-surface-container text-on-surface-variant hover:bg-secondary-container/60 hover:text-secondary';
            });
        });
    });
})();
</script>
@endpush