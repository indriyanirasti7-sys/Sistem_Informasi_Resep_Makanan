@props(['mode' => 'signin'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ $mode === 'signup' ? 'Daftar Akun' : 'Masuk' }} — L'Art de Cuisine</title>

    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: {
                    "primary": "#41240e", "primary-container": "#5a3a22",
                    "secondary": "#55643b", "secondary-container": "#d5e6b4",
                    "on-secondary-container": "#59683f",
                    "tertiary": "#462200", "tertiary-container": "#663500",
                    "tertiary-fixed": "#ffdcc3",
                    "surface": "#fff8ef", "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#fbf3e4", "surface-container": "#f5edde",
                    "surface-container-high": "#efe7d9",
                    "on-surface": "#1e1b12", "on-surface-variant": "#50443d",
                    "outline": "#82746c", "outline-variant": "#d4c3ba",
                    "error-container": "#ffdad6", "on-error-container": "#93000a",
                },
                fontFamily: {
                    display: ["Playfair Display", "serif"],
                    body: ["Plus Jakarta Sans", "sans-serif"],
                },
            }}
        };
    </script>
</head>

<body class="min-h-screen bg-surface-container-low font-body text-on-surface flex flex-col justify-between">

<header class="w-full py-4 sm:py-6 px-4 sm:px-6 lg:px-12">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="font-display text-lg sm:text-xl font-semibold text-primary">L'Art de Cuisine</span>
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-xs sm:text-sm text-on-surface-variant hover:text-primary transition">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span class="hidden sm:inline">Kembali ke Beranda</span>
            <span class="sm:hidden">Kembali</span>
        </a>
    </div>
</header>

<main class="w-full flex-1 flex items-start sm:items-center justify-center px-4 sm:px-6 py-4 sm:py-8">
    <div class="w-full max-w-4xl">

        {{-- Mobile Tab --}}
        <div class="flex md:hidden w-full max-w-xs mx-auto mb-4 p-1 rounded-full bg-surface-container">
            <button class="flex-1 py-2 rounded-full text-xs font-semibold transition-all"
                    id="mobileTabSignIn" type="button">Masuk</button>
            <button class="flex-1 py-2 rounded-full text-xs font-semibold transition-all"
                    id="mobileTabSignUp" type="button">Daftar</button>
        </div>

        {{-- Auth Container --}}
        <div class="relative w-full mx-auto bg-surface-container-low rounded-2xl overflow-hidden shadow-[8px_8px_24px_#ded4c3,-8px_-8px_24px_#ffffff] md:min-h-[600px]"
             id="authContainer" data-mode="{{ $mode }}" style="max-width: 900px;">

            {{-- SIGN UP PANEL --}}
            <div class="auth-panel w-full hidden flex-col justify-center px-6 sm:px-10 py-6 transition-all duration-700
                        md:flex md:absolute md:top-0 md:left-0 md:h-full md:w-1/2 md:z-[1]"
                 id="signUpPanel">
                <form class="flex flex-col w-full text-center" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="inline-flex items-center justify-center gap-1.5 mx-auto mb-2 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold">
                        <span class="material-symbols-outlined text-[14px]">restaurant_menu</span>
                        <span>Komunitas L'Art de Cuisine</span>
                    </div>

                    <h2 class="font-display text-xl sm:text-2xl font-semibold text-primary">Buat Akun Baru</h2>
                    <p class="text-xs text-on-surface-variant mt-1 mb-4">Bergabung dengan komunitas pencinta kuliner.</p>

                    @if ($errors->any() && $mode === 'signup')
                        <div class="mb-4 p-3 rounded-xl bg-error-container text-on-error-container text-left text-[11px]">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex items-center justify-center gap-2.5 mb-3">
                        @foreach (['G', 'F', 'A'] as $letter)
                            <button type="button" class="w-9 h-9 rounded-full flex items-center justify-center bg-surface-container-lowest shadow-sm hover:scale-105 transition text-primary text-xs font-bold">
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex items-center my-3">
                        <span class="flex-grow h-[1px] bg-outline-variant/60"></span>
                        <span class="px-3 text-[10px] font-semibold text-outline uppercase tracking-wider">atau dengan email</span>
                        <span class="flex-grow h-[1px] bg-outline-variant/60"></span>
                    </div>

                    <div class="space-y-2.5 text-left">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">person</span>
                            <input name="name" type="text" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">mail</span>
                            <input name="email" type="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">lock</span>
                            <input id="signUpPassword" name="password" type="password" required placeholder="Minimal 8 karakter"
                                   class="w-full pl-10 pr-11 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                            <button type="button" onclick="togglePasswordVisibility('signUpPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">lock_reset</span>
                            <input id="signUpPasswordConfirm" name="password_confirmation" type="password" required placeholder="Ulangi password"
                                   class="w-full pl-10 pr-11 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                        </div>
                    </div>

                    <button type="submit" class="mt-5 w-full py-3 rounded-full bg-primary-container text-white text-xs font-bold tracking-wider hover:bg-primary transition">
                        DAFTAR SEKARANG
                    </button>

                    <p class="text-center text-[11px] text-outline mt-3">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-secondary font-semibold hover:underline">Masuk di sini</a>
                    </p>
                </form>
            </div>

            {{-- SIGN IN PANEL --}}
            <div class="auth-panel w-full flex flex-col justify-center px-6 sm:px-10 py-6 transition-all duration-700
                        md:absolute md:top-0 md:left-0 md:h-full md:w-1/2 md:z-[2]"
                 id="signInPanel">
                <form class="flex flex-col w-full text-center" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="inline-flex items-center justify-center gap-1.5 mx-auto mb-2 px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">
                        <span class="material-symbols-outlined text-[14px]">soup_kitchen</span>
                        <span>Jurnal Gastronomi</span>
                    </div>

                    <h2 class="font-display text-xl sm:text-2xl font-semibold text-primary">Masuk ke Akun</h2>
                    <p class="text-xs text-on-surface-variant mt-1 mb-4">Akses ratusan kurasi resep & catatan rasa.</p>

                    @if (session('status'))
                        <div class="mb-3 p-2.5 rounded-xl bg-secondary/10 text-secondary text-left text-[11px]">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any() && $mode === 'signin')
                        <div class="mb-3 p-2.5 rounded-xl bg-error-container text-on-error-container text-left text-[11px]">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex items-center justify-center gap-2.5 mb-3">
                        @foreach (['G', 'F', 'A'] as $letter)
                            <button type="button" class="w-9 h-9 rounded-full flex items-center justify-center bg-surface-container-lowest shadow-sm hover:scale-105 transition text-primary text-xs font-bold">
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex items-center my-3">
                        <span class="flex-grow h-[1px] bg-outline-variant/60"></span>
                        <span class="px-3 text-[10px] font-semibold text-outline uppercase tracking-wider">atau dengan email</span>
                        <span class="flex-grow h-[1px] bg-outline-variant/60"></span>
                    </div>

                    <div class="space-y-2.5 text-left">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">mail</span>
                            <input name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">lock</span>
                            <input id="signInPassword" name="password" type="password" required placeholder="Kata sandi akun"
                                   class="w-full pl-10 pr-11 py-2.5 rounded-full bg-surface-container-lowest text-sm focus:outline-none shadow-[inset_2px_2px_5px_#ded4c3,inset_-2px_-2px_5px_#ffffff]"/>
                            <button type="button" onclick="togglePasswordVisibility('signInPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-3 mb-1">
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded"/>
                            <span class="text-[11px] text-on-surface-variant">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="mt-4 w-full py-3 rounded-full bg-primary-container text-white text-xs font-bold tracking-wider hover:bg-primary transition">
                        MASUK
                    </button>

                    <div class="mt-4 p-2.5 bg-secondary/5 border border-secondary/20 rounded-xl text-left">
                        <p class="text-[10px] font-bold text-secondary mb-1">Akun demo:</p>
                        <p class="text-[10px] text-on-surface-variant">Admin: admin@jelajahrasa.test / password</p>
                        <p class="text-[10px] text-on-surface-variant mt-0.5">User: user@jelajahrasa.test / password</p>
                    </div>
                </form>
            </div>

            {{-- SLIDING OVERLAY --}}
            <div class="hidden md:block absolute top-0 left-1/2 w-1/2 h-full overflow-hidden z-20 transition-transform duration-700 ease-in-out"
                 id="overlayContainer">
                <div class="relative -left-full h-full w-[200%] text-white transition-transform duration-700 ease-in-out bg-gradient-to-br from-primary via-primary-container to-secondary"
                     id="overlayTrack">

                    <div class="absolute top-0 left-0 w-1/2 h-full flex flex-col items-center justify-center px-6 text-center">
                        <span class="material-symbols-outlined text-[40px] text-white mb-4">menu_book</span>
                        <h3 class="font-display text-xl lg:text-2xl font-semibold mb-2">Selamat Datang!</h3>
                        <p class="text-xs lg:text-sm text-white/80 max-w-[220px] mb-6">Masuk untuk terhubung dengan resep favoritmu.</p>
                        <button type="button" id="signInButton"
                                class="py-2 px-8 rounded-full bg-transparent text-white text-xs font-bold tracking-wider shadow-[inset_0_0_0_1.5px_#fbf3e4] hover:bg-white hover:text-primary transition">
                            MASUK
                        </button>
                    </div>

                    <div class="absolute top-0 right-0 w-1/2 h-full flex flex-col items-center justify-center px-6 text-center">
                        <span class="material-symbols-outlined text-[40px] text-white mb-4">local_fire_department</span>
                        <h3 class="font-display text-xl lg:text-2xl font-semibold mb-2">Halo, Koki Baru!</h3>
                        <p class="text-xs lg:text-sm text-white/80 max-w-[220px] mb-6">Daftar dan mulai petualangan rempah Nusantara.</p>
                        <button type="button" id="signUpButton"
                                class="py-2 px-8 rounded-full bg-transparent text-white text-xs font-bold tracking-wider shadow-[inset_0_0_0_1.5px_#fbf3e4] hover:bg-white hover:text-primary transition">
                            DAFTAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="w-full py-4 sm:py-5 px-4 sm:px-6 text-center text-[10px] text-outline">
    <p>© {{ date('Y') }} L'Art de Cuisine. Hak Cipta Dilindungi.</p>
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
            mobileTabSignUp.classList.add('bg-primary-container', 'text-white');
            mobileTabSignUp.classList.remove('text-on-surface-variant');
            mobileTabSignIn.classList.remove('bg-primary-container', 'text-white');
            mobileTabSignIn.classList.add('text-on-surface-variant');
        } else {
            signUpPanel.classList.add('hidden');
            signInPanel.classList.add('flex');
            mobileTabSignIn.classList.add('bg-primary-container', 'text-white');
            mobileTabSignIn.classList.remove('text-on-surface-variant');
            mobileTabSignUp.classList.remove('bg-primary-container', 'text-white');
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