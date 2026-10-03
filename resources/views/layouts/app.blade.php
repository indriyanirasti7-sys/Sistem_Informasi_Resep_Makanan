<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', "L'Art de Cuisine — Inspirasi & Resep Kuliner")</title>

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
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
                        "inverse-primary": "#ecbd9d", "surface-dim": "#e1d9cb",
                        "tertiary-container": "#663500", "inverse-surface": "#343026",
                        "surface-bright": "#fff8ef", "on-primary-container": "#d2a485",
                        "tertiary-fixed": "#ffdcc3", "surface": "#fff8ef",
                        "surface-container": "#f5edde", "on-error-container": "#93000a",
                        "primary-container": "#5a3a22", "on-tertiary-fixed": "#2f1500",
                        "on-secondary-fixed": "#131f01", "on-secondary-container": "#59683f",
                        "error": "#ba1a1a", "tertiary-fixed-dim": "#ffb77d",
                        "on-tertiary-container": "#f09a50", "outline-variant": "#d4c3ba",
                        "on-primary-fixed": "#2e1502", "primary": "#41240e",
                        "surface-container-low": "#fbf3e4", "on-background": "#1e1b12",
                        "error-container": "#ffdad6", "outline": "#82746c",
                        "on-tertiary-fixed-variant": "#6e3900", "on-primary-fixed-variant": "#603f27",
                        "secondary-fixed": "#d8e9b6", "on-surface": "#1e1b12",
                        "on-tertiary": "#ffffff", "on-secondary-fixed-variant": "#3d4b26",
                        "on-surface-variant": "#50443d", "surface-container-highest": "#e9e2d3",
                        "surface-container-high": "#efe7d9", "secondary": "#55643b",
                        "on-error": "#ffffff", "on-primary": "#ffffff",
                        "on-secondary": "#ffffff", "tertiary": "#462200",
                        "surface-tint": "#7b563c", "secondary-container": "#d5e6b4",
                        "primary-fixed": "#ffdcc5", "primary-fixed-dim": "#ecbd9d",
                        "surface-variant": "#e9e2d3", "surface-container-lowest": "#ffffff",
                        "background": "#fff8ef", "inverse-on-surface": "#f8f0e1",
                        "secondary-fixed-dim": "#bccd9c"
                    },
                    borderRadius: { DEFAULT: "1rem", lg: "2rem", xl: "3rem", full: "9999px" },
                    spacing: {
                        "space-sm": "0.5rem", "margin": "3rem", "margin-mobile": "1.25rem",
                        "gutter": "1.5rem", "space-xl": "2.5rem", "gutter-mobile": "1rem",
                        "space-xs": "0.25rem", "space-lg": "1.5rem", "space-md": "1rem",
                        "space-2xl": "4rem"
                    },
                    fontFamily: {
                        "body-lg": ["Plus Jakarta Sans"], "label-md": ["Plus Jakarta Sans"],
                        "display": ["Playfair Display"], "label-sm": ["Plus Jakarta Sans"],
                        "display-mobile": ["Playfair Display"], "headline-lg-mobile": ["Playfair Display"],
                        "title-lg": ["Plus Jakarta Sans"], "title-md": ["Plus Jakarta Sans"],
                        "body-md": ["Plus Jakarta Sans"], "headline-lg": ["Playfair Display"],
                        "label-lg": ["Plus Jakarta Sans"], "headline-sm": ["Playfair Display"],
                        "body-sm": ["Plus Jakarta Sans"], "headline-md": ["Playfair Display"]
                    },
                    fontSize: {
                        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.03em", fontWeight: "600" }],
                        "display": ["56px", { lineHeight: "64px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "label-sm": ["11px", { lineHeight: "14px", letterSpacing: "0.05em", fontWeight: "700" }],
                        "display-mobile": ["40px", { lineHeight: "48px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-lg-mobile": ["30px", { lineHeight: "38px", fontWeight: "600" }],
                        "title-lg": ["20px", { lineHeight: "28px", fontWeight: "700" }],
                        "title-md": ["18px", { lineHeight: "26px", fontWeight: "600" }],
                        "body-md": ["15px", { lineHeight: "24px", fontWeight: "400" }],
                        "headline-lg": ["40px", { lineHeight: "48px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "label-lg": ["14px", { lineHeight: "20px", letterSpacing: "0.02em", fontWeight: "600" }],
                        "headline-sm": ["22px", { lineHeight: "30px", fontWeight: "500" }],
                        "body-sm": ["13px", { lineHeight: "20px", fontWeight: "400" }],
                        "headline-md": ["28px", { lineHeight: "36px", fontWeight: "500" }]
                    }
                }
            }
        };
    </script>
    @stack('styles')
</head>
<body class="bg-surface-container-low font-body-md text-on-surface antialiased">

    @include('partials.navbar')

    <main class="w-full pt-20 bg-surface-container-low min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>