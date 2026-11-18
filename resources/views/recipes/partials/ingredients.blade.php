{{-- ✅ CUKUP GUNAKAN CLASS INI, CSS STICKY DIATUR OLEH LAYOUT --}}
<div class="lg:col-span-5 flex flex-col gap-4">
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm flex flex-col gap-4">

        <div class="flex items-center justify-between pb-4 border-b border-surface-container-highest">
            <div class="flex flex-col">
                <span class="text-xl font-bold text-primary">Bahan-Bahan</span>
                <span class="text-xs text-on-surface-variant">Takar porsi sesuai kebutuhan</span>
            </div>

            <div class="flex items-center gap-2 bg-surface-container rounded-full px-4 py-2">
                <span class="material-symbols-outlined text-[18px] text-secondary">group</span>
                <span class="text-sm font-bold text-primary">
                    {{ $recipe->servings }} Porsi
                </span>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold text-secondary uppercase tracking-wider">Daftar Belanja Interaktif</span>
            <button type="button" onclick="copyIngredientsList()"
                    class="flex items-center gap-1 text-[11px] text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                <span>Salin Semua</span>
            </button>
        </div>

        {{-- Ingredient List (di-render JavaScript) --}}
        <div class="flex flex-col divide-y divide-surface-container" id="ingredientsContainer"></div>
        
    </div>
</div>

@php
    $ingredientsArray = [];
    foreach ($recipe->recipeIngredients as $ri) {
        $ingredientsArray[] = [
            'name'   => $ri->ingredient->name,
            'amount' => 1,
            'unit'   => '', 
        ];
    }
@endphp

<script id="recipe-ingredients-data" type="application/json">
{!! json_encode($ingredientsArray) !!}
</script>