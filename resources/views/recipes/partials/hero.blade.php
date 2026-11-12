<div class="w-full relative z-10">
    {{-- UBAH items-center MENJADI items-start --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
        
        {{-- KIRI: Informasi Teks --}}
        <div class="flex flex-col gap-5 order-2 lg:order-1 lg:pt-4">
            
            {{-- BADGES (Dipisah) --}}
            <div class="flex flex-wrap items-center gap-2.5">
                @if($recipe->category)
                    <a href="{{ route('recipes.daftar_resep', ['category' => $recipe->category->slug]) }}" 
                       class="px-4 py-1.5 rounded-full bg-secondary-container/60 text-on-secondary-container text-[11px] font-bold uppercase tracking-wider hover:bg-secondary-container transition-colors">
                        {{ $recipe->category->name }}
                    </a>
                @endif
                
                <span class="px-4 py-1.5 rounded-full bg-surface-container-high text-primary text-[11px] font-bold uppercase tracking-wider">
                    {{ $recipe->difficulty }}
                </span>
            </div>

            {{-- JUDUL & DESKRIPSI --}}
            <div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-primary font-bold leading-[1.1] mb-3">
                    {{ $recipe->title }}
                </h1>
                <p class="text-base text-on-surface-variant leading-relaxed w-full text-justify">
                    {{ $recipe->description }}
                </p>
            </div>

            {{-- CHEF INFO --}}
            <div class="flex items-center gap-3 py-3 border-y border-surface-container-high/60">
                <img src="{{ $recipe->user->avatar ? Storage::url($recipe->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) . '&background=5a3a22&color=fff&bold=true' }}" 
                     alt="{{ $recipe->user->name }}" 
                     class="w-10 h-10 rounded-full object-cover shadow-sm ring-2 ring-surface-container-lowest" />
                <div class="flex flex-col">
                    <div class="flex items-center gap-1.5">
                        <span class="font-bold text-primary text-sm">{{ $recipe->user->name ?? 'Anonim' }}</span>
                        <span class="material-symbols-outlined text-secondary text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                    <span class="text-[11px] text-on-surface-variant">
                        Kurator Gastronomi • Diperbarui {{ $recipe->updated_at->translatedFormat('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- METRIK (Grid 4 Kolom Rapi) --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                {{-- Penilaian --}}
                <div class="bg-surface-container-lowest rounded-2xl p-3.5 flex flex-col border border-surface-container shadow-sm">
                    <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold mb-1">Penilaian</span>
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <span class="material-symbols-outlined text-tertiary text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        <span class="text-base">{{ $recipe->average_rating }}</span>
                        <span class="text-[10px] font-medium text-outline mt-0.5">({{ $recipe->rating_count }})</span>
                    </div>
                </div>

                {{-- Total Waktu --}}
                <div class="bg-surface-container-lowest rounded-2xl p-3.5 flex flex-col border border-surface-container shadow-sm">
                    <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold mb-1">Waktu</span>
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <span class="material-symbols-outlined text-secondary text-[16px]">timer</span>
                        <span class="text-base">{{ $recipe->duration_minutes }}</span>
                        <span class="text-[10px] font-semibold mt-1">Mnt</span>
                    </div>
                </div>

                {{-- Kesulitan --}}
                <div class="bg-surface-container-lowest rounded-2xl p-3.5 flex flex-col border border-surface-container shadow-sm">
                    <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold mb-1">Kesulitan</span>
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <span class="material-symbols-outlined text-secondary text-[16px]">speed</span>
                        <span class="text-xs mt-0.5">{{ $recipe->difficulty }}</span>
                    </div>
                </div>

                {{-- Energi --}}
                <div class="bg-surface-container-lowest rounded-2xl p-3.5 flex flex-col border border-surface-container shadow-sm">
                    <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold mb-1">Energi</span>
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <span class="material-symbols-outlined text-secondary text-[16px]">local_fire_department</span>
                        <span class="text-base">{{ $recipe->calories ?? '-' }}</span>
                        <span class="text-[10px] font-semibold mt-1">kkal</span>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex flex-wrap items-center gap-2.5 pt-1">
                <a href="#recipeCoreSection" class="flex-1 sm:flex-none justify-center inline-flex items-center gap-2 px-6 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-md hover:bg-primary-container transition-all hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-[20px]">skillet</span>
                    Mulai Memasak
                </a>
                <a href="#recipeCoreSection" class="flex-1 sm:flex-none justify-center inline-flex items-center gap-2 px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container-highest transition-all">
                    <span class="material-symbols-outlined text-[20px]">list_alt</span>
                    Baca Instruksi
                </a>
            </div>
        </div>

        {{-- KANAN: Gambar Hero --}}
        {{-- Menghapus aspect-square lg:aspect-[4/5] agar gambar tidak terlalu menjulang ke atas --}}
        <div class="relative w-full h-[350px] sm:h-[450px] lg:h-[500px] rounded-3xl overflow-hidden shadow-2xl group bg-surface-container order-1 lg:order-2">
            @if($recipe->image)
                <img src="{{ Storage::url($recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-outline">
                    <span class="material-symbols-outlined text-[64px]">image_not_supported</span>
                </div>
            @endif
            
            {{-- Overlay Badge --}}
            <div class="absolute top-4 left-4 bg-inverse-surface/80 backdrop-blur-md px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                <span class="material-symbols-outlined text-primary-fixed text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                <span class="text-[10px] font-bold text-white tracking-wide">Resep Pilihan Redaksi</span>
            </div>

            {{-- Overlay Views --}}
            <div class="absolute bottom-4 right-4 bg-inverse-surface/80 backdrop-blur-md px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                <span class="material-symbols-outlined text-white text-[14px]">visibility</span>
                <span class="text-[10px] font-bold text-white">{{ number_format($recipe->views) }} kali dilihat</span>
            </div>
        </div>

    </div>
</div>