@extends('layouts.app')

@section('title', 'Profil Saya — L\'Art de Cuisine')

@section('content')
{{-- ✅ max-w DIPERLEBAR MENJADI 1200px AGAR TIDAK KOSONG DI PINGGIR --}}
<div class="max-w-[1200px] mx-auto px-5 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-primary">Profil Saya</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola informasi akun dan preferensi Anda.</p>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-secondary-container text-on-secondary-container text-sm font-semibold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ✅ GRID LAYOUT: KIRI (4 Kolom) & KANAN (8 Kolom) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- ========================================== --}}
        {{-- KOLOM KIRI: Profil Card & Statistik --}}
        {{-- ========================================== --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col items-center text-center gap-4 mb-6">
                    <img alt="{{ $user->name }}"
                         class="w-28 h-28 rounded-full object-cover ring-4 ring-primary/20"
                         src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=5a3a22&color=fff&bold=true&size=128' }}" />
                    <div>
                        <h2 class="text-xl font-bold text-primary">{{ $user->name }}</h2>
                        <p class="text-sm text-outline">{{ $user->email }}</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                     {{ $user->isAdmin() ? 'bg-primary/10 text-primary' : 'bg-secondary/15 text-secondary' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-1 gap-3 pt-4 border-t border-surface-container">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low">
                        <span class="text-sm font-semibold text-on-surface-variant flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">bookmark</span> Bookmark
                        </span>
                        <span class="text-lg font-bold text-primary">{{ $user->bookmarks()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low">
                        <span class="text-sm font-semibold text-on-surface-variant flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">star</span> Ulasan
                        </span>
                        <span class="text-lg font-bold text-primary">{{ $user->ratings()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low">
                        <span class="text-sm font-semibold text-on-surface-variant flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">calendar_month</span> Bergabung
                        </span>
                        <span class="text-sm font-bold text-primary">{{ $user->created_at->diffForHumans(null, true) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- KOLOM KANAN: Form Informasi & Password --}}
        {{-- ========================================== --}}
        <div class="lg:col-span-8 flex flex-col gap-6">
            
            {{-- Form Edit Profil --}}
            <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm">
                <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">manage_accounts</span> Informasi Akun
                </h3>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-error-container text-on-error-container text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-primary mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-primary mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-primary mb-1.5">Foto Profil (Opsional)</label>
                        <input type="file" name="avatar" accept="image/*"
                               class="w-full px-4 py-2.5 rounded-xl bg-surface-container text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20"/>
                        <p class="text-[11px] text-outline mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-full bg-primary-container text-white text-sm font-bold hover:bg-primary transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Form Ganti Password --}}
            <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-sm">
                <h3 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">lock_reset</span> Ganti Password
                </h3>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-primary mb-1.5">Password Saat Ini</label>
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-3 rounded-xl bg-surface-container text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        @error('current_password')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-primary mb-1.5">Password Baru</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-primary mb-1.5">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"/>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="px-6 py-2.5 rounded-full bg-secondary text-white text-sm font-bold hover:opacity-90 transition shadow-sm">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection