<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohon Silsilah - {{ $person->nama_lengkap }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS KHUSUS DIAGRAM POHON KELUARGA */
        .trah-container {
            display: block;
            text-align: center;
            overflow-x: auto;
            padding: 40px 0;
            white-space: nowrap;
            background-color: white;
            border-radius: 12px;
        }
        .trah-node {
            display: inline-block;
            vertical-align: top;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 8px 0 8px;
        }
        .trah-node::before, .trah-node::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2.5px solid #1e3c72;
            width: 50%;
            height: 20px;
        }
        .trah-node::after {
            right: auto;
            left: 50%;
            border-left: 2.5px solid #1e3c72;
        }
        .trah-node:only-child::after, .trah-node:only-child::before {
            display: none;
        }
        .trah-node:only-child {
            padding-top: 0;
        }
        .trah-node:first-child::before, .trah-node:last-child::after {
            border: 0 none;
        }
        .trah-node:last-child::before {
            border-right: 2.5px solid #1e3c72;
            border-radius: 0 5px 0 0;
        }
        .trah-node:first-child::after {
            border-radius: 5px 0 0 0;
        }
        .trah-row {
            display: block;
            position: relative;
            padding-bottom: 20px;
        }
        .trah-row::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            border-left: 2.5px solid #1e3c72;
            width: 0;
            height: 20px;
            margin-left: -1px;
        }
        .trah-card {
            border: 2px solid #1e3c72;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            border-radius: 8px;
            background-color: white;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            min-width: 180px;
        }
        .trah-card:hover {
            background-color: #2a5298;
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        .trah-card.active {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border-color: #1e3c72;
            padding: 15px 25px;
        }
        .trah-card.disabled {
            border: 2px dashed #ccc;
            background-color: #f9f9f9;
            color: #999;
            pointer-events: none;
        }

        /* MEDIA PRINT: Pengaturan Cetak Kertas */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                padding: 0;
            }
            .card {
                border: none !important;
            }
            .trah-container {
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-light">

    <div class="container my-4">
        <!-- HEADER NAVIGASI (HILANG SAAT DIPRINT) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('person.detail', $person->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Profil Tokoh
            </a>
            
            <!-- TOMBOL PRINT YANG ANDA MINTA -->
            <button onclick="window.print()" class="btn btn-primary btn-sm px-3 shadow-sm fw-bold">
                <i class="fa-solid fa-print me-1"></i> Cetak Bagan Trah Ini
            </button>
        </div>

        <!-- AREA UTAMA BAGAN POHON TRAH -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0 text-center">
                <h4 class="fw-bold text-primary mb-1">Bagan Silsilah Keturunan (Trah)</h4>
                <p class="text-muted mb-0 small">Generasi Hubungan dari Keluarga <strong>{{ $person->nama_lengkap }}</strong></p>
            </div>
            <div class="card-body bg-white p-4">
                
                <div class="trah-container">
                    <div style="display: inline-block;">
                        
                        <div class="d-inline-flex align-items-center bg-white p-2 rounded shadow-sm border {{ $rootAncestor->id == $person->id ? 'border-primary' : '' }}">
                            <div class="trah-card {{ $rootAncestor->id == $person->id ? 'active shadow-none' : '' }} m-0 border-0">
                                @if($rootAncestor->id == $person->id)
                                    <small class="text-warning d-block fw-normal mb-1"><i class="fa-solid fa-crown"></i> Subjek Fokus</small>
                                @else
                                    <small class="text-muted d-block fw-normal mb-1">
                                        @if($rootAncestor->jenis_kelamin == 'L')
                                            <i class="fa-solid fa-mars text-primary"></i> Leluhur Puncak
                                        @else
                                            <i class="fa-solid fa-venus text-danger"></i> Leluhur Puncak
                                        @endif
                                    </small>
                                @endif
                                <span class="{{ $rootAncestor->id == $person->id ? 'fs-5' : '' }}">{{ $rootAncestor->nama_lengkap }}</span>
                            </div>
                            
                            @if($rootAncestor->status_pernikahan == 'Menikah' && $rootAncestor->nama_pasangan)
                                <div class="px-2 text-danger fs-4">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                                <div class="trah-card m-0 border-0 bg-light text-start" style="min-width: 150px;">
                                    <small class="text-muted d-block fw-normal mb-1">
                                        <i class="fa-solid fa-user-friends text-secondary"></i> Pasangan
                                    </small>
                                    <span class="text-dark d-block" style="white-space: normal; line-height: 1.4; font-size: 13px;">
                                        {!! str_replace(',', '<br><i class="fa-solid fa-heart text-danger small me-1"></i>', $rootAncestor->nama_pasangan) !!}
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if(!$rootChildren->isEmpty())
                            <ul>
                                @foreach($rootChildren as $child)
                                    {{-- Memanggil partial node untuk menggambar seluruh cabang keturunan --}}
                                    @include('public.partials.trah_node', ['node' => $child, 'currentPersonId' => $person->id])
                                @endforeach
                            </ul>
                        @else
                            <div class="mt-4">
                                <div class="trah-card disabled">Belum Memiliki Keturunan Lebih Lanjut</div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>