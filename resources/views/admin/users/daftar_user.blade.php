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
</header>

{{-- ========== TABEL USER (KERANGKA) ========== --}}
<section class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm">
    <div class="w-full overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/70 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl">Nama</th>
                    <th class="py-3.5 px-4">Email</th>
                    <th class="py-3.5 px-4">Peran</th>
                    <th class="py-3.5 px-4 rounded-r-2xl">Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($users as $user)
                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                        <td class="py-4 px-4 font-bold text-primary">{{ $user->name }}</td>
                        <td class="py-4 px-4 text-sm text-on-surface-variant">{{ $user->email }}</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold
                                {{ $user->role === 'admin'
                                    ? 'bg-primary-container text-white'
                                    : 'bg-secondary-container text-on-secondary-fixed-variant' }}">
                                {{ ucfirst($user->role) }}
                            </span>
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