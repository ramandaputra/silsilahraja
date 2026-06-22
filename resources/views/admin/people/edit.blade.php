<x-app-layout>
    @slot('page-title') Perbarui Profil Silsilah @endslot

    <div class="space-y-lg">
        
        <div class="flex flex-col gap-xs mb-4">
            <a href="{{ route('admin.people.index') }}" class="inline-flex items-center gap-xs text-xs font-semibold text-secondary hover:underline transition-all">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Daftar Anggota
            </a>
            <h2 class="font-headline-md text-[22px] font-black text-primary mt-xs">Edit Data Tokoh: {{ $person->nama_lengkap }}</h2>
            <p class="font-body-md text-sm text-on-surface-variant">Perbarui informasi detail tokoh dan sesuaikan kembali garis hubungan silsilahnya pada basis data.</p>
        </div>

        <div class="bento-card overflow-hidden bg-surface-container-lowest p-lg">
            
            <form action="{{ route('admin.people.update', $person->id) }}" method="POST" enctype="multipart/form-data" class="space-y-lg">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                    
                    <div class="md:col-span-2 space-y-md">
                        
                        <div class="flex flex-col gap-xs">
                            <label for="nama_lengkap" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                   class="w-full px-md py-sm bg-surface-bright border @error('nama_lengkap') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all" 
                                   value="{{ old('nama_lengkap', $person->nama_lengkap) }}" required>
                            @error('nama_lengkap') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label for="jenis_kelamin" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" 
                                        class="w-full px-md py-sm bg-surface-bright border @error('jenis_kelamin') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all text-on-surface" required>
                                    <option value="L" {{ old('jenis_kelamin', $person->jenis_kelamin) == 'L' ? 'selected' : '' }}>♂️ Laki-Laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $person->jenis_kelamin) == 'P' ? 'selected' : '' }}>♀️ Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col gap-xs">
                                <label for="tempat_lahir" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                       value="{{ old('tempat_lahir', $person->tempat_lahir) }}" placeholder="Contoh: Istana Dalam">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label for="status_pernikahan" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Status Pernikahan</label>
                                <select name="status_pernikahan" id="status_pernikahan" onchange="togglePasanganField()"
                                        class="w-full px-md py-sm bg-surface-bright border @error('status_pernikahan') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 transition-all text-on-surface" required>
                                    <option value="Belum Menikah" {{ old('status_pernikahan', $person->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>💍 Belum Menikah</option>
                                    <option value="Menikah" {{ old('status_pernikahan', $person->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>👑 Menikah</option>
                                </select>
                                @error('status_pernikahan') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col gap-xs" id="pasangan_wrapper">
                                <label for="nama_pasangan" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Nama Suami / Istri (Luar Kerajaan)</label>
                                <input type="text" name="nama_pasangan" id="nama_pasangan" 
                                       class="w-full px-md py-sm bg-surface-bright border @error('nama_pasangan') border-error focus:ring-error @else border-outline-variant focus:ring-secondary @enderror rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                       value="{{ old('nama_pasangan', $person->nama_pasangan) }}" placeholder="Contoh: Permaisuri A, Selir B">
                                <span class="text-[11px] text-outline leading-tight">Jika menikah lebih dari sekali, pisahkan nama dengan tanda koma (,).</span>
                                @error('nama_pasangan') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label for="tanggal_lahir" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all text-on-surface-variant" 
                                       value="{{ old('tanggal_lahir', $person->tanggal_lahir) }}">
                            </div>

                            <div class="flex flex-col gap-xs">
                                <label for="tanggal_wafat" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Tanggal Wafat (Kosongkan jika hidup)</label>
                                <input type="date" name="tanggal_wafat" id="tanggal_wafat" 
                                       class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all text-on-surface-variant" 
                                       value="{{ old('tanggal_wafat', $person->tanggal_wafat) }}">
                            </div>
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label for="biografi" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Biografi Singkat / Sejarah</label>
                            <textarea name="biografi" id="biografi" rows="5" 
                                      class="w-full p-md bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                      placeholder="Tuliskan kisah hidup, pencapaian, atau catatan sejarah penting tokoh...">{{ old('biografi', $person->biografi) }}</textarea>
                        </div>
                    </div>

                    <div class="md:col-span-1 border-t md:border-t-0 md:border-l border-outline-variant/60 pt-lg md:pt-0 md:pl-lg space-y-md">
                        <h5 class="font-title-lg text-sm text-secondary font-bold uppercase tracking-widest flex items-center gap-xs mb-2">
                            <span class="material-symbols-outlined text-[18px]">account_tree</span> Hubungan Silsilah
                        </h5>
                        
                        <div class="flex flex-col gap-xs">
                            <label for="father_id" class="font-label-md text-xs font-bold text-primary">Ayah Kandung</label>
                            <select name="father_id" id="father_id" 
                                    class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                <option value="">-- Tidak Diketahui / Leluhur Teratas --</option>
                                @foreach($allPeople as $p)
                                    @if($p->jenis_kelamin == 'L')
                                        <option value="{{ $p->id }}" {{ old('father_id', $person->father_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-xs">
                            <label for="mother_id" class="font-label-md text-xs font-bold text-primary">Ibu Kandung (Keluarga Internal)</label>
                            <select name="mother_id" id="mother_id" 
                                    class="w-full px-md py-sm bg-surface-bright border border-outline-variant rounded-xl font-body-md text-sm outline-none focus:ring-2 focus:ring-secondary text-on-surface-variant">
                                <option value="">-- Bukan dari Keluarga Internal / Isi di Bawah --</option>
                                @foreach($allPeople as $p)
                                    @if($p->jenis_kelamin == 'P')
                                        <option value="{{ $p->id }}" {{ old('mother_id', $person->mother_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-xs bg-surface-container-low p-sm rounded-xl border border-outline-variant/50">
                            <label for="nama_ibu_non_raja" class="font-label-md text-[11px] font-black text-error flex items-center gap-0.5 uppercase tracking-wide">
                                <span class="material-symbols-outlined text-[14px]">edit_note</span> Jika Ibu dari Luar Silsilah Utama:
                            </label>
                            <input type="text" name="nama_ibu_non_raja" id="nama_ibu_non_raja" 
                                   class="w-full px-sm py-xs bg-surface-bright border border-outline-variant rounded-lg font-body-md text-xs outline-none focus:ring-2 focus:ring-secondary transition-all" 
                                   value="{{ old('nama_ibu_non_raja', $person->nama_ibu_non_raja) }}" placeholder="Ketik nama ibu kandung langsung...">
                            <span class="text-[10px] text-outline leading-tight">Gunakan kolom ini jika tokoh terlahir dari garis keturunan istri luar (selir/pernikahan eksternal).</span>
                        </div>

                        <div class="h-px bg-outline-variant/40 my-sm"></div>

                        <div class="flex flex-col gap-xs">
                            <label for="foto" class="font-label-md text-xs font-bold text-primary uppercase tracking-wider">Foto / Ilustrasi Tokoh</label>
                            
                            @if($person->foto)
                                <div class="mb-2 p-xs bg-surface-container-high rounded-xl border border-outline-variant flex flex-col items-center gap-xs">
                                    <img src="{{ asset('storage/' . $person->foto) }}" alt="Foto Tokoh" class="max-h-[140px] w-auto object-cover rounded-lg shadow-sm">
                                    <span class="text-[10px] text-outline font-medium">Berkas Aktif Saat Ini</span>
                                </div>
                            @endif

                            <input type="file" name="foto" id="foto" 
                                   class="w-full text-xs text-on-surface-variant file:mr-md file:py-xs file:px-md file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-fixed file:text-on-primary-fixed hover:file:opacity-90 border border-outline-variant rounded-xl p-1 bg-surface-bright">
                            <span class="text-[10px] text-outline">Format resmi: JPG, JPEG, PNG. Maksimal beban berkas: 2MB.</span>
                            @error('foto') <span class="text-xs text-error font-semibold mt-0.5 flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-sm border-t border-outline-variant pt-md mt-lg">
                    <a href="{{ route('admin.people.index') }}" 
                       class="px-md py-sm border border-outline-variant text-on-surface-variant hover:bg-surface-container-high rounded-xl font-label-md text-xs font-bold transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-lg py-sm bg-secondary text-on-secondary hover:opacity-90 active:scale-95 rounded-xl font-label-md text-xs font-bold flex items-center gap-xs transition-all shadow-md">
                        <span class="material-symbols-outlined text-[18px]">cloud_done</span> Perbarui Data Tokoh
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function togglePasanganField() {
            const statusPernikahan = document.getElementById('status_pernikahan').value;
            const pasanganWrapper = document.getElementById('pasangan_wrapper');
            const inputPasangan = document.getElementById('nama_pasangan');

            if (statusPernikahan === 'Menikah') {
                pasanganWrapper.style.opacity = '1';
                pasanganWrapper.style.pointerEvents = 'auto';
                // Menjaga elemen agar tetap terlihat rapi di Tailwind tanpa mengacaukan grid kalkulasi
                pasanganWrapper.classList.remove('invisible', 'h-0', 'overflow-hidden');
            } else {
                pasanganWrapper.style.opacity = '0';
                pasanganWrapper.style.pointerEvents = 'none';
                pasanganWrapper.classList.add('invisible', 'h-0', 'overflow-hidden');
                inputPasangan.value = ''; 
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            togglePasanganField();
        });
    </script>
</x-app-layout>