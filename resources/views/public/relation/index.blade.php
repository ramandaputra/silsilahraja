<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Cari Relasi | SilsilahRaja Institutional Archive</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#003366",
                        "on-tertiary-fixed-variant": "#3e4853",
                        "tertiary-fixed-dim": "#bdc7d6",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#d9e3f2",
                        "on-surface-variant": "#43474f",
                        "on-secondary-fixed": "#001a41",
                        "tertiary": "#151f29",
                        "surface-container-low": "#f5f3f3",
                        "surface-bright": "#fbf9f8",
                        "surface": "#fbf9f8",
                        "secondary-fixed": "#d8e2ff",
                        "primary-fixed-dim": "#a7c8ff",
                        "outline": "#737780",
                        "surface-container-high": "#eae8e7",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#929caa",
                        "on-primary-container": "#799dd6",
                        "primary-fixed": "#d5e3ff",
                        "on-primary-fixed-variant": "#1f477b",
                        "inverse-surface": "#303030",
                        "secondary-container": "#0070ea",
                        "on-secondary": "#ffffff",
                        "inverse-on-surface": "#f2f0f0",
                        "on-surface": "#1b1c1c",
                        "on-secondary-container": "#fefcff",
                        "surface-container-highest": "#e4e2e2",
                        "on-secondary-fixed-variant": "#004493",
                        "surface-dim": "#dbd9d9",
                        "surface-variant": "#e4e2e2",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#a7c8ff",
                        "secondary-fixed-dim": "#adc7ff",
                        "on-background": "#1b1c1c",
                        "primary": "#001e40",
                        "on-tertiary-fixed": "#131c27",
                        "secondary": "#0059bb",
                        "background": "#fbf9f8",
                        "tertiary-container": "#2a343f",
                        "on-primary": "#ffffff",
                        "on-primary-fixed": "#001b3c",
                        "error-container": "#ffdad6",
                        "surface-tint": "#3a5f94",
                        "outline-variant": "#c3c6d1",
                        "error": "#ba1a1a",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#efeded"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "lg": "32px",
                        "base": "4px",
                        "md": "24px",
                        "xs": "8px",
                        "xl": "48px",
                        "margin-desktop": "40px",
                        "gutter": "20px",
                        "sm": "16px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "title-lg": ["Inter"],
                        "headline-md": ["Montserrat"],
                        "headline-lg-mobile": ["Montserrat"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "data-table": ["Inter"],
                        "display-lg": ["Montserrat"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Montserrat"]
                    },
                    "fontSize": {
                        "title-lg": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "data-table": ["13px", {"lineHeight": "18px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "60px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bento-card {
            background: #ffffff;
            border: 1px solid #e1e4e8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            box-shadow: 0 12px 24px -10px rgba(0, 51, 102, 0.08);
        }
        .node-connector {
            background-image: radial-gradient(#001e40 1px, transparent 1px);
            background-size: 20px 20px;
        }
        /* Penyesuaian Select2 agar masuk ke tema Tailwind */
        .select2-container .select2-selection--single {
            height: 46px !important;
            padding-top: 10px;
            border: 1px solid #c3c6d1 !important;
            border-radius: 0.5rem !important;
            background-color: #ffffff !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1b1c1c !important;
            font-size: 14px !important;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col pt-16">

   <nav class="fixed top-0 w-full z-50 flex justify-between items-center px-margin-desktop bg-surface/90 backdrop-blur-sm border-b border-primary h-20">
        <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-3xl">account_tree</span>
            <span class="font-headline-md text-headline-md font-bold text-primary">Silsilah Keluarga</span>
        </div>
        <div class="hidden md:flex items-center gap-lg">
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors duration-200" href="{{ route('home') }}">Beranda</a>
            <a class="font-body-md text-body-md text-secondary border-b-2 border-secondary pb-1 font-bold" href="{{ route('relation.index') }}">Cari Relasi</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors duration-200" href="{{ route('about') }}">Tentang Kami</a>
        </div>
        <div class="flex items-center gap-sm">
            <a href="{{ route('login') }}" class="material-symbols-outlined text-primary p-xs hover:bg-surface-container-highest rounded-full transition-all">account_circle</a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-margin-mobile md:px-margin-desktop py-xl">
        
        <header class="mb-xl text-center max-w-3xl mx-auto">
            <h1 class="font-headline-lg text-headline-lg text-primary mb-sm">Pencari Relasi Hubungan</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">
                Cari tahu status hubungan kekerabatan keluarga berdasarkan ketentuan adat silsilah kerajaan.
            </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            
            <section class="md:col-span-5 space-y-gutter">
                <div class="bento-card p-md rounded-xl">
                    <h2 class="font-title-lg text-title-lg text-primary mb-md flex items-center gap-xs">
                        <span class="material-symbols-outlined">person_search</span> 
                        Input Parameter
                    </h2>

                    @if(session('error'))
                        <div class="bg-error-container text-on-error-container border border-error/20 p-sm rounded-lg mb-md text-body-md shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('relation.process') }}" method="GET" class="space-y-md">
                        
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs">JIKA SAYA ADALAH :</label>
                            <div class="relative">
                                <select name="person_a_id" id="person_a" class="w-full select2-enable" required>
                                    <option value="">-- Pilih Tokoh Utama --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personA) && $personA->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_lengkap }} ({{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-center -my-base">
                            <div class="bg-primary-fixed-dim p-xs rounded-full shadow-sm z-10">
                                <span class="material-symbols-outlined text-primary block">swap_vert</span>
                            </div>
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs">MAKA HUBUNGAN TOKOH INI :</label>
                            <div class="relative">
                                <select name="person_b_id" id="person_b" class="w-full select2-enable" required>
                                    <option value="">-- Pilih Tokoh Kedua --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personB) && $personB->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_lengkap }} ({{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-secondary text-on-secondary font-headline-md py-sm rounded-lg hover:bg-secondary/90 transition-colors flex justify-center items-center gap-xs mt-md active:scale-95 transition-transform">
                            <span class="material-symbols-outlined">analytics</span>
                            Analisis Hubungan
                        </button>
                    </form>
                </div>

                <div class="bento-card p-md rounded-xl">
                    <h3 class="font-title-lg text-title-lg text-primary mb-sm">Panduan Pencarian</h3>
                    <p class="text-body-md text-on-surface-variant leading-relaxed">
                        Sistem akan melacak bagan vertikal (leluhur/keturunan) serta bagan horizontal (saudara/sepupu) untuk merumuskan panggilan hubungan silsilah yang tepat.
                    </p>
                </div>
            </section>

            <section class="md:col-span-7 space-y-gutter">
                
                @if(isset($relationLabel))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-gutter">
                        
                        <div class="bento-card p-md rounded-xl flex gap-md items-center">
                            <div class="w-16 h-16 rounded-lg bg-surface-container flex-shrink-0 border border-outline-variant overflow-hidden flex items-center justify-center">
                                @if(isset($personA) && $personA->foto)
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $personA->foto) }}" alt="Foto">
                                @else
                                    <span class="material-symbols-outlined text-primary text-3xl">person</span>
                                @endif
                            </div>
                            <div>
                                <span class="bg-primary-fixed-dim text-on-primary-fixed-variant text-[10px] px-xs py-0.5 rounded uppercase tracking-wider font-bold">Tokoh I</span>
                                <h4 class="font-title-lg text-primary leading-tight mt-xs">{{ $personA->nama_lengkap }}</h4>
                                <p class="text-label-md text-on-surface-variant font-medium mt-1">Garis Utama</p>
                            </div>
                        </div>

                        <div class="bento-card p-md rounded-xl flex gap-md items-center border-l-4 border-l-secondary">
                            <div class="w-16 h-16 rounded-lg bg-surface-container flex-shrink-0 border border-outline-variant overflow-hidden flex items-center justify-center">
                                @if(isset($personB) && $personB->foto)
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $personB->foto) }}" alt="Foto">
                                @else
                                    <span class="material-symbols-outlined text-secondary text-3xl">person</span>
                                @endif
                            </div>
                            <div>
                                <span class="bg-secondary-fixed-dim text-on-secondary-fixed-variant text-[10px] px-xs py-0.5 rounded uppercase tracking-wider font-bold">Tokoh II</span>
                                <h4 class="font-title-lg text-primary leading-tight mt-xs">{{ $personB->nama_lengkap }}</h4>
                                <p class="text-label-md text-on-surface-variant font-medium mt-1">Target Relasi</p>
                            </div>
                        </div>

                    </div>

                    <div class="bento-card p-xl rounded-xl relative overflow-hidden">
                        <div class="absolute inset-0 node-connector opacity-20 pointer-events-none"></div>
                        <div class="relative z-10 text-center">
                            
                            <h6 class="text-uppercase tracking-wider text-secondary font-bold text-label-md mb-3">HASIL ANALISIS HUBUNGAN SILSILAH</h6>
                            
                            <div class="text-body-lg md:text-title-lg text-on-surface mb-2">
                                <strong>{{ $personB->nama_lengkap }}</strong> adalah
                            </div>
                            
                            <div class="block max-w-max mx-auto text-center font-headline-md text-headline-md font-bold text-white bg-primary-container py-3 px-6 rounded-xl border border-primary shadow-md my-4">
                                <span class="flex items-center justify-center gap-xs">
                                    <i class="fa-solid fa-crown text-amber-400"></i>
                                    {{ $relationLabel }}
                                </span>
                            </div>
                            
                            <div class="text-body-lg md:text-title-lg text-on-surface mb-6">
                                dari <strong>{{ $personA->nama_lengkap }}</strong>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-center items-center gap-sm pt-4 border-t border-outline-variant">
                                <a href="{{ route('person.trah', $personA->id) }}" class="inline-flex items-center gap-xs bg-surface-container border border-outline-variant text-primary font-medium px-md py-xs rounded-full hover:bg-outline-variant/30 transition-all text-body-md">
                                    <i class="fa-solid fa-sitemap text-xs"></i> 
                                    <span>Trah {{ Str::limit($personA->nama_lengkap, 20) }}</span>
                                </a>
                                <a href="{{ route('person.trah', $personB->id) }}" class="inline-flex items-center gap-xs bg-secondary text-white font-medium px-md py-xs rounded-full hover:bg-secondary/90 transition-all text-body-md shadow-sm">
                                    <i class="fa-solid fa-sitemap text-xs"></i> 
                                    <span>Trah {{ Str::limit($personB->nama_lengkap, 20) }}</span>
                                </a>
                            </div>

                        </div>
                    </div>
                @else
                    <div class="bento-card p-xl rounded-xl text-center relative overflow-hidden flex flex-col justify-center items-center min-h-[300px]">
                        <div class="absolute inset-0 node-connector opacity-10 pointer-events-none"></div>
                        <span class="material-symbols-outlined text-[64px] text-outline mb-md animate-pulse">analytics</span>
                        <h4 class="font-title-lg text-primary mb-xs">Menunggu Parameter Input</h4>
                        <p class="text-body-md text-on-surface-variant max-w-md">
                            Silakan pilih dua nama tokoh pada panel sebelah kiri kemudian klik tombol <strong>Analisis Hubungan</strong> untuk melihat visualisasi bagan kekerabatan.
                        </p>
                    </div>
                @endif

            </section>
        </div>
    </main>

    <footer class="w-full mt-auto bg-tertiary border-t border-outline-variant">
        <div class="flex flex-col md:flex-row justify-between items-center py-lg px-margin-desktop w-full text-on-tertiary">
            <div class="mb-md md:mb-0">
                <div class="font-headline-md text-headline-md text-white mb-xs">SilsilahRaja</div>
                <p class="font-body-md text-body-md opacity-60">Institutional Lineage Archive System v2.4</p>
            </div>
            <div class="flex flex-wrap justify-center gap-md mb-md md:mb-0 text-sm opacity-80">
                <a class="hover:text-tertiary-fixed transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-tertiary-fixed transition-colors" href="#">Terms of Service</a>
                <a class="hover:text-tertiary-fixed transition-colors" href="#">Contact Support</a>
            </div>
            <div class="text-center md:text-right opacity-60 text-body-md">
                <p>© 2026 SilsilahRaja Institutional Archive. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

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

        // Micro-interactions effect untuk button
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => button.classList.add('scale-95'));
            button.addEventListener('mouseup', () => button.classList.remove('scale-95'));
            button.addEventListener('mouseleave', () => button.classList.remove('scale-95'));
        });
    </script>
</body>
</html>