<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin — L\'Art de Cuisine')</title>

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
        ::-webkit-scrollbar { display: none; }
        .line-clamp-1 { display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#41240e", "primary-container": "#5a3a22",
                        "primary-fixed": "#ffdcc5", "primary-fixed-dim": "#ecbd9d",
                        "on-primary": "#ffffff", "on-primary-container": "#d2a485",
                        "secondary": "#55643b", "secondary-container": "#d5e6b4",
                        "secondary-fixed": "#d8e9b6", "secondary-fixed-dim": "#bccd9c",
                        "on-secondary": "#ffffff", "on-secondary-container": "#59683f",
                        "tertiary": "#462200", "tertiary-container": "#663500",
                        "tertiary-fixed": "#ffdcc3", "tertiary-fixed-dim": "#ffb77d",
                        "on-tertiary": "#ffffff", "on-tertiary-container": "#f09a50",
                        "surface": "#fff8ef", "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#fbf3e4", "surface-container": "#f5edde",
                        "surface-container-high": "#efe7d9", "surface-container-highest": "#e9e2d3",
                        "surface-bright": "#fff8ef", "surface-dim": "#e1d9cb", "surface-variant": "#e9e2d3",
                        "on-surface": "#1e1b12", "on-surface-variant": "#50443d",
                        "outline": "#82746c", "outline-variant": "#d4c3ba",
                        "error": "#ba1a1a", "error-container": "#ffdad6", "on-error-container": "#93000a",
                        "background": "#fff8ef"
                    },
                    borderRadius: { DEFAULT: "1rem", lg: "2rem", xl: "3rem", full: "9999px" },
                    fontFamily: {
                        "display": ["Playfair Display", "serif"],
                        "body-md": ["Plus Jakarta Sans"], "body-sm": ["Plus Jakarta Sans"],
                        "label-md": ["Plus Jakarta Sans"], "label-sm": ["Plus Jakarta Sans"],
                        "label-lg": ["Plus Jakarta Sans"], "title-lg": ["Plus Jakarta Sans"],
                        "title-md": ["Plus Jakarta Sans"],
                    },
                }
            }
        };
    </script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased">

{{-- ============ SIDEBAR ============ --}}
<aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-low z-50 flex flex-col justify-between py-6 px-4 shadow-[0_1px_8px_rgba(90,58,34,0.04)] overflow-y-auto">

    <div class="flex flex-col gap-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2">
            <img alt="L'Art de Cuisine" class="h-8 w-auto object-contain"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5GoTuEyWYTwoGI225Teo5lSMZZidm_qW5jpOCHm646LCZ6IigJoJ8PCQzpjzZXs1XGwyLjm50AN_e0RjVErbcxNrVmPcoeWGvGBXWGVYNUqTI6fxTEE5KLwNFMrDJnAwjYbV889BwRPQw3COYUhsD4mVHPKgF83SEBb-6095KMwryj3kb5-1o84Ay9tydqVY8K2cGqBKijQd2TBEXlGQETt0j5Pzxtc8YeVMK8emsi_fGZGP3Dy1Y"/>
            <div class="flex flex-col">
                <span class="font-display text-lg text-primary tracking-tight font-bold leading-tight">L'Art de Cuisine</span>
                <span class="text-[11px] uppercase tracking-wider text-secondary font-bold">Portal Gastronomi</span>
            </div>
        </a>

        <nav class="flex flex-col gap-1.5">
            @php
                $current = request()->route()?->getName();
                $navItems = [
                    ['label' => 'Dashboard',       'route' => 'admin.dashboard',        'icon' => 'dashboard', 'pattern' => 'admin.dashboard'],
                    ['label' => 'Kelola Resep',    'route' => 'admin.recipes.index',    'icon' => 'menu_book', 'pattern' => 'admin.recipes.*'],
                    ['label' => 'Kelola Kategori', 'route' => 'admin.categories.index', 'icon' => 'category',  'pattern' => 'admin.categories.*'],
                    ['label' => 'Kelola Tips',     'route' => 'admin.tips.index',   'icon' => 'lightbulb', 'pattern' => 'admin.tips.*'],
                    ['label' => 'Data User',       'route' => 'admin.users.index',      'icon' => 'group',     'pattern' => 'admin.users.*'],
                    ['label' => 'Ulasan',          'route' => 'admin.reviews.index',    'icon' => 'rate_review',   'pattern' => 'admin.reviews.*'],
                    ['label' => 'Pengaturan',      'route' => null,                     'icon' => 'settings',  'pattern' => null],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php
                    $isActive = $item['pattern'] && \Str::is($item['pattern'], $current);
                    $href = $item['route'] && Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all
                          {{ $isActive
                              ? 'bg-primary-container text-white font-bold shadow-sm'
                              : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                    <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                    <span class="text-sm font-semibold">{{ $item['label'] }}</span>
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-full text-error hover:bg-error-container/40 transition-all">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span class="text-sm font-semibold">Keluar</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="p-3 bg-surface-container rounded-2xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3 min-w-0">
            <div class="relative shrink-0">
                <img alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover"
                     src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}"/>
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-secondary rounded-full ring-2 ring-surface-container"></span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-xs font-bold text-on-surface leading-tight truncate">{{ Auth::user()->name }}</span>
                <span class="text-[11px] text-on-surface-variant">Super Admin</span>
            </div>
        </div>
        <span class="material-symbols-outlined text-white bg-secondary rounded-full p-1 text-[16px] shrink-0">verified</span>
    </div>
</aside>

{{-- ============ CONTENT WRAPPER ============ --}}
<div class="pl-72">

    {{-- HEADER --}}
    <header class="fixed top-0 left-72 right-0 h-20 bg-surface/85 backdrop-blur-xl z-40 flex items-center justify-between px-8 shadow-[0_1px_8px_rgba(90,58,34,0.04)]">
        <div class="flex flex-col gap-0.5">
            <div class="flex items-center gap-2 text-[11px] text-on-surface-variant">
                <span>Admin</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-secondary font-bold">@yield('breadcrumb', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                <span class="text-[11px] text-secondary font-bold tracking-wide uppercase">Sistem Aktif • Sinkronisasi Lancar</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3.5 text-on-surface-variant text-[20px]">search</span>
                <input type="text" placeholder="Cari resep, chef, tag..."
                       class="bg-surface-container-lowest text-on-surface text-sm rounded-full pl-10 pr-4 py-2 w-64 border border-outline-variant focus:outline-none focus:ring-2 focus:ring-secondary/40 shadow-sm placeholder:text-outline"/>
            </div>

            <button type="button" class="relative p-2.5 rounded-full bg-surface-container hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-on-surface shadow-sm">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-tertiary-container rounded-full ring-2 ring-surface"></span>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-2 pl-2">
                <img alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover shadow-sm"
                     src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}"/>
            </a>
        </div>
    </header>

    {{-- MAIN CONTENT — @yield('content') = DIISI TIAP HALAMAN --}}
    <main class="relative pt-20 bg-background min-h-screen px-8 pb-12">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>