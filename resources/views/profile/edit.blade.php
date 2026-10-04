@extends('layouts.app')

@section('title', 'Profil Saya — L\'Art de Cuisine')

@section('content')
<div class="max-w-4xl mx-auto px-5 py-8">

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

    {{-- Profile Card --}}
    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm mb-6">
        <div class="flex items-center gap-4 mb-6">
            <img alt="{{ $user->name }}"
                 class="w-20 h-20 rounded-full object-cover ring-4 ring-primary/20"
                 src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=5a3a22&color=fff&bold=true&size=128' }}" />
            <div>
                <h2 class="text-xl font-bold text-primary">{{ $user->name }}</h2>
                <p class="text-sm text-outline">{{ $user->email }}</p>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                             {{ $user->isAdmin() ? 'bg-primary/10 text-primary' : 'bg-secondary/15 text-secondary' }}">
                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                </span>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 pt-4 border-t border-surface-container">
            <div class="text-center">
                <p class="text-2xl font-bold text-primary">{{ $user->bookmarks()->count() }}</p>
                <p class="text-xs text-outline">Bookmark</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-primary">{{ $user->ratings()->count() }}</p>
                <p class="text-xs text-outline">Ulasan</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-primary">{{ $user->created_at->diffForHumans(null, true) }}</p>
                <p class="text-xs text-outline">Bergabung</p>
            </div>
        </div>
    </div>

    {{-- Form Edit Profil --}}
    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm mb-6">
        <h3 class="text-lg font-bold text-primary mb-4">Informasi Akun</h3>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-error-container text-on-error-container text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                       class="w-full px-4 py-2.5 rounded-xl bg-surface-container text-sm"/>
                <p class="text-[11px] text-outline mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="px-6 py-2.5 rounded-full bg-primary-container text-white text-sm font-bold hover:bg-primary transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Form Ganti Password --}}
    <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm mb-6">
        <h3 class="text-lg font-bold text-primary mb-4">Ganti Password</h3>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                        class="px-6 py-2.5 rounded-full bg-secondary text-white text-sm font-bold hover:opacity-90 transition">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection