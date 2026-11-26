<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pohon Silsilah (Zuriat) - {{ $person->nama_lengkap }}</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                        "background": "#f8f7f5",
                        "surface": "#ffffff"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f7f5; }
        
        /* ========================================================
           BAGAN SILSILAH MANUSKRIP DIRAJA (ZURIAT TRADISIONAL)
           ======================================================== */
        .trah-container {
            display: block;
            text-align: center;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 24px 16px;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            cursor: grab;
            position: relative;
            background-color: #ffffff;
        }
        .trah-container.is-grabbing {
            cursor: grabbing !important;
            user-select: none;
        }
        #trah-tree-root {
            display: inline-block;
            text-align: center;
            margin: 0 auto;
        }
        .trah-node-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* Kotak Tokoh (Format Manuskrip Klasik & Berwibawa - 1 Baris Rata Kiri) */
        .trah-person-box {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 3px 8px;
            text-decoration: none;
            color: #111827;
            border-radius: 4px;
            text-align: left;
            transition: all 0.15s ease-in-out;
            max-width: none;
            border: 1px solid transparent;
            line-height: 1.3;
            white-space: nowrap !important;
        }
        .trah-person-box:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #0059bb;
        }
        .trah-person-box.active {
            border: 1px solid transparent;
            background-color: transparent;
            box-shadow: none;
        }
        .trah-name {
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.02em;
            color: #0f172a;
            display: block;
            text-align: left;
            white-space: nowrap !important;
        }
        .trah-person-box.active .trah-name {
            font-weight: 900 !important;
            letter-spacing: 0.025em;
            color: #0f172a;
        }
        .trah-gelar {
            font-size: 9.5px;
            font-weight: 600;
            color: #334155;
            display: block;
            text-align: left;
            white-space: nowrap !important;
        }
        .trah-nasab {
            font-size: 8.5px;
            font-weight: 600;
            color: #b45309;
            display: block;
            text-align: left;
            white-space: nowrap !important;
        }
        .trah-spouse {
            font-size: 9.5px;
            font-style: italic;
            font-weight: 500;
            color: #475569;
            display: block;
            text-align: left;
            white-space: nowrap !important;
        }

        /* Garis Penghubung Tunggal (Single Connector) */
        .trah-single-connector {
            width: 0;
            height: 18px;
            border-left: 1.5px solid #111827;
            margin: 0 auto;
        }

        /* Percabangan Horizontal Crossbar */
        .trah-branch-horizontal-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .trah-branch-horizontal {
            display: flex;
            justify-content: center;
            position: relative;
            padding: 0;
            margin: 0;
            list-style: none;
            white-space: nowrap;
        }
        .trah-node-horizontal {
            position: relative;
            padding: 18px 12px 0 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            list-style: none;
        }
        .trah-node-horizontal::before,
        .trah-node-horizontal::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1.5px solid #111827;
            width: 50%;
            height: 18px;
        }
        .trah-node-horizontal::after {
            right: auto;
            left: 50%;
            border-left: 1.5px solid #111827;
        }
        .trah-node-horizontal:first-child::before {
            border-top: 0 none;
        }
        .trah-node-horizontal:last-child::after {
            border-top: 0 none;
        }
        .trah-node-horizontal:only-child::before,
        .trah-node-horizontal:only-child::after {
            display: none;
        }

        /* Daftar Daun Vertikal (Leaf Stack - Kontainer Rata Tengah dengan Garis, Nama Adik Beradik Rata Kiri) */
        .trah-leaf-stack {
            display: inline-flex;
            flex-direction: column;
            align-items: stretch;
            list-style: none;
            margin: 0 auto;
            padding: 0;
            gap: 3.5px;
            white-space: nowrap;
            width: max-content;
        }
        .trah-leaf-item {
            display: flex;
            width: 100%;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .trah-leaf-item .trah-person-box {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            width: 100%;
            white-space: nowrap !important;
        }

        /* GAYA KHUSUS CETAK (PRINT STYLESHEET A4 LANDSCAPE) */
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
                display: block !important;
                width: auto !important;
                padding: 0 !important;
                margin: 0 auto !important;
                background: #ffffff !important;
                white-space: nowrap !important;
            }

            #trah-tree-root {
                display: inline-block !important;
                transform-origin: top center !important;
                white-space: nowrap !important;
            }

            .trah-person-box,
            .trah-name,
            .trah-gelar,
            .trah-nasab,
            .trah-spouse {
                white-space: nowrap !important;
            }

            .trah-single-connector,
            .trah-node-horizontal::before,
            .trah-node-horizontal::after {
                border-color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-person-box.active {
                border: 1px solid transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
            }
            .trah-person-box.active .trah-name {
                font-weight: 900 !important;
                color: #000000 !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8f7f5] text-gray-900 min-h-screen flex flex-col pt-24">

    <!-- Navbar -->
    @include('public.partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 py-6">
        
        <!-- Toolbar Navigasi & Zoom -->
        <div class="flex flex-wrap justify-between items-center gap-3 mb-4 no-print">
            <a href="{{ route('person.detail', $person->id) }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Profil</span>
            </a>
            
            <div class="flex flex-wrap items-center gap-2">
                <!-- Kontrol Zoom & Ukuran Layar -->
                <div class="inline-flex items-center bg-white border border-gray-200 rounded-lg shadow-xs overflow-hidden">
                    <button type="button" onclick="zoomTree(-0.1)" class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 hover:text-primary transition" title="Perkecil Tampilan">
                        <i class="fa-solid fa-minus text-xs"></i>
                    </button>
                    <span id="zoom-badge" class="px-2 py-1 text-xs font-semibold text-gray-700 min-w-[48px] text-center select-none border-x border-gray-100">100%</span>
                    <button type="button" onclick="zoomTree(0.1)" class="px-2.5 py-1.5 text-gray-600 hover:bg-gray-100 hover:text-primary transition" title="Perbesar Tampilan">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                    <button type="button" onclick="fitTreeToScreen()" class="px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 hover:text-primary border-l border-gray-100 transition inline-flex items-center gap-1" title="Sesuaikan Tampilan dengan Lebar Layar">
                        <i class="fa-solid fa-expand text-[10px] text-gray-500"></i>
                        <span>Paskan</span>
                    </button>
                    <button type="button" onclick="resetZoom()" class="px-2.5 py-1.5 text-xs text-gray-500 hover:bg-gray-100 hover:text-primary border-l border-gray-100 transition" title="Reset Ukuran (100%)">
                        Reset
                    </button>
                </div>

                <button type="button" onclick="printFamilyTree()" class="bg-primary text-white px-3.5 py-1.5 rounded-lg text-xs shadow-xs hover:bg-secondary inline-flex items-center gap-1.5 transition font-medium">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Bagan</span>
                </button>
            </div>
        </div>

        <!-- Kartu Bagan Silsilah Manuskrip -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-6 sm:p-8 trah-main-card">
            
            <!-- Header Judul Silsilah Zuriat (Format Tradisional) -->
            <div class="text-left border-b border-gray-200 pb-4 mb-6">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                    Bagan Silsilah Keturunan Diraja &bull; Garis Nasab Menuju Leluhur Puncak: {{ $rootAncestor->nama_lengkap }}
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-wide uppercase text-gray-900 font-serif">
                    ZURIAT {{ $person->nama_lengkap }}
                    @if(!empty($person->nama_pasangan))
                        DAN {{ explode(',', $person->nama_pasangan)[0] }}
                    @endif
                </h2>
                <div class="hidden print:block text-[10px] text-gray-500 mt-1 font-mono">
                    Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
                </div>
            </div>
            
            <!-- Area Diagram Pohon -->
            <div class="trah-container">
                <div id="trah-tree-root" style="display: inline-block;">
                    @include('public.partials.trah_node', [
                        'node' => $rootAncestor,
                        'currentPersonId' => $person->id,
                        'childrenMap' => $childrenMap,
                        'branchTypeMap' => $branchTypeMap,
                        'relatives' => $relatives,
                        'peopleById' => $peopleById ?? []
                    ])
                </div>
            </div>

            <!-- Catatan & Sumber (Format Buku Silsilah) -->
            <div class="mt-12 pt-4 border-t border-gray-300 text-left font-mono text-xs text-gray-700 space-y-1">
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                    <div><strong>CATATAN :</strong></div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-gender-male text-black text-sm"></i> LAKI-LAKI</div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-gender-female text-black text-sm"></i> PEREMPUAN</div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-link-45deg text-sm"></i> MENIKAH / KAWIN DENGAN</div>
                </div>
                <div><strong>LELUHUR PUNCAK :</strong> {{ strtoupper($rootAncestor->nama_lengkap) }}{{ !empty($rootAncestor->gelar_pembeda) ? ' ('.strtoupper($rootAncestor->gelar_pembeda).')' : '' }}</div>
                <div><strong>SUMBER  :</strong> Silsilah Keturunan Kesultanan Riau-Lingga</div>
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

        function fitTreeToScreen() {
            const tree = document.getElementById('trah-tree-root');
            const container = document.querySelector('.trah-container');
            if (!tree || !container) return;

            // Reset scale sejenak untuk mengukur lebar asli bagan
            tree.style.transform = 'scale(1)';
            const treeWidth = tree.scrollWidth || tree.offsetWidth;
            const containerWidth = container.clientWidth - 32;

            if (treeWidth > containerWidth && containerWidth > 200) {
                const fitScale = Math.max(0.35, Math.min(1.0, Math.floor((containerWidth / treeWidth) * 100) / 100));
                currentZoom = fitScale;
                applyZoom(fitScale);
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                resetZoom();
            }
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

        // Auto-center ke tokoh saat halaman dibuka
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.trah-container');
            const activeCard = document.querySelector('.trah-person-box.active');
            if (container && activeCard) {
                const cardLeft = activeCard.getBoundingClientRect().left;
                const containerLeft = container.getBoundingClientRect().left;
                const scrollTarget = container.scrollLeft + (cardLeft - containerLeft) - (container.clientWidth / 2) + (activeCard.offsetWidth / 2);
                container.scrollTo({ left: Math.max(0, scrollTarget), behavior: 'smooth' });
            }
        });

        // Fitur drag-to-scroll & mouse wheel zoom yang fleksibel
        const trahContainer = document.querySelector('.trah-container');
        if (trahContainer) {
            let isDown = false;
            let startX, scrollLeft;
            let hasDragged = false;

            trahContainer.addEventListener('mousedown', (e) => {
                if (e.target.closest('button')) return;
                isDown = true;
                hasDragged = false;
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
                const walk = (x - startX) * 1.3;
                if (Math.abs(walk) > 4) {
                    hasDragged = true;
                }
                trahContainer.scrollLeft = scrollLeft - walk;
            });

            // Cegah terklik kartu jika pengguna sedang melakukan drag geser layar
            trahContainer.addEventListener('click', (e) => {
                if (hasDragged && e.target.closest('a')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            // Zoom fleksibel menggunakan Ctrl + Scroll Mouse
            trahContainer.addEventListener('wheel', (e) => {
                if (e.ctrlKey) {
                    e.preventDefault();
                    const step = e.deltaY < 0 ? 0.08 : -0.08;
                    zoomTree(step);
                }
            }, { passive: false });
        }
    </script>
</body>
</html>
