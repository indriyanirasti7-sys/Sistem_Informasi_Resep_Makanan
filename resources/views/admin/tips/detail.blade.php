@extends('admin.layout')

@section('title', 'Detail Tips — Jelajah Rasa')
@section('breadcrumb', 'Detail Tips')

@section('content')

<div class="w-full mx-auto pb-12">

    {{-- ========== HEADER (SERAGAM DENGAN HALAMAN LAIN) ========== --}}
    <header class="flex flex-col gap-2 mb-8 pt-8">
        
        {{-- TOMBOL KEMBALI DI ATAS KIRI --}}
        <a href="{{ route('admin.tips.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-container-highest text-primary text-sm font-bold rounded-full transition-all w-fit mb-3 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Tips
        </a>

        {{-- JUDUL --}}
        <div class="flex items-center gap-2 mt-2">
            <span class="material-symbols-outlined text-[28px] text-primary">article</span>
            <h1 class="font-['Playfair_Display'] text-3xl text-primary tracking-tight font-bold">
                Detail Tips: {{ $tip->title }}
            </h1>
        </div>

        <p class="text-sm text-on-surface-variant mt-1">
            Tinjau detail lengkap artikel tips, kategori, dan isi konten sebelum dipublikasikan.
        </p>
    </header>

    <!-- 2. Metadata & Status Banner -->
    <div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-6 shadow-sm mb-6 flex flex-col gap-5">
        
        <!-- Baris Atas: Status, Kategori, Penulis -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-surface-container-high">
            <div class="flex flex-wrap items-center gap-2">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $tip->status === 'published' ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container text-on-surface-variant' }} text-[11px] font-bold">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $tip->status === 'published' ? 'bg-secondary' : 'bg-outline' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $tip->status === 'published' ? 'bg-secondary' : 'bg-outline' }}"></span>
                    </span>
                    {{ $tip->status === 'published' ? 'Dipublikasikan (Live)' : 'Draf' }}
                </div>
                
                <span class="px-3 py-1.5 rounded-full bg-surface-container-low text-primary text-[11px] font-bold">
                    Kategori: Umum
                </span>
                
                <span class="px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant text-[11px]">
                    Tingkat: <strong class="text-primary">Pemula</strong>
                </span>
            </div>

            <div class="flex items-center gap-3 bg-surface-container-low px-4 py-2 rounded-2xl w-fit">
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs shrink-0">
                    {{ substr($tip->user->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-primary leading-tight">{{ $tip->user->name ?? 'Anonim' }}</span>
                    <span class="text-[10px] text-on-surface-variant leading-tight">{{ $tip->user->email ?? 'email@domain.com' }}</span>
                </div>
            </div>
        </div>

        <!-- Baris Bawah: Quick Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-surface-container-low rounded-2xl p-4 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Tanggal Dibuat</span>
                <span class="text-sm text-primary font-bold mt-1">{{ $tip->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
            <div class="bg-surface-container-low rounded-2xl p-4 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Terakhir Diperbarui</span>
                <span class="text-sm text-primary font-bold mt-1">{{ $tip->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>
            <div class="bg-surface-container-low rounded-2xl p-4 flex flex-col">
                <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Waktu Baca</span>
                <span class="text-sm text-secondary font-bold mt-1">{{ ceil(str_word_count(strip_tags($tip->content)) / 200) }} Menit Baca</span>
            </div>
        </div>
    </div>

    <!-- 3. Area Konten Utama -->
    <div class="w-full flex flex-col gap-6 mb-6">
        
        <!-- A. Hero Image & Title -->
        <article class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col gap-6">
            
            <!-- Hero Image -->
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-sm group bg-surface-container-high">
                @if($tip->image)
                    <img src="{{ asset('storage/'.$tip->image) }}" alt="{{ $tip->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
                @else
                    <div class="w-full h-full flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined text-[64px]">image_not_supported</span>
                    </div>
                @endif
            </div>

            <!-- Title & Lead-in -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                    <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Panduan Teknik Fundamental Dapur</span>
                </div>
                
                <h1 class="font-['Playfair_Display'] text-2xl sm:text-3xl text-primary font-bold leading-tight">
                    {{ $tip->title }}
                </h1>

                <div class="bg-surface-container-low rounded-2xl p-5 text-on-surface-variant italic text-sm leading-relaxed border-l-4 border-secondary">
                    "{{ Str::limit(strip_tags($tip->content), 200) }}"
                </div>
            </div>
        </article>

        <!-- B. Isi Artikel & Tags -->
        <article class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col gap-6">
    
            <div class="prose prose-sm sm:prose-base max-w-none text-on-surface leading-relaxed">
                {!! $tip->content !!}
            </div>

            <!-- Tags -->
            <div class="flex flex-col gap-2 pt-6 border-t border-surface-container-high">
                <span class="text-[11px] uppercase tracking-wider text-outline font-bold">Taksonomi & Kata Kunci Meta:</span>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#KnifeSkills</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#KeamananDapur</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#MiseEnPlace</span>
                    <span class="px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-medium">#GastronomiDasar</span>
                </div>
            </div>
        </article>

        <!-- Catatan Audit Internal -->
        <section class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 shadow-sm flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-surface-container-high pb-4">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[24px]">verified_user</span>
                        <h2 class="text-xl text-primary font-bold">Catatan Audit & Evaluasi Internal</h2>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">Log operasional tim kurator dan kepala koki dapur uji.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-surface-container text-on-surface-variant text-xs font-bold self-start sm:self-auto">
                    2 Log Aktif
                </span>
            </div>

            <!-- Timeline Log -->
            <div class="flex flex-col gap-4" id="audit-log-container">
                <!-- Log 1 -->
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-surface-container-low">
                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">A</div>
                    <div class="flex flex-col flex-grow">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-primary">{{ $tip->user->name ?? 'Admin' }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-primary-container text-white text-[10px] font-bold">Super Admin</span>
                            </div>
                            <span class="text-[11px] text-outline">{{ $tip->updated_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>
                        <p class="text-sm text-on-surface mt-2 leading-relaxed">
                            Memperbarui naskah panduan, mengganti foto utama, dan menyelaraskan taksonomi tagar untuk kebutuhan SEO.
                        </p>
                    </div>
                </div>

                <!-- Log 2 -->
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-surface-container-low">
                    <div class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center font-bold shrink-0">M</div>
                    <div class="flex flex-col flex-grow">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-primary">Maya Kartika</span>
                                <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold">Editor Konten</span>
                            </div>
                            <span class="text-[11px] text-outline">14 September 2026, 09:20 WIB</span>
                        </div>
                        <p class="text-sm text-on-surface mt-2 leading-relaxed">
                            Menambahkan istilah terminologi Prancis (chiffonade & brunoise) serta mengoptimalkan meta deskripsi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form Tambah Catatan Baru -->
        <div class="bg-surface-container-low rounded-3xl p-6 shadow-sm flex flex-col gap-4">
            <label class="text-sm font-bold text-primary flex items-center gap-2" for="admin-note-input">
                <span class="material-symbols-outlined text-[18px]">add_comment</span>
                Tambah Catatan Operasional Baru
            </label>
            
            <textarea id="admin-note-input" rows="3" placeholder="Tulis instruksi revisi, jadwal pembaruan materi, atau catatan penting..."
                      class="w-full p-4 rounded-2xl bg-surface-container-lowest text-on-surface placeholder:text-outline text-sm outline-none shadow-sm focus:ring-2 focus:ring-secondary/40 transition-all resize-y"></textarea>
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-1">
                <span class="text-[11px] text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px] text-outline">lock</span>
                    Catatan ini hanya dapat dibaca oleh staf editorial.
                </span>
                <button type="button" id="save-note-btn" class="px-6 py-2.5 rounded-full bg-primary-container text-white hover:bg-primary transition-all text-sm font-bold flex items-center justify-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Catatan
                </button>
            </div>
        </div>

    </div> <!-- Penutup Area Konten Utama -->

    {{-- ========== BOTTOM ACTIONS (HAPUS & EDIT DI BAWAH) ========== --}}
    <div class="flex items-center justify-between pt-6 border-t border-surface-container-high mt-2">
        
        {{-- Kiri Bawah: Kembali --}}
        <a href="{{ route('admin.tips.index') }}"
           class="px-6 py-3 rounded-full bg-surface-container-high text-primary text-sm font-bold hover:bg-surface-container transition">
            Batal
        </a>

        {{-- Kanan Bawah: Hapus & Edit --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Hapus (Memanggil Modal) --}}
            <button type="button" 
                    class="delete-tip-btn flex items-center gap-2 px-6 py-3 rounded-full bg-error-container text-error text-sm font-bold hover:bg-error hover:text-white transition-all" 
                    data-title="{{ $tip->title }}"
                    data-url="{{ route('admin.tips.destroy', $tip->id) }}">
                <span class="material-symbols-outlined text-[18px]">delete</span>
                Hapus
            </button>
            
            {{-- Tombol Edit --}}
            <a href="{{ route('admin.tips.edit', $tip->slug) }}" 
               class="flex items-center gap-2 px-8 py-3 rounded-full bg-primary text-white text-sm font-bold shadow-sm hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined text-[18px]">edit_note</span>
                Edit Tips
            </a>
        </div>
    </div>

</div>

{{-- ============================================================
     MODAL: Konfirmasi Hapus Tips
     ============================================================ --}}
<div id="deleteTipModal"
     class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-container-lowest rounded-3xl max-w-md w-full p-8 shadow-[0_16px_40px_-6px_rgba(90,58,34,0.18)] flex flex-col items-center text-center">

        <div class="w-16 h-16 rounded-full bg-error-container text-error flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-[32px]">warning</span>
        </div>

        <h3 class="font-display text-2xl text-primary font-bold">Hapus Tips Ini?</h3>
        <p class="text-sm text-on-surface-variant mt-2 leading-relaxed">
            Artikel <strong class="text-primary font-bold" id="deleteTipTitle">—</strong>
            akan dihapus permanen dari portal. Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex items-center gap-3 mt-8 w-full">
            {{-- Tombol Batal --}}
            <button type="button" id="cancelDeleteTipBtn" class="flex-1 py-2.5 rounded-full bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition">
                Batal
            </button>
            
            {{-- Form Hapus --}}
            <form id="deleteTipForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 rounded-full bg-error text-white font-bold text-sm hover:bg-error/90 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- SCRIPT UNTUK MODAL HAPUS ---
    (function () {
        const deleteModal  = document.getElementById('deleteTipModal');
        const deleteForm   = document.getElementById('deleteTipForm');
        const deleteTarget = document.getElementById('deleteTipTitle');
        const cancelDelete = document.getElementById('cancelDeleteTipBtn');

        function openDeleteModal(btn) {
            deleteTarget.textContent = btn.dataset.title;
            deleteForm.action = btn.dataset.url;
            
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.delete-tip-btn');
            if (btn) {
                openDeleteModal(btn);
            }
        });

        cancelDelete.addEventListener('click', closeDeleteModal);
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDeleteModal();
        });

        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) closeDeleteModal();
        });
    })();

    // --- SCRIPT UNTUK CATATAN AUDIT (BAWAAN ANDA) ---
    document.getElementById('save-note-btn')?.addEventListener('click', function() {
        const input = document.getElementById('admin-note-input');
        const text = input.value.trim();
        const container = document.getElementById('audit-log-container');

        if (!text) {
            input.focus();
            return;
        }

        const date = new Date();
        const options = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        const dateStr = date.toLocaleDateString('id-ID', options) + ' WIB';

        const newLog = document.createElement('div');
        newLog.className = 'flex items-start gap-4 p-4 rounded-xl bg-surface-container-lowest border border-secondary/30 shadow-sm animate-pulse';
        newLog.innerHTML = `
            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">A</div>
            <div class="flex flex-col flex-grow">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-primary">Anda</span>
                        <span class="px-2 py-0.5 rounded-full bg-primary-container text-white text-[10px] font-bold">Super Admin</span>
                    </div>
                    <span class="text-[11px] text-outline">${dateStr}</span>
                </div>
                <p class="text-sm text-on-surface mt-2 leading-relaxed">${text.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</p>
            </div>
        `;

        container.prepend(newLog);
        input.value = '';
        
        // Hapus animasi pulse setelah ditambahkan
        setTimeout(() => newLog.classList.remove('animate-pulse', 'border-secondary/30'), 1000);
    });
</script>
@endpush