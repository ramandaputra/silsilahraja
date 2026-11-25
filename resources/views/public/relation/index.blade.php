<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Cari Relasi | Silsilah Keluarga Kesultanan Riau - Lingga</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col pt-20">

@include('public.partials.navbar')

    <main class="flex-grow container mx-auto px-margin-mobile md:px-margin-desktop py-xl">
        
        <!-- Tombol Kembali Mobile -->
        <div class="block md:hidden mb-4">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
        
        <header class="mb-xl text-center max-w-3xl mx-auto">
            <h1 class="font-headline-lg text-headline-lg text-primary mb-sm">Pencari Relasi Hubungan</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">
                Lacak status kekerabatan, generasi keturunan, garis saudara/keponakan, dan mata rantai nasab Kesultanan.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            
            <!-- PANEL KIRI: Form Input Parameter -->
            <section class="lg:col-span-5 space-y-gutter">
                <div class="bento-card p-md rounded-xl">
                    <h2 class="font-title-lg text-title-lg text-primary mb-md flex items-center gap-xs">
                        <span class="material-symbols-outlined text-secondary">person_search</span> 
                        Input Parameter Tokoh
                    </h2>

                    @if(session('error'))
                        <div class="bg-error-container text-on-error-container border border-error/20 p-sm rounded-lg mb-md text-body-md shadow-sm flex items-start gap-2">
                            <span class="material-symbols-outlined text-error text-lg mt-0.5">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('relation.process') }}" method="GET" class="space-y-md" id="form-relation">
                        
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs">
                                1. JIKA SAYA ADALAH (TOKOH UTAMA) :
                            </label>
                            <div class="relative">
                                <select name="person_a_id" id="person_a" class="w-full select2-enable" required>
                                    <option value="">-- Pilih Tokoh Utama --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personA) && $personA->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_nasab }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Tukar Posisi -->
                        <div class="flex justify-center -my-1">
                            <button type="button" id="btn-swap-tokoh" title="Tukar Posisi Tokoh" class="inline-flex items-center gap-1.5 px-3 py-1 bg-surface-container hover:bg-secondary-fixed text-primary text-xs font-semibold rounded-full border border-outline-variant shadow-xs transition-all active:scale-90">
                                <span class="material-symbols-outlined text-[16px]">swap_vert</span>
                                <span>Tukar Posisi</span>
                            </button>
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-xs">
                                2. MAKA HUBUNGAN DENGAN (TOKOH KEDUA) :
                            </label>
                            <div class="relative">
                                <select name="person_b_id" id="person_b" class="w-full select2-enable" required>
                                    <option value="">-- Pilih Tokoh Kedua --</option>
                                    @foreach($people as $p)
                                        <option value="{{ $p->id }}" {{ isset($personB) && $personB->id == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_nasab }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-secondary text-on-secondary font-headline-md py-sm rounded-lg hover:bg-secondary/90 transition-colors flex justify-center items-center gap-xs mt-md active:scale-95 transition-transform shadow-sm">
                            <span class="material-symbols-outlined">analytics</span>
                            Analisis Hubungan Nasab
                        </button>
                    </form>
                </div>

                <div class="bento-card p-md rounded-xl">
                    <h3 class="font-title-lg text-title-lg text-primary mb-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">lightbulb</span>
                        Panduan Analisis Relasi
                    </h3>
                    <ul class="text-body-md text-on-surface-variant space-y-2 leading-relaxed">
                        <li class="flex items-start gap-2">
                            <span class="text-secondary font-bold">•</span>
                            <span><strong>Ponakan garis siapa:</strong> Melacak apakah keponakan berasal dari abang, adik, atau kakak kandung/sebapa.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-secondary font-bold">•</span>
                            <span><strong>Cucu generasi ke berapa:</strong> Menghitung tingkatan silsilah (Anak, Cucu, Cicit, Piut/Canggah, Wareng, dst.).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-secondary font-bold">•</span>
                            <span><strong>Adat Melayu:</strong> Menyajikan panggilan adat yang tepat (Pak Long, Pak Ngah, Pak Cik, Mak Long, Mak Cik).</span>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- PANEL KANAN: Hasil Analisis Lengkap -->
            <section class="lg:col-span-7 space-y-gutter">
                
                @if(isset($analysis) && isset($personA) && isset($personB))
                    
                    <!-- Dua Kartu Tokoh yang Dianalisis -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-gutter">
                        
                        <div class="bento-card p-md rounded-xl flex gap-md items-center border-l-4 border-l-primary">
                            <div class="w-16 h-16 rounded-lg bg-surface-container flex-shrink-0 border border-outline-variant overflow-hidden flex items-center justify-center">
                                @if($personA->foto)
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $personA->foto) }}" alt="{{ $personA->nama_lengkap }}">
                                @else
                                    <span class="material-symbols-outlined text-primary text-3xl">
                                        {{ $personA->jenis_kelamin === 'L' ? 'male' : 'female' }}
                                    </span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="bg-primary-fixed text-on-primary-fixed-variant text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                                    Tokoh I (Titik Tolak)
                                </span>
                                <h4 class="font-title-lg text-primary leading-tight mt-1 truncate" title="{{ $personA->nama_lengkap }}">
                                    {{ $personA->nama_lengkap }}
                                </h4>
                                @if($personA->gelar_pembeda)
                                    <span class="text-xs text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200 mt-1 inline-block">
                                        {{ $personA->gelar_pembeda }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="bento-card p-md rounded-xl flex gap-md items-center border-l-4 border-l-secondary">
                            <div class="w-16 h-16 rounded-lg bg-surface-container flex-shrink-0 border border-outline-variant overflow-hidden flex items-center justify-center">
                                @if($personB->foto)
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $personB->foto) }}" alt="{{ $personB->nama_lengkap }}">
                                @else
                                    <span class="material-symbols-outlined text-secondary text-3xl">
                                        {{ $personB->jenis_kelamin === 'L' ? 'male' : 'female' }}
                                    </span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <span class="bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                                    Tokoh II (Target Relasi)
                                </span>
                                <h4 class="font-title-lg text-primary leading-tight mt-1 truncate" title="{{ $personB->nama_lengkap }}">
                                    {{ $personB->nama_lengkap }}
                                </h4>
                                @if($personB->gelar_pembeda)
                                    <span class="text-xs text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200 mt-1 inline-block">
                                        {{ $personB->gelar_pembeda }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- KARTU UTAMA: Hasil Panggilan & Hubungan -->
                    <div class="bento-card p-xl rounded-xl relative overflow-hidden">
                        <div class="absolute inset-0 node-connector opacity-20 pointer-events-none"></div>
                        <div class="relative z-10 text-center">
                            
                            <div class="inline-flex items-center gap-1.5 bg-secondary-fixed text-on-secondary-fixed text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                                <span class="material-symbols-outlined text-sm">verified</span>
                                <span>{{ $analysis['category'] ?? 'Analisis Silsilah' }}</span>
                            </div>
                            
                            <div class="text-body-lg md:text-title-lg text-on-surface mb-2">
                                <strong>{{ $personB->nama_lengkap }}</strong> adalah
                            </div>
                            
                            <!-- Highlight Box -->
                            <div class="block max-w-xl mx-auto text-center font-headline-md text-headline-md font-bold text-white bg-primary-container py-4 px-6 rounded-2xl border-2 border-primary shadow-lg my-4">
                                <div class="flex items-center justify-center gap-2 mb-1">
                                    <i class="fa-solid fa-crown text-amber-400"></i>
                                    <span>{{ $analysis['primary_label'] }}</span>
                                </div>
                                @if(!empty($analysis['sub_label']))
                                    <div class="text-xs md:text-sm font-normal text-on-primary-container opacity-90 mt-1">
                                        {{ $analysis['sub_label'] }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="text-body-lg md:text-title-lg text-on-surface mb-6">
                                dari <strong>{{ $personA->nama_lengkap }}</strong>
                            </div>

                            <div class="flex flex-wrap justify-center items-center gap-sm pt-4 border-t border-outline-variant">
                                <a href="{{ route('person.trah', $personA->id) }}" class="inline-flex items-center gap-xs bg-surface-container border border-outline-variant text-primary font-medium px-md py-xs rounded-full hover:bg-outline-variant/30 transition-all text-body-md">
                                    <i class="fa-solid fa-sitemap text-xs"></i> 
                                    <span>Trah {{ Str::limit($personA->nama_lengkap, 18) }}</span>
                                </a>
                                <a href="{{ route('person.trah', $personB->id) }}" class="inline-flex items-center gap-xs bg-secondary text-white font-medium px-md py-xs rounded-full hover:bg-secondary/90 transition-all text-body-md shadow-sm">
                                    <i class="fa-solid fa-sitemap text-xs"></i> 
                                    <span>Trah {{ Str::limit($personB->nama_lengkap, 18) }}</span>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- BENTO GRID RINCIAN DETAIL (Garis Siapa? Generasi ke Berapa? Panggilan Balik?) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-gutter">
                        
                        <!-- 1. Garis Kekerabatan (Ponakan Garis Siapa / Jalur Keturunan Siapa) -->
                        <div class="bento-card p-md rounded-xl space-y-2">
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-secondary">hub</span>
                                <h4 class="font-title-lg text-sm md:text-base font-bold">Jalur Garis Kekerabatan</h4>
                            </div>
                            <p class="text-body-md text-on-surface-variant leading-relaxed">
                                {{ $analysis['lineage_line'] }}
                            </p>
                            @if(!empty($analysis['connecting_figure']))
                                <div class="pt-2 border-t border-outline-variant/50">
                                    <span class="text-xs text-on-surface-variant font-medium">Tokoh Penghubung:</span>
                                    <span class="text-xs font-semibold text-primary block mt-0.5">
                                        {{ $analysis['connecting_figure']->nama_lengkap }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- 2. Kedudukan Generasi (Cucu Generasi ke Berapa?) -->
                        <div class="bento-card p-md rounded-xl space-y-2">
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-secondary">stairs</span>
                                <h4 class="font-title-lg text-sm md:text-base font-bold">Tingkat Generasi</h4>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(isset($analysis['generation_number']))
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg font-bold text-xs {{ $analysis['generation_number'] < 0 ? 'bg-amber-100 text-amber-800' : ($analysis['generation_number'] > 0 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $analysis['generation_number'] > 0 ? '+' . $analysis['generation_number'] : $analysis['generation_number'] }}
                                    </span>
                                @endif
                                <span class="font-semibold text-primary text-sm">
                                    {{ $analysis['generation_text'] }}
                                </span>
                            </div>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                @if(isset($analysis['generation_number']) && $analysis['generation_number'] < 0)
                                    Kedudukan Tokoh II berada di bawah Tokoh Utama dalam bagan silsilah trah keluarga.
                                @elseif(isset($analysis['generation_number']) && $analysis['generation_number'] > 0)
                                    Kedudukan Tokoh II merupakan leluhur/orang tua di atas Tokoh Utama.
                                @else
                                    Kedudukan Tokoh I dan Tokoh II berada dalam tingkatan generasi yang setara (seangkatan).
                                @endif
                            </p>
                        </div>

                        <!-- 3. Panggilan Balik (Bagi Tokoh II) -->
                        <div class="bento-card p-md rounded-xl space-y-2">
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-secondary">record_voice_over</span>
                                <h4 class="font-title-lg text-sm md:text-base font-bold">Panggilan Timbal Balik</h4>
                            </div>
                            <p class="text-xs text-on-surface-variant">
                                Sebutan bagi <strong>{{ $personB->nama_lengkap }}</strong> saat memanggil <strong>{{ $personA->nama_lengkap }}</strong>:
                            </p>
                            <div class="p-2.5 bg-surface-container rounded-lg border border-outline-variant font-bold text-primary text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-base">forum</span>
                                <span>{{ $analysis['reciprocal_label'] }}</span>
                            </div>
                        </div>

                        <!-- 4. Titik Temu Nasab (Leluhur Bersama) -->
                        <div class="bento-card p-md rounded-xl space-y-2">
                            <div class="flex items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-secondary">account_tree</span>
                                <h4 class="font-title-lg text-sm md:text-base font-bold">Titik Temu Nasab</h4>
                            </div>
                            @if(!empty($analysis['common_ancestor']))
                                <p class="text-xs text-on-surface-variant">Leluhur bersama yang mempertemukan kedua garis nasab:</p>
                                <div class="p-2.5 bg-amber-50 rounded-lg border border-amber-200">
                                    <div class="font-bold text-primary text-sm">
                                        {{ $analysis['common_ancestor']->nama_lengkap }}
                                    </div>
                                    <a href="{{ route('person.trah', $analysis['common_ancestor']->id) }}" class="text-xs text-secondary hover:underline inline-flex items-center gap-1 mt-1 font-medium">
                                        <span>Buka Bagan Trah Leluhur Ini</span>
                                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                    </a>
                                </div>
                            @else
                                <p class="text-body-md text-on-surface-variant leading-relaxed">
                                    Garis hubungan langsung (vertikal langsung atau hubungan perkawinan).
                                </p>
                            @endif
                        </div>

                    </div>

                    <!-- MATA RANTAI JALUR SILSILAH (VISUAL PATH BREADCRUMBS) -->
                    @if(!empty($analysis['breadcrumbs']) && count($analysis['breadcrumbs']) > 1)
                        <div class="bento-card p-md md:p-lg rounded-xl">
                            <div class="flex items-center justify-between mb-md">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary">timeline</span>
                                    <h4 class="font-title-lg text-primary text-base md:text-lg">Mata Rantai Jalur Nasab</h4>
                                </div>
                                <span class="text-xs bg-surface-container text-on-surface-variant px-2.5 py-1 rounded-full font-medium">
                                    {{ count($analysis['breadcrumbs']) - 1 }} Langkah Hubungan
                                </span>
                            </div>

                            <!-- List / Chain Jalur -->
                            <div class="relative">
                                <div class="flex flex-col space-y-3">
                                    @foreach($analysis['breadcrumbs'] as $idx => $step)
                                        <div class="flex items-center gap-3">
                                            
                                            <!-- Avatar Node -->
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full border-2 {{ $step['person']->jenis_kelamin === 'L' ? 'border-blue-400 bg-blue-50 text-blue-700' : 'border-rose-400 bg-rose-50 text-rose-700' }} flex items-center justify-center font-bold text-xs shadow-xs overflow-hidden">
                                                @if($step['person']->foto)
                                                    <img src="{{ asset('storage/' . $step['person']->foto) }}" class="w-full h-full object-cover" alt="">
                                                @else
                                                    <span>{{ $step['person']->jenis_kelamin === 'L' ? 'L' : 'P' }}</span>
                                                @endif
                                            </div>

                                            <!-- Data Node -->
                                            <div class="flex-grow min-w-0 p-3 rounded-lg border {{ $step['is_start'] ? 'bg-primary-fixed-dim/20 border-primary/30' : ($step['is_target'] ? 'bg-secondary-fixed/30 border-secondary/40' : 'bg-surface-container-low border-outline-variant/60') }}">
                                                <div class="flex flex-wrap items-center justify-between gap-1">
                                                    <a href="{{ route('person.trah', $step['person']->id) }}" class="font-bold text-primary hover:text-secondary text-sm truncate hover:underline" title="{{ $step['person']->nama_lengkap }}">
                                                        {{ $step['person']->nama_lengkap }}
                                                    </a>
                                                    @if($step['is_start'])
                                                        <span class="text-[10px] bg-primary text-white font-bold px-2 py-0.5 rounded uppercase">Tokoh Utama</span>
                                                    @elseif($step['is_target'])
                                                        <span class="text-[10px] bg-secondary text-white font-bold px-2 py-0.5 rounded uppercase">Target Relasi</span>
                                                    @endif
                                                </div>
                                                @if($step['person']->gelar_pembeda)
                                                    <div class="text-[11px] text-amber-700 font-medium">
                                                        {{ $step['person']->gelar_pembeda }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Connector Arrow to next step -->
                                        @if($idx < count($analysis['breadcrumbs']) - 1)
                                            <div class="flex items-center gap-3 pl-5 my-0.5">
                                                <div class="w-0.5 h-6 bg-outline-variant"></div>
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-surface-container rounded-md text-[11px] text-on-surface-variant font-medium border border-outline-variant/50">
                                                    <span class="material-symbols-outlined text-[14px] text-secondary">arrow_downward</span>
                                                    <span>{{ $analysis['breadcrumbs'][$idx + 1]['transition_text'] ?? 'Terhubung ke' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                @else
                    <!-- State Awal Sebelum Memilih -->
                    <div class="bento-card p-xl rounded-xl text-center relative overflow-hidden flex flex-col justify-center items-center min-h-[350px]">
                        <div class="absolute inset-0 node-connector opacity-10 pointer-events-none"></div>
                        <div class="w-20 h-20 rounded-full bg-surface-container flex items-center justify-center text-secondary mb-md border border-outline-variant">
                            <span class="material-symbols-outlined text-4xl animate-pulse">analytics</span>
                        </div>
                        <h4 class="font-title-lg text-primary text-lg mb-xs">Menunggu Parameter Analisis</h4>
                        <p class="text-body-md text-on-surface-variant max-w-md leading-relaxed">
                            Pilih dua nama tokoh pada panel sebelah kiri lalu klik tombol <strong>Analisis Hubungan Nasab</strong>. Sistem akan langsung memetakan relasi, status generasi, jalur garis saudara/keponakan, dan mata rantai silsilah.
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
                <p class="font-body-md text-body-md opacity-60">Silsilah Keluarga Kesultanan Riau - Lingga</p>
            </div>
            <div class="flex flex-wrap justify-center gap-md mb-md md:mb-0 text-sm opacity-80">
                <a class="hover:text-tertiary-fixed transition-colors" href="{{ route('home') }}">Beranda</a>
                <a class="hover:text-tertiary-fixed transition-colors" href="{{ route('relation.index') }}">Cari Relasi</a>
                <a class="hover:text-tertiary-fixed transition-colors" href="{{ route('about') }}">Tentang Kami</a>
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

            // Tombol Swap Tokoh
            $('#btn-swap-tokoh').on('click', function(e) {
                e.preventDefault();
                var valA = $('#person_a').val();
                var valB = $('#person_b').val();
                $('#person_a').val(valB).trigger('change');
                $('#person_b').val(valA).trigger('change');
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
