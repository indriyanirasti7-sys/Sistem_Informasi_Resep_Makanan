<footer class="w-full bg-primary-container text-surface-bright">
    <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-gutter">

            {{-- Brand (Diperlebar menjadi lg:col-span-6 karena newsletter dihapus) --}}
            <div class="lg:col-span-6 flex flex-col gap-space-md pr-0 lg:pr-12">
                <span class="font-headline-md text-headline-md font-semibold text-primary-fixed">Griya Rasa</span>
                <p class="font-body-md text-body-md text-on-primary-container max-w-md">
                    Perpaduan kehangatan tradisi rempah Nusantara dengan keanggunan teknik gastronomi klasik.
                    Eksplorasi resep terkurasi untuk cita rasa otentik.
                </p>
                <div class="flex items-center gap-space-md pt-space-xs">
                    <a href="#" class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-primary-fixed hover:bg-tertiary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">public</span>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-primary-fixed hover:bg-tertiary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-primary-fixed hover:bg-tertiary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">mail</span>
                    </a>
                </div>
            </div>

            {{-- Navigasi (Menggunakan lg:col-span-3) --}}
            <div class="lg:col-span-3 flex flex-col gap-space-sm">
                <span class="font-title-md text-title-md font-bold text-surface-bright mb-space-xs">Navigasi</span>
                <a href="{{ route('home') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Beranda</a>
                <a href="{{ route('recipes.daftar_resep') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Daftar Resep</a>
                <a href="{{ route('recipes.daftar_resep') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Kategori</a>
                <a href="{{ route('tips.panduan') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Tips Memasak</a>
            </div>

            {{-- Eksplorasi (Menggunakan lg:col-span-3) --}}
            <div class="lg:col-span-3 flex flex-col gap-space-sm">
                <span class="font-title-md text-title-md font-bold text-surface-bright mb-space-xs">Eksplorasi</span>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Warisan Rempah</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Teknik Gastronomi</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Buku Resep</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Koki Mitra</a>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="mt-space-2xl pt-space-lg border-t border-primary/40 flex flex-col md:flex-row items-center justify-between gap-space-md text-on-primary-container font-body-sm text-body-sm">
            <p>© {{ date('Y') }} Griya Rasa Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-space-lg">
                <a href="#" class="hover:text-surface-bright transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-surface-bright transition-colors">Syarat &amp; Ketentuan</a>
                <a href="#" class="hover:text-surface-bright transition-colors">Kontak Redaksi</a>
            </div>
        </div>
    </div>
</footer>