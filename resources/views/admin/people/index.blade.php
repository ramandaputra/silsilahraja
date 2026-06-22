<x-app-layout>
    @slot('page-title') Kelola Data Silsilah @endslot

    <div class="space-y-lg">
        
        @if(session('success'))
            <div class="bg-primary-fixed text-on-primary-fixed px-lg py-sm rounded-xl flex items-center gap-xs shadow-sm text-sm">
                <span class="material-symbols-outlined text-secondary">check_circle</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bento-card overflow-hidden">
            
            <div class="px-lg py-md border-b border-outline-variant flex flex-col md:flex-row justify-between items-stretch md:items-center gap-sm bg-surface-container-low">
                <h3 class="font-title-lg text-[16px] text-primary font-bold flex items-center gap-xs">
                    <span class="material-symbols-outlined">groups</span>
                    Daftar Anggota Aktif
                </h3>
                
                <form action="{{ route('admin.people.index') }}" method="GET" class="flex flex-col sm:flex-row gap-xs">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                        <input class="pl-9 pr-md py-xs bg-surface border border-outline-variant rounded-lg font-label-md text-xs focus:ring-2 focus:ring-secondary outline-none transition-all" placeholder="Cari Nama Anggota..." type="text" name="search" value="{{ request('search') }}">
                    </div>
                    
                    <select name="gender" onchange="this.form.submit()" class="bg-surface border border-outline-variant rounded-lg font-label-md text-xs px-md py-xs outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                        <option value="">Semua Gender</option>
                        <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>♂️ Laki-laki</option>
                        <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>♀️ Perempuan</option>
                    </select>

                    @if(request('search') || request('gender'))
                        <a href="{{ route('admin.people.index') }}" class="flex items-center justify-center px-md py-xs border border-error text-error rounded-lg font-label-md text-xs hover:bg-error-container transition-colors">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left font-data-table text-sm">
                    <thead class="bg-primary-container/10 text-primary border-b border-outline-variant text-xs font-bold uppercase">
                        <tr>
                            <th class="px-lg py-md">Nama Tokoh</th>
                            <th class="px-lg py-md">Jenis Kelamin</th>
                            <th class="px-lg py-md">Hubungan Orang Tua</th>
                            <th class="px-lg py-md text-center">Status Hubungan</th>
                            <th class="px-lg py-md text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-xs">
                        @forelse($people as $person)
                            <tr class="hover:bg-primary-container/5 transition-colors group">
                                <td class="px-lg py-md">
                                    <div class="flex items-center gap-sm">
                                        <div class="w-8 h-8 rounded-lg bg-primary-fixed text-primary flex items-center justify-center font-bold uppercase">
                                            {{ Str::substr($person->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-on-surface block text-sm">{{ $person->nama_lengkap }}</span>
                                            <span class="text-[10px] text-outline block">ID: #{{ $person->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-md">
                                    @if($person->jenis_kelamin == 'L')
                                        <span class="px-xs py-0.5 bg-secondary-fixed text-on-secondary-fixed rounded-full font-bold text-[10px]">♂️ LAKI-LAKI</span>
                                    @else
                                        <span class="px-xs py-0.5 bg-error-container text-on-error-container rounded-full font-bold text-[10px]">♀️ PEREMPUAN</span>
                                    @endif
                                </td>
                                <td class="px-lg py-md text-on-surface-variant">
                                    <div class="space-y-0.5">
                                        <div><span class="text-outline font-bold">Ayah:</span> {{ $person->father ? $person->father->nama_lengkap : '—' }}</div>
                                        <div><span class="text-outline font-bold">Ibu:</span> {{ $person->mother ? $person->mother->nama_lengkap : ($person->nama_ibu_non_raja ?: '—') }}</div>
                                    </div>
                                </td>
                                <td class="px-lg py-md text-center">
                                    @if(!$person->father_id && !$person->mother_id)
                                        <span class="px-xs py-0.5 bg-tertiary-fixed text-on-tertiary-fixed rounded-full text-[10px] font-black tracking-wider">👑 LELUHUR PUNCAK</span>
                                    @else
                                        <span class="px-xs py-0.5 bg-surface-container-highest text-on-surface-variant rounded-full text-[10px] font-medium">🔗 KETURUNAN</span>
                                    @endif
                                </td>
                                <td class="px-lg py-md text-right">
                                    <div class="inline-flex items-center gap-xs opacity-80 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.people.edit', $person->id) }}" class="p-1 hover:bg-primary-fixed text-primary rounded" title="Edit">
                                            <span class="material-symbols-outlined text-[18px] block">edit_square</span>
                                        </a>
                                        <form action="{{ route('admin.people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1 hover:bg-error-container text-error rounded" title="Hapus">
                                                <span class="material-symbols-outlined text-[18px] block">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-lg py-xl text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-xl block text-outline mb-1">search_off</span>
                                    Tidak ditemukan data silsilah yang sesuai kriteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-lg py-sm border-t border-outline-variant bg-surface-container-low flex items-center justify-between text-xs">
                <p class="font-label-md text-on-surface-variant">
                    Menampilkan {{ $people->firstItem() ?? 0 }} - {{ $people->lastItem() ?? 0 }} dari {{ $people->total() ?? 0 }} Anggota
                </p>
                <div class="flex items-center gap-xs">
                    @if ($people->onFirstPage())
                        <span class="p-1 border border-outline-variant rounded-lg text-outline cursor-not-allowed"><span class="material-symbols-outlined text-[18px] block">chevron_left</span></span>
                    @else
                        <a href="{{ $people->previousPageUrl() }}" class="p-1 border border-outline-variant rounded-lg hover:bg-surface text-on-surface-variant"><span class="material-symbols-outlined text-[18px] block">chevron_left</span></a>
                    @endif

                    <span class="font-label-md px-md text-on-surface font-semibold">Halaman {{ $people->currentPage() }}</span>

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