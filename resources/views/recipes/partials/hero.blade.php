@php
    $badgeClass = match($recipe->difficulty) {
        'Mudah' => 'bg-secondary-container text-on-secondary-container',
        'Sedang' => 'bg-primary-fixed text-primary',
        'Sulit'  => 'bg-error-container text-on-error-container',
        default  => 'bg-surface-container-high',
    };
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

    {{-- Left: Story --}}
    <div class="lg:col-span-7 flex flex-col gap-4">

        <div class="flex items-center gap-2 flex-wrap">
            @if ($recipe->category)
                <span class="px-4 py-1 {{ $badgeClass }} rounded-full text-[11px] font-bold tracking-wider uppercase">
                    {{ $recipe->category->name }} • {{ $recipe->difficulty }}
                </span>
            @endif
            @if ($recipe->duration_minutes && $recipe->duration_minutes > 60)
                <span class="px-4 py-1 bg-tertiary-fixed text-on-tertiary-fixed rounded-full text-[11px] font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">local_fire_department</span>
                    Slow-cooked
                </span>
            @endif
        </div>

        <h1 class="font-['Playfair_Display'] text-3xl lg:text-5xl font-semibold text-primary leading-tight">
            {{ $recipe->title }}
        </h1>

        <p class="text-base lg:text-lg text-on-surface-variant leading-relaxed">
            {{ $recipe->description }}
        </p>

        {{-- Author --}}
        <div class="flex items-center gap-4 py-3 border-y border-surface-container-highest">
            <img alt="{{ $recipe->user->name ?? 'Anonim' }}"
                 class="w-12 h-12 rounded-full object-cover shadow-sm ring-2 ring-secondary/30"
                 src="{{ $recipe->user->avatar ? Storage::url($recipe->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name ?? 'Chef') . '&background=5a3a22&color=fff&bold=true' }}"/>
            <div class="flex flex-col">
                <div class="flex items-center gap-1">
                    <span class="text-base font-semibold text-primary">{{ $recipe->user->name ?? 'Tim Dapur' }}</span>
                    @if ($recipe->user && $recipe->user->isAdmin())
                        <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings: 'FILL' 1;" title="Koki Terverifikasi">verified</span>
                    @endif
                </div>
                <span class="text-xs text-on-surface-variant">
                    Kurator Gastronomi • Diperbarui {{ $recipe->updated_at?->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>

        {{-- Metrics --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="p-3 bg-surface-container-lowest rounded-xl flex flex-col gap-0.5 shadow-sm">
                <span class="text-[11px] font-semibold text-on-surface-variant">Penilaian</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px] text-on-tertiary-container" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="text-lg font-bold text-primary">{{ $recipe->average_rating }}</span>
                </div>
                <span class="text-[11px] text-outline">({{ $recipe->rating_count }} ulasan)</span>
            </div>

            <div class="p-3 bg-surface-container-lowest rounded-xl flex flex-col gap-0.5 shadow-sm">
                <span class="text-[11px] font-semibold text-on-surface-variant">Total Waktu</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px] text-secondary">schedule</span>
                    <span class="text-lg font-bold text-primary">{{ $recipe->duration_minutes ?? '-' }} Mnt</span>
                </div>
                <span class="text-[11px] text-outline">Persiapan: {{ max(10, intval($recipe->duration_minutes / 6)) }} mnt</span>
            </div>

            <div class="p-3 bg-surface-container-lowest rounded-xl flex flex-col gap-0.5 shadow-sm">
                <span class="text-[11px] font-semibold text-on-surface-variant">Kesulitan</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px] text-tertiary-container">psychology</span>
                    <span class="text-lg font-bold text-primary">{{ $recipe->difficulty }}</span>
                </div>
                <span class="text-[11px] text-tertiary-container font-semibold">{{ $recipe->difficulty === 'Sulit' ? 'Slow-cooked' : 'Cepat' }}</span>
            </div>

            <div class="p-3 bg-surface-container-lowest rounded-xl flex flex-col gap-0.5 shadow-sm">
                <span class="text-[11px] font-semibold text-on-surface-variant">Energi / Porsi</span>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px] text-secondary">nutrition</span>
                    <span class="text-lg font-bold text-primary">{{ $recipe->calories ?? '-' }}</span>
                </div>
                <span class="text-[11px] text-outline">kkal / porsi</span>
            </div>
        </div>

        {{-- CTA --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
            <button type="button" onclick="openCookingModal()"
                    class="flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-container text-white rounded-full text-sm font-semibold shadow-md hover:shadow-xl transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-[22px]">restaurant</span>
                <span>Mulai Mode Memasak</span>
            </button>
            <button type="button" onclick="scrollToInstructions()"
                    class="flex items-center justify-center gap-1.5 px-6 py-3.5 bg-surface-container-highest hover:bg-surface-container text-primary rounded-full text-sm font-semibold transition-colors">
                <span class="material-symbols-outlined text-[20px]">list_alt</span>
                <span>Baca Instruksi Lengkap</span>
            </button>
        </div>
    </div>

    {{-- Right: Image --}}
    <div class="lg:col-span-5 relative flex items-center justify-center">
        <div class="absolute -inset-4 bg-secondary-container/40 rounded-full blur-2xl -z-10 transform rotate-3"></div>
        <div class="absolute w-72 h-72 bg-tertiary-fixed/30 rounded-full blur-xl -z-10 -bottom-6 -right-6"></div>

        <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl bg-surface-container">
            <img class="w-full h-[460px] object-cover transition-transform duration-700 hover:scale-105"
                 src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                 alt="{{ $recipe->title }}"/>

            <div class="absolute top-4 left-4 flex flex-col gap-2">
                <div class="px-4 py-1.5 bg-primary/90 backdrop-blur-md text-white rounded-full text-[11px] font-bold flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">award_star</span>
                    <span>Resep Pilihan Redaksi</span>
                </div>
            </div>

            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-primary/80 via-primary/40 to-transparent p-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                    <span class="text-[11px] font-semibold">Sajian Autentik</span>
                </div>
                <span class="text-[11px] font-semibold opacity-80">{{ $recipe->views }} kali dilihat</span>
            </div>
        </div>
    </div>
</div>