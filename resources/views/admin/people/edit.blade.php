<x-app-layout>
    <div class="container">
        <!-- Breadcrumb & Header -->
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.people.index') }}" class="text-decoration-none small text-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h2 class="fw-bold text-dark mt-2">Edit Data Tokoh: {{ $person->nama_lengkap }}</h2>
                <p class="text-muted">Perbarui informasi detail tokoh dan sesuaikan kembali hubungan silsilahnya.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- FORM UTAMA -->
                <form action="{{ route('admin.people.update', $person->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Wajib di Laravel untuk proses Update/Edit -->

                    <div class="row">
                        <!-- SISI KIRI: DATA UTAMA -->
                        <div class="col-md-8">
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $person->nama_lengkap) }}" required>
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="L" {{ old('jenis_kelamin', $person->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $person->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $person->tempat_lahir) }}" placeholder="Contoh: Istana Dalam">
                                </div>
                            </div>

                            <!-- INPUT BARU: STATUS PERNIKAHAN & PASANGAN -->
                            <div class="row">
                                <!-- Status Pernikahan -->
                                <div class="col-md-6 mb-3">
                                    <label for="status_pernikahan" class="form-label fw-semibold">Status Pernikahan</label>
                                    <select name="status_pernikahan" id="status_pernikahan" class="form-select @error('status_pernikahan') is-invalid @enderror" required onchange="togglePasanganField()">
                                        <option value="Belum Menikah" {{ old('status_pernikahan', $person->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Menikah" {{ old('status_pernikahan', $person->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    </select>
                                    @error('status_pernikahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Nama Pasangan (Dinamis muncul lewat JS) -->
                                <div class="col-md-6 mb-3" id="pasangan_wrapper">
                                    <label for="nama_pasangan" class="form-label fw-semibold">Nama Suami / Istri (Luar Kerajaan)</label>
                                    <input type="text" name="nama_pasangan" id="nama_pasangan" class="form-control @error('nama_pasangan') is-invalid @enderror" value="{{ old('nama_pasangan', $person->nama_pasangan) }}" placeholder="Contoh: Permaisuri A, Selir B, Istri C (Pisahkan dengan tanda koma)">
                                    <small class="text-muted">Jika menikah lebih dari sekali, tuliskan semua nama dan pisahkan dengan tanda koma (,)</small>
                                    @error('nama_pasangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $person->tanggal_lahir) }}">
                                </div>

                                <!-- Tanggal Wafat -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_wafat" class="form-label fw-semibold">Tanggal Wafat (Kosongkan jika masih hidup)</label>
                                    <input type="date" name="tanggal_wafat" id="tanggal_wafat" class="form-control" value="{{ old('tanggal_wafat', $person->tanggal_wafat) }}">
                                </div>
                            </div>

                            <!-- Biografi -->
                            <div class="mb-3">
                                <label for="biografi" class="form-label fw-semibold">Biografi Singkat / Sejarah</label>
                                <textarea name="biografi" id="biografi" rows="5" class="form-control" placeholder="Tuliskan kisah hidup...">{{ old('biografi', $person->biografi) }}</textarea>
                            </div>
                        </div>

                        <!-- SISI KANAN: HUBUNGAN SILSILAH & FOTO -->
                        <div class="col-md-4 border-start ps-md-4">
                            <h5 class="fw-bold mb-3 text-secondary">Hubungan Silsilah</h5>
                            
                            <!-- Dropdown Ayah -->
                            <div class="mb-3">
                                <label for="father_id" class="form-label fw-semibold">Ayah Kandung</label>
                                <select name="father_id" id="father_id" class="form-select">
                                    <option value="">-- Tidak Diketahui / Leluhur Teratas --</option>
                                    @foreach($allPeople as $p)
                                        @if($p->jenis_kelamin == 'L')
                                            <option value="{{ $p->id }}" {{ old('father_id', $person->father_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Ibu -->
                            <div class="mb-3">
                                <label for="mother_id" class="form-label fw-semibold">Ibu Kandung (Dari Keluarga Kerajaan)</label>
                                <select name="mother_id" id="mother_id" class="form-select">
                                    <option value="">-- Bukan dari Keluarga Kerajaan / Pilih Manual di Bawah --</option>
                                    @foreach($allPeople as $p)
                                        @if($p->jenis_kelamin == 'P')
                                            <option value="{{ $p->id }}" {{ old('mother_id', $person->mother_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 bg-light p-2 rounded border">
                                <label for="nama_ibu_non_raja" class="form-label fw-semibold text-danger small"><i class="fa-solid fa-pen"></i> JIKA IBU DARI LUAR KERAJAAN (Istri 2/3/dst):</label>
                                <input type="text" name="nama_ibu_non_raja" id="nama_ibu_non_raja" class="form-control form-control-sm" value="{{ old('nama_ibu_non_raja', $person->nama_ibu_non_raja) }}" placeholder="Ketik langsung nama Ibu Kandungnya di sini...">
                                <small class="text-muted d-block mt-1" style="font-size: 11px;">Isi kolom ini jika Ibu anak ini adalah istri luar kerajaan (misal: Istri Kedua yang namanya Anda tulis di profil sang Ayah).</small>
                            </div>

                            <hr>

                            <!-- Foto Saat Ini & Upload Baru -->
                            <div class="mb-4">
                                <label for="foto" class="form-label fw-semibold">Foto / Ilustrasi Tokoh</label>
                                
                                @if($person->foto)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $person->foto) }}" alt="Foto Tokoh" class="img-thumbnail" style="max-height: 150px;">
                                        <span class="d-block small text-muted">Foto saat ini</span>
                                    </div>
                                @endif

                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maks: 2MB (Biarkan kosong jika tidak ingin diubah)</small>
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="row mt-3 border-top pt-3">
                        <div class="col text-end">
                            <a href="{{ route('admin.people.index') }}" class="btn btn-light me-2">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 text-dark font-bold">
                                <i class="fa-solid fa-square-check me-1"></i> Perbarui Data
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT UNTUK TOGGLE KONDISI INPUT -->
    <script>
        function togglePasanganField() {
            const statusPernikahan = document.getElementById('status_pernikahan').value;
            const pasanganWrapper = document.getElementById('pasangan_wrapper');
            const inputPasangan = document.getElementById('nama_pasangan');

            if (statusPernikahan === 'Menikah') {
                pasanganWrapper.style.display = 'block';
            } else {
                pasanganWrapper.style.display = 'none';
                inputPasangan.value = ''; // Mengosongkan data input jika diubah ke 'Belum Menikah'
            }
        }

        // Jalankan fungsi saat halaman selesai dimuat agar kondisi awal sesuai data dari database
        document.addEventListener('DOMContentLoaded', function() {
            togglePasanganField();
        });
    </script>
</x-app-layout>