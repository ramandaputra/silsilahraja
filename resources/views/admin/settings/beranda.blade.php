<x-app-layout>
    @section('page-title', 'Pengaturan Situs')

    <div class="max-w-4xl mx-auto space-y-lg">
        
        <div class="flex items-center justify-between border-b border-outline-variant/60 pb-sm">
            <p class="text-on-surface-variant text-sm md:text-base">Kelola konten dinamis untuk Halaman Utama (Beranda) dan Halaman Profil Penyusun (About Us) secara terpusat.</p>
        </div>

        @if(session('success'))
        <div class="p-5 bg-white border-2 border-emerald-500 rounded-xl flex items-center gap-md shadow-md text-sm font-semibold text-on-background">
            <span class="material-symbols-outlined text-emerald-600 text-2xl shrink-0">check_circle</span>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-lg">
            @csrf
            @method('PUT')

            <div class="space-y-md">
                <div class="flex items-center gap-xs px-xs">
                    <span class="material-symbols-outlined text-secondary font-bold">home</span>
                    <h2 class="font-headline-md text-base font-bold text-primary uppercase tracking-wider">Konten Halaman Beranda (index.blade.php)</h2>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">language</span> Pengaturan Umum
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Situs (Meta Title)</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">view_frontpage</span> Hero Banner Beranda
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Utama Hero</label>
                        <textarea name="hero_title" rows="2" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Subjudul Hero</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Gambar Latar Belakang Beranda</label>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-sm items-center p-4 bg-surface-container-low border border-outline-variant rounded-xl">
                            <div class="sm:col-span-4">
                                @if(!empty($settings['hero_background']))
                                    <img src="{{ asset('storage/' . $settings['hero_background']) }}" class="w-full h-24 object-cover rounded-xl border border-outline-variant shadow-sm">
                                @else
                                    <div class="w-full h-24 bg-primary rounded-xl flex flex-col items-center justify-center text-white/40 text-[10px] px-2 text-center">
                                        <span class="material-symbols-outlined text-lg mb-1">landscape</span> Gradient Asli
                                    </div>
                                @endif
                            </div>
                            <div class="sm:col-span-8 space-y-2">
                                <input type="file" name="hero_background" accept="image/*" class="w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-secondary file:text-white hover:file:bg-primary file:cursor-pointer transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-md pt-md border-t border-outline-variant/40">
                <div class="flex items-center gap-xs px-xs">
                    <span class="material-symbols-outlined text-secondary font-bold">info</span>
                    <h2 class="font-headline-md text-base font-bold text-primary uppercase tracking-wider">Konten Halaman Tentang Kami (about.blade.php)</h2>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">person_book</span> Teks Banner Profil Penyusun
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Deskripsi Sub-Hero (Di bawah tulisan "Profil Penyusun")</label>
                        <textarea name="about_hero_description" rows="4" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_hero_description', $settings['about_hero_description'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">history_edu</span> Teks Blok Dedikasi & Integritas
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Sejarah/Dedikasi</label>
                        <input type="text" name="about_history_title" value="{{ old('about_history_title', $settings['about_history_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 1</label>
                        <textarea name="about_history_body_1" rows="4" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_1', $settings['about_history_body_1'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 2</label>
                        <textarea name="about_history_body_2" rows="4" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_2', $settings['about_history_body_2'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-outline-variant/40">
                <button type="submit" class="w-full sm:w-auto bg-secondary hover:bg-primary text-white font-bold text-sm px-8 py-4 rounded-full shadow-md flex items-center justify-center gap-xs active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-sm">save</span> Simpan Perubahan Situs (Beranda & Tentang Kami)
                </button>
            </div>
        </form>
    </div>
</x-app-layout>