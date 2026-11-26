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
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 24px 16px;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            cursor: grab;
            position: relative;
            background-color: #ffffff;
            min-height: 250px;
        }
        .trah-container.is-grabbing {
            cursor: grabbing !important;
            user-select: none;
        }
        #trah-tree-root {
            display: inline-block;
            text-align: center;
            margin: 0 auto;
            flex-shrink: 0;
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

        /* GAYA KHUSUS CETAK (PRINT STYLESHEET A4 LANDSCAPE - MENGISI 1 HALAMAN SECARA MAKSIMAL & JELAS) */
        @media print {
            @page {
                size: A4 landscape;
                margin: 4mm 5mm;
            }

            nav,
            .no-print,
            .no-print * {
                display: none !important;
            }

            html, body {
                width: 100% !important;
                height: 100% !important;
                max-height: 100vh !important;
                overflow: hidden !important;
                background: #ffffff !important;
                background-color: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            main {
                max-width: 100% !important;
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden !important;
            }

            .trah-main-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                overflow: hidden !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-after: avoid !important;
                break-after: avoid !important;
            }

            .trah-container {
                overflow: visible !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                flex: 1 1 auto !important;
                padding: 0 !important;
                margin: auto auto !important;
                background: #ffffff !important;
                white-space: nowrap !important;
            }

            #trah-tree-root {
                display: inline-block !important;
                transform-origin: center center !important;
                white-space: nowrap !important;
            }

            /* Pengaturan Tipografi yang Jelas, Tajam, dan Proporsional Saat Cetak */
            .trah-person-box {
                padding: 2.5px 7px !important;
                line-height: 1.25 !important;
                white-space: nowrap !important;
            }

            .trah-name {
                font-size: 11.5px !important;
                font-weight: 700 !important;
                color: #000000 !important;
                letter-spacing: 0.02em !important;
                white-space: nowrap !important;
                -webkit-font-smoothing: antialiased !important;
            }

            .trah-person-box.active .trah-name {
                font-size: 12px !important;
                font-weight: 900 !important;
                color: #000000 !important;
            }

            .trah-gelar {
                font-size: 9.5px !important;
                font-weight: 600 !important;
                color: #111111 !important;
                white-space: nowrap !important;
            }

            .trah-nasab {
                font-size: 8.5px !important;
                font-weight: 600 !important;
                color: #222222 !important;
                white-space: nowrap !important;
            }

            .trah-spouse {
                font-size: 9.5px !important;
                font-weight: 500 !important;
                color: #111111 !important;
                white-space: nowrap !important;
            }

            /* Garis Penghubung & Percabangan yang Proporsional & Mantap Saat Cetak */
            .trah-single-connector {
                height: 16px !important;
                border-left-width: 1.5px !important;
                border-color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-node-horizontal {
                padding: 16px 8px 0 8px !important;
            }

            .trah-node-horizontal::before,
            .trah-node-horizontal::after {
                height: 16px !important;
                border-top-width: 1.5px !important;
                border-left-width: 1.5px !important;
                border-color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .trah-leaf-stack {
                gap: 2.5px !important;
            }

            .trah-person-box.active {
                border: 1px solid transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8f7f5] text-gray-900 min-h-screen flex flex-col pt-16 sm:pt-20">

    <!-- Navbar -->
    @include('public.partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-3 sm:px-4 py-3 sm:py-6">
        
        <!-- Toolbar Navigasi & Kontrol Bagan (Sangat Rapi & Responsif) -->
        <div class="space-y-2 mb-4 no-print">
            <!-- Baris 1: Tombol Navigasi Cepat Seimbang 3 Kolom -->
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('person.detail', $person->id) }}" class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 rounded-xl text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all min-h-[38px]">
                    <span class="material-symbols-outlined text-[15px]">arrow_back</span>
                    <span class="truncate">Profil Tokoh</span>
                </a>
                <button type="button" onclick="scrollToActivePerson()" class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 rounded-xl text-xs font-bold text-primary bg-white hover:bg-surface-container border border-gray-300 shadow-xs active:scale-95 transition-all min-h-[38px]" title="Gulir Layar Menuju Tokoh Fokus">
                    <span class="material-symbols-outlined text-[15px] text-secondary">my_location</span>
                    <span class="truncate">Fokus Tokoh</span>
                </button>
                <button type="button" onclick="printFamilyTree()" class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 rounded-xl text-xs font-bold text-white bg-secondary hover:bg-secondary/90 shadow-xs active:scale-95 transition-all min-h-[38px]" title="Cetak Bagan Pas 1 Halaman A4">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span class="truncate">Cetak A4</span>
                </button>
            </div>

            <!-- Baris 2: Kontrol Zoom & Tampilan (1 Baris Ringkas & Seimbang) -->
            <div class="flex items-center justify-between bg-white border border-gray-200 rounded-xl shadow-xs p-1 min-h-[40px]">
                <div class="flex items-center">
                    <button type="button" onclick="zoomTree(-0.1)" class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-lg active:scale-90 transition" title="Perkecil">
                        <i class="fa-solid fa-minus text-xs"></i>
                    </button>
                    <span id="zoom-badge" class="px-2 py-1 text-xs font-bold text-primary min-w-[46px] text-center select-none font-mono">100%</span>
                    <button type="button" onclick="zoomTree(0.1)" class="w-8 h-8 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-lg active:scale-90 transition" title="Perbesar">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </button>
                </div>
                
                <div class="h-4 w-px bg-gray-200 mx-1"></div>

                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="fitTreeToScreen()" class="px-3 py-1.5 text-xs font-bold text-secondary bg-blue-50 hover:bg-blue-100 rounded-lg inline-flex items-center gap-1 active:scale-95 transition" title="Sesuaikan Tampilan dengan Lebar Layar">
                        <span class="material-symbols-outlined text-[15px]">fit_screen</span>
                        <span>Paskan Layar</span>
                    </button>
                    <button type="button" onclick="resetZoom()" class="px-2.5 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg active:scale-95 transition" title="Reset Ukuran Normal (100%)">
                        <span>Reset</span>
                    </button>
                </div>
            </div>

            <!-- Petunjuk Ringkas & Elegan (1 Baris Sederhana) -->
            <div class="text-[11px] text-gray-400 flex items-center justify-center gap-1.5 pt-0.5">
                <span class="material-symbols-outlined text-xs text-secondary">swipe</span>
                <span>Geser bagan untuk menjelajah &bull; Tekan <strong>Fokus Tokoh</strong> untuk melihat subjek</span>
            </div>
        </div>

        <!-- Kartu Bagan Silsilah Manuskrip -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-4 sm:p-6 md:p-8 trah-main-card">
            
            <!-- Header Judul Silsilah Zuriat (Format Tradisional) -->
            <div class="text-center sm:text-left border-b border-gray-200 pb-3 sm:pb-4 mb-4 sm:mb-6 print:pb-1.5 print:mb-2 print:border-b-gray-400">
                <div class="text-[10px] sm:text-[11px] print:text-[8.5px] font-bold text-gray-400 uppercase tracking-widest mb-1 print:mb-0.5">
                    Bagan Silsilah Keturunan Diraja &bull; Garis Nasab Menuju Leluhur Puncak: {{ $rootAncestor->nama_lengkap }}
                </div>
                <h2 class="text-lg sm:text-xl md:text-2xl print:text-base font-extrabold tracking-wide uppercase text-gray-900 font-serif leading-tight">
                    ZURIAT {{ $person->nama_lengkap }}
                    @if(!empty($person->nama_pasangan))
                        DAN {{ explode(',', $person->nama_pasangan)[0] }}
                    @endif
                </h2>
                <div class="hidden print:block text-[8px] text-gray-500 mt-0.5 font-mono">
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
            <div class="mt-12 pt-4 print:mt-2 print:pt-1.5 border-t border-gray-300 print:border-t-gray-400 text-left font-mono text-xs print:text-[8px] text-gray-700 space-y-1 print:space-y-0.5">
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 print:gap-x-3 print:gap-y-0.5">
                    <div><strong>CATATAN :</strong></div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-gender-male text-black text-sm print:text-[8.5px]"></i> LAKI-LAKI</div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-gender-female text-black text-sm print:text-[8.5px]"></i> PEREMPUAN</div>
                    <div class="inline-flex items-center gap-1"><i class="bi bi-link-45deg text-sm print:text-[8.5px]"></i> MENIKAH / KAWIN DENGAN</div>
                </div>
                <div><strong>LELUHUR PUNCAK :</strong> {{ strtoupper($rootAncestor->nama_lengkap) }}{{ !empty($rootAncestor->gelar_pembeda) ? ' ('.strtoupper($rootAncestor->gelar_pembeda).')' : '' }}</div>
                <div><strong>SUMBER  :</strong> Silsilah Keturunan Kesultanan Riau-Lingga</div>
            </div>

        </div>
    </main>

    <footer class="w-full mt-auto py-8 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop bg-primary text-white border-t-4 border-secondary no-print">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6 sm:gap-lg">
            <div>
                <div class="text-lg sm:text-xl md:text-2xl font-bold mb-1 tracking-tight">Silsilah Keluarga Raja</div>
                <p class="opacity-70 text-xs sm:text-sm max-w-md leading-relaxed">
                    Pusat Data Genealogi Digital untuk pelestarian sejarah keturunan nusantara dan warisan agung leluhur.
                </p>
            </div>
            <div class="text-xs opacity-60 font-medium">
                &copy; 2026 Silsilah Keluarga Digital. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <script>
        let currentZoom = 1;

        function zoomTree(step) {
            currentZoom = Math.max(0.2, Math.min(2.0, Math.round((currentZoom + step) * 10) / 10));
            applyZoom(currentZoom);
        }

        function resetZoom() {
            currentZoom = 1;
            applyZoom(1);
            centerRootAncestor();
        }

        function fitTreeToScreen() {
            const tree = document.getElementById('trah-tree-root');
            const container = document.querySelector('.trah-container');
            if (!tree || !container) return;

            // Reset zoom terlebih dahulu agar membaca dimensi asli
            applyZoom(1);
            
            setTimeout(() => {
                const treeWidth = tree.scrollWidth || tree.offsetWidth;
                const containerWidth = container.clientWidth - 24;

                if (treeWidth > containerWidth && containerWidth > 150) {
                    const fitScale = Math.max(0.25, Math.min(1.0, Math.floor((containerWidth / treeWidth) * 100) / 100));
                    currentZoom = fitScale;
                    applyZoom(fitScale);
                    container.scrollLeft = 0;
                } else {
                    resetZoom();
                }
            }, 30);
        }

        function applyZoom(zoomLevel) {
            const tree = document.getElementById('trah-tree-root');
            if (!tree) return;
            
            if ('zoom' in tree.style) {
                tree.style.zoom = zoomLevel;
                tree.style.transform = '';
                tree.style.transformOrigin = '';
            } else {
                tree.style.transform = `scale(${zoomLevel})`;
                tree.style.transformOrigin = 'top center';
            }
            
            const badge = document.getElementById('zoom-badge');
            if (badge) {
                badge.innerText = Math.round(zoomLevel * 100) + '%';
            }
        }

        // Posisikan Leluhur Puncak tepat di tengah horizontal pandangan layar
        function centerRootAncestor() {
            const container = document.querySelector('.trah-container');
            const rootBox = document.querySelector('#trah-tree-root > .trah-node-wrapper > .trah-person-box');
            if (container && rootBox) {
                const rootBoxRect = rootBox.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                const scrollTarget = container.scrollLeft + (rootBoxRect.left - containerRect.left) - (container.clientWidth / 2) + (rootBox.offsetWidth / 2);
                container.scrollLeft = Math.max(0, scrollTarget);
            }
        }

        // Gulir layar langsung ke Tokoh Fokus
        function scrollToActivePerson() {
            const container = document.querySelector('.trah-container');
            const activeCard = document.querySelector('.trah-person-box.active');
            if (container && activeCard) {
                const activeRect = activeCard.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                const scrollTarget = container.scrollLeft + (activeRect.left - containerRect.left) - (container.clientWidth / 2) + (activeCard.offsetWidth / 2);
                container.scrollTo({ left: Math.max(0, scrollTarget), behavior: 'smooth' });
                activeCard.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
                
                // Highlight halus sejenak
                activeCard.style.outline = '2px solid #0059bb';
                activeCard.style.outlineOffset = '2px';
                setTimeout(() => {
                    activeCard.style.outline = '';
                    activeCard.style.outlineOffset = '';
                }, 2500);
            }
        }

        function preparePrintScale() {
            const tree = document.getElementById('trah-tree-root');
            const container = document.querySelector('.trah-container');
            if (!tree) return;

            // Reset transform sementara untuk mengukur dimensi elemen yang sebenarnya
            tree.style.transform = '';
            tree.style.transformOrigin = '';
            if ('zoom' in tree.style) {
                tree.style.zoom = '';
            }
            if (container) {
                container.style.height = '';
                container.style.overflow = '';
            }

            const treeWidth = tree.scrollWidth || tree.offsetWidth;
            const treeHeight = tree.scrollHeight || tree.offsetHeight;

            // Area cetak A4 Landscape efektif (standar 96 DPI):
            // Lebar: ~1060px (margin 5mm). Tinggi diagram efektif: ~645px
            const printableWidth = 1060;
            const printableHeight = 645;

            const scaleX = printableWidth / treeWidth;
            const scaleY = printableHeight / treeHeight;

            // Skala yang mengisi lembar secara maksimal agar tidak banyak ruang kosong,
            // huruf & garis boleh membesar (upscale hingga 1.5x), dan tetap pas dalam 1 halaman
            let scale = Math.min(scaleX, scaleY);
            scale = Math.min(scale, 1.50); // Batas maksimal pembesaran proporsional
            scale = Math.floor(scale * 100) / 100;

            if ('zoom' in tree.style) {
                tree.style.zoom = scale;
            } else {
                tree.style.transform = `scale(${scale})`;
                tree.style.transformOrigin = 'center center';
            }

            if (container) {
                container.style.height = Math.ceil(treeHeight * scale) + 'px';
                container.style.overflow = 'hidden';
            }
        }

        function resetPrintScale() {
            const tree = document.getElementById('trah-tree-root');
            const container = document.querySelector('.trah-container');
            if (!tree) return;
            if ('zoom' in tree.style) {
                tree.style.zoom = '';
            }
            tree.style.transform = '';
            tree.style.transformOrigin = '';
            if (container) {
                container.style.height = '';
                container.style.overflow = '';
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

        // Saat halaman pertama kali dibuka, posisikan Leluhur Puncak tepat di tengah
        window.addEventListener('DOMContentLoaded', () => {
            centerRootAncestor();
        });
        window.addEventListener('load', () => {
            centerRootAncestor();
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
