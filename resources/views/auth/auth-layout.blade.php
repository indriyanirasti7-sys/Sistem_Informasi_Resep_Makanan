@props(['mode' => 'signin'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ $mode === 'signup' ? 'Daftar Akun' : 'Masuk' }} — Griya Rasa</title>

    <link rel="icon" type="image/png" href="{{ asset('uploads/images/logo.png') }}">

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#3d1f0a",
                        "primary-container": "#5c3418",
                        "secondary": "#4f5e35",
                        "secondary-container": "#d4e5b0",
                        "on-secondary-container": "#4a5931",
                        "surface": "#f3f6eb",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eef2e3",
                        "surface-container": "#e6ecda",
                        "surface-container-high": "#dfe6d1",
                        "on-surface": "#1c1a12",
                        "on-surface-variant": "#4d433c",
                        "outline": "#7d7169",
                        "outline-variant": "#d0c0b7",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                    },
                    fontFamily: {
                        display: ["Playfair Display", "serif"],
                        body: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    boxShadow: {
                        'soft': '8px 8px 24px #c5d1b5, -8px -8px 24px #ffffff',
                        'soft-inset': 'inset 2px 2px 6px #c5d1b5, inset -2px -2px 6px #ffffff',
                        'card': '0 25px 50px -12px rgb(0 0 0 / 0.15)',
                    }
                }
            }
        };
    </script>

    <style>
        .auth-bg {
            background: linear-gradient(145deg, #eaf0df 0%, #f4f7ed 40%, #e6ecda 100%);
        }
        .glow-circle {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.45;
            pointer-events: none;
        }
        /* Style untuk background gambar masakan transparan pada panel */
        .cooking-overlay-bg {
            background-image: linear-gradient(to bottom right, rgba(61, 31, 10, 0.88), rgba(92, 52, 24, 0.82), rgba(79, 94, 53, 0.85)), url('https://images.unsplash.com/photo-1543353071-10c8ba85a904?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="min-h-screen auth-bg font-body text-on-surface flex flex-col justify-between relative overflow-x-hidden">

    <!-- Decorative background circles -->
    <div class="glow-circle w-72 h-72 bg-secondary-container top-[-80px] left-[-60px]"></div>
    <div class="glow-circle w-96 h-96 bg-[#d4c3a8] bottom-[-120px] right-[-80px] opacity-30"></div>
    <div class="glow-circle w-64 h-64 bg-primary/10 top-1/2 left-1/3"></div>

    <header class="w-full py-5 sm:py-6 px-4 sm:px-6 lg:px-12 relative z-10">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="font-display text-xl sm:text-2xl font-semibold text-primary tracking-tight group-hover:text-primary-container transition">
                    Griya Rasa
                </span>
            </a>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-1.5 text-sm text-on-surface-variant hover:text-primary transition">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>
    </header>

    <main class="w-full flex-1 flex items-center justify-center px-4 sm:px-6 py-8 relative z-10">
        <div class="w-full max-w-4xl">

            <!-- Mobile Tab -->
            <div class="flex md:hidden w-full max-w-xs mx-auto mb-6 p-1.5 rounded-full bg-white/70 backdrop-blur-sm shadow-sm">
                <button class="flex-1 py-2.5 rounded-full text-xs font-semibold transition-all"
                        id="mobileTabSignIn" type="button">Masuk</button>
                <button class="flex-1 py-2.5 rounded-full text-xs font-semibold transition-all"
                        id="mobileTabSignUp" type="button">Daftar</button>
            </div>

            <!-- Auth Container -->
            <div class="relative w-full mx-auto bg-white/80 backdrop-blur-md rounded-3xl overflow-hidden shadow-card border border-white/60"
                 id="authContainer" data-mode="{{ $mode }}"
                 style="max-width: 920px; min-height: 560px;">

                <!-- SIGN UP PANEL -->
                <div class="auth-panel w-full hidden flex-col justify-center px-7 sm:px-12 py-10 transition-all duration-700
                            md:flex md:absolute md:top-0 md:left-0 md:h-full md:w-1/2 md:z-[1]"
                     id="signUpPanel">
                    <form class="flex flex-col w-full text-center my-auto" method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf

                        <div class="inline-flex items-center justify-center gap-1.5 mx-auto mb-3 px-3.5 py-1.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold tracking-wide">
                            <span class="material-symbols-outlined text-[15px]">restaurant_menu</span>
                            <span>Komunitas Griya Rasa</span>
                        </div>

                        <h2 class="font-display text-2xl sm:text-3xl font-semibold text-primary leading-tight">
                            Buat Akun Baru
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-2 mb-7">
                            Bergabung dengan komunitas pencinta kuliner.
                        </p>

                        @if ($errors->any() && $mode === 'signup')
                            <div class="mb-5 p-3.5 rounded-2xl bg-error-container text-on-error-container text-left text-xs">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-3 text-left">
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">person</span>
                                <input name="name" type="text" value="{{ old('name') }}" required
                                       placeholder="Nama Lengkap Anda"
                                       class="w-full pl-12 pr-4 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                                <input name="email" type="email" value="{{ old('email') }}" required
                                       placeholder="nama@email.com" autocomplete="off"
                                       class="w-full pl-12 pr-4 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                                <input id="signUpPassword" name="password" type="password" required
                                       placeholder="Minimal 8 karakter" autocomplete="new-password"
                                       class="w-full pl-12 pr-12 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                                <button type="button" onclick="togglePasswordVisibility('signUpPassword', this)"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock_reset</span>
                                <input id="signUpPasswordConfirm" name="password_confirmation" type="password" required
                                       placeholder="Ulangi password"
                                       class="w-full pl-12 pr-4 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                            </div>
                        </div>

                        <button type="submit"
                                class="mt-7 w-full py-3.5 rounded-2xl bg-primary text-white text-sm font-bold tracking-wider hover:bg-primary-container transition shadow-lg shadow-primary/20">
                            DAFTAR SEKARANG
                        </button>

                        <p class="text-center text-xs text-outline mt-5">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-secondary font-semibold hover:underline ml-1">Masuk di sini</a>
                        </p>
                    </form>
                </div>

                <!-- SIGN IN PANEL -->
                <div class="auth-panel w-full flex flex-col justify-center px-7 sm:px-12 py-8 transition-all duration-700
                            md:absolute md:top-0 md:left-0 md:h-full md:w-1/2 md:z-[2]"
                     id="signInPanel">
                    <form class="flex flex-col w-full text-center my-auto" method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf

                        <div class="inline-flex items-center justify-center gap-1.5 mx-auto mb-3 px-3.5 py-1.5 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold tracking-wide">
                            <span class="material-symbols-outlined text-[15px]">soup_kitchen</span>
                            <span>Jurnal Gastronomi</span>
                        </div>

                        <h2 class="font-display text-2xl sm:text-3xl font-semibold text-primary leading-tight">
                            Masuk ke Akun
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-2 mb-7">
                            Akses ratusan kurasi resep & catatan rasa.
                        </p>

                        @if (session('status'))
                            <div class="mb-4 p-3 rounded-2xl bg-secondary/10 text-secondary text-left text-xs">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any() && $mode === 'signin')
                            <div class="mb-4 p-3 rounded-2xl bg-error-container text-on-error-container text-left text-xs">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-3 text-left">
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                                <input name="email" type="email" value="{{ old('email') }}" required autofocus
                                       placeholder="nama@email.com" autocomplete="off"
                                       class="w-full pl-12 pr-4 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                                <input id="signInPassword" name="password" type="password" required
                                       placeholder="Kata sandi akun" autocomplete="new-password"
                                       class="w-full pl-12 pr-12 py-3 rounded-2xl bg-surface-container-lowest text-sm focus:outline-none focus:ring-2 focus:ring-secondary/30 shadow-soft-inset transition"/>
                                <button type="button" onclick="togglePasswordVisibility('signInPassword', this)"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4 mb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-primary"/>
                                <span class="text-xs text-on-surface-variant">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit"
                                class="mt-7 w-full py-3.5 rounded-2xl bg-primary text-white text-sm font-bold tracking-wider hover:bg-primary-container transition shadow-lg shadow-primary/20">
                            MASUK
                        </button>
                    </form>
                </div>

                <!-- SLIDING OVERLAY (Dengan Background Gambar Masakan Transparan) -->
                <div class="hidden md:block absolute top-0 left-1/2 w-1/2 h-full overflow-hidden z-20 transition-transform duration-700 ease-in-out"
                     id="overlayContainer">
                    <div class="relative -left-full h-full w-[200%] text-white transition-transform duration-700 ease-in-out cooking-overlay-bg"
                         id="overlayTrack">

                        <div class="absolute top-0 left-0 w-1/2 h-full flex flex-col items-center justify-center px-8 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-5 backdrop-blur-sm">
                                <span class="material-symbols-outlined text-[32px]">menu_book</span>
                            </div>
                            <h3 class="font-display text-2xl lg:text-3xl font-semibold mb-3">Selamat Datang!</h3>
                            <p class="text-sm text-white/80 max-w-[240px] mb-8 leading-relaxed">
                                Masuk untuk terhubung dengan resep favoritmu.
                            </p>
                            <button type="button" id="signInButton"
                                    class="py-2.5 px-9 rounded-full border-2 border-white/70 text-white text-xs font-bold tracking-wider hover:bg-white hover:text-primary transition-all duration-300">
                                MASUK
                            </button>
                        </div>

                        <div class="absolute top-0 right-0 w-1/2 h-full flex flex-col items-center justify-center px-8 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-5 backdrop-blur-sm">
                                <span class="material-symbols-outlined text-[32px]">local_fire_department</span>
                            </div>
                            <h3 class="font-display text-2xl lg:text-3xl font-semibold mb-3">Halo, Koki Baru!</h3>
                            <p class="text-sm text-white/80 max-w-[240px] mb-8 leading-relaxed">
                                Daftar dan mulai petualangan rempah Nusantara.
                            </p>
                            <button type="button" id="signUpButton"
                                    class="py-2.5 px-9 rounded-full border-2 border-white/70 text-white text-xs font-bold tracking-wider hover:bg-white hover:text-primary transition-all duration-300">
                                DAFTAR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full py-5 px-4 text-center text-[11px] text-outline relative z-10">
        <p>© {{ date('Y') }} Griya Rasa. Hak Cipta Dilindungi.</p>
    </footer>

    <script>
    (function () {
        const authContainer = document.getElementById('authContainer');
        const signUpBtn = document.getElementById('signUpButton');
        const signInBtn = document.getElementById('signInButton');
        const overlayContainer = document.getElementById('overlayContainer');
        const overlayTrack = document.getElementById('overlayTrack');
        const signInPanel = document.getElementById('signInPanel');
        const signUpPanel = document.getElementById('signUpPanel');
        const mobileTabSignIn = document.getElementById('mobileTabSignIn');
        const mobileTabSignUp = document.getElementById('mobileTabSignUp');

        const initialMode = authContainer?.getAttribute('data-mode') || 'signin';
        let isSignUpActive = initialMode === 'signup';

        function resetPanels() {
            [signInPanel, signUpPanel].forEach(p => {
                if (!p) return;
                p.classList.remove('hidden', 'flex', 'opacity-0', 'opacity-100',
                    'pointer-events-none', 'pointer-events-auto', 'translate-x-full',
                    'z-[1]', 'z-[2]', 'z-[5]');
            });
        }

        function updateMobileView(active) {
            isSignUpActive = active;
            resetPanels();
            if (active) {
                signInPanel.classList.add('hidden');
                signUpPanel.classList.add('flex');
                mobileTabSignUp.classList.add('bg-primary', 'text-white');
                mobileTabSignUp.classList.remove('text-on-surface-variant');
                mobileTabSignIn.classList.remove('bg-primary', 'text-white');
                mobileTabSignIn.classList.add('text-on-surface-variant');
            } else {
                signUpPanel.classList.add('hidden');
                signInPanel.classList.add('flex');
                mobileTabSignIn.classList.add('bg-primary', 'text-white');
                mobileTabSignIn.classList.remove('text-on-surface-variant');
                mobileTabSignUp.classList.remove('bg-primary', 'text-white');
                mobileTabSignUp.classList.add('text-on-surface-variant');
            }
        }

        function updateDesktopSliding(active) {
            isSignUpActive = active;
            resetPanels();
            if (active) {
                overlayContainer.classList.add('-translate-x-full');
                overlayTrack.classList.add('translate-x-1/2');
                signUpPanel.classList.add('opacity-100', 'translate-x-full', 'z-[5]', 'pointer-events-auto');
                signInPanel.classList.add('opacity-0', 'z-[1]', 'pointer-events-none');
            } else {
                overlayContainer.classList.remove('-translate-x-full');
                overlayTrack.classList.remove('translate-x-1/2');
                signInPanel.classList.add('opacity-100', 'z-[2]', 'pointer-events-auto');
                signUpPanel.classList.add('opacity-0', 'z-[1]', 'pointer-events-none');
            }
        }

        function applyState() {
            if (window.innerWidth >= 768) {
                updateDesktopSliding(isSignUpActive);
            } else {
                updateMobileView(isSignUpActive);
            }
        }

        signUpBtn?.addEventListener('click', () => updateDesktopSliding(true));
        signInBtn?.addEventListener('click', () => updateDesktopSliding(false));
        mobileTabSignIn?.addEventListener('click', () => updateMobileView(false));
        mobileTabSignUp?.addEventListener('click', () => updateMobileView(true));

        window.addEventListener('resize', applyState);
        applyState();
    })();

    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
    </script>

</body>
</html>