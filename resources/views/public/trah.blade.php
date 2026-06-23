<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohon Silsilah - {{ $person->nama_lengkap }}</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#001e40",
                        "secondary": "#0059bb",
                        "background": "#fbf9f8",
                        "outline-variant": "#c3c6d1",
                        "surface-variant": "#e4e2e2"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fbf9f8; }
        
        /* STRUKTUR DIAGRAM MINIMALIS & RAMPOK LUAS */
        .trah-container {
            display: block;
            text-align: center;
            overflow-x: auto;
            padding: 20px 0;
            white-space: nowrap;
        }
        .trah-container ul {
            padding-top: 20px;
            position: relative;
        }
        .trah-container ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1.5px solid #001e40;
            width: 0;
            height: 20px;
            margin-left: -0.75px;
        }
        .trah-node {
            display: inline-block;
            vertical-align: top;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 6px 0 6px;
        }
        .trah-node::before, .trah-node::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1.5px solid #001e40;
            width: 50%;
            height: 20px;
        }
        .trah-node::after {
            right: auto;
            left: 50%;
            border-left: 1.5px solid #001e40;
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
            border-right: 1.5px solid #001e40;
            border-radius: 0 4px 0 0;
        }
        .trah-node:first-child::after {
            border-radius: 4px 0 0 0;
        }
        
        /* DESAIN KARTU NODE SUPER CLEAN */
        .trah-card {
            border: 1px solid #c3c6d1;
            padding: 8px 14px;
            text-decoration: none;
            color: #1b1c1c;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
            border-radius: 6px;
            background-color: #ffffff;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            min-width: 150px;
            text-align: left;
        }
        .trah-card:hover {
            border-color: #0059bb;
            transform: translateY(-1px);
        }
        
        /* WARNA FOKUS UTAMA YANG KONTRAS & BERSIH */
        .trah-card.active {
            background: linear-gradient(135deg, #001e40 0%, #003366 100%);
            color: #ffffff !important;
            border-color: #001e40;
            box-shadow: 0 4px 8px rgba(0, 30, 64, 0.15);
        }
    </style>
</head>
<body class="bg-[#fbf9f8] text-gray-900 min-h-screen flex flex-col pt-24">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 flex justify-between items-center px-8 bg-white/90 backdrop-blur-sm border-b border-gray-200 h-20">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-3xl">account_tree</span>
            <span class="text-xl font-bold text-primary">Silsilah Keluarga</span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-6">
        
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('person.detail', $person->id) }}" class="inline-flex items-center gap-1 text-primary font-medium hover:underline text-sm">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali ke Profil</span>
            </a>
            <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded-md text-sm shadow-sm hover:bg-secondary">
                <i class="fa-solid fa-print mr-1"></i> Cetak Bagan
            </button>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-6">
            <div class="text-center mb-6">
                <h4 class="text-2xl font-bold text-primary">Bagan Silsilah Keturunan (Trah)</h4>
                <p class="text-sm text-gray-500 mt-1">Generasi Hubungan dari Keluarga <strong>{{ $person->nama_lengkap }}</strong></p>
            </div>
            
            <div class="trah-container">
                <div style="display: inline-block;">
                    
                    <!-- KELOMPOK INDIVIDU / PASANGAN LELUHUR PUNCAK -->
                    <div class="inline-flex items-center gap-2">
                        <div class="trah-card {{ $rootAncestor->id == $person->id ? 'active' : '' }}">
                            <small class="{{ $rootAncestor->id == $person->id ? 'text-amber-400' : 'text-gray-400' }} block text-[10px] tracking-wider uppercase font-semibold mb-0.5">
                                {{ $rootAncestor->id == $person->id ? '👑 Subjek Fokus' : '👴 Leluhur Puncak' }}
                            </small>
                            <span class="block">{{ $rootAncestor->nama_lengkap }}</span>
                        </div>
                        
                        @if($rootAncestor->status_pernikahan == 'Menikah' && $rootAncestor->nama_pasangan)
                            <div class="text-red-500 text-xs"><i class="fa-solid fa-heart"></i></div>
                            <div class="trah-card bg-gray-50 border-dashed">
                                <small class="text-gray-400 block text-[10px] tracking-wider uppercase font-medium mb-0.5">💍 Pasangan</small>
                                <span class="block text-gray-600 text-xs font-normal">{!! str_replace(',', '<br>', $rootAncestor->nama_pasangan) !!}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Keturunan -->
                    @if(!$rootChildren->isEmpty())
                        <ul>
                            @foreach($rootChildren as $child)
                                @include('public.partials.trah_node', ['node' => $child, 'currentPersonId' => $person->id])
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    </main>
</body>
</html>