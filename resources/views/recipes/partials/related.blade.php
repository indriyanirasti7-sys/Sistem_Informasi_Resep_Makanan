@if ($related->count())
<div class="flex flex-col gap-6">
    <div class="flex items-end justify-between">
        <div class="flex flex-col">
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Inspirasi Jamuan</span>
            <h2 class="text-2xl lg:text-3xl font-bold text-primary">Resep Terkait &amp; Pendamping</h2>
        </div>
        <a href="{{ route('recipes.index') }}"
           class="hidden sm:flex items-center gap-1 text-sm text-primary hover:text-tertiary font-bold">
            <span>Lihat Semua</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($related as $item)
            <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                <div class="relative h-48 overflow-hidden bg-surface-container">
                    <a href="{{ route('recipes.show', $item->slug) }}">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             src="{{ $item->image ? Storage::url($item->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                             alt="{{ $item->title }}"/>
                    </a>
                    <span class="absolute bottom-3 left-3 px-3 py-0.5 bg-primary/80 backdrop-blur-md text-white rounded-full text-[11px] font-bold">
                        {{ $item->duration_minutes ?? '-' }} Mnt
                    </span>
                </div>

                <div class="p-4 flex-1 flex flex-col justify-between gap-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between text-[11px] text-on-surface-variant">
                            <span>{{ $item->category->name ?? 'Umum' }}</span>
                            <div class="flex items-center text-on-tertiary-container gap-0.5">
                                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="font-bold text-primary">{{ $item->average_rating }}</span>
                            </div>
                        </div>
                        <a href="{{ route('recipes.show', $item->slug) }}">
                            <h3 class="text-base font-bold text-primary group-hover:text-secondary transition-colors line-clamp-1">
                                {{ $item->title }}
                            </h3>
                        </a>
                        <p class="text-xs text-on-surface-variant line-clamp-2">{{ Str::limit($item->description, 80) }}</p>
                    </div>
                    <a href="{{ route('recipes.show', $item->slug) }}"
                       class="text-[11px] text-secondary font-bold flex items-center gap-1 hover:underline">
                        <span>Buka Resep</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif