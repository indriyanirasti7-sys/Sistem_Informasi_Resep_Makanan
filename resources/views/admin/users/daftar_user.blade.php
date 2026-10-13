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

{{-- ========== FILTER & SEARCH ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-4 shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 mb-5">
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
        <div class="relative flex-1 flex items-center">
            <span class="material-symbols-outlined absolute left-4 text-[20px] text-on-surface-variant pointer-events-none">search</span>
            <input type="search" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama atau email..."
                   class="w-full pl-11 pr-4 py-2.5 rounded-full bg-surface-container-low text-on-surface placeholder:text-on-surface-variant/70 text-sm focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all"/>
        </div>

        <div class="relative min-w-[160px]">
            <select name="role" onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-2.5 pr-9 rounded-full bg-surface-container-low text-on-surface text-xs font-bold cursor-pointer focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                <option value="all" @selected(request('role', 'all') === 'all')>Semua Peran</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="user" @selected(request('role') === 'user')>User</option>
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
        </div>

        <div class="relative min-w-[220px]">
            <select name="sort" onchange="this.form.submit()"
                    class="w-full appearance-none px-4 py-2.5 pr-9 rounded-full bg-surface-container-low text-on-surface text-xs font-bold cursor-pointer focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all">
                <option value="newest" @selected(request('sort', 'newest') === 'newest')>Urutkan: Paling Baru</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Urutkan: Nama A-Z</option>
                <option value="name_desc" @selected(request('sort') === 'name_desc')>Urutkan: Nama Z-A</option>
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant pointer-events-none">expand_more</span>
        </div>
    </form>

    <div class="flex items-center justify-between lg:justify-end gap-4">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-on-surface-variant hover:text-primary hover:bg-surface-container transition text-xs font-bold">
            <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            <span>Reset</span>
        </a>
        <div class="h-4 w-px bg-outline-variant hidden sm:block"></div>
        <span class="text-xs text-on-surface-variant whitespace-nowrap">
            Menampilkan <strong class="text-primary font-bold">{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</strong>
            dari <strong class="text-primary font-bold">{{ number_format($users->total(), 0, ',', '.') }}</strong> pengguna
        </span>
    </div>
</section>

{{-- ========== TABEL USER ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/70 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl">Pengguna</th>
                    <th class="py-3.5 px-4">Email</th>
                    <th class="py-3.5 px-4">Peran</th>
                    <th class="py-3.5 px-4 text-center">Resep Disimpan</th>
                    <th class="py-3.5 px-4 text-center">Ulasan Dibuat</th>
                    <th class="py-3.5 px-4">Bergabung</th>
                    <th class="py-3.5 px-4 text-right rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($users as $user)
                    @php
                        $isMe = auth()->id() === $user->id;
                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                    @endphp
                    <tr class="hover:bg-surface-container-low/40 transition-colors {{ $isMe ? 'bg-surface-container-high/20' : '' }}">
                        {{-- Pengguna --}}
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

                        {{-- Email --}}
                        <td class="py-4 px-4 text-sm text-on-surface-variant">{{ $user->email }}</td>

                        {{-- Peran --}}
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

                        {{-- Resep Disimpan --}}
                        <td class="py-4 px-4 text-center">
                            <div class="inline-flex items-center gap-1.5 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-secondary">bookmark</span>
                                <span class="font-bold">{{ $user->bookmarks_count ?? 0 }}</span>
                            </div>
                        </td>

                        {{-- Ulasan Dibuat --}}
                        <td class="py-4 px-4 text-center">
                            <div class="inline-flex items-center gap-1.5 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-tertiary-container" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="font-bold">{{ $user->ratings_count ?? 0 }}</span>
                            </div>
                        </td>

                        {{-- Bergabung --}}
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ optional($user->created_at)->translatedFormat('d M Y') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1">
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="w-9 h-9 rounded-full bg-surface-container-high hover:bg-surface-container text-on-surface-variant hover:text-primary flex items-center justify-center transition" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <button type="button"
                                        class="edit-role-btn w-9 h-9 rounded-full bg-surface-container-high hover:bg-surface-container text-on-surface-variant hover:text-primary flex items-center justify-center transition"
                                        data-user-name="{{ $user->name }}"
                                        data-user-email="{{ $user->email }}"
                                        data-user-role="{{ $user->role }}"
                                        data-update-url="{{ route('admin.users.update', $user->id) }}"
                                        title="Ubah Peran">
                                    <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                                </button>
                                @unless ($isMe)
                                    <button type="button"
                                            class="delete-btn w-9 h-9 rounded-full bg-error-container/60 hover:bg-error-container text-error flex items-center justify-center transition"
                                            data-user-name="{{ $user->name }}"
                                            data-user-bookmarks="{{ $user->bookmarks_count ?? 0 }}"
                                            data-user-ratings="{{ $user->ratings_count ?? 0 }}"
                                            data-delete-url="{{ route('admin.users.destroy', $user->id) }}"
                                            title="Hapus User">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[32px]">group</span>
                                </div>
                                <h3 class="font-display text-xl text-primary font-bold">Tidak Ada Pengguna</h3>
                                <p class="text-sm text-on-surface-variant max-w-md">
                                    Tidak ada pengguna yang cocok dengan filter yang dipilih.
                                </p>
                            </div>
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