@if ($related->count() > 0)
<section class="w-full mt-12 pt-8 border-t border-surface-container-high/60 relative z-10">
    
    {{-- Header Jamuan Terkait --}}
    <div class="flex items-end justify-between mb-6">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-secondary">
                <span class="material-symbols-outlined text-[20px]">restaurant_menu</span>
                <span class="text-[11px] uppercase tracking-widest font-bold">Inspirasi Lainnya</span>
            </div>
            <h2 class="font-display text-2xl sm:text-3xl text-primary font-bold">Resep Pendamping</h2>
        </div>
        
        {{-- Tombol Navigasi Geser (Desktop) --}}
        <div class="hidden sm:flex items-center gap-2">
            <button type="button" id="related-prev" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container-high flex items-center justify-center text-primary hover:bg-surface-container transition shadow-sm active:scale-95">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </button>
            <button type="button" id="related-next" class="w-10 h-10 rounded-full bg-surface-container-lowest border border-surface-container-high flex items-center justify-center text-primary hover:bg-surface-container transition shadow-sm active:scale-95">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </button>
        </div>
    </div>

    {{-- Container Utama: Flex + Overflow-X-Auto (Bisa digeser) --}}
    <div id="related-scroll-container" class="flex items-stretch gap-4 sm:gap-6 overflow-x-auto snap-x snap-mandatory pb-6 scrollbar-none scroll-smooth">
        
        @foreach ($related as $item)
            {{-- Card: shrink-0 memastikan lebar card tidak mengecil sehingga memicu scroll --}}
            <article class="snap-start shrink-0 w-[260px] sm:w-[280px] group flex flex-col bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 border border-surface-container-high/50">
                
                {{-- Gambar --}}
                <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
                    <a href="{{ route('recipes.show', $item->slug) }}" class="block w-full h-full">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             src="{{ $item->image ? Storage::url($item->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                             alt="{{ $item->title }}" />
                    </a>
                    @if($item->category)
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-surface-container-lowest/90 backdrop-blur-md text-[10px] font-bold text-primary shadow-sm">
                            {{ $item->category->name }}
                        </span>
                    @endif
                </div>

                {{-- Konten --}}
                <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between gap-4">
                    <div class="flex flex-col gap-1.5">
                        <div class="flex items-center gap-1 text-tertiary">
                            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="text-xs font-bold text-primary">{{ $item->average_rating }}</span>
                            <span class="text-[10px] text-outline">({{ $item->rating_count }})</span>
                        </div>
                        
                        <a href="{{ route('recipes.show', $item->slug) }}">
                            <h3 class="font-display text-base font-bold text-primary group-hover:text-secondary transition line-clamp-2 leading-snug">
                                {{ $item->title }}
                            </h3>
                        </a>
                    </div>

                    <div class="pt-3 border-t border-surface-container-high/60 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-[11px] font-semibold text-on-surface-variant">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-secondary">timer</span>
                                {{ $item->duration_minutes ?? '-' }}m
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-secondary">group</span>
                                {{ $item->servings }} org
                            </span>
                        </div>
                        <a href="{{ route('recipes.show', $item->slug) }}" class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach

    </div>
</section>

<script>
    // Script Tombol Geser Kiri/Kanan
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('related-scroll-container');
        const btnPrev = document.getElementById('related-prev');
        const btnNext = document.getElementById('related-next');

        if (container && btnPrev && btnNext) {
            btnPrev.addEventListener('click', () => {
                container.scrollBy({ left: -300, behavior: 'smooth' });
            });
            btnNext.addEventListener('click', () => {
                container.scrollBy({ left: 300, behavior: 'smooth' });
            });
        }
    });
</script>
@endif