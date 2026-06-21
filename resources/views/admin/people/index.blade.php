<x-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Kelola Silsilah Keluarga</h2>
                <p class="text-muted mb-0">Daftar seluruh silsilah raja yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('admin.people.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-user-plus me-1"></i> Tambah Anggota
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-3 py-3" width="50">No</th>
                                <th class="py-3">Nama Lengkap</th>
                                <th class="py-3">Jenis Kelamin</th>
                                <th class="py-3">Ayah</th>
                                <th class="py-3">Ibu</th>
                                <th class="text-center py-3" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($people as $index => $p)
                                <tr>
                                    <td class="ps-3 text-muted">
                                        {{ $people->firstItem() + $index }}
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ $p->nama_lengkap }}
                                    </td>
                                    <td>
                                        @if($p->jenis_kelamin == 'L')
                                            <span class="badge bg-info-subtle text-info px-2 py-1.5">
                                                <i class="fa-solid fa-mars me-1"></i> Laki-Laki
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1.5">
                                                <i class="fa-solid fa-venus me-1"></i> Perempuan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-secondary">
                                        {{ $p->father->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="text-secondary">
                                        {{ $p->mother->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm shadow-sm" role="group">
                                            <a href="{{ route('admin.people.edit', $p->id) }}" class="btn btn-outline-warning" title="Ubah Data">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.people.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tokoh {{ $p->nama_lengkap }} dari silsilah?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus Data">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-opacity-25 text-secondary"></i>
                                        <p class="mb-0 fw-semibold">Belum ada data silsilah raja yang tersimpan.</p>
                                        <small class="text-muted">Klik tombol "Tambah Anggota" di atas untuk memasukkan data pertama.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $people->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>