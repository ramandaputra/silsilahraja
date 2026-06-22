<x-app-layout>
    @slot('page-title') Dashboard Utama @endslot

    <div class="space-y-lg">
        <div class="bento-card bg-gradient-to-r from-surface-container-lowest to-surface-container-low p-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-md border-l-4 border-primary">
            <div class="space-y-xs">
                <h2 class="font-headline-md text-2xl font-black text-primary">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="font-body-md text-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    Panel kendali Silsilah Raja siap digunakan. Anda memiliki hak akses penuh sebagai <span class="bg-primary-fixed text-on-primary-fixed px-sm py-0.5 rounded-md font-semibold text-xs">Administrator</span> untuk memperbarui silsilah kerajaan.
                </p>
            </div>
            <div class="hidden md:block bg-surface-container-high p-md rounded-2xl border border-outline-variant/30 text-primary/40 shadow-inner">
                <span class="material-symbols-outlined text-[48px] block">admin_panel_settings</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-md">
            <div class="bento-card p-xl bg-surface-container-lowest border-t-4 border-primary flex flex-col justify-between group hover:border-primary-variant transition-all">
                <div class="flex justify-between items-start">
                    <div class="space-y-xs">
                        <span class="font-label-md text-xs font-bold text-outline uppercase tracking-wider block">Total Anggota Silsilah</span>
                        <h2 class="font-headline-lg text-4xl font-black text-primary tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::count() }}</h2>
                    </div>
                    <div class="bg-primary/10 text-primary p-md rounded-xl">
                        <span class="material-symbols-outlined text-[28px] block">schema</span>
                    </div>
                </div>
                <div class="mt-md pt-sm border-t border-outline-variant/30 flex items-center gap-xs text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">database</span> Semua tokoh terdaftar di database publik
                </div>
            </div>

            <div class="bento-card p-xl bg-surface-container-lowest border-t-4 border-secondary flex flex-col justify-between group hover:border-secondary-variant transition-all">
                <div class="flex justify-between items-start">
                    <div class="space-y-xs">
                        <span class="font-label-md text-xs font-bold text-outline uppercase tracking-wider block">Tokoh Laki-Laki</span>
                        <h2 class="font-headline-lg text-4xl font-black text-secondary tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::where('jenis_kelamin', 'L')->count() }}</h2>
                    </div>
                    <div class="bg-secondary/10 text-secondary p-md rounded-xl">
                        <span class="material-symbols-outlined text-[28px] block">man</span>
                    </div>
                </div>
                <div class="mt-md pt-sm border-t border-outline-variant/30 flex items-center gap-xs text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">shield</span> Garis utama pemegang takhta keturunan
                </div>
            </div>

            <div class="bento-card p-xl bg-surface-container-lowest border-t-4 border-error flex flex-col justify-between group hover:border-error-variant transition-all sm:col-span-2 lg:col-span-1">
                <div class="flex justify-between items-start">
                    <div class="space-y-xs">
                        <span class="font-label-md text-xs font-bold text-outline uppercase tracking-wider block">Tokoh Perempuan</span>
                        <h2 class="font-headline-lg text-4xl font-black text-error tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::where('jenis_kelamin', 'P')->count() }}</h2>
                    </div>
                    <div class="bg-error/10 text-error p-md rounded-xl">
                        <span class="material-symbols-outlined text-[28px] block">woman</span>
                    </div>
                </div>
                <div class="mt-md pt-sm border-t border-outline-variant/30 flex items-center gap-xs text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">family_history</span> Putri, permaisuri, dan selir kerajaan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
            <div class="bento-card p-lg bg-surface-container-lowest flex flex-col justify-between space-y-md">
                <div class="space-y-xs">
                    <h5 class="font-title-lg text-base font-bold text-primary flex items-center gap-xs">
                        <span class="material-symbols-outlined text-secondary text-[22px]">bolt</span> Akses Cepat Pengelolaan
                    </h5>
                    <p class="font-body-md text-sm text-on-surface-variant leading-relaxed">
                        Gunakan jalan pintas di bawah untuk langsung memanipulasi, menyunting, dan menyelaraskan bagan pohon keluarga besar kerajaan.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row gap-sm pt-sm">
                    <a href="{{ route('admin.people.index') }}" 
                       class="flex-1 px-md py-sm bg-primary text-on-primary hover:opacity-95 active:scale-[0.98] rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-xs shadow-md transition-all">
                        <span class="material-symbols-outlined text-[18px]">account_tree</span> Kelola Pohon Silsilah
                    </a>
                    <a href="{{ route('admin.people.create') }}" 
                       class="flex-1 px-md py-sm bg-surface-bright border border-outline text-secondary hover:bg-surface-container-low active:scale-[0.98] rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-xs transition-all">
                        <span class="material-symbols-outlined text-[18px]">person_add</span> Tambah Tokoh Baru
                    </a>
                </div>
            </div>

            <div class="bento-card p-lg bg-surface-container-lowest space-y-md border border-outline-variant/40">
                <div class="space-y-xs">
                    <h5 class="font-title-lg text-base font-bold text-primary flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">info</span> Panduan Alur Input Data
                    </h5>
                    <p class="font-body-md text-sm text-on-surface-variant">
                        Agar relasi silsilah terhubung sempurna secara visual pada halaman publik, ikuti kaidah standarisasi berikut:
                    </p>
                </div>
                <div class="bg-surface-container-low p-md rounded-xl border border-outline-variant/60">
                    <ul class="space-y-sm font-body-sm text-xs text-on-surface-variant">
                        <li class="flex items-start gap-sm">
                            <span class="w-5 h-5 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">1</span>
                            <span>Input data <strong>Raja Tetua / Leluhur Teratas</strong> terlebih dahulu dengan mengosongkan relasi Ayah & Ibu.</span>
                        </li>
                        <li class="flex items-start gap-sm">
                            <span class="w-5 h-5 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">2</span>
                            <span>Setelah data generasi teratas tersimpan, lanjutkan pembuatan profil data para <strong>Anak Keturunannya</strong>.</span>
                        </li>
                        <li class="flex items-start gap-sm">
                            <span class="w-5 h-5 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">3</span>
                            <span>Pada formulir anak, tautkan dropdown entitas <strong>Ayah Kandung</strong> atau <strong>Ibu Kandung</strong> ke tokoh leluhur yang diinput sebelumnya.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>