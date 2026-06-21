<x-app-layout>
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-dark">Ringkasan Data Silsilah</h2>
                <p class="text-muted">Selamat datang kembali, Panel Admin siap digunakan.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Total Anggota</h6>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Person::count() }}</h3>
                        </div>
                        <i class="fa-solid fa-users fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-info text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Laki-Laki</h6>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Person::where('jenis_kelamin', 'L')->count() }}</h3>
                        </div>
                        <i class="fa-solid fa-mars fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-danger text-white p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase small mb-1">Perempuan</h6>
                            <h3 class="fw-bold mb-0">{{ \App\Models\Person::where('jenis_kelamin', 'P')->count() }}</h3>
                        </div>
                        <i class="fa-solid fa-venus fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm p-4 text-center bg-white">
                    <h5 class="fw-bold mb-3">Mulai Kelola Silsilah Keluarga</h5>
                    <p class="text-muted mb-4">Anda bisa menambah data individu, mengatur hubungan orang tua ke anak, serta mengunggah foto biografi sejarah raja.</p>
                    <a href="{{ route('admin.people.index') }}" class="btn btn-primary px-4 py-2">
                        <i class="fa-solid fa-folder-plus me-1"></i> Buka Manajemen Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>