<div class="lg:col-span-5 flex flex-col gap-4 lg:sticky lg:top-24">
    <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm flex flex-col gap-4">

        <div class="flex items-center justify-between pb-4 border-b border-surface-container-highest">
            <div class="flex flex-col">
                <span class="text-xl font-bold text-primary">Bahan-Bahan</span>
                <span class="text-xs text-on-surface-variant">Takar porsi sesuai kebutuhan</span>
            </div>

            {{-- Portion Scaler --}}
            <div class="flex items-center bg-surface-container rounded-full p-1 shadow-inner">
                <button type="button" onclick="changePortion(-1)" aria-label="Kurangi Porsi"
                        class="w-8 h-8 rounded-full bg-surface-container-lowest text-primary flex items-center justify-center hover:bg-surface-container-highest transition font-bold shadow-sm active:scale-95">
                    <span class="material-symbols-outlined text-[16px]">remove</span>
                </button>
                <div class="px-3 min-w-[70px] text-center">
                    <span class="text-base font-bold text-primary" id="currentPortionDisplay">{{ $recipe->servings }}</span>
                    <span class="text-[11px] text-on-surface-variant block -mt-1">Porsi</span>
                </div>
                <button type="button" onclick="changePortion(1)" aria-label="Tambah Porsi"
                        class="w-8 h-8 rounded-full bg-surface-container-lowest text-primary flex items-center justify-center hover:bg-surface-container-highest transition font-bold shadow-sm active:scale-95">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                </button>
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

        <div class="p-3 bg-surface-container rounded-xl flex items-start gap-3">
            <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">skillet</span>
            <div class="flex flex-col">
                <span class="text-base font-semibold text-primary">Peralatan Ideal</span>
                <p class="text-xs text-on-surface-variant">Gunakan wajan cekung tebal untuk menjaga suhu konstan saat pengadukan.</p>
            </div>
        </div>
    </div>
</div>

@php
    // Data bahan untuk JavaScript (dibuat sebagai array PHP, baru di-encode ke JSON)
    $ingredientsArray = [];
    foreach ($recipe->recipeIngredients as $ri) {
        $ingredientsArray[] = [
            'name'   => $ri->ingredient->name,
            'amount' => (float) $ri->amount,
            'unit'   => $ri->unit ?: $ri->ingredient->unit,
        ];
    }
@endphp

<script id="recipe-ingredients-data" type="application/json">
{!! json_encode($ingredientsArray) !!}
</script>