<div class="fixed inset-0 z-50 bg-primary/95 backdrop-blur-md hidden flex-col justify-between text-white p-5 lg:p-12 transition-opacity duration-300"
     id="cookingModalOverlay">

    {{-- Top Bar --}}
    <div class="flex items-center justify-between border-b border-on-primary-container/30 pb-4">
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-secondary-fixed text-[32px]">skillet</span>
            <div class="flex flex-col">
                <span class="text-[11px] uppercase tracking-wider text-secondary-fixed font-bold">Mode Memasak Terpandu</span>
                <span class="text-base font-bold text-white">{{ $recipe->title }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col items-end">
                <span class="text-[11px] text-secondary-fixed" id="modalStepIndicatorText">Langkah 1 dari 1</span>
                <div class="w-36 h-2 bg-on-primary-container/30 rounded-full mt-1 overflow-hidden">
                    <div class="h-full bg-secondary-fixed rounded-full transition-all duration-300" id="modalProgressBar" style="width: 0%;"></div>
                </div>
            </div>
            <button type="button" onclick="closeCookingModal()"
                    class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>
    </div>

    {{-- Center --}}
    <div class="max-w-3xl w-full mx-auto my-auto flex flex-col gap-6 text-center items-center py-6">
        <div class="inline-flex items-center gap-2 px-4 py-1 bg-secondary-fixed/20 text-secondary-fixed rounded-full text-xs font-semibold">
            <span class="material-symbols-outlined text-[18px]">checklist</span>
            <span id="modalCurrentStepHeader">Langkah 1</span>
        </div>

        <h2 class="font-['Playfair_Display'] text-3xl lg:text-5xl font-semibold text-white leading-snug"
            id="modalInstructionTitle">Memuat langkah...</h2>

        <p class="text-base lg:text-lg text-primary-fixed max-w-2xl leading-relaxed"
           id="modalInstructionDetail">...</p>

        <div class="mt-6 p-6 bg-white/10 rounded-3xl flex flex-col items-center gap-3 backdrop-blur-sm border border-white/10 min-w-[280px]"
             id="modalTimerBox">
            <span class="text-[11px] text-secondary-fixed uppercase tracking-widest font-semibold" id="modalTimerLabel">Timer</span>
            <span class="font-mono text-[48px] lg:text-[56px] font-bold text-white leading-none" id="modalTimerCount">00:00</span>
            <div class="flex items-center gap-3 mt-2">
                <button type="button" id="modalTimerControlBtn" onclick="toggleModalTimer()"
                        class="px-6 py-2 bg-secondary text-white hover:bg-secondary/90 rounded-full text-xs font-semibold flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                    <span>Mulai Timer</span>
                </button>
                <button type="button" onclick="resetModalTimer()"
                        class="w-9 h-9 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Bottom Nav --}}
    <div class="flex items-center justify-between border-t border-on-primary-container/30 pt-4">
        <button type="button" id="modalPrevBtn" onclick="prevCookingStep()"
                class="px-6 py-2.5 bg-white/10 hover:bg-white/20 rounded-full text-white text-xs font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span>Sebelumnya</span>
        </button>
        <span class="sm:hidden text-[11px] text-secondary-fixed" id="modalMobileCounter">1 / 1</span>
        <button type="button" id="modalNextBtn" onclick="nextCookingStep()"
                class="px-8 py-2.5 bg-secondary text-white hover:bg-secondary/90 rounded-full text-xs font-semibold flex items-center gap-2 shadow-lg">
            <span>Tandai Selesai &amp; Lanjut</span>
            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
        </button>
    </div>
</div>