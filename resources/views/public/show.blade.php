<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Profil - {{ $person->nama_lengkap }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#f5f3f3",
                        "primary": "#001e40",
                        "secondary-container": "#0070ea",
                        "inverse-primary": "#a7c8ff",
                        "background": "#fbf9f8",
                        "secondary-fixed-dim": "#adc7ff",
                        "on-tertiary-container": "#929caa",
                        "on-error": "#ffffff",
                        "secondary": "#0059bb",
                        "surface-container": "#efeded",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#fbf9f8",
                        "on-tertiary-fixed": "#131c27",
                        "outline": "#737780",
                        "error-container": "#ffdad6",
                        "surface-dim": "#dbd9d9",
                        "primary-container": "#003366",
                        "on-primary-fixed-variant": "#1f477b",
                        "surface-tint": "#3a5f94",
                        "surface-variant": "#e4e2e2",
                        "on-tertiary-fixed-variant": "#3e4853",
                        "tertiary": "#151f29",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#c3c6d1",
                        "surface": "#fbf9f8",
                        "on-primary-fixed": "#001b3c",
                        "surface-container-highest": "#e4e2e2",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-secondary-fixed": "#001a41",
                        "error": "#ba1a1a",
                        "tertiary-fixed": "#d9e3f2",
                        "on-primary": "#ffffff",
                        "secondary-fixed": "#d8e2ff",
                        "primary-fixed": "#d5e3ff",
                        "on-surface-variant": "#43474f",
                        "on-secondary-fixed-variant": "#004493",
                        "on-background": "#1b1c1c",
                        "inverse-surface": "#303030",
                        "on-surface": "#1b1c1c",
                        "surface-container-high": "#eae8e7",
                        "tertiary-container": "#2a343f",
                        "inverse-on-surface": "#f2f0f0",
                        "on-secondary": "#ffffff",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#bdc7d6",
                        "on-primary-container": "#799dd6",
                        "on-secondary-container": "#fefcff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "base": "4px",
                        "lg": "32px",
                        "gutter": "20px",
                        "margin-mobile": "16px",
                        "xs": "8px",
                        "xl": "48px",
                        "margin-desktop": "40px",
                        "sm": "16px",
                        "md": "24px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Montserrat"],
                        "title-lg": ["Inter"],
                        "headline-lg-mobile": ["Montserrat"],
                        "body-lg": ["Inter"],
                        "data-table": ["Inter"],
                        "headline-md": ["Montserrat"],
                        "label-md": ["Inter"],
                        "display-lg": ["Montserrat"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "title-lg": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "data-table": ["13px", {"lineHeight": "18px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "display-lg": ["48px", {"lineHeight": "60px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fbf9f8; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .bento-card { border: 1px solid #E1E4E8; background-color: #ffffff; border-radius: 12px; }
        .active-tab { 
            background-color: #001e40 !important; 
            color: #ffffff !important; 
            font-weight: 600; 
        }
        @media (min-width: 768px) {
            .active-tab { 
                border-left: 4px solid #001e40 !important; 
                background-color: #efeded !important; 
                color: #001e40 !important; 
            }
        }
        .hero-gradient { background: linear-gradient(135deg, #001e40 0%, #0059bb 100%); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col pt-16 sm:pt-20">

    @php
        // 1. Cari Saudara Kandung
        $saudaraKandung = collect();
        if(!empty($person->father_id)) {
            $saudaraKandung = \App\Models\Person::where('father_id', $person->father_id)
                                                ->where('id', '!=', $person->id)
                                                ->get();
        } elseif(!empty($person->mother_id)) {
            $saudaraKandung = \App\Models\Person::where('mother_id', $person->mother_id)
                                                ->where('id', '!=', $person->id)
                                                ->get();
        } elseif(!empty($person->nama_ibu_non_raja)) {
            $saudaraKandung = \App\Models\Person::where('nama_ibu_non_raja', $person->nama_ibu_non_raja)
                                                ->where('id', '!=', $person->id)
                                                ->get();
        }

        // 2. Cari Anak Kandung (baik jika subjek adalah Ayah maupun Ibu)
        $anakKandung = \App\Models\Person::where('father_id', $person->id)
                                        ->orWhere('mother_id', $person->id)
                                        ->get();
    @endphp

    @include('public.partials.navbar')

    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-margin-mobile md:px-margin-desktop py-4 sm:py-md">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-sm mb-4 sm:mb-lg">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all min-h-[38px]">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Pencarian</span>
            </a>
        </div>

        <header class="hero-gradient rounded-2xl p-5 sm:p-8 md:p-xl text-on-primary mb-6 sm:mb-lg shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row gap-5 sm:gap-lg items-center sm:items-start">
                <div class="w-28 h-28 sm:w-36 sm:h-36 md:w-48 md:h-48 rounded-2xl overflow-hidden border-4 border-white/90 shadow-md flex-shrink-0 bg-surface-container flex items-center justify-center">
                    @if($person->foto)
                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $person->foto) }}" alt="Foto {{ $person->nama_lengkap }}">
                    @else
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($person->nama_lengkap) }}&size=150&background=random" alt="Avatar">
                    @endif
                </div>
                <div class="flex-grow text-center sm:text-left text-white min-w-0">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                        <h1 class="text-xl sm:text-2xl md:text-headline-lg font-extrabold leading-tight">{{ $person->nama_lengkap }}</h1>
                        @if(!empty($person->gelar_pembeda))
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold bg-white/20 text-white border border-white/30">
                                {{ $person->gelar_pembeda }}
                            </span>
                        @endif
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-2xl sm:text-3xl" style="font-variation-settings: 'FILL' 1;" title="Terverifikasi">verified</span>
                    </div>
                    @if($person->nasab)
                        <p class="text-xs sm:text-sm md:text-base font-semibold text-white/90 mb-2">
                            {{ $person->nasab }}
                        </p>
                    @endif
                    <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-2">
                        <span class="bg-primary-container/60 border border-inverse-primary/30 px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1.5">
                            @if($person->jenis_kelamin == 'L')
                                <i class="bi bi-gender-male"></i> Laki-laki
                            @else
                                <i class="bi bi-gender-female"></i> Perempuan
                            @endif
                        </span>
                        @if($person->tanggal_wafat)
                            <span class="bg-error border border-error-container/30 px-3 py-1 rounded-full text-xs font-semibold">Wafat</span>
                        @else
                            <span class="bg-green-700 border border-white/30 px-3 py-1 rounded-full text-xs font-semibold">Hidup</span>
                        @endif
                        <span class="bg-primary-container/60 border border-white/20 px-3 py-1 rounded-full text-xs font-semibold">ID: #{{ str_pad($person->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    @if($person->has_duplicate_name && $person->tokoh_nama_sama->isNotEmpty())
                        <div class="mt-4 p-3 rounded-xl bg-amber-500/20 border border-amber-300/40 text-xs text-white text-left">
                            <div class="flex items-center gap-1.5 font-bold mb-1.5 text-amber-200">
                                <span class="material-symbols-outlined text-sm">info</span>
                                <span>Perhatian Genealogi: Terdapat tokoh lain dengan nama yang sama persis:</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($person->tokoh_nama_sama as $samePerson)
                                    <a href="{{ route('person.detail', $samePerson->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-white transition-all text-xs font-semibold">
                                        <span>{{ $samePerson->nama_nasab }}</span>
                                        <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <p class="mt-3 text-xs sm:text-sm text-white/80 max-w-2xl italic">
                        "{{ $person->biografi ? Str::limit($person->biografi, 120) : 'Belum ada ringkasan biografi tertulis untuk tokoh ini.' }}"
                    </p>
                </div>
            </div>
            <div class="absolute -right-16 -bottom-16 opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'FILL' 1;">account_tree</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 sm:gap-gutter">
            
            <!-- Navigasi Profil: Horizontal Tab bar di Mobile, Sidebar di Desktop -->
            <aside class="md:col-span-3">
                <div class="bento-card p-2 sm:p-md md:sticky md:top-24 rounded-xl">
                    <div class="hidden md:block">
                        <h3 class="font-title-lg text-title-lg text-primary mb-md pb-base border-b border-surface-variant">Navigasi Profil</h3>
                    </div>
                    
                    <nav class="flex flex-row md:flex-col gap-2 overflow-x-auto pb-1 md:pb-0 no-scrollbar">
                        <button type="button" class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all text-left active-tab whitespace-nowrap shrink-0 text-xs sm:text-sm font-semibold" id="btn-basic" onclick="switchTab('basic')">
                            <span class="material-symbols-outlined text-base sm:text-lg">family_history</span>
                            <span>Profil &amp; Keluarga</span>
                        </button>
                        <button type="button" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-surface-container md:bg-transparent hover:bg-surface-container transition-all text-left text-on-surface-variant whitespace-nowrap shrink-0 text-xs sm:text-sm font-semibold" id="btn-biografi" onclick="switchTab('biografi')">
                            <span class="material-symbols-outlined text-base sm:text-lg">description</span>
                            <span>Biografi Lengkap</span>
                        </button>
                        
                        <div class="hidden md:block border-t border-surface-variant my-xs"></div>
                        
                        <a href="{{ route('person.trah', $person->id) }}" class="flex items-center gap-2 px-3.5 py-2 rounded-lg bg-primary text-white hover:bg-secondary transition-all text-left text-xs sm:text-sm font-bold shadow-sm whitespace-nowrap shrink-0 md:mt-2">
                            <span class="material-symbols-outlined text-base sm:text-lg">account_tree</span>
                            <span>Bagan Trah &rarr;</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <div class="md:col-span-9 space-y-4 sm:space-y-md">
                
                <section class="bento-card p-5 sm:p-lg block" id="content-basic">
                    <div class="flex items-center justify-between mb-4 sm:mb-lg">
                        <h2 class="text-lg sm:text-xl md:text-headline-md font-bold text-primary">Informasi Personal</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 border-b border-surface-variant pb-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">Nama Lengkap</label>
                                <p class="text-sm sm:text-base font-bold text-on-surface">{{ $person->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">Jenis Kelamin</label>
                                <p class="text-sm sm:text-base inline-flex items-center gap-1.5 font-medium">
                                    @if($person->jenis_kelamin == 'L')
                                        <i class="bi bi-gender-male text-secondary"></i> Laki-laki
                                    @else
                                        <i class="bi bi-gender-female text-rose-600"></i> Perempuan
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">Status Pernikahan</label>
                                <p class="text-sm sm:text-base font-medium">{{ $person->status_pernikahan ?? 'Belum Menikah' }}</p>
                            </div>
                            @if($person->status_pernikahan == 'Menikah' && $person->nama_pasangan)
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">
                                    Pasangan ({{ $person->jenis_kelamin == 'L' ? 'Istri' : 'Suami' }})
                                </label>
                                <ul class="list-disc pl-4 text-sm sm:text-base text-secondary font-medium space-y-1">
                                    @foreach(explode(',', $person->nama_pasangan) as $pasangan)
                                        <li>{{ trim($pasangan) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">Tempat Lahir</label>
                                <p class="text-sm sm:text-base font-medium">{{ $person->tempat_lahir ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-outline block mb-1">Tanggal Lahir</label>
                                <p class="text-sm sm:text-base font-medium">{{ $person->tanggal_lahir ? \Carbon\Carbon::parse($person->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                            </div>
                            @if($person->tanggal_wafat)
                            <div>
                                <label class="text-xs font-semibold text-error block mb-1">Tanggal Wafat</label>
                                <p class="text-sm sm:text-base text-error font-bold">{{ \Carbon\Carbon::parse($person->tanggal_wafat)->translatedFormat('d F Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-xl">diversity_3</span> Orang Tua Kandung
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-md">
                                <div class="p-3.5 sm:p-md border border-outline-variant bg-surface-container-low rounded-xl flex items-center gap-3 hover:border-secondary transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                        <span class="material-symbols-outlined text-secondary">woman</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-semibold text-outline uppercase tracking-wider">Ibu Kandung</p>
                                        @if($person->nama_ibu_non_raja)
                                            <p class="text-xs sm:text-sm font-bold text-primary truncate">
                                                {{ $person->nama_ibu_non_raja }}
                                            </p>
                                            <span class="text-[10px] text-outline block italic">(Non-Raja)</span>
                                        @elseif($person->mother)
                                            <a href="{{ route('person.detail', $person->mother->id) }}" class="text-xs sm:text-sm font-bold text-primary hover:text-secondary hover:underline truncate block">
                                                {{ $person->mother->has_duplicate_name ? $person->mother->nama_nasab : $person->mother->nama_lengkap }}
                                            </a>
                                        @else
                                            <p class="text-xs sm:text-sm italic text-outline">Tidak terdata</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-3.5 sm:p-md border border-outline-variant bg-surface-container-low rounded-xl flex items-center gap-3 hover:border-secondary transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                        <span class="material-symbols-outlined text-secondary">man</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-semibold text-outline uppercase tracking-wider">Ayah Kandung</p>
                                        @if($person->father)
                                            <a href="{{ route('person.detail', $person->father->id) }}" class="text-xs sm:text-sm font-bold text-primary hover:text-secondary hover:underline truncate block">
                                                {{ $person->father->has_duplicate_name ? $person->father->nama_nasab : $person->father->nama_lengkap }}
                                            </a>
                                        @else
                                            <p class="text-xs sm:text-sm italic text-outline">Tidak terdata</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-xl">group</span> Saudara Kandung
                            </h3>
                            @if(count($saudaraKandung) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-sm">
                                    @foreach($saudaraKandung as $sibling)
                                        <a href="{{ route('person.detail', $sibling->id) }}" class="p-3 border border-outline-variant rounded-xl flex items-center gap-3 hover:border-secondary transition-colors group bg-white shadow-xs">
                                            <div class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                                <span class="material-symbols-outlined text-primary text-sm">person</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm font-bold text-primary group-hover:text-secondary group-hover:underline truncate">{{ $sibling->has_duplicate_name ? $sibling->nama_nasab : $sibling->nama_lengkap }}</p>
                                                <p class="text-[11px] text-outline inline-flex items-center gap-1">
                                                    @if($sibling->jenis_kelamin == 'L')
                                                        <i class="bi bi-gender-male text-secondary"></i> Laki-laki
                                                    @else
                                                        <i class="bi bi-gender-female text-rose-600"></i> Perempuan
                                                    @endif
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-3.5 bg-surface-container-low rounded-xl text-xs sm:text-sm italic text-on-surface-variant flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base text-outline">info</span>
                                    <span>Tidak ada data saudara kandung yang terdaftar dengan orang tua yang sama.</span>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-primary mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-xl">child_care</span> Keturunan Langsung (Anak)
                            </h3>
                            @if(count($anakKandung) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-sm">
                                    @foreach($anakKandung as $child)
                                        <a href="{{ route('person.detail', $child->id) }}" class="p-3 border border-outline-variant rounded-xl flex items-center gap-3 hover:border-secondary transition-colors group bg-white shadow-xs">
                                            <div class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                                <span class="material-symbols-outlined text-primary text-sm">child_care</span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm font-bold text-primary group-hover:text-secondary group-hover:underline truncate">{{ $child->has_duplicate_name ? $child->nama_nasab : $child->nama_lengkap }}</p>
                                                <p class="text-[11px] text-outline inline-flex items-center gap-1">
                                                    @if($child->jenis_kelamin == 'L')
                                                        <i class="bi bi-gender-male text-secondary"></i> Laki-laki
                                                    @else
                                                        <i class="bi bi-gender-female text-rose-600"></i> Perempuan
                                                    @endif
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-3.5 bg-surface-container-low rounded-xl text-xs sm:text-sm italic text-on-surface-variant flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base text-outline">info</span>
                                    <span>Tidak ada data anak yang terdaftar untuk tokoh ini.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="bento-card p-5 sm:p-lg hidden" id="content-biografi">
                    <h2 class="text-lg sm:text-xl md:text-headline-md font-bold text-primary mb-4 sm:mb-lg">Biografi / Catatan Sejarah</h2>
                    <div class="bg-surface-container-low p-4 sm:p-md rounded-xl border border-outline-variant">
                        <p class="text-on-surface-variant text-xs sm:text-sm md:text-base leading-relaxed whitespace-pre-line text-justify">
                            {{ $person->biografi ?? 'Belum ada data biografi tertulis lengkap untuk tokoh ini.' }}
                        </p>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <footer class="bg-primary text-on-primary w-full mt-auto border-t border-primary-container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-md px-4 sm:px-margin-mobile md:px-margin-desktop py-6 sm:py-lg max-w-7xl mx-auto items-center">
            <div>
                <div class="text-base sm:text-lg font-bold text-on-primary mb-1">Silsilah Keluarga</div>
                <p class="text-xs opacity-75">© 2026 Silsilah Keluarga. Seluruh Hak Cipta Dilindungi. Institusi Genealogi Digital.</p>
            </div>
            <div class="flex flex-wrap md:justify-end gap-3 sm:gap-md text-xs sm:text-sm">
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors" href="#">Kebijakan Privasi</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors" href="#">Syarat &amp; Ketentuan</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors" href="#">Bantuan</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors" href="#">Kontak Kami</a>
            </div>
        </div>
    </footer>

    <script>
        function switchTab(tabId) {
            const sections = ['content-basic', 'content-biografi'];
            sections.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.add('hidden');
                    el.classList.remove('block');
                }
            });

            const buttons = ['btn-basic', 'btn-biografi'];
            buttons.forEach(id => {
                const btn = document.getElementById(id);
                if (btn) {
                    btn.classList.remove('active-tab');
                    btn.classList.add('text-on-surface-variant');
                }
            });

            const targetSection = document.getElementById('content-' + tabId);
            const targetButton = document.getElementById('btn-' + tabId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
                targetSection.classList.add('block');
            }
            if (targetButton) {
                targetButton.classList.add('active-tab');
                targetButton.classList.remove('text-on-surface-variant');
            }
        }
    </script>
</body>
</html>