@php
    $currentRoute = request()->route()?->getName();
    $navItems = [
        ['label' => 'Beranda',      'route' => 'home',              'active' => ['home']],
        ['label' => 'Resep',        'route' => 'recipes.daftar_resep', 'active' => ['recipes.daftar_resep']],
        ['label' => 'Favorit',      'route' => 'bookmarks.favorit', 'active' => ['bookmarks.favorit']], 
        ['label' => 'Tips Memasak', 'route' => 'tips.panduan',      'active' => ['tips.panduan']],
    ];
    
    // Fallback jika variabel dari layouts.app belum terkirim
    $brandName = 'Griya Rasa'; 
@endphp

{{-- NAVBAR FLOATING COKELAT --}}
<header class="fixed top-4 left-0 right-0 z-50 w-full px-4 sm:px-6 flex flex-col gap-2">
    
    {{-- Main Navbar Pill --}}
    <div class="bg-primary rounded-[2rem] px-5 py-3 flex items-center justify-between gap-4 shadow-xl shadow-primary/20 relative z-50">
        
        {{-- Logo & Brand --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 shrink-0 group">
            <img alt="{{ $brandName }}"
                 class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover ring-2 ring-white/20 group-hover:ring-white/50 transition-all"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5GoTuEyWYTwoGI225Teo5lSMZZidm_qW5jpOCHm646LCZ6IigJoJ8PCQzpjzZXs1XGwyLjm50AN_e0RjVErbcxNrVmPcoeWGvGBXWGVYNUqTI6fxTEE5KLwNFMrDJnAwjYbV889BwRPQw3COYUhsD4mVHPKgF83SEBb-6095KMwryj3kb5-1o84Ay9tydqVY8K2cGqBKijQd2TBEXlGQETt0j5Pzxtc8YeVMK8emsi_fGZGP3Dy1Y" />
            <div class="flex flex-col leading-tight">
                {{-- NAMA BRAND (Dikunci) --}}
                <span class="font-['Playfair_Display'] text-[17px] sm:text-[20px] font-semibold tracking-tight text-white">
                    {{ $brandName }}
                </span>
                {{-- TAGLINE (Dinamis dari Admin) --}}
                <span class="text-[9px] sm:text-[11px] text-primary-fixed-dim font-medium tracking-wide">
                    {{ $siteTagline ?? 'Inspirasi & Resep Kuliner' }}
                </span>
            </div>
        </a>

        {{-- Menu Navigasi Tengah (Desktop Only) --}}
        <nav class="hidden lg:flex items-center gap-1.5">
            @foreach ($navItems as $item)
                @php
                    $isActive = in_array($currentRoute, $item['active']);
                    $href = Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="px-4 py-2 rounded-full text-[13px] font-semibold transition-all whitespace-nowrap
                          {{ $isActive
                              ? 'bg-white text-primary shadow-sm' 
                              : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Search & Profile & Hamburger --}}
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            
            {{-- Search (Desktop Only) --}}
            <form action="{{ Route::has('recipes.daftar_resep') ? route('recipes.daftar_resep') : '#' }}" method="GET" class="relative hidden lg:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/70 text-[18px] pointer-events-none">search</span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari resep..."
                       class="w-44 lg:w-56 pl-9 pr-4 py-2 bg-white/10 text-white text-[13px] rounded-full placeholder:text-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/20 transition-all" />
            </form>

            {{-- Profile / Login --}}
            @auth
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 cursor-pointer focus:outline-none">
                        <img alt="{{ Auth::user()->name }}"
                             class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover ring-2 ring-white/30 group-hover:ring-white transition-all"
                             src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}" />
                        <span class="material-symbols-outlined text-white/80 text-[18px] group-hover:text-white transition-colors hidden sm:block">expand_more</span>
                    </button>

                    {{-- Dropdown Desktop --}}
                    <div class="absolute right-0 top-full mt-4 w-56 bg-surface-container-lowest rounded-2xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-outline-variant/30">
                        <div class="px-4 py-2.5 border-b border-surface-container">
                            <p class="text-sm font-semibold text-primary leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-outline truncate">{{ Auth::user()->email }}</p>
                        </div>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-surface-container transition">
                                <span class="material-symbols-outlined text-[18px] text-primary">dashboard</span> Dashboard Admin
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-surface-container transition">
                            <span class="material-symbols-outlined text-[18px] text-primary">person</span> Profil Saya
                        </a>
                        <hr class="my-1 border-surface-container" />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-error hover:bg-error-container/30 transition">
                                <span class="material-symbols-outlined text-[18px]">logout</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-white text-primary text-[12px] sm:text-[13px] font-bold hover:bg-surface-container transition-all shadow-sm whitespace-nowrap">
                    Masuk
                </a>
            @endauth

            {{-- TOMBOL HAMBURGER (Hanya muncul di Mobile) --}}
            <button id="public-mobile-btn" type="button" class="lg:hidden p-1.5 text-white hover:text-primary-fixed transition-colors">
                <span class="material-symbols-outlined text-[28px]">menu</span>
            </button>
        </div>
    </div>

    {{-- MOBILE DROPDOWN MENU (Tersembunyi secara default) --}}
    <div id="public-mobile-menu" class="hidden lg:hidden bg-primary rounded-[2rem] p-4 flex-col gap-2 shadow-xl shadow-primary/20 mt-1">
        
        {{-- Menu Links --}}
        @foreach ($navItems as $item)
            @php
                $isActive = in_array($currentRoute, $item['active']);
                $href = Route::has($item['route']) ? route($item['route']) : '#';
            @endphp
            <a href="{{ $href }}"
               class="px-5 py-3 rounded-xl text-sm font-semibold transition-all
                      {{ $isActive
                          ? 'bg-white text-primary shadow-sm'
                          : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                {{ $item['label'] }}
            </a>
        @endforeach

        {{-- Search Bar di Mobile --}}
        <form action="{{ Route::has('recipes.daftar_resep') ? route('recipes.daftar_resep') : '#' }}" method="GET" class="relative mt-2">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/70 text-[20px] pointer-events-none">search</span>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari resep, bahan..."
                   class="w-full pl-12 pr-4 py-3 bg-white/10 text-white text-sm rounded-xl placeholder:text-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all" />
        </form>

    </div>
</header>

{{-- SCRIPT UNTUK HAMBURGER MENU PUBLIK --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('public-mobile-btn');
        const mobileMenu = document.getElementById('public-mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', function() {
                // Toggle kelas 'hidden' dan 'flex' untuk memunculkan/menyembunyikan menu
                if (mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('flex');
                } else {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                }
            });
        }
    });
</script>