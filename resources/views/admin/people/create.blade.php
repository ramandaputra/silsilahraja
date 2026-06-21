<x-app-layout>
    <div class="container">
        <!-- Breadcrumb & Header -->
        <div class="row mb-4">
            <div class="col">
                <a href="{{ route('admin.people.index') }}" class="text-decoration-none small text-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h2 class="fw-bold text-dark mt-2">Tambah Anggota Silsilah Baru</h2>
                <p class="text-muted">Masukkan informasi detail tokoh dan hubungkan ke orang tuanya.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- FORM UTAMA -->
                <form action="{{ route('admin.people.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- SISI KIRI: DATA UTAMA -->
                        <div class="col-md-8">
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Sultan Iskandar Muda" required>
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Gender --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Istana Dalam">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                                </div>

                                <!-- Tanggal Wafat -->
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_wafat" class="form-label fw-semibold">Tanggal Wafat (Kosongkan jika masih hidup)</label>
                                    <input type="date" name="tanggal_wafat" id="tanggal_wafat" class="form-control" value="{{ old('tanggal_wafat') }}">
                                </div>
                            </div>

                            <!-- Biografi / Catatan Sejarah -->
                            <div class="mb-3">
                                <label for="biografi" class="form-label fw-semibold">Biografi Singkat / Sejarah</label>
                                <textarea name="biografi" id="biografi" rows="5" class="form-control" placeholder="Tuliskan kisah hidup, pencapaian, atau masa kejayaan tokoh di sini...">{{ old('biografi') }}</textarea>
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
                                            <option value="{{ $p->id }}" {{ old('father_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Ibu -->
                            <div class="mb-3">
                                <label for="mother_id" class="form-label fw-semibold">Ibu Kandung</label>
                                <select name="mother_id" id="mother_id" class="form-select">
                                    <option value="">-- Tidak Diketahui / Leluhur Teratas --</option>
                                    @foreach($allPeople as $p)
                                        @if($p->jenis_kelamin == 'P')
                                            <option value="{{ $p->id }}" {{ old('mother_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            <!-- Upload Foto Lukisan/Tokoh -->
                            <div class="mb-4">
                                <label for="foto" class="form-label fw-semibold">Foto / Ilustrasi Tokoh</label>
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror">
                                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="row mt-3 border-top pt-3">
                        <div class="col text-end">
                            <button type="reset" class="btn btn-light me-2">Reset Form</button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Data Tokoh
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>