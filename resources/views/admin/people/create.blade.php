<x-app-layout>
    @slot('page-title') Tambah Anggota Silsilah @endslot

    <div class="space-y-lg">
        
        <!-- Breadcrumb & Header Akses Cepat -->
        <div class="flex flex-col gap-xs mb-4">
            <a href="{{ route('admin.people.index') }}" class="inline-flex items-center gap-xs text-xs font-semibold text-secondary hover:underline transition-all">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Daftar
            </a>
            <h2 class="font-headline-md text-[22px] font-black text-primary mt-xs">Tambah Anggota Silsilah Baru</h2>
            <p class="font-body-md text-sm text-on-surface-variant">Masukkan informasi detail tokoh dan hubungkan relasinya ke entitas orang tua yang sah.</p>
        </div>

        <!-- Wadah Utama Formulir Bergaya Bento Card -->
        <div class="bento-card overflow-hidden bg-surface-container-lowest p-lg">
            
            <!-- FORM UTAMA -->
            <form action="{{ route('admin.people.store') }}" method="POST" enctype="multipart/form-data" class="space-y-lg">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                    
                    <!-- SISI KIRI & TENGAH: DETAIL DATA UTAMA TOKOH (Col-span 2) -->
                    <div class="md:col-span-2 space-y-md">
                        
                        <!-- Nama Lengkap -->
                        <div class="flex flex-col gap-xs">
                            <label for="nama_lengkap" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                   class="w-full px-md py-sm bg-surface-bright border @error('nama_lengkap') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all" 
                                   value="{{ old('nama_lengkap') }}" placeholder="Contoh: Sultan Iskandar Muda" required>
                            @error('nama_lengkap') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <!-- Jenis Kelamin -->
                            <div class="flex flex-col gap-xs">
                                <label for="jenis_kelamin" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" 
                                        class="w-full px-md py-sm bg-surface-bright border @error('jenis_kelamin') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all text-on-surface" required>
                                    <option value="" disabled selected>-- Pilih Gender --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>♂️ Laki-Laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>♀️ Perempuan</option>
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
                    <div class="md:col-span-1 border-t md:border-t-0 md:border-l border-outline-variant/60 pt-lg md:pt-0 md:pl-lg space-y-md">
                        <h5 class="font-title-lg text-sm text-secondary font-bold uppercase tracking-widest flex items-center gap-xs mb-2">
                            <span class="material-symbols-outlined text-[18px]">account_tree</span> Hubungan Silsilah
                        </h5>
                        
                        <!-- Dropdown Ayah -->
                        <div class="flex flex-col gap-xs">
                            <label for="father_id" class="font-label-md text-xs font-bold text-primary">Ayah Kandung</label>
                            <select name="father_id" id="father_id" 
                                    class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                <option value="">-- Tidak Diketahui / Leluhur Teratas --</option>
                                @foreach($allPeople as $p)
                                    @if($p->jenis_kelamin == 'L')
                                        <option value="{{ $p->id }}" {{ old('father_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Dropdown Ibu -->
                        <div class="flex flex-col gap-xs">
                            <label for="mother_id" class="font-label-md text-xs font-bold text-primary">Ibu Kandung (Keluarga Internal)</label>
                            <select name="mother_id" id="mother_id" 
                                    class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                <option value="">-- Bukan dari Keluarga Internal / Isi di Bawah --</option>
                                @foreach($allPeople as $p)
                                    @if($p->jenis_kelamin == 'P')
                                        <option value="{{ $p->id }}" {{ old('mother_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Ibu Eksternal (Non-Raja) -->
                        <div class="flex flex-col gap-xs bg-surface-container-low p-sm rounded-xl border border-outline-variant/50">
                            <label for="nama_ibu_non_raja" class="font-label-md text-[11px] font-black text-error flex items-center gap-0.5 uppercase tracking-wide">
                                <span class="material-symbols-outlined text-[14px]">edit_note</span> Jika Ibu dari Luar Silsilah Utama:
                            </label>
                            <input type="text" name="nama_ibu_non_raja" id="nama_ibu_non_raja" 
                                   class="w-full px-sm py-xs bg-surface-bright border border-outline-variant rounded-lg font-body-md text-xs outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                   value="{{ old('nama_ibu_non_raja') }}" placeholder="Ketik nama ibu kandung langsung...">
                            <span class="text-[10px] text-outline leading-tight">Gunakan kolom ini jika tokoh terlahir dari garis keturunan istri luar (selir/pernikahan eksternal).</span>
                        </div>

                        <div class="h-px bg-outline-variant/40 my-sm"></div>

                        <!-- Upload Foto Tokoh -->
                        <div class="flex flex-col gap-xs">
                            <label for="foto" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Foto / Ilustrasi Tokoh</label>
                            <!-- PERBAIKAN UTAMA: Mengubah file modifier menggunakan utility warna dasar yang aman (slate/neutral/blue) -->
                            <input type="file" name="foto" id="foto" 
                                   class="w-full text-xs text-on-surface-variant file:mr-md file:py-2 file:px-md file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-outline-variant rounded-xl p-1 bg-surface-bright transition-all cursor-pointer">
                            <span class="text-[10px] text-outline">Format resmi: JPG, JPEG, PNG. Maksimal beban berkas: 2MB.</span>
                            @error('foto') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- AKSI KENDALI FORMULIR (Tombol Simpan / Reset) -->
                <div class="flex justify-end items-center gap-sm border-t border-outline-variant pt-md mt-lg">
                    <!-- PERBAIKAN: Memastikan text color kontras (text-slate-700 dan bg-slate-100 saat di-hover) -->
                    <button type="reset" 
                            class="px-md py-sm border border-outline-variant text-slate-700 bg-transparent hover:bg-slate-100 rounded-xl font-label-md text-xs font-bold transition-colors">
                        Reset Form
                    </button>
                    <!-- PERBAIKAN: Memastikan bg-success (atau diganti emerald-600) berpasangan jelas dengan text-white -->
                    <button type="submit" 
                            class="px-lg py-sm bg-emerald-600 text-white hover:bg-emerald-700 active:scale-95 rounded-xl font-label-md text-xs font-bold flex items-center gap-xs transition-all shadow-md">
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

        document.addEventListener('DOMContentLoaded', function() {
            togglePasanganField();
        });
    </script>
</x-app-layout>