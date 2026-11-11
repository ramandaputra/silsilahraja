<x-app-layout>
    @slot('page-title') Dashboard Utama @endslot

    <div class="space-y-4 sm:space-y-6">
        <!-- Tombol Kembali -->
        <div class="mb-1">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Beranda Situs</span>
            </a>
        </div>
        <div class="bento-card bg-gradient-to-r from-surface-container-lowest to-surface-container-low p-4 sm:p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6 border-l-4 border-primary">
            <div class="space-y-1.5 sm:space-y-2">
                <h2 class="font-headline-md text-xl sm:text-2xl font-black text-primary">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="font-body-md text-xs sm:text-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    Panel kendali Silsilah Raja siap digunakan. Anda memiliki hak akses sebagai <span class="bg-primary-fixed text-on-primary-fixed px-2 py-0.5 rounded-md font-semibold text-xs">{{ auth()->user()?->role === 'superadmin' ? 'Superadmin' : 'Admin' }}</span> untuk memperbarui silsilah kerajaan.
                </p>
            </div>
            <div class="hidden md:block bg-surface-container-high p-4 rounded-2xl border border-outline-variant/30 text-primary/40 shadow-inner shrink-0">
                <span class="material-symbols-outlined text-[44px] block">admin_panel_settings</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-5">
            <div class="bento-card p-4 sm:p-5 bg-surface-container-lowest border-t-4 border-primary flex flex-col justify-between group hover:border-primary-variant transition-all">
                <div class="flex justify-between items-start gap-2">
                    <div class="space-y-1">
                        <span class="font-label-md text-[11px] sm:text-xs font-bold text-outline uppercase tracking-wider block">Total Anggota Silsilah</span>
                        <h2 class="font-headline-lg text-3xl sm:text-4xl font-black text-primary tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::count() }}</h2>
                    </div>
                    <div class="bg-primary/10 text-primary p-3 rounded-xl shrink-0">
                        <span class="material-symbols-outlined text-[24px] sm:text-[28px] block">schema</span>
                    </div>
                </div>
                <div class="mt-4 pt-2.5 border-t border-outline-variant/30 flex items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">database</span> Semua tokoh terdaftar di database
                </div>
            </div>

            <div class="bento-card p-4 sm:p-5 bg-surface-container-lowest border-t-4 border-secondary flex flex-col justify-between group hover:border-secondary-variant transition-all">
                <div class="flex justify-between items-start gap-2">
                    <div class="space-y-1">
                        <span class="font-label-md text-[11px] sm:text-xs font-bold text-outline uppercase tracking-wider flex items-center gap-1"><i class="bi bi-gender-male text-secondary"></i> Tokoh Laki-Laki</span>
                        <h2 class="font-headline-lg text-3xl sm:text-4xl font-black text-secondary tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::where('jenis_kelamin', 'L')->count() }}</h2>
                    </div>
                    <div class="bg-secondary/10 text-secondary p-3 rounded-xl shrink-0">
                        <i class="bi bi-gender-male text-[24px] sm:text-[28px] block"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2.5 border-t border-outline-variant/30 flex items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">shield</span> Garis utama pemegang takhta keturunan
                </div>
            </div>

            <div class="bento-card p-4 sm:p-5 bg-surface-container-lowest border-t-4 border-error flex flex-col justify-between group hover:border-error-variant transition-all sm:col-span-2 lg:col-span-1">
                <div class="flex justify-between items-start gap-2">
                    <div class="space-y-1">
                        <span class="font-label-md text-[11px] sm:text-xs font-bold text-outline uppercase tracking-wider flex items-center gap-1"><i class="bi bi-gender-female text-error"></i> Tokoh Perempuan</span>
                        <h2 class="font-headline-lg text-3xl sm:text-4xl font-black text-error tracking-tight group-hover:scale-105 transition-transform origin-left">{{ \App\Models\Person::where('jenis_kelamin', 'P')->count() }}</h2>
                    </div>
                    <div class="bg-error/10 text-error p-3 rounded-xl shrink-0">
                        <i class="bi bi-gender-female text-[24px] sm:text-[28px] block"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2.5 border-t border-outline-variant/30 flex items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                    <span class="material-symbols-outlined text-[14px]">family_history</span> Putri, permaisuri, dan selir kerajaan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <div class="bento-card p-4 sm:p-6 bg-surface-container-lowest flex flex-col justify-between space-y-4">
                <div class="space-y-1.5">
                    <h5 class="font-title-lg text-sm sm:text-base font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[20px]">bolt</span> Akses Cepat Pengelolaan
                    </h5>
                    <p class="font-body-md text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                        Gunakan jalan pintas di bawah untuk langsung menyunting, menambah, dan menelusuri bagan silsilah keluarga.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                    <a href="{{ route('admin.people.index') }}" 
                       class="flex-1 min-h-[42px] px-4 py-2.5 bg-primary text-white hover:bg-secondary active:scale-[0.98] rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition-all text-center">
                        <span class="material-symbols-outlined text-[18px]">account_tree</span> Kelola Pohon Silsilah
                    </a>
                    <a href="{{ route('admin.people.create') }}" 
                       class="flex-1 min-h-[42px] px-4 py-2.5 bg-surface-bright border border-outline text-primary hover:bg-surface-container-low active:scale-[0.98] rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-2 transition-all text-center">
                        <span class="material-symbols-outlined text-[18px]">person_add</span> Tambah Tokoh Baru
                    </a>
                </div>
            </div>

            <div class="bento-card p-4 sm:p-6 bg-surface-container-lowest space-y-3.5 border border-outline-variant/40">
                <div class="space-y-1.5">
                    <h5 class="font-title-lg text-sm sm:text-base font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[20px]">swap_vert</span> Panduan Alur Input Data (Dua Arah)
                    </h5>
                    <p class="font-body-md text-xs sm:text-sm text-on-surface-variant">
                        Sistem mendukung penambahan data silsilah secara fleksibel baik dari atas ke bawah maupun dari bawah ke atas:
                    </p>
                </div>
                <div class="bg-surface-container-low p-3.5 sm:p-4 rounded-xl border border-outline-variant/60 space-y-3">
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-md bg-primary text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[13px]">arrow_downward</span>
                        </span>
                        <div class="text-xs text-on-surface-variant leading-relaxed">
                            <strong class="text-primary block font-bold">1. Dari Leluhur Utama ke Bawah (Top-Down)</strong>
                            Input data leluhur/raja tetua terlebih dahulu, lalu saat menambahkan anak keturunannya, tautkan ke <em>Ayah/Ibu Kandung</em> yang sah.
                        </div>
                    </div>
                    <div class="h-px bg-outline-variant/40"></div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-md bg-secondary text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[13px]">arrow_upward</span>
                        </span>
                        <div class="text-xs text-on-surface-variant leading-relaxed">
                            <strong class="text-secondary block font-bold">2. Dari Generasi Terakhir ke Atas (Bottom-Up)</strong>
                            Input anggota generasi muda/terakhir terlebih dahulu, lalu saat menambah orang tua/leluhur ke atas, pilih anak-anak yang sudah ada di bagian <em>Pilih Anak</em>. Tokoh baru otomatis menjadi Ayah/Ibu bagi anak tersebut.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->role === 'superadmin')
        @php
            $recentLogs = \App\Models\ActivityLog::latest()->take(5)->get();
        @endphp
        <div class="bento-card overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-3.5 border-b border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-surface-container-low">
                <h3 class="font-title-lg text-xs sm:text-sm font-bold text-primary flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-secondary text-[18px]">history</span>
                    Aktivitas Sistem Terbaru
                </h3>
                <a href="{{ route('admin.logs.index') }}" class="text-xs text-secondary hover:underline font-bold flex items-center gap-1">
                    Lihat Semua Log <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
            <div class="divide-y divide-outline-variant/30 text-xs">
                @forelse($recentLogs as $log)
                <div class="p-3 sm:p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3 hover:bg-surface-container-low/50 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs shrink-0">
                            {{ Str::substr($log->user_name ?? 'A', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="font-bold text-primary text-xs">{{ $log->user_name }}</span>
                                <span class="px-1.5 py-0.2 text-[9px] font-bold rounded uppercase
                                    {{ $log->user_role === 'superadmin' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                    {{ $log->user_role }}
                                </span>
                                <span class="px-1.5 py-0.2 text-[9px] font-extrabold rounded bg-gray-100 text-gray-700">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <p class="text-on-surface-variant text-[11px] mt-0.5 truncate max-w-sm sm:max-w-md">{{ $log->description }}</p>
                        </div>
                    </div>
                    <div class="text-right text-[11px] text-gray-400 whitespace-nowrap self-end sm:self-center shrink-0">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">schedule</span>
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-400 text-xs">
                    Belum ada riwayat aktivitas tercatat.
                </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</x-app-layout>