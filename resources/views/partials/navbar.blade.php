@php
    $currentRoute = request()->route()?->getName();
    $navItems = [
        ['label' => 'Beranda',      'route' => 'home',          'active' => ['home']],
        ['label' => 'Daftar Resep', 'route' => 'recipes.index', 'active' => ['recipes.index', 'recipes.show']],
        ['label' => 'Favorit', 'route' => 'bookmarks.favorit', 'active' => ['bookmarks.favorit']],
        ['label' => 'Tips Memasak', 'route' => 'tips.index',    'active' => ['tips.index', 'tips.show']],
    ];
@endphp

<header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-xl shadow-[0_2px_12px_-2px_rgba(90,58,34,0.06)]">
    <div class="h-20 max-w-[1280px] mx-auto px-6 lg:px-8 flex items-center justify-between gap-6">

        {{-- ============ LOGO & BRAND ============ --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
            <img alt="L'Art de Cuisine"
                 class="w-10 h-10 rounded-full object-cover ring-2 ring-surface-container"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5GoTuEyWYTwoGI225Teo5lSMZZidm_qW5jpOCHm646LCZ6IigJoJ8PCQzpjzZXs1XGwyLjm50AN_e0RjVErbcxNrVmPcoeWGvGBXWGVYNUqTI6fxTEE5KLwNFMrDJnAwjYbV889BwRPQw3COYUhsD4mVHPKgF83SEBb-6095KMwryj3kb5-1o84Ay9tydqVY8K2cGqBKijQd2TBEXlGQETt0j5Pzxtc8YeVMK8emsi_fGZGP3Dy1Y" />
            <div class="flex flex-col leading-tight">
                <span class="font-['Playfair_Display'] text-[19px] sm:text-[20px] font-semibold tracking-tight text-primary">
                    L'Art de Cuisine
                </span>
                <span class="text-[10px] sm:text-[11px] text-on-surface-variant font-medium tracking-wide">
                    Inspirasi &amp; Resep Kuliner
                </span>
            </div>
        </a>

        {{-- ============ NAV MENU (Center) ============ --}}
        <nav class="hidden xl:flex items-center gap-1">
            @foreach ($navItems as $item)
                @php
                    $isActive = in_array($currentRoute, $item['active']);
                    $href = Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="px-4 py-2 rounded-full text-[13px] font-semibold transition-all whitespace-nowrap
                          {{ $isActive
                              ? 'bg-primary text-white shadow-sm'
                              : 'text-on-surface-variant hover:text-primary hover:bg-surface-container' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- ============ SEARCH + PROFILE (Right) ============ --}}
        <div class="flex items-center gap-3 shrink-0">

            {{-- Search --}}
            <form action="{{ Route::has('recipes.index') ? route('recipes.index') : '#' }}" method="GET"
                  class="relative hidden md:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">
                    search
                </span>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari resep, bahan, atau koki..."
                       class="w-44 lg:w-64 pl-9 pr-4 py-2 bg-surface-container-lowest text-on-surface text-[13px] rounded-full placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/20 focus:w-56 lg:focus:w-72 shadow-[0_1px_3px_0_rgba(90,58,34,0.04)] transition-all" />
            </form>

            {{-- Profile / Login --}}
            @auth
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1.5 cursor-pointer focus:outline-none">
                        <img alt="{{ Auth::user()->name }}"
                             class="w-9 h-9 rounded-full object-cover ring-2 ring-surface-container"
                             src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}" />
                        <span class="material-symbols-outlined text-on-surface-variant text-[18px] group-hover:text-primary transition-colors">
                            expand_more
                        </span>
                    </button>

                    {{-- Dropdown --}}
                    <div class="absolute right-0 top-full mt-2 w-56 bg-surface-container-lowest rounded-2xl shadow-[0_12px_32px_-8px_rgba(90,58,34,0.15)] py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-outline-variant/30">
                        {{-- User info --}}
                        <div class="px-4 py-2.5 border-b border-surface-container">
                            <p class="text-sm font-semibold text-primary leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-outline truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ Auth::user()->isAdmin() ? 'bg-primary/10 text-primary' : 'bg-secondary/15 text-secondary' }}">
                                {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                            </span>
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
                   class="px-5 py-2.5 rounded-full bg-primary text-white text-[13px] font-semibold hover:bg-primary-container transition-all shadow-sm whitespace-nowrap">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Nav Menu --}}
    <nav class="xl:hidden flex items-center gap-1 px-4 pb-3 overflow-x-auto no-scrollbar"
         style="scrollbar-width:none;">
        @foreach ($navItems as $item)
            @php
                $isActive = in_array($currentRoute, $item['active']);
                $href = Route::has($item['route']) ? route($item['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               class="px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all
                      {{ $isActive
                          ? 'bg-primary text-white'
                          : 'text-on-surface-variant hover:text-primary hover:bg-surface-container' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</header>