@extends('admin.layout')

@section('title', 'Edit Kategori — L\'Art de Cuisine')
@section('breadcrumb', 'Edit Kategori')

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
            <span class="material-symbols-outlined text-lg">edit</span>
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Editor Gastronomi</span>
        </div>

        <h1 class="font-display text-4xl text-primary tracking-tight font-bold">
            Sunting: {{ $category->name }}
        </h1>
        <p class="text-sm text-on-surface-variant max-w-xl">
            Perbarui nama atau ikon visual kategori. Perubahan akan langsung tampil di beranda.
        </p>
    </div>
</header>

{{-- ========== FORM CARD ========== --}}
<section class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Kolom Kiri: Form --}}
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-6 md:p-8 shadow-sm">
        <form method="POST" action="{{ route('admin.categories.update', $category->slug) }}" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="flex flex-col gap-2">
                <label for="name" class="text-xs font-bold text-primary uppercase tracking-wider">
                    Nama Kategori <span class="text-error">*</span>
                </label>
                <input type="text" id="name" name="name" required
                       value="{{ old('name', $category->name) }}"
                       class="w-full bg-surface-container-low px-4 py-3 rounded-2xl text-on-surface text-sm outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary/50 transition-all"/>
                @error('name')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <label for="slug" class="text-xs font-bold text-primary uppercase tracking-wider">
                        Slug URL
                    </label>
                    <span class="text-[11px] text-secondary">Otomatis dari nama</span>
                </div>
                <div class="relative flex items-center">
                    <span class="absolute left-4 text-sm text-on-surface-variant">/kategori/</span>
                    <input type="text" id="slug" name="slug" required readonly
                           value="{{ old('slug', $category->slug) }}"
                           class="w-full bg-surface-container px-4 py-3 rounded-2xl text-on-surface-variant pl-24 pr-4 text-sm outline-none cursor-not-allowed"/>
                </div>
            </div>

            {{-- INI YANG TADI HILANG: Hidden Input untuk Menyimpan Ikon --}}
            <input type="hidden" name="icon" id="iconInput" value="{{ old('icon', $category->icon ?? 'restaurant') }}"/>

            {{-- Actions --}}
            <div class="flex items-center justify-between gap-3 pt-4 border-t border-surface-container-high/60">
                <div class="text-[11px] text-on-surface-variant">
                    Dibuat {{ $category->created_at->translatedFormat('d M Y') }}
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-6 py-2.5 rounded-full text-sm font-bold text-on-surface-variant hover:bg-surface-container transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="group inline-flex items-center gap-2.5 px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-container transition shadow-sm hover:shadow-md">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Perbarui Kategori</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Kolom Kanan (Preview & Icon Picker) --}}
    <div class="flex flex-col gap-5">

        {{-- Preview --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Pratinjau Kartu</span>

            <div class="mt-4 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-secondary/15 flex items-center justify-center text-secondary shrink-0">
                    <span class="material-symbols-outlined text-[32px]" id="previewIcon">
                        {{ $category->icon ?? 'restaurant' }}
                    </span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-display text-xl text-primary font-bold truncate" id="previewName">
                        {{ $category->name }}
                    </span>
                    <code class="text-[11px] text-on-surface-variant truncate" id="previewSlug">
                        /kategori/{{ $category->slug }}
                    </code>
                </div>
            </div>
        </div>

        {{-- Icon Picker --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
            <label class="text-xs font-bold text-primary uppercase tracking-wider">Ikon Visual</label>
            <p class="text-[11px] text-on-surface-variant mt-1 mb-3">Pilih ikon yang mewakili kategori.</p>

            <div class="grid grid-cols-4 gap-2" id="iconPicker">
                @php $currentIcon = old('icon', $category->icon ?? 'restaurant'); @endphp
                @foreach (['restaurant','bakery_dining','dinner_dining','cookie','icecream','local_cafe','spa','lunch_dining','ramen_dining','local_bar','kitchen','emoji_food_beverage'] as $icon)
                    <button type="button" data-icon="{{ $icon }}"
                            class="icon-choice aspect-square rounded-2xl flex items-center justify-center transition-all
                                   {{ $currentIcon === $icon
                                        ? 'bg-primary text-white shadow-sm'
                                        : 'bg-surface-container text-on-surface-variant hover:bg-secondary-container/60 hover:text-secondary' }}">
                        <span class="material-symbols-outlined text-[22px]">{{ $icon }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-error-container/30 rounded-3xl p-6 shadow-sm border border-error-container">
            <span class="text-[11px] uppercase tracking-widest text-error font-bold">Zona Berbahaya</span>
            <p class="text-xs text-on-surface-variant mt-2">
                Menghapus kategori ini akan memindahkan resep di dalamnya ke status <em>Uncategorized</em>.
            </p>

            <form method="POST" action="{{ route('admin.categories.destroy', $category->slug) }}"
                  onsubmit="return confirm('Hapus kategori {{ $category->name }}?')" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-error text-white text-sm font-bold rounded-full hover:opacity-90 transition">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    <span>Hapus Kategori</span>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const iconInput = document.getElementById('iconInput'); // Sekarang ID ini ada di HTML

    const prevName  = document.getElementById('previewName');
    const prevSlug  = document.getElementById('previewSlug');
    const prevIcon  = document.getElementById('previewIcon');

    const iconBtns  = document.querySelectorAll('.icon-choice');

    function slugify(t) {
        return (t || '').toLowerCase().trim()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-');
    }

    nameInput.addEventListener('input', e => {
        prevName.textContent = e.target.value || 'Nama Kategori';
        const s = slugify(e.target.value);
        slugInput.value = s;
        prevSlug.textContent = '/kategori/' + s;
    });

    iconBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.dataset.icon;
            if (iconInput) iconInput.value = icon; // Simpan ke hidden input
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