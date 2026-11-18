<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin — Griya Rasa')</title>


    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
        
        ::-webkit-scrollbar { display: none; }
        
        /* Scrollbar tipis khusus sidebar */
        .sidebar-scroll::-webkit-scrollbar { display: block; width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }

        .line-clamp-1 { display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
        .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

        /* =========================================
           CSS SIDEBAR COLLAPSE (HANYA UNTUK DESKTOP)
           ========================================= */
        @media (min-width: 1024px) {
            /* Saat class sidebar-collapsed aktif di body */
            body.sidebar-collapsed #sidebar {
                width: 84px;
            }
            body.sidebar-collapsed #sidebar .sidebar-text,
            body.sidebar-collapsed #sidebar .sidebar-category-title {
                display: none !important;
            }
            body.sidebar-collapsed #sidebar .sidebar-nav-item {
                justify-content: center !important;
                padding-left: 0;
                padding-right: 0;
            }
            body.sidebar-collapsed #sidebar .sidebar-profile {
                justify-content: center !important;
            }
            body.sidebar-collapsed #sidebar .sidebar-header {
                justify-content: center !important;
            }
            
            /* Geser konten utama dan header ke kiri */
            body.sidebar-collapsed #main-content {
                padding-left: 84px !important;
            }
            body.sidebar-collapsed #main-header {
                left: 84px !important;
            }

            /* Putar ikon panah */
            body.sidebar-collapsed #toggle-icon {
                transform: rotate(180deg);
            }
        }
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

<body class="bg-background font-body-md text-on-surface antialiased overflow-hidden">

<!-- SCRIPT CEGAH FLICKER & KUNCI SIDEBAR -->
<script>
    // Cek memory sebelum halaman dirender
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
    }
</script>

<!-- OVERLAY GELAP (Hanya muncul di Mobile) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity duration-300"></div>

{{-- ============ SIDEBAR ============ --}}
<!-- Hapus class 'relative' dan pastikan fixed bekerja dengan baik -->
<aside id="sidebar" class="fixed left-0 top-0 h-[100dvh] bg-secondary z-50 flex flex-col p-4 shadow-xl transform -translate-x-full lg:translate-x-0 transition-all duration-300 w-72">
    
    <!-- TOMBOL TOGGLE (MENGAMBANG DI LUAR SIDEBAR) -->
    <button id="desktop-toggle-btn" type="button" class="hidden lg:flex absolute top-8 -right-3.5 z-50 w-7 h-7 bg-primary text-white rounded-full items-center justify-center shadow-md border-2 border-secondary hover:bg-primary-container transition-all">
        <span class="material-symbols-outlined text-[16px] transition-transform duration-300" id="toggle-icon">chevron_left</span>
    </button>

    <!-- BAGIAN ATAS (Logo & Menu) -->
    <div class="flex flex-col gap-6 flex-1 min-h-0 overflow-y-auto overflow-x-hidden w-full sidebar-scroll">
        
        <!-- Logo Brand -->
        <div class="sidebar-header flex items-center gap-3 px-1.5 mt-2 w-full shrink-0 transition-all duration-300">
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white shrink-0">
                <span class="material-symbols-outlined text-[24px]">restaurant_menu</span>
            </div>
            
            <!-- Teks Logo -->
            <div class="flex flex-col flex-1 overflow-hidden whitespace-nowrap sidebar-text transition-all duration-300">
                <span class="font-display text-[17px] text-white font-bold leading-tight">Griya Rasa</span>
                <span class="text-[10px] uppercase tracking-wider text-white/60 mt-0.5 font-semibold">Portal Gastronomi</span>
            </div>
            
            <!-- Tombol Close (Mobile) -->
            <button id="close-sidebar-btn" type="button" class="lg:hidden shrink-0 p-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors ml-auto">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigasi Berkelompok -->
        <nav class="flex flex-col gap-6 w-full shrink-0 pb-4 mt-2">
            
            <!-- UTAMA -->
            <div>
                <p class="sidebar-category-title px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 mb-2 whitespace-nowrap transition-all">Utama</p>
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">dashboard</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- MANAJEMEN KONTEN -->
            <div>
                <p class="sidebar-category-title px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 mb-2 whitespace-nowrap transition-all">Manajemen Konten</p>
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.recipes.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.recipes.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">menu_book</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Kelola Resep</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">category</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Kelola Kategori</span>
                    </a>
                    <a href="{{ route('admin.tips.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.tips.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">lightbulb</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Kelola Tips</span>
                    </a>
                </div>
            </div>

            <!-- INTERAKSI -->
            <div>
                <p class="sidebar-category-title px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 mb-2 whitespace-nowrap transition-all">Interaksi</p>
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">group</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Data User</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">reviews</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Ulasan</span>
                    </a>
                </div>
            </div>

            <!-- SISTEM -->
            <div>
                <p class="sidebar-category-title px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 mb-2 whitespace-nowrap transition-all">Sistem</p>
                <div class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-white text-secondary shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[22px] shrink-0">settings</span>
                        <span class="sidebar-text text-sm font-semibold whitespace-nowrap">Pengaturan</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- BAGIAN BAWAH (Profil & Keluar) -->
    <div class="flex flex-col gap-3 pt-4 border-t border-white/10 shrink-0 mt-auto">
        <!-- Kartu Profil -->
        <div class="sidebar-profile bg-black/10 rounded-xl p-2.5 flex items-center justify-between shadow-sm overflow-hidden transition-all duration-300">
            <div class="flex items-center gap-3">
                <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=fff&color=55643b&bold=true' }}" 
                     class="w-9 h-9 rounded-full object-cover shadow-sm shrink-0"/>
                
                <div class="sidebar-text flex flex-col whitespace-nowrap transition-all">
                    <span class="text-xs font-bold text-white">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-white/60 capitalize">{{ Auth::user()->role === 'admin' ? 'Super Admin' : 'User' }}</span>
                </div>
            </div>
            <span class="sidebar-text material-symbols-outlined text-white/60 text-[18px] transition-all">verified</span>
        </div>

        <!-- Tombol Keluar -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="sidebar-nav-item flex items-center justify-center gap-2 w-full px-3 py-3 rounded-xl bg-white/10 text-white hover:bg-error hover:text-white transition-all shadow-sm">
                <span class="material-symbols-outlined text-[22px] shrink-0">logout</span>
                <span class="sidebar-text text-sm font-bold whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- ============ CONTENT WRAPPER ============ --}}
<div id="main-content" class="pl-0 lg:pl-72 w-full h-screen overflow-y-auto transition-all duration-300">

    {{-- HEADER (COKLAT) --}}
    <header id="main-header" class="fixed top-0 left-0 lg:left-72 right-0 h-20 bg-primary z-40 flex items-center justify-between px-4 lg:px-8 shadow-md transition-all duration-300">
        
        <div class="flex items-center gap-4">
            <button id="mobile-menu-btn" type="button" class="lg:hidden p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>

            <div class="flex flex-col gap-0.5 pl-2">
                <div class="flex items-center gap-2 text-[11px] text-white/70">
                    <span>Admin</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-white font-bold">@yield('breadcrumb', 'Dashboard')</span>
                </div>
                <div class="hidden sm:flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-secondary-fixed animate-pulse"></span>
                    <span class="text-[11px] text-secondary-fixed font-bold tracking-wide uppercase">Sistem Aktif</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 lg:gap-4">
            <form action="{{ route('admin.recipes.index') }}" method="GET" class="relative hidden md:flex items-center">
                <span class="material-symbols-outlined absolute left-4 text-white/60 text-[18px]">search</span>
                <input type="text" name="q" value="{{ request('q') }}" 
                    class="w-56 lg:w-96 pl-10 pr-4 py-2 rounded-full bg-white/10 text-white placeholder:text-white/50 text-sm shadow-sm outline-none focus:ring-2 focus:ring-secondary-fixed transition-all" 
                    placeholder="Cari resep, chef, tag..." />
            </form>

            <a href="{{ route('home') }}" class="flex items-center gap-2 pl-1 lg:pl-2">
                <img alt="{{ Auth::user()->name }}" class="w-8 h-8 lg:w-9 lg:h-9 rounded-full object-cover shadow-sm border-2 border-white/20"
                     src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=5a3a22&color=fff&bold=true' }}"/>
            </a>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="relative pt-20 bg-background min-h-screen px-4 lg:px-8 pb-12">
        @yield('content')
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==== LOGIKA MOBILE (BURGER MENU) ====
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');

        function toggleSidebarMobile() {
            sidebar.classList.toggle('-translate-x-full');
            
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
            } else {
                overlay.classList.remove('opacity-100');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        menuBtn.addEventListener('click', toggleSidebarMobile);
        closeBtn.addEventListener('click', toggleSidebarMobile);
        overlay.addEventListener('click', toggleSidebarMobile);

        // ==== LOGIKA DESKTOP (LOCK/TOGGLE) ====
        const desktopToggleBtn = document.getElementById('desktop-toggle-btn');

        desktopToggleBtn.addEventListener('click', function() {
            // Toggle class di body
            const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
            
            // Simpan status ke localStorage agar tidak reset saat pindah halaman
            localStorage.setItem('sidebarCollapsed', isCollapsed ? 'true' : 'false');
        });
    });
</script>

@stack('scripts')
</body>
</html>