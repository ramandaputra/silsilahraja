<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencari Relasi Silsilah - SilsilahRaja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body { background-color: #f4f6f9; }
        .select2-container .select2-selection--single { height: 45px !important; padding-top: 8px; border: 1px solid #ced4da; border-radius: 8px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px; }
        .card-custom { border-radius: 15px; border: none; }
        .result-box { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border-radius: 12px; }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary"><i class="fa-solid fa-people-arrows me-2"></i> Pencari Relasi Hubungan</h2>
            <p class="text-muted">Cari tahu status hubungan kekerabatan keluarga berdasarkan adat Melayu</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                
                @if(session('error'))
                    <div class="alert alert-danger mb-4 shadow-sm">{{ session('error') }}</div>
                @endif

                <div class="card shadow card-custom p-4 bg-white mb-4">
                    <form action="{{ route('relation.process') }}" method="GET">
                        <div class="row g-4 align-items-center">
                            
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-secondary">Jika Saya Adalah :</label>
                                <select name="person_a_id" id="person_a" class="form-select select2-enable" required>
                                    <option value="">-- Pilih Tokoh Utama --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personA) && $personA->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_lengkap }} ({{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 text-center pt-4">
                                <span class="bg-light p-3 rounded-circle border d-inline-block shadow-sm">
                                    <i class="fa-solid fa-arrows-left-right text-primary fs-4"></i>
                                </span>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-bold text-secondary">Maka Hubungan Tokoh Ini :</label>
                                <select name="person_b_id" id="person_b" class="form-select select2-enable" required>
                                    <option value="">-- Pilih Tokoh Kedua --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personB) && $personB->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_lengkap }} ({{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow fw-bold rounded-pill">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i> Analisis Hubungan
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

                @if(isset($relationLabel))
                    <div class="card shadow card-custom result-box p-4 text-center">
                        <h6 class="text-uppercase tracking-wider text-warning fw-bold mb-3">Hasil Analisis Hubungan Silsilah</h6>
                        <div class="fs-4 mb-2">
                            <strong>{{ $personB->nama_lengkap }}</strong> adalah 
                        </div>
                        <div class="display-5 fw-black text-white bg-white bg-opacity-25 py-2 px-4 rounded d-inline-block my-2 border border-white border-opacity-25 shadow-sm">
                            <i class="fa-solid fa-crown text-warning me-2"></i>{{ $relationLabel }}
                        </div>
                        <div class="fs-5 mt-2">
                            dari <strong>{{ $personA->nama_lengkap }}</strong>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top border-white border-opacity-25">
                            <a href="{{ route('person.trah', $personA->id) }}" class="btn btn-sm btn-light fw-bold text-primary rounded-pill px-3 me-2">
                                <i class="fa-solid fa-sitemap me-1"></i> Lihat Trah {{ $personA->nama_lengkap }}
                            </a>
                            <a href="{{ route('person.trah', $personB->id) }}" class="btn btn-sm btn-outline-light fw-bold rounded-pill px-3">
                                <i class="fa-solid fa-sitemap me-1"></i> Lihat Trah {{ $personB->nama_lengkap }}
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-enable').select2({
                placeholder: "-- Pilih Anggota Silsilah --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</body>
</html>