@php
    $ratings = $recipe->ratings;
    $total = $ratings->count() ?: 1;
    $breakdown = collect([5,4,3,2,1])->map(function ($star) use ($ratings, $total) {
        $count = $ratings->where('rating', $star)->count();
        return ['star' => $star, 'count' => $count, 'pct' => round(($count / $total) * 100)];
    });
@endphp

<div class="p-8 lg:p-10 bg-surface-container-lowest rounded-3xl shadow-sm flex flex-col gap-10">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col">
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Komunitas Pecinta Rasa</span>
            <h2 class="text-2xl lg:text-3xl font-bold text-primary">Ulasan &amp; Penilaian Pembaca</h2>
        </div>
        <div class="flex items-center gap-2 text-xs text-on-surface-variant">
            <span class="material-symbols-outlined text-[18px] text-secondary">verified_user</span>
            <span>Semua ulasan diverifikasi dari pemasak nyata</span>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center bg-surface-container-low p-6 rounded-2xl">
        <div class="md:col-span-4 flex flex-col items-center justify-center text-center p-2 border-b md:border-b-0 md:border-r border-surface-container-highest">
            <span class="font-['Playfair_Display'] text-5xl font-bold text-primary">{{ $recipe->average_rating }}</span>
            <div class="flex items-center text-on-tertiary-container gap-1 my-1">
                @for ($i = 0; $i < 5; $i++)
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">star</span>
                @endfor
            </div>
            <span class="text-xs text-on-surface-variant">Berdasarkan {{ $recipe->rating_count }} pengalaman memasak</span>
        </div>

        <div class="md:col-span-8 flex flex-col gap-2">
            @foreach ($breakdown as $row)
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold w-16 text-on-surface-variant">{{ $row['star'] }} Bintang</span>
                    <div class="flex-1 h-3 bg-surface-container-highest rounded-full overflow-hidden">
                        <div class="h-full bg-secondary rounded-full" style="width: {{ $row['pct'] }}%;"></div>
                    </div>
                    <span class="text-[11px] font-semibold w-12 text-right text-on-surface-variant">{{ $row['pct'] }}%</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Review Form --}}
    @auth
        <form method="POST" action="{{ route('ratings.store', $recipe) }}"
              class="bg-surface-container-low p-6 rounded-2xl flex flex-col gap-4"
              id="reviewForm">
            @csrf
            <span class="text-base font-bold text-primary">Bagikan Pengalaman Memasak Anda</span>

            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <span class="text-sm font-semibold text-on-surface">Pilih Penilaian:</span>
                <div class="flex items-center gap-1 text-outline" id="starRatingSelector">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn transition-colors hover:text-on-tertiary-container"
                                data-value="{{ $i }}" onclick="setRating({{ $i }})">
                            <span class="material-symbols-outlined text-[28px]">star</span>
                        </button>
                    @endfor
                </div>
                <span class="text-[11px] font-bold text-secondary" id="selectedRatingText">
                    {{ $userRating ? $userRating->rating . ' Bintang' : '5 Bintang (Sempurna)' }}
                </span>
            </div>

            <input type="hidden" name="rating" id="ratingInput" value="{{ $userRating->rating ?? 5 }}">

            <textarea name="comment" rows="3" required
                      class="px-4 py-3 bg-surface-container-lowest rounded-xl text-sm placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-secondary/40 shadow-sm"
                      placeholder="Ceritakan tekstur, aroma, atau modifikasi kecil yang Anda lakukan...">{{ $userRating->comment ?? '' }}</textarea>

            <div class="flex items-center justify-end">
                <button type="submit"
                        class="px-8 py-2.5 bg-primary hover:bg-tertiary text-white rounded-full text-xs font-semibold shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span>{{ $userRating ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}</span>
                </button>
            </div>
        </form>
    @else
        <div class="p-4 bg-secondary/5 border border-secondary/20 rounded-2xl text-center">
            <p class="text-sm text-on-surface-variant">
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk</a>
                untuk memberikan ulasan.
            </p>
        </div>
    @endauth

    {{-- Reviews List --}}
    <div class="flex flex-col gap-6 divide-y divide-surface-container">
        @forelse ($recipe->ratings()->with('user')->latest()->take(10)->get() as $rating)
            <div class="pt-6 flex flex-col gap-3 first:pt-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr($rating->user->name ?? 'A', 0, 2)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-semibold text-primary">{{ $rating->user->name ?? 'Anonim' }}</span>
                            <span class="text-xs text-on-surface-variant">{{ $rating->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex items-center text-on-tertiary-container">
                        @for ($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined text-[18px]"
                                  style="font-variation-settings: 'FILL' {{ $i < $rating->rating ? 1 : 0 }};">
                                star
                            </span>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-on-surface-variant leading-relaxed">"{{ $rating->comment }}"</p>
            </div>
        @empty
            <div class="text-center text-on-surface-variant py-6 text-sm">
                Belum ada ulasan. Jadilah yang pertama!
            </div>
        @endforelse
    </div>
</div>