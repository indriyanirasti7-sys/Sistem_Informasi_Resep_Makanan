{{-- File: resources/views/recipes/partials/recipe_items.blade.php --}}
@foreach ($recipes as $recipe)
    <div class="group flex flex-col bg-surface-container-lowest rounded-2xl shadow-sm hover:shadow-xl transition-all overflow-hidden">
        <div class="relative w-full aspect-[4/3] overflow-hidden bg-surface-container">
            <a href="{{ route('recipes.show', $recipe->slug) }}">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    src="{{ $recipe->image ? Storage::url($recipe->image) : 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800' }}"
                    alt="{{ $recipe->title }}" />
            </a>

            {{-- Tombol Simpan (Bookmark) --}}
            @auth
                <button type="button" data-recipe-slug="{{ $recipe->slug }}"
                        class="bookmark-btn absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ auth()->user()->bookmarks()->where('recipe_id', $recipe->id)->exists() ? 1 : 0 }};">bookmark</span>
                </button>
            @else
                <a href="{{ route('login') }}?require_login=1" title="Masuk untuk menyimpan"
                class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-md text-outline hover:text-primary flex items-center justify-center shadow-sm transition-all z-10">
                    <span class="material-symbols-outlined text-[20px]">bookmark_border</span>
                </a>
            @endauth
        </div>

        <div class="p-3 md:p-5 flex flex-col flex-1 justify-between gap-2">
            <div class="flex flex-col gap-1">
                <a href="{{ route('recipes.show', $recipe->slug) }}">
                    <h3 class="font-display text-[13px] md:text-base font-bold text-primary group-hover:text-secondary transition line-clamp-2 leading-tight">
                        {{ $recipe->title }}
                    </h3>
                </a>
                <p class="text-[10px] text-on-surface-variant truncate">
                    {{ $recipe->user->name ?? 'Tim Dapur' }}
                </p>
            </div>
            
            <div class="flex items-center justify-between text-[10px] md:text-xs pt-2 border-t border-surface-container mt-1">
                <div class="flex items-center gap-1 text-tertiary font-bold">
                    <span class="material-symbols-outlined text-[14px] md:text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    {{ $recipe->average_rating }}
                </div>
                <div class="flex items-center gap-1 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px] md:text-[16px] text-primary">bookmark</span>
                    {{ $recipe->bookmarks_count ?? 0 }}
                </div>
                <div class="flex items-center gap-1 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px] md:text-[16px] text-secondary">timer</span>
                    {{ $recipe->duration_minutes ?? '-' }}m
                </div>
            </div>
        </div>
    </div>
@endforeach