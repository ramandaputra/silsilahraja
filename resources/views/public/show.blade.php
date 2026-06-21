<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ $person->nama_lengkap }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 40px 0;
            border-radius: 0 0 20px 20px;
        }
        .avatar-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid white;
        }
        .tree-box {
            border-left: 3px solid #2a5298;
            padding-left: 20px;
            position: relative;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pencarian
        </a>
    </div>

    <header class="profile-header shadow-sm mb-4">
        <div class="container">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-2 mb-3 mb-md-0">
                    @if($person->foto)
                        <img src="{{ asset('storage/' . $person->foto) }}" class="rounded-circle avatar-img shadow" alt="Foto {{ $person->nama_lengkap }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($person->nama_lengkap) }}&size=150&background=random" class="rounded-circle avatar-img shadow" alt="Avatar">
                    @endif
                </div>
                <div class="col-md-10">
                    <h1 class="fw-bold mb-1">{{ $person->nama_lengkap }}</h1>
                    <p class="lead mb-2">
                        <span class="badge bg-light text-dark">
                            {{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        @if($person->tanggal_wafat)
                            <span class="badge bg-danger">Wafat</span>
                        @else
                            <span class="badge bg-success">Hidup</span>
                        @endif
                    </</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold text-primary">
                        <i class="fa-solid fa-id-card me-2"></i> Informasi Biodata
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="ps-3">Tempat Lahir</th>
                                    <td>{{ $person->tempat_lahir ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-3">Tanggal Lahir</th>
                                    <td>{{ $person->tanggal_lahir ? \Carbon\Carbon::parse($person->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                @if($person->tanggal_wafat)
                                <tr>
                                    <th class="ps-3">Tanggal Wafat</th>
                                    <td>{{ \Carbon\Carbon::parse($person->tanggal_wafat)->translatedFormat('d F Y') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white fw-bold text-primary">
                        <i class="fa-solid fa-book me-2"></i> Biografi / Catatan Sejarah
                    </div>
                    <div class="card-body">
                        <p class="text-muted lh-base">
                            {{ $person->biografi ?? 'Belum ada data biografi tertulis untuk tokoh ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold text-primary">
                        <i class="fa-solid fa-sitemap me-2"></i> Struktur Hubungan Keluarga (Silsilah)
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold small"><i class="fa-solid fa-caret-up text-secondary"></i> Orang Tua</h6>
                            <div class="row g-2 mt-1">
                                <div class="col-6">
                                    <div class="p-3 border rounded bg-white">
                                        <small class="text-muted d-block">Ayah</small>
                                        @if($person->father)
                                            <a href="{{ route('person.detail', $person->father->id) }}" class="fw-bold text-decoration-none text-dark">
                                                <i class="fa-solid fa-mars text-primary me-1"></i> {{ $person->father->nama_lengkap }}
                                            </a>
                                        @else
                                            <span class="text-muted italic">Tidak terdata</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded bg-white">
                                        <small class="text-muted d-block">Ibu</small>
                                        @if($person->mother)
                                            <a href="{{ route('person.detail', $person->mother->id) }}" class="fw-bold text-decoration-none text-dark">
                                                <i class="fa-solid fa-venus text-danger me-1"></i> {{ $person->mother->nama_lengkap }}
                                            </a>
                                        @else
                                            <span class="text-muted italic">Tidak terdata</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold small"><i class="fa-solid fa-user text-primary"></i> Fokus Profil</h6>
                            <div class="p-3 bg-primary text-white rounded shadow-sm mt-1">
                                <span class="fw-bold d-block">{{ $person->nama_lengkap }}</span>
                                <small>Subjek Utama</small>
                            </div>
                        </div>

                        <div>
                            <h6 class="text-uppercase text-muted fw-bold small mb-2"><i class="fa-solid fa-caret-down text-secondary"></i> Keturunan / Anak</h6>
                            
                            @php
                                // Ambil data anak secara fleksibel (baik subjek ini bertindak sebagai ayah maupun ibu)
                                $children = \App\Models\Person::where('father_id', $person->id)
                                             ->orWhere('mother_id', $person->id)
                                             ->get();
                            @endphp

                            @if($children->isEmpty())
                                <div class="p-3 border rounded bg-white text-muted">
                                    Tidak memiliki atau belum terdata hubungan anak.
                                </div>
                            @else
                                <div class="tree-box">
                                    <div class="list-group shadow-sm">
                                        @foreach($children as $child)
                                            <a href="{{ route('person.detail', $child->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                <div>
                                                    @if($child->jenis_kelamin == 'L')
                                                        <i class="fa-solid fa-mars text-primary me-2"></i>
                                                    @else
                                                        <i class="fa-solid fa-venus text-danger me-2"></i>
                                                    @endif
                                                    <span class="fw-bold">{{ $child->nama_lengkap }}</span>
                                                </div>
                                                <span class="badge bg-secondary rounded-pill btn-sm">Lihat Profil</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>