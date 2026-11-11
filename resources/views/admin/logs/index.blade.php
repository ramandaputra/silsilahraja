<x-app-layout>
    @slot('page-title') Log Aktivitas Sistem @endslot

    <div class="space-y-4 sm:space-y-6">
        
        <!-- Tombol Kembali -->
        <div class="mb-1">
            <a href="{{ route('admin.dashboard') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
        
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm text-xs sm:text-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 shrink-0">check_circle</span>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Header Ringkasan & Aksi -->
        <div class="bento-card p-4 sm:p-6 md:p-8 bg-gradient-to-r from-surface-container-lowest to-surface-container-low flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 border-l-4 border-primary">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl sm:text-2xl">history</span>
                    <h2 class="font-headline-md text-lg sm:text-xl font-black text-primary">Jejak Audit & Log Aktivitas</h2>
                </div>
                <p class="font-body-md text-xs sm:text-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    Memantau riwayat aktivitas operasional administrator dan superadmin seperti penambahan silsilah, perubahan konfigurasi, login, dan manajemen pengguna.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH riwayat log aktivitas? Tindakan ini tidak dapat dibatalkan.');" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto px-4 py-2.5 bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 active:scale-95 rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">delete_sweep</span> Bersihkan Seluruh Log
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="bento-card p-4 sm:p-5 bg-surface-container-lowest">
            <form action="{{ route('admin.logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
                <div>
                    <label class="block font-label-md text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Pencarian</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, aktivitas, IP..." class="w-full pl-9 pr-3 py-2 bg-surface-container-low border border-outline-variant/60 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Modul</label>
                    <select name="module" class="w-full px-3 py-2 bg-surface-container-low border border-outline-variant/60 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="">Semua Modul</option>
                        @foreach($modules as $mod)
                            <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-label-md text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Aksi</label>
                    <select name="action" class="w-full px-3 py-2 bg-surface-container-low border border-outline-variant/60 rounded-lg text-xs focus:ring-2 focus:ring-primary outline-none transition-all">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white hover:bg-secondary active:scale-95 rounded-lg font-label-md text-xs font-bold flex items-center justify-center gap-1.5 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span> Terapkan Filter
                    </button>
                    @if(request()->hasAny(['search', 'module', 'action']))
                        <a href="{{ route('admin.logs.index') }}" class="px-2.5 py-2 bg-surface-container-high text-on-surface-variant hover:bg-surface-container-highest rounded-lg text-xs font-bold transition-all" title="Reset Filter">
                            <span class="material-symbols-outlined text-[16px] block">close</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Riwayat Aktivitas -->
        <div class="bento-card overflow-hidden">
            <div class="p-3.5 sm:p-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                <h3 class="font-title-lg text-xs sm:text-sm font-bold text-primary flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-gray-500 text-[18px]">receipt_long</span>
                    <span>Catatan Aktivitas</span>
                    <span class="text-xs font-normal text-on-surface-variant font-mono">({{ $logs->total() }})</span>
                </h3>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-surface-container-lowest text-on-surface-variant text-[11px] font-bold uppercase tracking-wider border-b border-outline-variant/40">
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Pengguna</th>
                            <th class="py-3 px-4">Modul & Aksi</th>
                            <th class="py-3 px-4">Deskripsi Aktivitas</th>
                            <th class="py-3 px-4">IP & Jaringan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-xs text-on-surface font-body-md">
                        @forelse($logs as $log)
                        <tr class="hover:bg-surface-container-lowest/80 transition-colors">
                            <td class="py-3 px-4 whitespace-nowrap text-on-surface-variant font-medium">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[15px] text-gray-400">schedule</span>
                                    <span>{{ $log->created_at->isoFormat('D MMM Y, HH:mm:ss') }}</span>
                                </div>
                                <span class="text-[10px] text-gray-400 block mt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ Str::substr($log->user_name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-primary">{{ $log->user_name }}</div>
                                        <span class="inline-block px-1.5 py-0.5 text-[10px] font-bold rounded-full uppercase
                                            {{ $log->user_role === 'superadmin' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                            {{ $log->user_role ?? 'user' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="font-semibold text-primary mb-1">{{ $log->module }}</div>
                                @php
                                    $actionClasses = match($log->action) {
                                        'CREATE' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'UPDATE' => 'bg-sky-50 text-sky-700 border-sky-200',
                                        'DELETE' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'LOGIN'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'LOGOUT' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        default  => 'bg-gray-100 text-gray-700 border-gray-200',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded border {{ $actionClasses }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="py-3 px-4 max-w-md">
                                <p class="text-on-surface leading-relaxed">{{ $log->description }}</p>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-on-surface-variant text-[11px]">
                                <div class="font-mono">{{ $log->ip_address ?? '-' }}</div>
                                <div class="text-[10px] text-gray-400 max-w-[160px] truncate" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent ?? '-' }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[40px] text-gray-300 block mb-2">history_toggle_off</span>
                                <p class="font-medium text-sm">Belum ada riwayat aktivitas yang tercatat.</p>
                                <p class="text-xs text-gray-400 mt-1">Aktivitas login, penambahan silsilah, dan pembaruan pengaturan akan muncul otomatis di sini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>

