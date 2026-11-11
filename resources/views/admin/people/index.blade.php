<x-app-layout>
    @slot('page-title') Kelola Data Silsilah @endslot

    <div class="space-y-4 sm:space-y-6">
        
        <!-- Header Atas: Tombol Kembali & Tambah Data -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 mb-1">
            <a href="{{ route('admin.dashboard') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all self-start">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Dashboard</span>
            </a>

            <a href="{{ route('admin.people.create') }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-primary hover:bg-secondary text-white rounded-lg text-xs font-bold shadow-xs active:scale-95 transition-all self-stretch sm:self-auto">
                <span class="material-symbols-outlined text-[16px]">person_add</span>
                <span>Tambah Tokoh Baru</span>
            </a>
        </div>
        
        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm text-xs sm:text-sm">
                <span class="material-symbols-outlined text-secondary shrink-0">check_circle</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bento-card overflow-hidden">
            
            <div class="p-3.5 sm:p-5 border-b border-outline-variant flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3 bg-surface-container-low">
                <h3 class="font-title-lg text-sm sm:text-base text-primary font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[20px]">groups</span>
                    <span>Daftar Anggota Aktif</span>
                    <span class="text-xs font-normal text-on-surface-variant font-mono">({{ $people->total() }})</span>
                </h3>
                
                <form action="{{ route('admin.people.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <div class="relative flex-1 sm:w-64">
                        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                        <input class="w-full pl-9 pr-3 py-2 bg-surface border border-outline-variant rounded-lg font-label-md text-xs focus:ring-2 focus:ring-secondary outline-none transition-all" placeholder="Cari Nama Anggota..." type="text" name="search" value="{{ request('search') }}">
                    </div>
                    
                    <select name="gender" onchange="this.form.submit()" class="bg-surface border border-outline-variant rounded-lg font-label-md text-xs px-3 py-2 outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                        <option value="">Semua Gender</option>
                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>

                    @if(request('search') || request('gender'))
                        <a href="{{ route('admin.people.index') }}" class="flex items-center justify-center px-3 py-2 border border-error text-error rounded-lg font-label-md text-xs hover:bg-error-container transition-colors">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left font-data-table text-sm min-w-[700px]">
                    <thead class="bg-primary-container/10 text-primary border-b border-outline-variant text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                        <tr>
                            <th class="px-4 sm:px-6 py-3">Nama Tokoh</th>
                            <th class="px-4 sm:px-6 py-3">Jenis Kelamin</th>
                            <th class="px-4 sm:px-6 py-3">Hubungan Orang Tua</th>
                            <th class="px-4 sm:px-6 py-3 text-center">Status Hubungan</th>
                            <th class="px-4 sm:px-6 py-3 text-right">Aksi & Relasi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-xs">
                        @forelse($people as $person)
                            <tr class="hover:bg-primary-container/5 transition-colors group">
                                <td class="px-4 sm:px-6 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-primary-fixed text-primary flex items-center justify-center font-bold uppercase shrink-0">
                                            {{ Str::substr($person->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <span class="font-semibold text-on-surface text-xs sm:text-sm">{{ $person->nama_lengkap }}</span>
                                                @if($person->has_duplicate_name && $person->nasab)
                                                    <span class="text-[11px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-md border border-primary/20">
                                                        {{ $person->nasab }}
                                                    </span>
                                                @elseif(!empty($person->gelar_pembeda))
                                                    <span class="text-[11px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-md border border-primary/20">
                                                        {{ $person->gelar_pembeda }}
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-[10px] text-outline block mt-0.5 font-mono">ID: #{{ $person->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap">
                                    @if($person->jenis_kelamin == 'L')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-secondary-fixed text-on-secondary-fixed rounded-full font-bold text-[10px]">
                                            <i class="bi bi-gender-male"></i>
                                            <span>LAKI-LAKI</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-error-container text-on-error-container rounded-full font-bold text-[10px]">
                                            <i class="bi bi-gender-female"></i>
                                            <span>PEREMPUAN</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-on-surface-variant">
                                    <div class="space-y-0.5 text-xs">
                                        <div><span class="text-outline font-bold">Ayah:</span> {{ $person->father ? $person->father->nama_lengkap : '—' }}</div>
                                        <div><span class="text-outline font-bold">Ibu:</span> {{ $person->mother ? $person->mother->nama_lengkap : ($person->nama_ibu_non_raja ?: '—') }}</div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-center whitespace-nowrap">
                                    @if(!$person->father_id && !$person->mother_id)
                                        <span class="px-2 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed rounded-full text-[10px] font-black tracking-wider">👑 LELUHUR PUNCAK</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-surface-container-highest text-on-surface-variant rounded-full text-[10px] font-medium">🔗 KETURUNAN</span>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1 opacity-100 sm:opacity-85 sm:group-hover:opacity-100 transition-opacity">
                                        <!-- Tambah Orang Tua (Alur ke Atas) -->
                                        <a href="{{ route('admin.people.create', ['as_parent_of' => $person->id]) }}" class="p-1.5 hover:bg-secondary/15 text-secondary rounded-lg transition-colors" title="Tambah Orang Tua / Leluhur ke Atas">
                                            <span class="material-symbols-outlined text-[18px] block">arrow_upward</span>
                                        </a>
                                        <!-- Tambah Anak (Alur ke Bawah) -->
                                        <a href="{{ route('admin.people.create', ['as_child_of' => $person->id]) }}" class="p-1.5 hover:bg-primary/15 text-primary rounded-lg transition-colors" title="Tambah Keturunan / Anak ke Bawah">
                                            <span class="material-symbols-outlined text-[18px] block">arrow_downward</span>
                                        </a>
                                        <!-- Edit -->
                                        <a href="{{ route('admin.people.edit', $person->id) }}" class="p-1.5 hover:bg-primary-fixed text-primary rounded-lg transition-colors" title="Edit Data">
                                            <span class="material-symbols-outlined text-[18px] block">edit_square</span>
                                        </a>
                                        <!-- Hapus -->
                                        <form action="{{ route('admin.people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 hover:bg-error-container text-error rounded-lg transition-colors" title="Hapus Data">
                                                <span class="material-symbols-outlined text-[18px] block">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-2xl block text-outline mb-1">search_off</span>
                                    Tidak ditemukan data silsilah yang sesuai kriteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-3 border-t border-outline-variant bg-surface-container-low flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <p class="font-label-md text-on-surface-variant text-center sm:text-left">
                    Menampilkan {{ $people->firstItem() ?? 0 }} - {{ $people->lastItem() ?? 0 }} dari {{ $people->total() ?? 0 }} Anggota
                </p>
                <div class="flex items-center gap-1.5">
                    @if ($people->onFirstPage())
                        <span class="p-1 border border-outline-variant rounded-lg text-outline cursor-not-allowed"><span class="material-symbols-outlined text-[18px] block">chevron_left</span></span>
                    @else
                        <a href="{{ $people->previousPageUrl() }}" class="p-1 border border-outline-variant rounded-lg hover:bg-surface text-on-surface-variant"><span class="material-symbols-outlined text-[18px] block">chevron_left</span></a>
                    @endif

                    <span class="font-label-md px-3 text-on-surface font-semibold">Halaman {{ $people->currentPage() }}</span>

                    @if ($people->hasMorePages())
                        <a href="{{ $people->nextPageUrl() }}" class="p-1 border border-outline-variant rounded-lg hover:bg-surface text-on-surface-variant"><span class="material-symbols-outlined text-[18px] block">chevron_right</span></a>
                    @else
                        <span class="p-1 border border-outline-variant rounded-lg text-outline cursor-not-allowed"><span class="material-symbols-outlined text-[18px] block">chevron_right</span></span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>