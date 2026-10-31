@php
    $currentRoute = request()->route()?->getName();
    $navItems = [
        ['label' => 'Beranda',      'route' => 'home',              'active' => ['home']],
        ['label' => 'Resep',        'route' => 'recipes.daftar_resep', 'active' => ['recipes.daftar_resep']],
        ['label' => 'Favorit',      'route' => 'bookmarks.favorit', 'active' => ['bookmarks.favorit']], 
        ['label' => 'Tips Memasak', 'route' => 'tips.panduan',      'active' => ['tips.panduan']],
    ];
@endphp

{{-- NAVBAR FLOATING COKELAT (FULL WIDTH) --}}
{{-- Perubahan: left-1/2 -translate-x-1/2 w-[95%] max-w-[1280px] diganti menjadi left-0 right-0 w-full px-4 --}}
<header class="fixed top-4 left-0 right-0 z-50 w-full px-4 sm:px-6 flex flex-col gap-2">
    
    {{-- Main Navbar Container (Full Width) --}}
    {{-- Perubahan: menambahkan w-full mx-auto pada container --}}
    <div class="bg-primary rounded-[2rem] px-6 py-3 flex items-center justify-between gap-6 shadow-xl shadow-primary/20 w-full mx-auto">
        
        {{-- Logo & Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
            <img alt="L'Art de Cuisine"
                 class="w-10 h-10 rounded-xl object-cover ring-2 ring-white/20 group-hover:ring-white/50 transition-all"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5GoTuEyWYTwoGI225Teo5lSMZZidm_qW5jpOCHm646LCZ6IigJoJ8PCQzpjzZXs1XGwyLjm50AN_e0RjVErbcxNrVmPcoeWGvGBXWGVYNUqTI6fxTEE5KLwNFMrDJnAwjYbV889BwRPQw3COYUhsD4mVHPKgF83SEBb-6095KMwryj3kb5-1o84Ay9tydqVY8K2cGqBKijQd2TBEXlGQETt0j5Pzxtc8YeVMK8emsi_fGZGP3Dy1Y" />
            <div class="flex flex-col leading-tight">
                <span class="font-['Playfair_Display'] text-[19px] sm:text-[20px] font-semibold tracking-tight text-white">
                    L'Art de Cuisine
                </span>
                <span class="text-[10px] sm:text-[11px] text-primary-fixed-dim font-medium tracking-wide">
                    Inspirasi &amp; Resep Kuliner
                </span>
            </div>
        </a>

        {{-- Menu Navigasi Tengah --}}
        <nav class="hidden xl:flex items-center gap-1.5">
            @foreach ($navItems as $item)
                @php
                    $isActive = in_array($currentRoute, $item['active']);
                    $href = Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="px-4 py-2 rounded-xl text-[13px] font-semibold transition-all whitespace-nowrap
                          {{ $isActive
                              ? 'bg-white text-primary shadow-sm' 
                              : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Search & Profile --}}
        <div class="flex items-center gap-3 shrink-0">
            {{-- Search --}}
            <form action="{{ Route::has('recipes.daftar_resep') ? route('recipes.daftar_resep') : '#' }}" method="GET"
                  class="relative hidden md:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/70 text-[18px] pointer-events-none">
                    search
                </span>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari resep..."
                       class="w-44 lg:w-56 pl-9 pr-4 py-2 bg-white/10 text-white text-[13px] rounded-xl placeholder:text-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/20 transition-all" />
            </form>

            {{-- Profile / Login --}}
            @auth
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1.5 cursor-pointer focus:outline-none">
                        <img alt="{{ Auth::user()->name }}"
                             class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/30 group-hover:ring-white transition-all"
                             src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}" />
                        <span class="material-symbols-outlined text-white/80 text-[18px] group-hover:text-white transition-colors">
                            expand_more
                        </span>
                    </button>

                    {{-- Dropdown --}}
                    <div class="absolute right-0 top-full mt-4 w-56 bg-surface-container-lowest rounded-2xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-outline-variant/30">
                        <div class="px-4 py-2.5 border-b border-surface-container">
                            <p class="text-sm font-semibold text-primary leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-outline truncate">{{ Auth::user()->email }}</p>
                        </div>

                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-surface-container transition">
                                <span class="material-symbols-outlined text-[18px] text-primary">dashboard</span>
                                Dashboard Admin
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-surface-container transition">
                            <span class="material-symbols-outlined text-[18px] text-primary">person</span>
                            Profil Saya
                        </a>

                        <hr class="my-1 border-surface-container" />

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-error hover:bg-error-container/30 transition">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 rounded-xl bg-white text-primary text-[13px] font-bold hover:bg-surface-container transition-all shadow-sm whitespace-nowrap">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Nav Menu --}}
    <nav class="xl:hidden flex items-center justify-center gap-1 p-1.5 bg-primary rounded-2xl shadow-lg overflow-x-auto no-scrollbar w-full mx-auto"
         style="scrollbar-width:none;">
        @foreach ($navItems as $item)
            @php
                $isActive = in_array($currentRoute, $item['active']);
                $href = Route::has($item['route']) ? route($item['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               class="px-4 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition-all
                      {{ $isActive
                          ? 'bg-white text-primary shadow-sm'
                          : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</header>