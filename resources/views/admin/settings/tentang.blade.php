<x-app-layout>
    @section('page-title', 'Pengaturan Situs')

    <div class="max-w-4xl mx-auto">
        <div class="flex border-b border-outline-variant/60 mb-lg gap-xs">
            <a href="{{ route('admin.settings.beranda') }}" class="px-md py-sm font-headline-md text-[14px] font-medium text-on-surface-variant hover:text-primary hover:border-b-2 hover:border-outline transition-all flex items-center gap-xs">
                <span class="material-symbols-outlined text-[18px]">home</span> Settings Beranda
            </a>
            <a href="{{ route('admin.settings.tentang') }}" class="px-md py-sm font-headline-md text-[14px] font-bold border-b-2 border-secondary text-secondary flex items-center gap-xs">
                <span class="material-symbols-outlined text-[18px]">info</span> Settings Tentang Kami
            </a>
        </div>

        @if(session('success'))
        <div class="mb-lg p-5 bg-white border-2 border-emerald-500 rounded-xl flex items-center gap-md shadow-md text-sm font-semibold text-on-background">
            <span class="material-symbols-outlined text-emerald-600 text-2xl shrink-0">check_circle</span>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <form action="{{ route('admin.settings.tentang.update') }}" method="POST" class="space-y-lg">
            @csrf
            @method('PUT')

            <div class="bento-card p-6 rounded-xl space-y-4">
                <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                    <span class="material-symbols-outlined text-secondary">history_edu</span> Konten Sejarah & Warisan
                </h3>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Sejarah</label>
                    <input type="text" name="history_title" value="{{ old('history_title', $settings['history_title']) }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    @error('history_title') <p class="text-error text-xs font-medium mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Isi Paragraf Sejarah</label>
                    <textarea name="history_body_1" rows="6" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('history_body_1', $settings['history_body_1']) }}</textarea>
                    @error('history_body_1') <p class="text-error text-xs font-medium mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="w-full sm:w-auto bg-secondary hover:bg-primary text-white font-bold text-sm px-6 py-3.5 rounded-full shadow-md flex items-center justify-center gap-xs active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-sm">save</span> Simpan Pengaturan Tentang Kami
                </button>
            </div>
        </form>
    </div>
</x-app-layout>