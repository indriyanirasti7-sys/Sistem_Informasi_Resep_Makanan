<div class="lg:col-span-7 flex flex-col gap-8" id="instructionTimeline">

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Panduan Redaksi</span>
            <h2 class="text-2xl lg:text-3xl font-bold text-primary">Langkah-Langkah Pembuatan</h2>
        </div>
        <button type="button" onclick="openCookingModal()"
                class="hidden sm:flex items-center gap-2 px-4 py-2 bg-secondary text-white rounded-full text-xs font-semibold hover:bg-secondary/90 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">fullscreen</span>
            <span>Buka Layar Penuh</span>
        </button>
    </div>

    @foreach ($recipe->steps as $i => $step)
        @php $isLast = $loop->last; $stepIdx = $i + 1; @endphp

        <div class="flex gap-4 items-start">
            <div class="flex flex-col items-center shrink-0">
                <span class="w-10 h-10 rounded-full {{ $isLast ? 'bg-secondary text-white' : 'bg-primary text-white' }} flex items-center justify-center text-base font-bold shadow-md">
                    {{ $step->step_number }}
                </span>
                @if (!$isLast)
                    <div class="w-0.5 flex-1 min-h-[40px] bg-surface-container-highest mt-2"></div>
                @endif
            </div>

            <div class="flex-1 bg-surface-container-lowest p-6 rounded-2xl shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <span class="text-lg font-bold text-primary">Langkah {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[11px] px-3 py-1 bg-surface-container rounded-full text-on-surface-variant font-semibold">
                        {{ $isLast ? 'Sentuhan Akhir' : 'Step ' . $step->step_number }}
                    </span>
                </div>

                <p class="text-sm text-on-surface-variant leading-relaxed">
                    {{ $step->instruction }}
                </p>

                {{-- TAMPILKAN GAMBAR JIKA ADA --}}
                @if ($step->image)
                    <div class="w-full rounded-xl overflow-hidden mt-2 bg-surface-container border border-surface-container-high shadow-sm group">
                        <img src="{{ asset('storage/'.$step->image) }}" 
                             alt="Ilustrasi Langkah {{ $step->step_number }}" 
                             class="w-full h-auto max-h-[350px] object-cover group-hover:scale-[1.02] transition-transform duration-500">
                    </div>
                @endif

                @if ($step->duration_minutes)
                    <div class="p-3 bg-surface-container rounded-xl flex flex-wrap items-center justify-between gap-3 mt-2">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-[24px]">timer</span>
                            <div>
                                <span class="text-[11px] text-on-surface-variant block">Timer Langkah {{ $step->step_number }}</span>
                                <span class="text-lg font-bold text-primary font-mono" id="stepTimerDisplay_{{ $stepIdx }}">
                                    {{ str_pad(intval($step->duration_minutes / 60), 2, '0', STR_PAD_LEFT) }}:{{ str_pad($step->duration_minutes % 60, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="timerBtn_{{ $stepIdx }}"
                                    data-timer-seconds="{{ $step->duration_minutes * 60 }}"
                                    onclick="toggleStepTimer({{ $stepIdx }}, {{ $step->duration_minutes * 60 }})"
                                    class="px-4 py-1.5 bg-primary text-white rounded-full text-xs font-semibold flex items-center gap-1 hover:bg-primary-container">
                                <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                <span>Mulai Timer</span>
                            </button>
                            <button type="button" onclick="resetStepTimer({{ $stepIdx }}, {{ $step->duration_minutes * 60 }})"
                                    class="w-8 h-8 rounded-full bg-surface-container-highest text-on-surface flex items-center justify-center hover:bg-surface-container">
                                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    {{-- Chef Tip --}}
    @if ($recipe->user)
        <div class="p-6 bg-surface-container rounded-2xl flex items-start gap-4 shadow-sm border-l-4 border-on-tertiary-container">
            <div class="w-12 h-12 rounded-full bg-surface-container-lowest flex items-center justify-center text-on-tertiary-container shrink-0 shadow-sm">
                <span class="material-symbols-outlined text-[26px]">lightbulb</span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-base font-bold text-primary">Rahasia Dapur {{ $recipe->user->name }}:</span>
                <p class="text-sm text-on-surface-variant leading-relaxed italic">
                    "Kunci kelezatan {{ $recipe->title }} adalah kesabaran di tahap akhir. Jangan buru-buru, biarkan bumbu berkaramelisasi sempurna."
                </p>
            </div>
        </div>
    @endif
</div>

@php
    // Data langkah untuk JavaScript (cooking modal)
    $stepsArray = [];
    foreach ($recipe->steps as $s) {
        $stepsArray[] = [
            'step'         => $s->step_number,
            'title'        => 'Langkah ' . $s->step_number,
            'detail'       => $s->instruction,
            'timerSeconds' => (int) (($s->duration_minutes ?? 0) * 60),
            'timerLabel'   => $s->duration_minutes ? 'Timer ' . $s->duration_minutes . ' menit' : 'Tanpa Timer',
            'image'        => $s->image ? asset('storage/'.$s->image) : null, // <--- TAMBAHKAN INI
        ];
    }
@endphp

<script id="recipe-steps-data" type="application/json">
{!! json_encode($stepsArray) !!}
</script>