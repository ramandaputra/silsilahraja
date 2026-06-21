<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Silsilah Raja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold text-primary"><i class="fa-solid fa-crown text-warning me-2"></i>Silsilah Raja</h1>
            <p class="text-muted">Cari dan temukan informasi silsilah data keluarga kerajaan</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <form action="{{ route('home') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Ketik nama anggota keluarga kerajaan..." value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary btn-lg">Cari</button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(request()->has('q'))
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold text-dark">Hasil Pencarian untuk: "{{ request('q') }}"</div>
                        <div class="card-body">
                            @if($results->isEmpty())
                                <p class="text-danger text-center my-3">Data tidak ditemukan.</p>
                            @else
                                <div class="list-group">
                                    @foreach($results as $person)
                                        <a href="{{ route('person.detail', $person->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $person->nama_lengkap }}</h6>
                                                <small class="text-muted">Jenis Kelamin: {{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                            </div>
                                            <span class="badge bg-secondary rounded-pill">Lihat Profil</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</body>
</html>