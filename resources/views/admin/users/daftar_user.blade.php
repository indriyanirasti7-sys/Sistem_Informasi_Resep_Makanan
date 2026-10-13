@extends('admin.layout')

@section('title', 'Data User — L\'Art de Cuisine')
@section('breadcrumb', 'Data User')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col gap-1.5 max-w-2xl">
        <div class="flex items-center gap-2 text-secondary">
            <span class="material-symbols-outlined text-lg">group</span>
            <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Direktori &amp; Hak Akses</span>
        </div>
        <h1 class="font-display text-4xl text-primary tracking-tight font-bold">Data User</h1>
        <p class="text-sm text-on-surface-variant">
            Pantau pengguna yang terdaftar di situs dan kelola hak aksesnya.
        </p>
    </div>

    {{-- ========== STAT CARDS ========== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-2">
        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Total User</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ number_format($totalUsers, 0, ',', '.') }}</span>
                    <span class="text-xs text-on-surface-variant">Pengguna</span>
                </div>
                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container text-[11px] font-bold w-fit">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    <span>{{ $newUsersThisMonth }} baru bulan ini</span>
                </span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">group</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">Admin</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $totalAdmins }}</span>
                    <span class="text-xs text-on-surface-variant">Pengelola</span>
                </div>
                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold w-fit">
                    <span class="material-symbols-outlined text-[14px]">shield</span>
                    <span>Akses penuh sistem</span>
                </span>
            </div>
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">admin_panel_settings</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xs text-on-surface-variant font-medium">User Baru Bulan Ini</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="font-display text-3xl text-primary font-bold">{{ $newUsersThisMonth }}</span>
                    <span class="text-xs text-on-surface-variant">Akun</span>
                </div>
                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant text-[11px] font-bold w-fit">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                    <span>Terverifikasi aktif</span>
                </span>
            </div>
            <div class="w-12 h-12 rounded-full bg-secondary-container/70 flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[24px]">person_add</span>
            </div>
        </div>
    </div>
</header>

{{-- ========== TABEL USER ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/70 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl">Pengguna</th>
                    <th class="py-3.5 px-4">Email</th>
                    <th class="py-3.5 px-4">Peran</th>
                    <th class="py-3.5 px-4 rounded-r-2xl">Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($users as $user)
                    @php
                        $isMe = auth()->id() === $user->id;
                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                    @endphp
                    <tr class="hover:bg-surface-container-low/40 transition-colors {{ $isMe ? 'bg-surface-container-high/20' : '' }}">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                         alt="{{ $user->name }}"
                                         class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-container/20"/>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold text-sm">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-primary truncate">{{ $user->name }}</span>
                                        @if ($isMe)
                                            <span class="px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[10px] font-bold">Anda</span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-on-surface-variant">
                                        {{ $user->role === 'admin' ? 'Kepala Kurator Gastronomi' : 'Anggota Komunitas' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm text-on-surface-variant">{{ $user->email }}</td>
                        <td class="py-4 px-4">
                            @if ($user->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container text-white text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    <span>Admin</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container text-on-secondary-fixed-variant text-[11px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                    <span>User</span>
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ optional($user->created_at)->translatedFormat('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center text-sm text-on-surface-variant">
                            Belum ada user terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-6 pt-4 border-t border-surface-container-high">
            {{ $users->links() }}
        </div>
    @endif
</section>

@endsection