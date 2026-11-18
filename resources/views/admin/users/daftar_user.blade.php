@extends('admin.layout')

@section('title', 'Data User — Griya Rasa')
@section('breadcrumb', 'Data User')

@section('content')

{{-- ========== HEADER ========== --}}
<header class="flex flex-col gap-6 mb-8 pt-8">
    <div class="flex flex-col gap-1.5">
        <h1 class="font-['Playfair_Display'] text-4xl text-primary tracking-tight font-bold">Data User</h1>
        <p class="text-sm text-on-surface-variant max-w-xl">
            Kelola akun pengguna, termasuk admin dan anggota komunitas, untuk mengatur hak akses dan aktivitas di portal Griya Rasa.
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
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-surface-container-low/70 text-on-surface-variant text-[11px] uppercase tracking-wider font-bold">
                    <th class="py-3.5 px-4 rounded-l-2xl text-center">Pengguna</th>
                    <th class="py-3.5 px-4 text-center">Email</th>
                    <th class="py-3.5 px-4 text-center">Peran</th>
                    <th class="py-3.5 px-4 text-center">Resep Disimpan</th>
                    <th class="py-3.5 px-4 text-center">Ulasan Dibuat</th>
                    <th class="py-3.5 px-4 text-center">Bergabung</th>
                    <th class="py-3.5 px-4 text-center rounded-r-2xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high/40 text-on-surface">
                @forelse ($users as $user)
                    @php
                        $isMe = auth()->id() === $user->id;
                        $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                    @endphp
                    <tr class="hover:bg-surface-container-low/40 transition-colors {{ $isMe ? 'bg-surface-container-high/20' : '' }}">
                        
                        {{-- Kolom Pengguna --}}
                        <td class="py-4 px-4">
                            <div class="flex items-center justify-center">
                                <div class="flex items-center gap-3 w-full max-w-[200px]"> 
                                    {{-- Avatar --}}
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-container/20 shrink-0"/>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    
                                    {{-- Nama & Role --}}
                                    <div class="flex flex-col text-left min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold text-primary truncate">{{ $user->name }}</span>
                                            @if ($isMe)
                                                <span class="px-1.5 py-0.5 rounded-md bg-primary-fixed text-on-primary-fixed text-[9px] font-bold shrink-0">Anda</span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-on-surface-variant truncate">
                                            {{ $user->role === 'admin' ? 'Kepala Kurator Gastronomi' : 'Anggota Komunitas' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="py-4 px-4 text-sm text-on-surface-variant">{{ $user->email }}</td>

                        {{-- Peran --}}
                        <td class="py-4 px-4">
                            <div class="flex justify-center">
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
                            </div>
                        </td>

                        {{-- Resep Disimpan --}}
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center justify-center gap-1.5 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-secondary">bookmark</span>
                                <span class="font-bold">{{ $user->bookmarks_count ?? 0 }}</span>
                            </div>
                        </td>

                        {{-- Ulasan Dibuat --}}
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center justify-center gap-1.5 text-sm text-on-surface">
                                <span class="material-symbols-outlined text-[16px] text-tertiary-container" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="font-bold">{{ $user->ratings_count ?? 0 }}</span>
                            </div>
                        </td>

                        {{-- Bergabung --}}
                        <td class="py-4 px-4 text-xs text-on-surface-variant">
                            {{ optional($user->created_at)->translatedFormat('d M Y') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center justify-center gap-1">
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

    {{-- ========================================== --}}
    {{-- PAGINATION (DESAIN BARU)                  --}}
    {{-- ========================================== --}}
    @if ($users->hasPages())
        <div class="mt-8 pt-6 flex flex-col items-center justify-center gap-4 border-t border-surface-container">
            
            <div class="flex items-center gap-1.5">
                {{-- Prev --}}
                @if ($users->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-full text-outline/50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $users->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                    @if ($page == $users->currentPage())
                        <span class="w-9 h-9 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shadow-md transform scale-110">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="w-9 h-9 rounded-full text-on-surface-variant text-xs font-bold flex items-center justify-center hover:bg-surface-container transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-surface-container transition">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-full text-outline/50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </span>
                @endif
            </div>

            <span class="text-[11px] text-on-surface-variant font-medium">
                Menampilkan <strong class="text-primary">{{ $users->firstItem() }}-{{ $users->lastItem() }}</strong>
                dari <strong class="text-primary">{{ $users->total() }}</strong> pengguna
            </span>
        </div>
    @endif
</section>

{{-- ========== MODAL: Ubah Peran ========== --}}
<div id="roleModal" class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-lg w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)]">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">manage_accounts</span>
            </div>
            <div class="flex flex-col flex-1">
                <h3 class="font-display text-2xl text-primary font-bold">Ubah Peran Pengguna</h3>
                <p class="text-sm text-on-surface-variant mt-1">
                    Pilih tingkat hak akses untuk <strong id="roleModalName">—</strong>
                    (<span class="text-secondary" id="roleModalEmail">—</span>)
                </p>
            </div>
        </div>

        <form id="roleForm" method="POST" action="" class="mt-6">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-3">
                <label class="flex items-start gap-3 p-4 rounded-2xl bg-secondary-container/40 cursor-pointer shadow-sm hover:bg-secondary-container/60 transition">
                    <input type="radio" name="role" value="user" class="mt-1 accent-primary w-4 h-4 role-radio"/>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-primary">User</span>
                            <span class="px-2 py-0.5 rounded-full bg-secondary text-white text-[10px] font-bold">Terbatas</span>
                        </div>
                        <span class="text-sm text-on-surface-variant mt-1">
                            Akses menyimpan resep, memberi ulasan bintang, dan menyukai tips kuliner.
                        </span>
                    </div>
                </label>
                <label class="flex items-start gap-3 p-4 rounded-2xl bg-surface-container-low hover:bg-surface-container cursor-pointer transition">
                    <input type="radio" name="role" value="admin" class="mt-1 accent-primary w-4 h-4 role-radio"/>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-primary">Admin</span>
                            <span class="px-2 py-0.5 rounded-full bg-primary-container text-white text-[10px] font-bold">Super Privilese</span>
                        </div>
                        <span class="text-sm text-on-surface-variant mt-1">
                            Hak akses penuh mengelola resep, kategori, tips, dan data pengguna portal.
                        </span>
                    </div>
                </label>
            </div>
            <div class="mt-5 p-4 rounded-2xl bg-tertiary-fixed/60 flex items-start gap-3">
                <span class="material-symbols-outlined text-[20px] text-tertiary-container mt-0.5">info</span>
                <p class="text-sm text-on-tertiary-fixed-variant leading-relaxed">
                    <strong>Peringatan:</strong> Admin dapat mengelola, menyunting, dan menghapus seluruh isi situs Griya Rasa.
                </p>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-surface-container-high">
                <button type="button" id="cancelRoleBtn"
                        class="px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant hover:text-primary text-sm font-bold transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========== MODAL: Konfirmasi Hapus ========== --}}
<div id="deleteUserModal" class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-md w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)]">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-error-container text-error flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">warning</span>
            </div>
            <div class="flex flex-col flex-1">
                <h3 class="font-display text-2xl text-primary font-bold">Hapus User Ini?</h3>
                <p class="text-sm text-on-surface-variant mt-1">
                    Akun <strong id="deleteUserName">—</strong> akan dihapus permanen.
                </p>
            </div>
        </div>

        <div class="mt-5 p-4 rounded-2xl bg-error-container/40 flex items-start gap-3">
            <span class="material-symbols-outlined text-[20px] text-error mt-0.5">delete_forever</span>
            <p class="text-sm text-on-surface leading-relaxed">
                <strong>Dampak:</strong> Seluruh riwayat bookmark
                (<strong id="deleteUserBookmarks">0</strong> resep) dan
                (<strong id="deleteUserRatings">0</strong> ulasan) akan otomatis terhapus.
            </p>
        </div>

        <form id="deleteUserForm" method="POST" action="" class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-surface-container-high">
            @csrf
            @method('DELETE')
            <button type="button" id="cancelDeleteUserBtn"
                    class="px-6 py-2.5 rounded-full bg-surface-container-high text-on-surface-variant hover:text-primary text-sm font-bold transition">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-error text-white text-sm font-bold shadow-sm hover:opacity-90 transition">
                <span class="material-symbols-outlined text-[18px]">delete</span>
                <span>Ya, Hapus Akun</span>
            </button>
        </form>
    </div>
</div>

{{-- ========== TOAST ========== --}}
<div id="toastSuccess"
     class="fixed bottom-6 right-6 z-50 bg-primary-container text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-2.5 transition-all transform translate-y-24 opacity-0 pointer-events-none">
    <span class="material-symbols-outlined text-[20px] text-secondary-fixed">check_circle</span>
    <span class="text-sm font-bold" id="toastMessage">Berhasil!</span>
</div>
@endsection

@push('scripts')
<script>
(function () {
    /* ===== Modal Ubah Peran ===== */
    const roleModal     = document.getElementById('roleModal');
    const roleForm      = document.getElementById('roleForm');
    const roleModalName = document.getElementById('roleModalName');
    const roleModalEmail= document.getElementById('roleModalEmail');
    const cancelRoleBtn = document.getElementById('cancelRoleBtn');

    function openRoleModal(data) {
        roleModalName.textContent  = data.name;
        roleModalEmail.textContent = data.email;
        roleForm.action = data.updateUrl;
        document.querySelectorAll('.role-radio').forEach(r => { r.checked = r.value === data.role; });
        roleModal.classList.remove('hidden');
        roleModal.classList.add('flex');
    }
    function closeRoleModal() {
        roleModal.classList.add('hidden');
        roleModal.classList.remove('flex');
    }
    document.querySelectorAll('.edit-role-btn').forEach(btn => {
        btn.addEventListener('click', () => openRoleModal({
            name:      btn.dataset.userName,
            email:     btn.dataset.userEmail,
            role:      btn.dataset.userRole,
            updateUrl: btn.dataset.updateUrl,
        }));
    });
    cancelRoleBtn.addEventListener('click', closeRoleModal);

    /* ===== Modal Hapus ===== */
    const deleteModal     = document.getElementById('deleteUserModal');
    const deleteForm      = document.getElementById('deleteUserForm');
    const deleteName      = document.getElementById('deleteUserName');
    const deleteBookmarks = document.getElementById('deleteUserBookmarks');
    const deleteRatings   = document.getElementById('deleteUserRatings');
    const cancelDeleteBtn = document.getElementById('cancelDeleteUserBtn');

    function openDeleteModal(data) {
        deleteName.textContent      = data.name;
        deleteBookmarks.textContent = data.bookmarks;
        deleteRatings.textContent   = data.ratings;
        deleteForm.action = data.deleteUrl;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => openDeleteModal({
            name:      btn.dataset.userName,
            bookmarks: btn.dataset.userBookmarks,
            ratings:   btn.dataset.userRatings,
            deleteUrl: btn.dataset.deleteUrl,
        }));
    });
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);

    /* ===== Escape handler ===== */
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') { closeRoleModal(); closeDeleteModal(); }
    });

    /* ===== Toast dari flash message ===== */
    @if (session('success'))
        (function () {
            const toast = document.getElementById('toastSuccess');
            document.getElementById('toastMessage').textContent = @json(session('success'));
            toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
            }, 3200);
        })();
    @endif
})();
</script>
@endpush