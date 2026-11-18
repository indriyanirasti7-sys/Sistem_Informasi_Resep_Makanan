@extends('admin.layout')

@section('title', 'Detail Resep — Griya Rasa')
@section('breadcrumb', 'Detail Resep')

@section('content')

<div class="w-full mx-auto pb-12">

    {{-- ========== HEADER (BERSIH TANPA TOMBOL AKSI) ========== --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.recipes.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Resep
        </a>

        {{-- JUDUL --}}
        <div class="flex items-center gap-2 mt-2">
            <span class="material-symbols-outlined text-[28px] text-primary">receipt_long</span>
            <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">
                Detail Resep: {{ $recipe->title }}
            </h1>
        </div>

        <p class="text-sm text-on-surface-variant mt-1">
            Tinjau detail lengkap resep, bahan-bahan, dan instruksi memasak sebelum dipublikasikan.
        </p>
    </header>

    <!-- Recipe Metadata & Status Banner -->
    <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-6 shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-5 items-center">
            <!-- Status Badge & ID -->
            <div class="xl:col-span-1 flex flex-col gap-2">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full {{ $recipe->status === 'published' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container text-on-surface-variant' }} text-[11px] font-bold w-fit">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $recipe->status === 'published' ? 'bg-secondary' : 'bg-outline' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $recipe->status === 'published' ? 'bg-secondary' : 'bg-outline' }}"></span>
                    </span>
                    <span>{{ $recipe->status === 'published' ? 'Dipublikasikan (Live)' : 'Draf' }}</span>
                </div>
            </div>

            <!-- Created Date -->
            <div class="flex flex-col">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Tanggal Dibuat</span>
                <span class="text-on-surface text-sm font-semibold mt-1">{{ $recipe->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

            <!-- Last Updated -->
            <div class="flex flex-col">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Terakhir Diperbarui</span>
                <span class="text-on-surface text-sm font-semibold mt-1">{{ $recipe->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

            <!-- Author / Curator (DENGAN LOKAL STORAGE AVATAR) -->
            @php
                $author = $recipe->user;
                $authorAvatar = null;
                if ($author && $author->avatar) {
                    $cleanAuthorAvatar = str_replace(['storage/', 'uploads/avatars/', 'avatars/'], '', $author->avatar);
                    if (file_exists(public_path('storage/' . $author->avatar))) {
                        $authorAvatar = asset('storage/' . $author->avatar);
                    } elseif (file_exists(public_path('storage/' . $cleanAuthorAvatar))) {
                        $authorAvatar = asset('storage/' . $cleanAuthorAvatar);
                    } elseif (file_exists(public_path('storage/avatars/' . $cleanAuthorAvatar))) {
                        $authorAvatar = asset('storage/avatars/' . $cleanAuthorAvatar);
                    } elseif (file_exists(public_path('uploads/' . $cleanAuthorAvatar))) {
                        $authorAvatar = asset('uploads/' . $cleanAuthorAvatar);
                    } else {
                        $authorAvatar = asset('storage/' . $author->avatar);
                    }
                }
                $authorInitials = collect(explode(' ', $author->name ?? 'A'))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
            @endphp

            <div class="flex items-center gap-3 mt-1 xl:mt-0">
                <div class="w-9 h-9 rounded-full overflow-hidden bg-primary text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                    @if($authorAvatar)
                        <img src="{{ $authorAvatar }}" alt="{{ $author->name ?? 'Penulis' }}" class="w-full h-full object-cover">
                    @else
                        {{ $authorInitials }}
                    @endif
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-1">
                        <span class="text-primary text-xs font-bold truncate">{{ $author->name ?? 'Anonim' }}</span>
                        <span class="material-symbols-outlined text-secondary text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                    <span class="text-outline text-[10px] truncate">{{ $author->email ?? 'email@domain.com' }}</span>
                </div>
            </div>

            <!-- Visibility Status -->
            <div class="flex flex-col xl:items-end mt-1 xl:mt-0">
                <span class="text-on-surface-variant text-[10px] uppercase tracking-wider font-bold">Kategori</span>
                <div class="flex items-center gap-1.5 text-secondary text-xs mt-1 font-bold">
                    <span class="material-symbols-outlined text-[16px]">category</span>
                    <span>{{ $recipe->category->name ?? 'Tanpa Kategori' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Column (Full Width) -->
    <div class="w-full flex flex-col gap-6 mb-6">
        
        <!-- 1. Featured Visual & Title Narrative -->
        <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col">
            {{-- HERO VISUAL DENGAN LOKAL STORAGE --}}
            @php
                $recipeImg = null;
                if ($recipe->image) {
                    $cleanRecipeImg = str_replace(['storage/', 'uploads/recipes/', 'uploads/'], '', $recipe->image);
                    if (file_exists(public_path('storage/' . $recipe->image))) {
                        $recipeImg = asset('storage/' . $recipe->image);
                    } elseif (file_exists(public_path('storage/' . $cleanRecipeImg))) {
                        $recipeImg = asset('storage/' . $cleanRecipeImg);
                    } elseif (file_exists(public_path('storage/recipes/' . $cleanRecipeImg))) {
                        $recipeImg = asset('storage/recipes/' . $cleanRecipeImg);
                    } elseif (file_exists(public_path('uploads/' . $cleanRecipeImg))) {
                        $recipeImg = asset('uploads/' . $cleanRecipeImg);
                    } else {
                        $recipeImg = asset('storage/' . $recipe->image);
                    }
                }
            @endphp

            <div class="relative w-full h-64 sm:h-96 rounded-2xl overflow-hidden bg-surface-container-high mb-6 group">
                @if($recipeImg)
                    <img class="w-full h-full object-cover object-center group-hover:scale-[1.02] transition-transform duration-700" src="{{ $recipeImg }}" alt="{{ $recipe->title }}"/>
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined text-[64px]">image_not_supported</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-transparent to-transparent"></div>
            </div>

            <!-- Culinary Philosophy & Long Description -->
            <div class="bg-surface-container-low rounded-2xl p-5 text-on-surface-variant text-sm leading-relaxed">
                <p>{!! nl2br(e($recipe->description)) !!}</p>
            </div>
        </div>

        <!-- 2. Spesifikasi Dapur (Full Width Grid) -->
        <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-6 shadow-sm">
            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-surface-container-high">
                <span class="material-symbols-outlined text-secondary text-[22px]">restaurant</span>
                <h2 class="font-['Playfair_Display'] text-lg text-primary font-bold">Spesifikasi Dapur</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-sm">
                <div class="flex flex-col bg-surface-container-low p-4 rounded-2xl">
                    <span class="text-on-surface-variant text-[11px] sm:text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">timer</span> Total Waktu</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->duration_minutes }} Menit</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-4 rounded-2xl">
                    <span class="text-on-surface-variant text-[11px] sm:text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">group</span> Kapasitas</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->servings }} Orang</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-4 rounded-2xl">
                    <span class="text-on-surface-variant text-[11px] sm:text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">speed</span> Kesulitan</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->difficulty }}</span>
                </div>
                <div class="flex flex-col bg-surface-container-low p-4 rounded-2xl">
                    <span class="text-on-surface-variant text-[11px] sm:text-xs flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">local_fire_department</span> Kalori</span>
                    <span class="font-bold text-primary mt-1">{{ $recipe->calories ? $recipe->calories . ' kkal' : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- 3. Bahan & Takaran -->
        <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 gap-4 border-b border-surface-container-high mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">grocery</span>
                    </div>
                    <div>
                        <h2 class="font-['Playfair_Display'] text-xl sm:text-2xl text-primary font-bold leading-tight">Bahan &amp; Takaran</h2>
                        <p class="text-[11px] sm:text-xs text-on-surface-variant mt-0.5">Komposisi tervalidasi standar dapur</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-xl text-on-surface-variant text-xs w-fit">
                    <span class="material-symbols-outlined text-secondary text-[18px]">scale</span>
                    <span>Kalibrasi: <strong class="text-primary">{{ $recipe->servings }} Porsi</strong></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                @foreach($recipe->recipeIngredients as $ri)
                    <div class="bg-surface-container-low rounded-xl p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-[18px] mt-0.5">check_circle</span>
                        <div class="text-sm">
                            <span class="text-primary font-medium">{{ $ri->ingredient->name ?? 'Bahan' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 4. Step-by-Step Cooking Instructions -->
        <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-surface-container-high mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[22px]">skillet</span>
                    </div>
                    <div>
                        <h2 class="font-['Playfair_Display'] text-xl sm:text-2xl text-primary font-bold leading-tight">Tahapan Memasak</h2>
                        <p class="text-[11px] sm:text-xs text-on-surface-variant mt-0.5">Protokol langkah demi langkah</p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col gap-4">
                @foreach($recipe->steps as $step)
                    {{-- STEP IMAGE DENGAN LOKAL STORAGE --}}
                    @php
                        $stepImg = null;
                        if ($step->image) {
                            $cleanStepImg = str_replace(['storage/', 'uploads/steps/', 'uploads/'], '', $step->image);
                            if (file_exists(public_path('storage/' . $step->image))) {
                                $stepImg = asset('storage/' . $step->image);
                            } elseif (file_exists(public_path('storage/' . $cleanStepImg))) {
                                $stepImg = asset('storage/' . $cleanStepImg);
                            } elseif (file_exists(public_path('storage/steps/' . $cleanStepImg))) {
                                $stepImg = asset('storage/steps/' . $cleanStepImg);
                            } elseif (file_exists(public_path('uploads/' . $cleanStepImg))) {
                                $stepImg = asset('uploads/' . $cleanStepImg);
                            } else {
                                $stepImg = asset('storage/' . $step->image);
                            }
                        }
                    @endphp

                    <div class="bg-surface-container-low rounded-xl p-4 flex flex-col sm:flex-row gap-4 items-start">
                        <div class="flex sm:flex-col items-center justify-between w-full sm:w-20 gap-2 shrink-0 border-b sm:border-b-0 pb-3 sm:pb-0 border-surface-container-high">
                            <span class="w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center">
                                {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <div class="flex flex-col min-w-0 mt-1 sm:mt-0 gap-3">
                            <p class="text-[13px] sm:text-sm text-on-surface-variant leading-relaxed">
                                {{ $step->instruction }}
                            </p>
                            
                            @if($stepImg)
                                <img src="{{ $stepImg }}" alt="Langkah {{ $step->step_number }}" class="w-full max-w-sm rounded-xl shadow-sm object-cover h-40">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ========== BOTTOM ACTIONS (HAPUS & EDIT DI BAWAH) ========== --}}
    <div class="flex items-center justify-between pt-6 border-t border-surface-container-high mt-2">
        
        {{-- Kiri Bawah: Kembali --}}
        <a href="{{ route('admin.recipes.index') }}"
           class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
            Batal
        </a>

        {{-- Kanan Bawah: Hapus & Edit --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Hapus (Memanggil Modal) --}}
            <button type="button" 
                    class="delete-recipe-btn flex items-center gap-2 px-6 py-3 rounded-full bg-error-container text-error text-sm font-bold hover:bg-error hover:text-white transition-all" 
                    data-title="{{ $recipe->title }}"
                    data-url="{{ route('admin.recipes.destroy', $recipe->slug) }}">
                <span class="material-symbols-outlined text-[18px]">delete</span>
                Hapus
            </button>
            
            {{-- Tombol Edit --}}
            <a href="{{ route('admin.recipes.edit', $recipe->slug) }}" 
               class="flex items-center gap-2 px-8 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined text-[18px]">edit_note</span>
                Edit Resep
            </a>
        </div>
    </div>

</div>

{{-- ============================================================
     MODAL: Konfirmasi Hapus Resep
     ============================================================ --}}
<div id="deleteRecipeModal"
     class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-md w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col items-center text-center">

        <div class="w-16 h-16 rounded-full bg-error-container text-error flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-[32px]">warning</span>
        </div>

        <h3 class="font-display text-2xl text-primary font-bold">Hapus Resep Ini?</h3>
        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
            Resep <strong class="text-primary font-bold" id="deleteRecipeTitle">—</strong>
            akan dihapus permanen dari portal. Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex items-center gap-3 mt-8 w-full">
            {{-- Tombol Batal --}}
            <button type="button" id="cancelDeleteRecipeBtn" class="flex-1 py-2.5 rounded-full bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition">
                Batal
            </button>
            
            {{-- Form Hapus --}}
            <form id="deleteRecipeForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 rounded-full bg-error text-white font-bold text-sm hover:bg-error/90 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const deleteModal  = document.getElementById('deleteRecipeModal');
    const deleteForm   = document.getElementById('deleteRecipeForm');
    const deleteTarget = document.getElementById('deleteRecipeTitle');
    const cancelDelete = document.getElementById('cancelDeleteRecipeBtn');

    function openDeleteModal(btn) {
        deleteTarget.textContent = btn.dataset.title;
        deleteForm.action = btn.dataset.url;
        
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.delete-recipe-btn');
        if (btn) {
            openDeleteModal(btn);
        }
    });

    cancelDelete.addEventListener('click', closeDeleteModal);
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) closeDeleteModal();
    });
})();
</script>
@endpush