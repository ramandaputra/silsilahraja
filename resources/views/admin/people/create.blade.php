<x-app-layout>
    @slot('page-title') Tambah Anggota Silsilah @endslot

    <div class="space-y-4 sm:space-y-6">
        
        <!-- Breadcrumb & Header Akses Cepat -->
        <div class="flex flex-col gap-1 mb-2">
            <div>
                <a href="{{ route('admin.people.index') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                    <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                    </span>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>
            <h2 class="font-headline-md text-lg sm:text-[22px] font-black text-primary mt-1">Tambah Anggota Silsilah Baru</h2>
            <p class="font-body-md text-xs sm:text-sm text-on-surface-variant">
                Mendukung penambahan dari <strong>leluhur utama ke bawah</strong> (generasi pertama ke terakhir) maupun dari <strong>generasi terakhir ke atas</strong> (anak ke orang tua/leluhur).
            </p>
        </div>

        @if(isset($prefilledChild) && $prefilledChild)
            <!-- Banner Penambahan Generasi Terakhir ke Atas (Bottom-Up) -->
            <div class="bg-secondary/10 border-2 border-secondary/30 text-secondary p-3.5 sm:p-4 rounded-xl flex items-center gap-3 shadow-xs">
                <span class="material-symbols-outlined text-2xl text-secondary shrink-0">arrow_upward</span>
                <div class="text-xs sm:text-sm">
                    <span class="font-bold block text-primary">Mode Penambahan: Generasi Terakhir ke Atas (Bottom-Up)</span>
                    <span>Anda sedang menambahkan <strong>Orang Tua / Leluhur</strong> untuk: <strong class="text-secondary">{{ $prefilledChild->nama_nasab }}</strong>. Tokoh ini otomatis terhubung sebagai orang tuanya saat disimpan.</span>
                </div>
            </div>
        @elseif(isset($prefilledParent) && $prefilledParent)
            <!-- Banner Penambahan Leluhur ke Bawah (Top-Down) -->
            <div class="bg-primary/10 border-2 border-primary/30 text-primary p-3.5 sm:p-4 rounded-xl flex items-center gap-3 shadow-xs">
                <span class="material-symbols-outlined text-2xl text-primary shrink-0">arrow_downward</span>
                <div class="text-xs sm:text-sm">
                    <span class="font-bold block">Mode Penambahan: Leluhur ke Bawah (Top-Down)</span>
                    <span>Anda sedang menambahkan <strong>Anak / Keturunan</strong> dari: <strong class="text-secondary">{{ $prefilledParent->nama_nasab }}</strong>.</span>
                </div>
            </div>
        @endif

        <!-- Wadah Utama Formulir Bergaya Bento Card -->
        <div class="bento-card overflow-hidden bg-surface-container-lowest p-4 sm:p-6 md:p-8">
            
            <!-- FORM UTAMA -->
            <form action="{{ route('admin.people.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- SISI KIRI & TENGAH: DETAIL DATA UTAMA TOKOH (Col-span 2) -->
                    <div class="lg:col-span-2 space-y-4">
                        
                        <!-- Nama Lengkap -->
                        <div class="flex flex-col gap-xs">
                            <label for="nama_lengkap" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                   class="w-full px-md py-sm bg-surface-bright border @error('nama_lengkap') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all" 
                                   value="{{ old('nama_lengkap') }}" placeholder="Contoh: Sultan Iskandar Muda" required>
                            @error('nama_lengkap') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>

                        <!-- Gelar / Julukan Pembeda (Jika nama sama) -->
                        <div class="flex flex-col gap-xs">
                            <label for="gelar_pembeda" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1">
                                <span>Gelar / Julukan Pembeda</span>
                                <span class="text-[10px] text-outline font-normal lowercase">(opsional, penanda jika nama sama)</span>
                            </label>
                            <input type="text" name="gelar_pembeda" id="gelar_pembeda" 
                                   class="w-full px-md py-sm bg-surface-bright border border-outline-variant focus:ring-secondary rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all" 
                                   value="{{ old('gelar_pembeda') }}" placeholder="Contoh: Marhum Kantor, Yang Dipertuan Muda IV, atau Ke-1">
                            <span class="text-[11px] text-outline leading-tight">Digunakan untuk membedakan tokoh jika terdapat nama yang 100% sama dalam silsilah kerajaan.</span>
                            @error('gelar_pembeda') <span class="text-xs text-error font-semibold mt-0.5">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <!-- Jenis Kelamin -->
                            <div class="flex flex-col gap-xs">
                                <label for="jenis_kelamin" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" 
                                        class="w-full px-md py-sm bg-surface-bright border @error('jenis_kelamin') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all text-on-surface" required>
                                    <option value="" disabled selected>-- Pilih Gender --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="flex flex-col gap-xs">
                                <label for="tempat_lahir" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                       value="{{ old('tempat_lahir') }}" placeholder="Contoh: Istana Dalam">
                            </div>
                        </div>

                        <!-- STATUS PERNIKAHAN & PASANGAN -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <!-- Status Pernikahan -->
                            <div class="flex flex-col gap-xs">
                                <label for="status_pernikahan" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Status Pernikahan</label>
                                <select name="status_pernikahan" id="status_pernikahan" onchange="togglePasanganField()"
                                        class="w-full px-md py-sm bg-surface-bright border @error('status_pernikahan') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all text-on-surface" required>
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>💍 Belum Menikah</option>
                                    <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>👑 Menikah</option>
                                </select>
                                @error('status_pernikahan') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>

                            <!-- Nama Pasangan -->
                            <div class="flex flex-col gap-xs transition-all duration-300" id="input_pasangan_wrapper">
                                <label for="nama_pasangan" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Nama Suami / Istri (Luar Kerajaan)</label>
                                <input type="text" name="nama_pasangan" id="nama_pasangan" 
                                       class="w-full px-md py-sm bg-surface-bright border @error('nama_pasangan') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                       value="{{ old('nama_pasangan') }}" placeholder="Contoh: Permaisuri A, Selir B">
                                <span class="text-[11px] text-outline leading-tight">Jika menikah lebih dari sekali, pisahkan nama dengan tanda koma (,).</span>
                                @error('nama_pasangan') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <!-- Tanggal Lahir -->
                            <div class="flex flex-col gap-xs">
                                <label for="tanggal_lahir" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all text-on-surface-variant" 
                                       value="{{ old('tanggal_lahir') }}">
                            </div>

                            <!-- Tanggal Wafat -->
                            <div class="flex flex-col gap-xs">
                                <label for="tanggal_wafat" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tanggal Wafat (Kosongkan jika hidup)</label>
                                <input type="date" name="tanggal_wafat" id="tanggal_wafat" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all text-on-surface-variant" 
                                       value="{{ old('tanggal_wafat') }}">
                            </div>
                        </div>

                        <!-- Biografi -->
                        <div class="flex flex-col gap-xs">
                            <label for="biografi" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Biografi Singkat / Sejarah</label>
                            <textarea name="biografi" id="biografi" rows="5" 
                                      class="w-full p-md bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                      placeholder="Tuliskan kisah hidup, pencapaian, atau masa kejayaan tokoh di sini...">{{ old('biografi') }}</textarea>
                        </div>
                    </div>

                    <!-- SISI KANAN: HUBUNGAN RELASI SILSILAH & MANAJEMEN FOTO (Col-span 1) -->
                    <div class="lg:col-span-1 border-t lg:border-t-0 lg:border-l border-outline-variant/60 pt-6 lg:pt-0 lg:pl-6 space-y-4">
                        <div class="flex items-center justify-between gap-1 mb-1">
                            <h5 class="font-title-lg text-sm text-secondary font-bold uppercase tracking-widest flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">account_tree</span> Hubungan Silsilah
                            </h5>
                        </div>

                        <!-- Pengatur Arah Penambahan Silsilah -->
                        <div class="space-y-1.5 bg-surface-container-low p-2.5 rounded-xl border border-outline-variant/60">
                            <label class="font-label-md text-[11px] font-bold text-primary uppercase tracking-wider block">Arah Alur Silsilah</label>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-surface-container-high rounded-lg text-[11px] font-semibold text-center">
                                <button type="button" id="btn_mode_top_down" onclick="switchRelationMode('top_down')" class="flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-white bg-primary shadow-xs font-bold">
                                    <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                                    <span>Ke Bawah</span>
                                </button>
                                <button type="button" id="btn_mode_bottom_up" onclick="switchRelationMode('bottom_up')" class="flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-on-surface-variant hover:text-primary">
                                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                                    <span>Ke Atas</span>
                                </button>
                                <button type="button" id="btn_mode_both" onclick="switchRelationMode('both')" class="flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-on-surface-variant hover:text-primary">
                                    <span class="material-symbols-outlined text-[14px]">swap_vert</span>
                                    <span>Keduanya</span>
                                </button>
                            </div>
                            <span class="text-[10px] text-outline block leading-tight" id="mode_help_text">
                                Mode Ke Bawah: Menambahkan tokoh sebagai anak/keturunan dari orang tua yang dipilih.
                            </span>
                        </div>

                        <!-- BAGIAN A: HUBUNGAN KE ATAS (ORANG TUA TOKOH INI) -->
                        <div id="section_parents" class="space-y-3 transition-all duration-200">
                            <div class="flex items-center gap-1 text-xs font-bold text-primary border-b border-outline-variant/40 pb-1">
                                <span class="material-symbols-outlined text-[16px] text-secondary">family_restroom</span>
                                <span>Orang Tua Tokoh Ini (Generasi ke Atas)</span>
                            </div>

                            <!-- Dropdown Ayah -->
                            <div class="flex flex-col gap-1">
                                <label for="father_id" class="font-label-md text-xs font-bold text-primary">Ayah Kandung</label>
                                <select name="father_id" id="father_id" 
                                        class="w-full px-3 py-2.5 bg-surface-bright border border-outline-variant rounded-xl font-body-md text-xs sm:text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                    <option value="">-- Tidak Diketahui / Leluhur Teratas --</option>
                                    @foreach($allPeople as $p)
                                        @if($p->jenis_kelamin == 'L')
                                            <option value="{{ $p->id }}" {{ (old('father_id') == $p->id) || (isset($prefilledParent) && $prefilledParent->jenis_kelamin == 'L' && $prefilledParent->id == $p->id) ? 'selected' : '' }}>
                                                {{ $p->nama_nasab }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Ibu -->
                            <div class="flex flex-col gap-1">
                                <label for="mother_id" class="font-label-md text-xs font-bold text-primary">Ibu Kandung (Keluarga Internal)</label>
                                <select name="mother_id" id="mother_id" 
                                        class="w-full px-3 py-2.5 bg-surface-bright border border-outline-variant rounded-xl font-body-md text-xs sm:text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                    <option value="">-- Bukan dari Keluarga Internal / Isi di Bawah --</option>
                                    @foreach($allPeople as $p)
                                        @if($p->jenis_kelamin == 'P')
                                            <option value="{{ $p->id }}" {{ (old('mother_id') == $p->id) || (isset($prefilledParent) && $prefilledParent->jenis_kelamin == 'P' && $prefilledParent->id == $p->id) ? 'selected' : '' }}>
                                                {{ $p->nama_nasab }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input Ibu Eksternal (Non-Raja) -->
                            <div class="flex flex-col gap-1 bg-surface-container-low p-3 rounded-xl border border-outline-variant/50">
                                <label for="nama_ibu_non_raja" class="font-label-md text-[11px] font-black text-error flex items-center gap-0.5 uppercase tracking-wide">
                                    <span class="material-symbols-outlined text-[14px]">edit_note</span> Jika Ibu dari Luar Silsilah Utama:
                                </label>
                                <input type="text" name="nama_ibu_non_raja" id="nama_ibu_non_raja" 
                                       class="w-full px-3 py-2 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-xs outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                       value="{{ old('nama_ibu_non_raja') }}" placeholder="Ketik nama ibu kandung langsung...">
                                <span class="text-[10px] text-outline leading-tight">Gunakan kolom ini jika tokoh terlahir dari garis keturunan istri luar (selir/pernikahan eksternal).</span>
                            </div>
                        </div>

                        <!-- BAGIAN B: HUBUNGAN KE BAWAH (ANAK KANDUNG DARI TOKOH INI / GENERASI TERAKHIR KE ATAS) -->
                        <div id="section_children" class="space-y-2.5 transition-all duration-200 hidden">
                            <div class="flex items-center justify-between border-b border-outline-variant/40 pb-1">
                                <div class="flex items-center gap-1 text-xs font-bold text-primary">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">child_care</span>
                                    <span>Pilih Anak (Generasi di Bawahnya)</span>
                                </div>
                                <span class="text-[10px] font-bold text-secondary px-2 py-0.5 bg-secondary/10 rounded-full" id="selected_children_counter">0 Anak Terpilih</span>
                            </div>

                            <p class="text-[11px] text-on-surface-variant leading-relaxed">
                                Tokoh baru ini otomatis menjadi <strong id="label_peran_ortu" class="text-secondary">Ayah Kandung</strong> bagi anak-anak yang Anda centang:
                            </p>

                            <!-- Kotak Pencarian Anak -->
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[16px] text-outline">search</span>
                                <input type="text" id="search_child" oninput="filterChildrenList()" placeholder="Ketik nama anak untuk mencari..." 
                                       class="w-full pl-8 pr-3 py-1.5 bg-surface-bright border border-outline-variant rounded-lg text-xs outline-none focus:ring-2 focus:ring-secondary transition-all">
                            </div>

                            <!-- Daftar Centang Anak-Anak -->
                            <div class="max-h-56 overflow-y-auto space-y-1 p-1 border border-outline-variant/60 rounded-xl bg-surface-bright custom-scrollbar" id="children_list_container">
                                @forelse($allPeople as $p)
                                    @php
                                        $isChecked = (old('children_ids') && in_array($p->id, old('children_ids'))) || (isset($prefilledChild) && $prefilledChild->id == $p->id);
                                    @endphp
                                    <label class="child-item flex items-center justify-between p-2 rounded-lg border {{ $isChecked ? 'border-secondary/40 bg-secondary/5' : 'border-transparent' }} hover:bg-surface-container hover:border-outline-variant/40 cursor-pointer transition-all text-xs" data-name="{{ strtolower($p->nama_nasab . ' ' . $p->nama_lengkap) }}">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <input type="checkbox" name="children_ids[]" value="{{ $p->id }}" class="rounded text-primary focus:ring-secondary w-4 h-4 child-checkbox" {{ $isChecked ? 'checked' : '' }} onchange="onChildCheckboxChange(this)">
                                            <div class="truncate">
                                                <span class="font-bold text-on-surface block truncate">{{ $p->nama_lengkap }}</span>
                                                <span class="inline-flex items-center gap-1 text-[10px] text-outline truncate">
                                                    @if($p->jenis_kelamin == 'L')
                                                        <span class="text-blue-600 font-bold inline-flex items-center gap-0.5"><i class="bi bi-gender-male"></i> Laki-laki</span>
                                                    @else
                                                        <span class="text-rose-600 font-bold inline-flex items-center gap-0.5"><i class="bi bi-gender-female"></i> Perempuan</span>
                                                    @endif
                                                    @if($p->father)
                                                        &bull; Ayah: {{ $p->father->nama_lengkap }}
                                                    @endif
                                                    @if($p->mother)
                                                        &bull; Ibu: {{ $p->mother->nama_lengkap }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant shrink-0">#{{ $p->id }}</span>
                                    </label>
                                @empty
                                    <div class="p-4 text-center text-xs text-outline">
                                        Belum ada data anggota lain yang dapat dipilih sebagai anak.
                                    </div>
                                @endforelse
                            </div>
                            <span class="text-[10px] text-outline block">Tips: Anda dapat mencentang lebih dari satu anak sekaligus.</span>
                        </div>

                        <div class="h-px bg-outline-variant/40 my-2"></div>

                        <!-- Upload Foto Tokoh -->
                        <div class="flex flex-col gap-1">
                            <label for="foto" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Foto / Ilustrasi Tokoh</label>
                            <input type="file" name="foto" id="foto" 
                                   class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-outline-variant rounded-xl p-1 bg-surface-bright transition-all cursor-pointer">
                            <span class="text-[10px] text-outline">Format resmi: JPG, JPEG, PNG. Maksimal beban berkas: 2MB.</span>
                            @error('foto') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- AKSI KENDALI FORMULIR (Tombol Simpan / Reset) -->
                <div class="flex flex-col-reverse sm:flex-row justify-end items-stretch sm:items-center gap-2 sm:gap-3 border-t border-outline-variant pt-4 sm:pt-6 mt-6">
                    <button type="reset" 
                            class="px-4 py-2.5 border border-outline-variant text-slate-700 bg-transparent hover:bg-slate-100 rounded-xl font-label-md text-xs font-bold transition-colors text-center justify-center">
                        Reset Form
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-primary text-white hover:bg-secondary active:scale-95 rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-md text-center">
                        <span class="material-symbols-outlined text-[18px]">save</span> Simpan Data Tokoh
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- SISTEM KONTROL VISUAL DINAMIS -->
    <script>
        function togglePasanganField() {
            const statusPernikahan = document.getElementById('status_pernikahan').value;
            const pasanganWrapper = document.getElementById('input_pasangan_wrapper');
            const inputPasangan = document.getElementById('nama_pasangan');

            if (statusPernikahan === 'Menikah') {
                pasanganWrapper.style.opacity = '1';
                pasanganWrapper.style.pointerEvents = 'auto';
                pasanganWrapper.classList.remove('invisible', 'h-0', 'overflow-hidden', 'mt-0');
            } else {
                pasanganWrapper.style.opacity = '0';
                pasanganWrapper.style.pointerEvents = 'none';
                pasanganWrapper.classList.add('invisible', 'h-0', 'overflow-hidden', 'mt-0');
                inputPasangan.value = ''; 
            }
        }

        // Pergantian Mode Arah Hubungan Silsilah (Ke Bawah, Ke Atas, atau Keduanya)
        function switchRelationMode(mode) {
            const secParents = document.getElementById('section_parents');
            const secChildren = document.getElementById('section_children');
            const btnTopDown = document.getElementById('btn_mode_top_down');
            const btnBottomUp = document.getElementById('btn_mode_bottom_up');
            const btnBoth = document.getElementById('btn_mode_both');
            const helpText = document.getElementById('mode_help_text');

            // Reset tombol styling
            [btnTopDown, btnBottomUp, btnBoth].forEach(btn => {
                btn.className = "flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-on-surface-variant hover:text-primary";
            });

            if (mode === 'top_down') {
                secParents.classList.remove('hidden');
                secChildren.classList.add('hidden');
                btnTopDown.className = "flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-white bg-primary shadow-xs font-bold";
                helpText.innerText = "Mode Ke Bawah: Menambahkan tokoh sebagai anak/keturunan dari orang tua yang dipilih.";
            } else if (mode === 'bottom_up') {
                secParents.classList.add('hidden');
                secChildren.classList.remove('hidden');
                btnBottomUp.className = "flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-white bg-secondary shadow-xs font-bold";
                helpText.innerText = "Mode Ke Atas: Menambahkan tokoh sebagai orang tua/leluhur dari generasi yang sudah ada.";
            } else {
                secParents.classList.remove('hidden');
                secChildren.classList.remove('hidden');
                btnBoth.className = "flex flex-col sm:flex-row items-center justify-center gap-1 py-1.5 px-1 rounded-md transition-all text-white bg-primary shadow-xs font-bold";
                helpText.innerText = "Mode Keduanya: Tokoh berada di tengah silsilah (memiliki orang tua sekaligus anak).";
            }
        }

        // Perbarui label peran (Ayah vs Ibu) saat gender tokoh diubah
        function updateParentRoleLabel() {
            const gender = document.getElementById('jenis_kelamin').value;
            const label = document.getElementById('label_peran_ortu');
            if (label) {
                label.innerText = (gender === 'P') ? 'Ibu Kandung' : 'Ayah Kandung';
            }
        }

        // Filter pencarian anak dalam daftar
        function filterChildrenList() {
            const q = document.getElementById('search_child').value.toLowerCase();
            const items = document.querySelectorAll('.child-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name') || '';
                item.style.display = name.includes(q) ? 'flex' : 'none';
            });
        }

        // Update jumlah anak yang dicentang
        function updateSelectedChildrenCount() {
            const checked = document.querySelectorAll('.child-checkbox:checked').length;
            const counter = document.getElementById('selected_children_counter');
            if (counter) {
                counter.innerText = checked + ' Anak Terpilih';
            }
        }

        function onChildCheckboxChange(chk) {
            const label = chk.closest('label');
            if (chk.checked) {
                label.classList.add('border-secondary/40', 'bg-secondary/5');
                label.classList.remove('border-transparent');
            } else {
                label.classList.remove('border-secondary/40', 'bg-secondary/5');
                label.classList.add('border-transparent');
            }
            updateSelectedChildrenCount();
        }

        document.addEventListener('DOMContentLoaded', function() {
            togglePasanganField();

            // Dengarkan perubahan jenis kelamin untuk update label peran orang tua
            const genderSelect = document.getElementById('jenis_kelamin');
            if (genderSelect) {
                genderSelect.addEventListener('change', updateParentRoleLabel);
                updateParentRoleLabel();
            }

            // Inisialisasi mode penambahan berdasarkan parameter
            @if(isset($prefilledChild) && $prefilledChild)
                switchRelationMode('bottom_up');
            @elseif(isset($prefilledParent) && $prefilledParent)
                switchRelationMode('top_down');
            @else
                switchRelationMode('top_down');
            @endif

            updateSelectedChildrenCount();
        });
    </script>
</x-app-layout>