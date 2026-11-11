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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#001e40",
                        "secondary": "#0059bb",
                        "background": "#fbf9f8",
                        "surface": "#fbf9f8",
                        "surface-container-high": "#eae8e7",
                        "surface-container-highest": "#e4e2e2",
                        "surface-container-low": "#f5f3f3",
                        "primary-container": "#003366",
                        "on-primary-container": "#799dd6",
                        "on-surface": "#1b1c1c",
                        "on-surface-variant": "#43474f",
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
            -webkit-overflow-scrolling: touch;
            cursor: grab;
        }
        .trah-container.is-grabbing {
            cursor: grabbing !important;
            user-select: none;
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

        /* GAYA KHUSUS CETAK (PRINT STYLESHEET) */
        @media print {
            @page {
                size: landscape;
                margin: 6mm;
            }

            nav,
            .no-print,
            .no-print * {
                display: none !important;
            }

            body {
                background: #ffffff !important;
                background-color: #ffffff !important;
                color: #000000 !important;
                padding-top: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            main {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .trah-main-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            .trah-container {
                overflow: visible !important;
                overflow-x: visible !important;
                display: block !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 auto !important;
                white-space: nowrap !important;
            }

            #trah-tree-root {
                display: inline-block !important;
                transform-origin: top center !important;
            }

            .trah-container ul::before,
            .trah-node::before,
            .trah-node::after {
                border-color: #001e40 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-card {
                box-shadow: none !important;
                border: 1px solid #9ca3af !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-card.active {
                background: #001e40 !important;
                color: #ffffff !important;
                border-color: #001e40 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-node {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .overflow-hidden {
                overflow: visible !important;
            }
        }
    </style>
</head>
<body class="bg-[#fbf9f8] text-gray-900 min-h-screen flex flex-col pt-24">

    <!-- Navbar -->
    @include('public.partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-6">
        
        <div class="flex flex-wrap justify-between items-center gap-3 mb-6 no-print">
            <a href="{{ route('person.detail', $person->id) }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Profil</span>
            </a>
            <div class="flex items-center gap-2">
                <!-- Kontrol Zoom Layar -->
                <div class="inline-flex items-center bg-white border border-gray-200 rounded-lg shadow-xs overflow-hidden">
                    <button type="button" onclick="zoomTree(-0.1)" class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 hover:text-primary transition" title="Perkecil Tampilan">
                        <i class="fa-solid fa-minus text-xs"></i>
                    </button>
                    <span id="zoom-badge" class="px-2 py-1 text-xs font-semibold text-gray-700 min-w-[48px] text-center select-none border-x border-gray-100">100%</span>
                    <button type="button" onclick="zoomTree(0.1)" class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 hover:text-primary transition" title="Perbesar Tampilan">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                    <button type="button" onclick="resetZoom()" class="px-2.5 py-1.5 text-xs text-gray-500 hover:bg-gray-100 hover:text-primary border-l border-gray-100 transition" title="Reset Ukuran">
                        Reset
                    </button>
                </div>

                <button type="button" onclick="printFamilyTree()" class="bg-primary text-white px-4 py-2 rounded-lg text-sm shadow-sm hover:bg-secondary inline-flex items-center gap-2 transition font-medium">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Bagan</span>
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-6 trah-main-card">
            <div class="text-center mb-6">
                <h4 class="text-2xl font-bold text-primary">Bagan Silsilah Keturunan (Trah)</h4>
                <p class="text-sm text-gray-500 mt-1">
                    Generasi Hubungan dari Keluarga <strong>{{ $person->nama_lengkap }}</strong>
                    @if(!empty($person->gelar_pembeda))
                        <span class="text-xs text-primary font-semibold">{{ $person->gelar_pembeda }}</span>
                    @elseif($person->has_duplicate_name && $person->nasab)
                        <span class="text-xs text-amber-700 font-semibold">{{ $person->nasab }}</span>
                    @endif
                </p>
                <p class="hidden print:block text-[11px] text-gray-500 mt-1">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-800 rounded-full text-xs font-medium mt-2.5 shadow-xs">
                    <span class="material-symbols-outlined text-sm">account_tree</span>
                    <span>Bagan Silsilah Kekerabatan Terdekat dari Subjek Fokus</span>
                </div>
            </div>
            
            <div class="trah-container">
                <div id="trah-tree-root" style="display: inline-block;">
                    
                    <!-- KELOMPOK INDIVIDU / PASANGAN LELUHUR PUNCAK -->
                    <div class="inline-flex items-center gap-2">
                        @if($rootAncestor->id == $person->id)
                            <div class="trah-card active">
                                <small class="text-amber-400 block text-[10px] tracking-wider uppercase font-semibold mb-0.5">
                                    @if($rootAncestor->jenis_kelamin == 'L')
                                        <i class="bi bi-gender-male text-amber-300"></i>
                                    @else
                                        <i class="bi bi-gender-female text-amber-300"></i>
                                    @endif
                                    <span>Subjek Fokus</span>
                                </small>
                                <span class="block">{{ $rootAncestor->nama_lengkap }}</span>
                            </div>
                        @else
                            @php
                                $rootRelInfo = $relatives[$rootAncestor->id] ?? null;
                                $rootRelText = $rootRelInfo['relation'] ?? 'Leluhur Awal';
                            @endphp
                            <a href="{{ route('person.trah', $rootAncestor->id) }}" class="trah-card">
                                <small class="text-gray-400 block text-[10px] tracking-wider uppercase font-semibold mb-0.5">
                                    @if($rootAncestor->jenis_kelamin == 'L')
                                        <i class="bi bi-gender-male text-blue-500"></i>
                                    @else
                                        <i class="bi bi-gender-female text-rose-500"></i>
                                    @endif
                                    <span>{{ $rootRelText }}</span>
                                </small>
                                <span class="block">{{ $rootAncestor->nama_lengkap }}</span>
                            </a>
                        @endif
                        
                        @if($rootAncestor->status_pernikahan == 'Menikah' && $rootAncestor->nama_pasangan)
                            <div class="text-red-500 text-xs"><i class="fa-solid fa-heart"></i></div>
                            <div class="trah-card bg-gray-50 border-dashed">
                                <small class="text-gray-400 block text-[10px] tracking-wider uppercase font-medium mb-0.5">
                                    @if($rootAncestor->jenis_kelamin == 'L')
                                        <i class="bi bi-gender-female text-rose-500"></i>
                                    @else
                                        <i class="bi bi-gender-male text-blue-500"></i>
                                    @endif
                                    <span>Pasangan</span>
                                </small>
                                <span class="block text-gray-600 text-xs font-normal">{!! str_replace(',', '<br>', $rootAncestor->nama_pasangan) !!}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Keturunan -->
                    @if(!$rootChildren->isEmpty())
                        <ul>
                            @foreach($rootChildren as $child)
                                @include('public.partials.trah_node', [
                                    'node' => $child,
                                    'currentPersonId' => $person->id,
                                    'childrenMap' => $childrenMap,
                                    'relatives' => $relatives,
                                    'peopleById' => $peopleById ?? []
                                ])
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>

            <!-- Keterangan Relasi -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-xs text-gray-600">
                <div class="flex items-center gap-2 font-semibold text-primary mb-2">
                    <span class="material-symbols-outlined text-base">info</span>
                    <span>Panduan Relasi Kekerabatan Terpilih:</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <span class="font-bold text-gray-800 block mb-1">Garis Langsung (1 Generasi)</span>
                        <ul class="list-disc list-inside space-y-0.5 text-gray-600">
                            <li>Orang Tua (Ayah / Ibu)</li>
                            <li>Keturunan Langsung (Anak)</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <span class="font-bold text-gray-800 block mb-1">Garis Dekat (2 Generasi)</span>
                        <ul class="list-disc list-inside space-y-0.5 text-gray-600">
                            <li>Kakek / Nenek</li>
                            <li>Saudara Kandung</li>
                            <li>Cucu</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <span class="font-bold text-gray-800 block mb-1">Garis Kerabat (3 Generasi)</span>
                        <ul class="list-disc list-inside space-y-0.5 text-gray-600">
                            <li>Kakek/Nenek Buyut</li>
                            <li>Paman / Bibi</li>
                            <li>Keponakan</li>
                            <li>Cicit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let currentZoom = 1;

        function zoomTree(step) {
            currentZoom = Math.max(0.3, Math.min(2.0, Math.round((currentZoom + step) * 10) / 10));
            applyZoom(currentZoom);
        }

        function resetZoom() {
            currentZoom = 1;
            applyZoom(1);
        }

        function applyZoom(zoomLevel) {
            const tree = document.getElementById('trah-tree-root');
            if (!tree) return;
            tree.style.transform = `scale(${zoomLevel})`;
            tree.style.transformOrigin = 'top center';
            
            const badge = document.getElementById('zoom-badge');
            if (badge) {
                badge.innerText = Math.round(zoomLevel * 100) + '%';
            }
        }

        function preparePrintScale() {
            const tree = document.getElementById('trah-tree-root');
            if (!tree) return;

            // Reset transform sementara untuk mengukur lebar elemen yang sebenarnya
            tree.style.transform = '';
            tree.style.transformOrigin = '';
            if ('zoom' in tree.style) {
                tree.style.zoom = '';
            }

            const treeWidth = tree.scrollWidth || tree.offsetWidth;
            
            // Area cetak standar kertas A4 Landscape dikurangi margin (sekitar 1060px)
            const printableWidth = 1060;

            if (treeWidth > printableWidth) {
                const scale = Math.floor((printableWidth / treeWidth) * 100) / 100;
                if ('zoom' in tree.style) {
                    tree.style.zoom = scale;
                } else {
                    tree.style.transform = `scale(${scale})`;
                    tree.style.transformOrigin = 'top center';
                }
            }
        }

        function resetPrintScale() {
            const tree = document.getElementById('trah-tree-root');
            if (!tree) return;
            if ('zoom' in tree.style) {
                tree.style.zoom = '';
            }
            applyZoom(currentZoom);
        }

        function printFamilyTree() {
            preparePrintScale();
            setTimeout(() => {
                window.print();
            }, 100);
        }

        window.addEventListener('beforeprint', preparePrintScale);
        window.addEventListener('afterprint', resetPrintScale);

        // Auto-center ke subjek fokus saat halaman dibuka
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.trah-container');
            const activeCard = document.querySelector('.trah-card.active');
            if (container && activeCard) {
                const cardLeft = activeCard.getBoundingClientRect().left;
                const containerLeft = container.getBoundingClientRect().left;
                const scrollTarget = container.scrollLeft + (cardLeft - containerLeft) - (container.clientWidth / 2) + (activeCard.offsetWidth / 2);
                container.scrollTo({ left: Math.max(0, scrollTarget), behavior: 'smooth' });
            }
        });

        // Fitur drag-to-scroll (geser dengan mouse)
        const trahContainer = document.querySelector('.trah-container');
        if (trahContainer) {
            let isDown = false;
            let startX, scrollLeft;

            trahContainer.addEventListener('mousedown', (e) => {
                if (e.target.closest('a') || e.target.closest('button')) return;
                isDown = true;
                trahContainer.classList.add('is-grabbing');
                startX = e.pageX - trahContainer.offsetLeft;
                scrollLeft = trahContainer.scrollLeft;
            });

            window.addEventListener('mouseup', () => {
                if (isDown) {
                    isDown = false;
                    trahContainer.classList.remove('is-grabbing');
                }
            });

            trahContainer.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - trahContainer.offsetLeft;
                const walk = (x - startX) * 1.5;
                trahContainer.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
</body>
</html>