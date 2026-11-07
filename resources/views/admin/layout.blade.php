<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden">
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

<body class="bg-background font-body-md text-on-surface antialiased overflow-x-hidden">

<!-- OVERLAY GELAP (Hanya muncul di Mobile saat sidebar dibuka) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity duration-300"></div>

{{-- ============ SIDEBAR (HIJAU) ============ --}}
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-72 bg-secondary z-50 flex flex-col justify-between p-4 shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <!-- BAGIAN ATAS (Logo & Menu) -->
    <div class="flex flex-col gap-6 overflow-y-auto overflow-x-hidden no-scrollbar w-full">
        
        <!-- Logo Brand & Tombol X -->
        <div class="flex items-center gap-3 px-2 mt-2 w-full">
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined text-[24px]">restaurant_menu</span>
            </div>
            
            <!-- Div pembungkus teks (min-w-0 agar bisa menyusut) -->
            <div class="flex flex-col min-w-0 flex-1">
                <span class="font-display text-lg text-white font-bold leading-none truncate">L'Art de Cuisine</span>
                <span class="text-[10px] uppercase tracking-wider text-white/60 mt-1 font-semibold truncate">Portal Gastronomi</span>
            </div>
            
            <!-- TOMBOL SILANG (Hanya muncul di HP) -->
            <button id="close-sidebar-btn" type="button" class="lg:hidden shrink-0 p-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors ml-auto">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigasi Berkelompok -->
        <nav class="flex flex-col gap-6 w-full">
            <div>
                <p class="px-4 text-[10px] font-bold uppercase tracking-wider text-white/50 mb-2">Utama</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold uppercase tracking-wider text-white/50 mb-2">Manajemen Konten</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.recipes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.recipes.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">menu_book</span>
                        <span class="text-sm font-semibold">Kelola Resep</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">category</span>
                        <span class="text-sm font-semibold">Kelola Kategori</span>
                    </a>
                    <a href="{{ route('admin.tips.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.tips.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                        <span class="text-sm font-semibold">Kelola Tips</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold uppercase tracking-wider text-white/50 mb-2">Interaksi</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.users.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                        <span class="text-sm font-semibold">Data User</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">reviews</span>
                        <span class="text-sm font-semibold">Ulasan</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold uppercase tracking-wider text-white/50 mb-2">Sistem</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-full transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]">settings</span>
                        <span class="text-sm font-semibold">Pengaturan</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- BAGIAN BAWAH (Profil & Keluar) -->
    <div class="flex flex-col gap-3 mt-4 pt-4 border-t border-white/10">
        <!-- Kartu Profil -->
                <!-- Kartu Profil Admin (Posisi Atas) -->
        <div class="bg-black/10 rounded-2xl p-3 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <!-- Mengambil foto dari database, jika kosong pakai inisial nama asli -->
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=fff&color=55643b&bold=true' }}" 
                     class="w-10 h-10 rounded-full object-cover shadow-sm"/>
                
                <div class="flex flex-col">
                    <!-- Mengambil nama asli dari database -->
                    <span class="text-xs font-bold text-white">{{ Auth::user()->name }}</span>
                    
                    <!-- Menampilkan role -->
                    <span class="text-[10px] text-white/60 capitalize">{{ Auth::user()->role === 'admin' ? 'Super Admin' : 'User' }}</span>
                </div>
            </div>
            <span class="material-symbols-outlined text-white/60 text-[18px]" title="Terverifikasi">verified</span>
        </div>

        <!-- Tombol Keluar -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-2xl bg-white/10 text-white hover:bg-error hover:text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                <span class="text-sm font-bold">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- ============ CONTENT WRAPPER ============ --}}
<div class="lg:pl-72">

    {{-- HEADER --}}
    <header class="fixed top-0 left-0 lg:left-72 right-0 h-20 bg-surface/85 backdrop-blur-xl z-40 flex items-center justify-between px-4 lg:px-8 shadow-[0_1px_8px_rgba(90,58,34,0.04)]">
        
        <div class="flex items-center gap-4">
            <button id="mobile-menu-btn" type="button" class="lg:hidden p-2.5 rounded-full bg-surface-container hover:bg-surface-container-high text-primary transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>

            <div class="flex flex-col gap-0.5">
                <div class="flex items-center gap-2 text-[11px] text-on-surface-variant">
                    <span>Admin</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-secondary font-bold">@yield('breadcrumb', 'Dashboard')</span>
                </div>
                <div class="hidden sm:flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                    <span class="text-[11px] text-secondary font-bold tracking-wide uppercase">Sistem Aktif</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 lg:gap-4">
            <form action="{{ route('admin.recipes.index') }}" method="GET" class="relative hidden md:flex items-center">
                <span class="material-symbols-outlined absolute left-4 text-outline text-[18px]">search</span>
                <input type="text" name="q" value="{{ request('q') }}" 
                    class="w-56 lg:w-96 pl-10 pr-4 py-2 rounded-full bg-surface-container-lowest text-on-surface placeholder:text-outline text-sm shadow-sm outline-none focus:ring-2 focus:ring-secondary/40 transition-all" 
                    placeholder="Cari resep, chef, tag..." />
            </form>

            <button type="button" class="relative p-2.5 rounded-full bg-surface-container hover:bg-surface-container-high transition-colors text-on-surface-variant hover:text-on-surface shadow-sm">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-tertiary-container rounded-full ring-2 ring-surface"></span>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-2 pl-1 lg:pl-2">
                <img alt="{{ Auth::user()->name }}" class="w-8 h-8 lg:w-9 lg:h-9 rounded-full object-cover shadow-sm"
                     src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}"/>
            </a>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="relative pt-20 bg-background min-h-screen px-4 lg:px-8 pb-12">
        @yield('content')
    </main>
</div>

{{-- SCRIPT UNTUK HAMBURGER MENU & TOMBOL SILANG --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
            } else {
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    });
</script>

@stack('scripts')
</body>
</html>