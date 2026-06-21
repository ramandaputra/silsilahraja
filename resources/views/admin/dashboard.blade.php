<x-app-layout>
    <div class="container">
        <!-- Header Welcome -->
        <div class="row mb-4">
            <div class="col">
                <div class="bg-white p-4 rounded shadow-sm d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Selamat Datang, {{ auth()->user()->name }}!</h2>
                        <p class="text-muted mb-0">Panel kendali Silsilah Raja siap digunakan. Anda memiliki akses penuh sebagai Administrator.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fa-solid fa-user-gear fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik Real-time -->
        <div class="row g-3 mb-4">
            <!-- Total Silsilah -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1 opacity-75">Total Anggota Silsilah</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Person::count() }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="fa-solid fa-users fa-2x"></i>
                        </div>
                    </div>
                    <small class="mt-3 text-white-50">Semua tokoh yang terdaftar di database</small>
                </div>
            </div>

            <!-- Total Laki-Laki -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-info text-white p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1 opacity-75">Tokoh Laki-Laki (Raja/Pangeran)</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Person::where('jenis_kelamin', 'L')->count() }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="fa-solid fa-mars fa-2x"></i>
                        </div>
                    </div>
                    <small class="mt-3 text-white-50">Laki-laki pemegang garis keturunan</small>
                </div>
            </div>

            <!-- Total Perempuan -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-danger text-white p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1 opacity-75">Tokoh Perempuan (Ratu/Putri)</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Person::where('jenis_kelamin', 'P')->count() }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="fa-solid fa-venus fa-2x"></i>
                        </div>
                    </div>
                    <small class="mt-3 text-white-50">Perempuan dalam silsilah keluarga kerajaan</small>
                </div>
            </div>
        </div>

        <!-- Panel Akses Cepat & Log Sistem -->
        <div class="row g-4">
            <!-- Shortcut Manajemen -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                    <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-bolt text-warning me-2"></i>Akses Cepat Pengelolaan</h5>
                    <p class="text-muted small">Gunakan tombol di bawah ini untuk langsung menuju ke halaman manipulasi data silsilah keluarga kerajaan.</p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('admin.people.index') }}" class="btn btn-primary py-2.5 fw-semibold">
                            <i class="fa-solid fa-sitemap me-2"></i> Lihat Semua Data Silsilah
                        </a>
                        <a href="{{ route('admin.people.create') }}" class="btn btn-outline-success py-2.5 fw-semibold">
                            <i class="fa-solid fa-user-plus me-2"></i> Tambah Anggota/Raja Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Database Petunjuk -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                    <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-circle-info text-info me-2"></i>Panduan Alur Input</h5>
                    <div class="small text-secondary">
                        <p class="mb-2">Agar silsilah terhubung dengan sempurna di halaman publik, ikuti urutan input berikut:</p>
                        <ol class="ps-3 mb-0">
                            <li class="mb-1">Input data <strong>Raja Tetua / Leluhur paling atas</strong> terlebih dahulu dengan mengosongkan kolom Ayah & Ibu.</li>
                            <li class="mb-1">Setelah data Leluhur tersimpan, barulah input data <strong>Anak-Anaknya</strong>.</li>
                            <li>Saat menginput data Anak, pastikan Anda memilih nama Leluhur tadi pada pilihan dropdown <strong>Ayah</strong> atau <strong>Ibu</strong> yang tersedia.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>