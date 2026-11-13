<footer class="w-full bg-primary-container text-surface-bright">
    <div class="max-w-[1280px] mx-auto px-margin-mobile lg:px-margin py-space-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-gutter">

            {{-- Brand --}}
            <div class="lg:col-span-4 flex flex-col gap-space-md">
                <span class="font-headline-md text-headline-md font-semibold text-primary-fixed">Griya Rasa</span>
                <p class="font-body-md text-body-md text-on-primary-container max-w-sm">
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

            {{-- Navigasi --}}
            <div class="lg:col-span-2 flex flex-col gap-space-sm">
                <span class="font-title-md text-title-md font-bold text-surface-bright mb-space-xs">Navigasi</span>
                <a href="{{ route('home') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Beranda</a>
                <a href="{{ route('recipes.daftar_resep') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Daftar Resep</a>
                <a href="{{ route('recipes.daftar_resep') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Kategori</a>
                <a href="{{ route('tips.panduan') }}" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Tips Memasak</a>
            </div>

            {{-- Eksplorasi --}}
            <div class="lg:col-span-2 flex flex-col gap-space-sm">
                <span class="font-title-md text-title-md font-bold text-surface-bright mb-space-xs">Eksplorasi</span>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Warisan Rempah</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Teknik Gastronomi</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Buku Resep</a>
                <a href="#" class="font-body-sm text-body-sm text-on-primary-container hover:text-surface-bright transition-colors">Koki Mitra</a>
            </div>

            {{-- Newsletter --}}
            <div class="lg:col-span-4 flex flex-col gap-space-sm">
                <span class="font-title-md text-title-md font-bold text-surface-bright mb-space-xs">Warta Rasa Mingguan</span>
                <p class="font-body-sm text-body-sm text-on-primary-container">
                    Dapatkan resep eksklusif dan rahasia bumbu langsung di kotak masuk Anda.
                </p>
                <form class="flex items-center gap-space-xs mt-space-xs" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Alamat email Anda..."
                           class="w-full px-space-md py-space-sm bg-primary text-surface font-body-sm text-body-sm rounded-full placeholder:text-outline-variant focus:outline-none" />
                    <button type="submit"
                            class="px-space-lg py-space-sm bg-secondary text-on-secondary font-label-md text-label-md rounded-full hover:bg-secondary/90 transition-colors whitespace-nowrap">
                        Langganan
                    </button>
                </form>
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