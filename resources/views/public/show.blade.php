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
        .active-tab { border-left: 4px solid #001e40; background-color: #efeded; color: #001e40; font-weight: 600; }
        .hero-gradient { background: linear-gradient(135deg, #001e40 0%, #0059bb 100%); }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col pt-24">

    @php
        // 1. Cari Saudara Kandung
        $saudaraKandung = [];
        if(!empty($person->father_id)) {
            $saudaraKandung = \App\Models\Person::where('father_id', $person->father_id)
                                                ->where('id', '!=', $person->id)
                                                ->get();
        } elseif(!empty($person->nama_ibu_non_raja)) {
            $saudaraKandung = \App\Models\Person::where('nama_ibu_non_raja', $person->nama_ibu_non_raja)
                                                ->where('id', '!=', $person->id)
                                                ->get();
        }

        // 2. Cari Anak Kandung
        $anakKandung = \App\Models\Person::where('father_id', $person->id)->get();
    @endphp

    <nav class="fixed top-0 w-full z-50 flex justify-between items-center px-margin-desktop bg-surface/90 backdrop-blur-sm border-b border-primary h-20">
        <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-3xl">account_tree</span>
            <span class="font-headline-md text-headline-md font-bold text-primary">Silsilah Keluarga</span>
        </div>
        <div class="hidden md:flex items-center gap-lg">
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors duration-200" href="{{ route('home') }}">Beranda</a>
            <a class="font-body-md text-body-md text-on-surface-variant hover:text-secondary transition-colors duration-200" href="{{ route('relation.index') }}">Cari Relasi</a>
            <a class="font-body-md text-body-md text-secondary border-b-2 border-secondary pb-1 font-bold" href="{{ route('about') }}">Tentang Kami</a>
        </div>
        <div class="flex items-center gap-sm">
            <a href="{{ route('login') }}" class="material-symbols-outlined text-primary p-xs hover:bg-surface-container-highest rounded-full transition-all">account_circle</a>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto w-full px-margin-mobile md:px-margin-desktop py-md">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-sm mb-lg">
            <a href="{{ route('home') }}" class="flex items-center gap-xs text-primary font-medium hover:underline transition-all">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back</span>
                <span class="font-label-md text-label-md">Kembali ke Pencarian</span>
            </a>
        </div>

        <header class="hero-gradient rounded-xl p-md md:p-xl text-on-primary mb-lg shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row gap-lg items-center md:items-start">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-lg overflow-hidden border-4 border-white shadow-md flex-shrink-0 bg-surface-container flex items-center justify-center">
                    @if($person->foto)
                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $person->foto) }}" alt="Foto {{ $person->nama_lengkap }}">
                    @else
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($person->nama_lengkap) }}&size=150&background=random" alt="Avatar">
                    @endif
                </div>
                <div class="flex-grow text-center md:text-left text-white">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-xs mb-base">
                        <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg font-bold">{{ $person->nama_lengkap }}</h1>
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-3xl" style="font-variation-settings: 'FILL' 1;" title="Terverifikasi">verified</span>
                    </div>
                    <div class="flex flex-wrap justify-center md:justify-start gap-sm mt-sm">
                        <span class="bg-primary-container/50 border border-inverse-primary/30 px-md py-xs rounded-full font-label-md text-label-md">
                            {{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        @if($person->tanggal_wafat)
                            <span class="bg-error border border-error-container/30 px-md py-xs rounded-full font-label-md text-label-md">Wafat</span>
                        @else
                            <span class="bg-green-700 border border-white/30 px-md py-xs rounded-full font-label-md text-label-md">Hidup</span>
                        @endif
                        <span class="bg-primary-container/50 border border-white/20 px-md py-xs rounded-full font-label-md text-label-md">ID: #{{ str_pad($person->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <p class="mt-md font-body-lg text-body-lg text-white/80 max-w-2xl italic">
                        "{{ $person->biografi ? Str::limit($person->biografi, 120) : 'Belum ada ringkasan biografi tertulis untuk tokoh ini.' }}"
                    </p>
                </div>
            </div>
            <div class="absolute -right-16 -bottom-16 opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'FILL' 1;">account_tree</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            
            <aside class="md:col-span-3 space-y-md">
                <div class="bento-card p-md sticky top-24">
                    <h3 class="font-title-lg text-title-lg text-primary mb-md pb-base border-b border-surface-variant">Navigasi Profil</h3>
                    <nav class="flex flex-col gap-base">
                        <button class="flex items-center gap-sm p-sm rounded-lg hover:bg-surface-container transition-colors w-full text-left active-tab" id="btn-basic" onclick="switchTab('basic')">
                            <span class="material-symbols-outlined">family_history</span>
                            <span class="font-body-md text-body-md">Profil & Keluarga Inti</span>
                        </button>
                        <button class="flex items-center gap-sm p-sm rounded-lg hover:bg-surface-container transition-colors w-full text-left text-on-surface-variant" id="btn-biografi" onclick="switchTab('biografi')">
                            <span class="material-symbols-outlined">description</span>
                            <span class="font-body-md text-body-md">Biografi Lengkap</span>
                        </button>
                        
                        <div class="border-t border-surface-variant my-xs"></div>
                        
                        <a href="{{ route('person.trah', $person->id) }}" class="flex items-center gap-sm p-sm rounded-lg bg-primary text-white hover:bg-secondary transition-all w-full text-left font-body-md font-medium shadow-sm">
                            <span class="material-symbols-outlined text-md">account_tree</span>
                            <span class="font-body-md text-body-md">Lihat Pohon Silsilah / Trah</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <div class="md:col-span-9 space-y-md">
                
                <section class="bento-card p-lg block" id="content-basic">
                    <div class="flex items-center justify-between mb-lg">
                        <h2 class="font-headline-md text-headline-md text-primary">Informasi Personal</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-xl border-b border-surface-variant pb-lg mb-lg">
                        <div class="space-y-md">
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">Nama Lengkap</label>
                                <p class="font-body-lg text-body-lg font-semibold">{{ $person->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">Jenis Kelamin</label>
                                <p class="font-body-lg text-body-lg">{{ $person->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">Status Pernikahan</label>
                                <p class="font-body-lg text-body-lg">{{ $person->status_pernikahan ?? 'Belum Menikah' }}</p>
                            </div>
                            @if($person->status_pernikahan == 'Menikah' && $person->nama_pasangan)
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">
                                    Pasangan ({{ $person->jenis_kelamin == 'L' ? 'Istri' : 'Suami' }})
                                </label>
                                <ul class="list-disc pl-sm font-body-lg text-body-lg text-secondary font-medium">
                                    @foreach(explode(',', $person->nama_pasangan) as $pasangan)
                                        <li>{{ trim($pasangan) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="space-y-md">
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">Tempat Lahir</label>
                                <p class="font-body-lg text-body-lg">{{ $person->tempat_lahir ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="font-label-md text-label-md text-on-tertiary-fixed-variant block mb-xs">Tanggal Lahir</label>
                                <p class="font-body-lg text-body-lg">{{ $person->tanggal_lahir ? \Carbon\Carbon::parse($person->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                            </div>
                            @if($person->tanggal_wafat)
                            <div>
                                <label class="font-label-md text-label-md text-error block mb-xs">Tanggal Wafat</label>
                                <p class="font-body-lg text-body-lg text-error font-semibold">{{ \Carbon\Carbon::parse($person->tanggal_wafat)->translatedFormat('d F Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-lg">
                        <div>
                            <h3 class="font-title-lg text-title-lg text-primary mb-sm flex items-center gap-xs">
                                <span class="material-symbols-outlined text-md">diversity_3</span> Orang Tua Kandung
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                                <div class="p-md border border-outline-variant bg-surface-container-low rounded-xl flex items-center gap-md hover:border-secondary transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <span class="material-symbols-outlined text-secondary">woman</span>
                                    </div>
                                    <div>
                                        <p class="font-label-md text-label-md text-outline">Ibu Kandung</p>
                                        @if($person->nama_ibu_non_raja)
                                            <p class="font-body-md text-body-md font-bold text-primary">
                                                {{ $person->nama_ibu_non_raja }} <span class="text-[11px] font-normal text-outline block italic">(Masyarakat Biasa / Non-Raja)</span>
                                            </p>
                                        @elseif($person->mother)
                                            <a href="{{ route('person.detail', $person->mother->id) }}" class="font-body-md text-body-md font-bold text-primary hover:text-secondary hover:underline">
                                                {{ $person->mother->nama_lengkap }}
                                            </a>
                                        @else
                                            <p class="font-body-md text-body-md italic text-outline">Tidak terdata</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-md border border-outline-variant bg-surface-container-low rounded-xl flex items-center gap-md hover:border-secondary transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <span class="material-symbols-outlined text-secondary">man</span>
                                    </div>
                                    <div>
                                        <p class="font-label-md text-label-md text-outline">Ayah Kandung</p>
                                        @if($person->father)
                                            <a href="{{ route('person.detail', $person->father->id) }}" class="font-body-md text-body-md font-bold text-primary hover:text-secondary hover:underline">
                                                {{ $person->father->nama_lengkap }}
                                            </a>
                                        @else
                                            <p class="font-body-md text-body-md italic text-outline">Tidak terdata</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-title-lg text-title-lg text-primary mb-sm flex items-center gap-xs">
                                <span class="material-symbols-outlined text-md">group</span> Saudara Kandung
                            </h3>
                            @if(count($saudaraKandung) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-sm">
                                    @foreach($saudaraKandung as $sibling)
                                        <a href="{{ route('person.detail', $sibling->id) }}" class="p-sm border border-outline-variant rounded-xl flex items-center gap-md hover:border-secondary transition-colors group bg-white">
                                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                                <span class="material-symbols-outlined text-primary text-sm">person</span>
                                            </div>
                                            <div>
                                                <p class="font-body-md text-body-md font-bold text-primary group-hover:text-secondary group-hover:underline">{{ $sibling->nama_lengkap }}</p>
                                                <p class="font-label-md text-label-md text-outline">{{ $sibling->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm italic text-on-surface-variant bg-surface-container-low p-sm rounded-lg">Tidak ada data saudara kandung yang terdaftar dengan Orang Tua yang sama.</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-title-lg text-title-lg text-primary mb-sm flex items-center gap-xs">
                                <span class="material-symbols-outlined text-md">child_care</span> Keturunan Langsung (Anak)
                            </h3>
                            @if(count($anakKandung) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-sm">
                                    @foreach($anakKandung as $child)
                                        <a href="{{ route('person.detail', $child->id) }}" class="p-sm border border-outline-variant rounded-xl flex items-center gap-md hover:border-secondary transition-colors group bg-white">
                                            <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
                                                <span class="material-symbols-outlined text-primary text-sm">child_care</span>
                                            </div>
                                            <div>
                                                <p class="font-body-md text-body-md font-bold text-primary group-hover:text-secondary group-hover:underline">{{ $child->nama_lengkap }}</p>
                                                <p class="font-label-md text-label-md text-outline">{{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm italic text-on-surface-variant bg-surface-container-low p-sm rounded-lg">Tidak ada data anak yang terdaftar.</p>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="bento-card p-lg hidden" id="content-biografi">
                    <h2 class="font-headline-md text-headline-md text-primary mb-lg">Biografi / Catatan Sejarah</h2>
                    <div class="bg-surface-container-low p-md rounded-xl border border-outline-variant">
                        <p class="text-on-surface-variant font-body-lg text-body-lg leading-relaxed whitespace-pre-line text-justify">
                            {{ $person->biografi ?? 'Belum ada data biografi tertulis lengkap untuk tokoh ini.' }}
                        </p>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <footer class="bg-primary text-on-primary w-full mt-auto border-t border-primary-container">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md px-margin-mobile md:px-margin-desktop py-lg max-w-7xl mx-auto items-center">
            <div>
                <div class="text-headline-md font-headline-md text-on-primary mb-base">Silsilah Keluarga</div>
                <p class="font-body-md text-body-md opacity-80">© 2026 Silsilah Keluarga. Seluruh Hak Cipta Dilindungi. Institusi Genealogi Digital.</p>
            </div>
            <div class="flex flex-wrap md:justify-end gap-md">
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors font-body-md text-body-md" href="#">Kebijakan Privasi</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors font-body-md text-body-md" href="#">Syarat &amp; Ketentuan</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors font-body-md text-body-md" href="#">Bantuan</a>
                <a class="text-on-primary-container hover:text-secondary-fixed transition-colors font-body-md text-body-md" href="#">Kontak Kami</a>
            </div>
        </div>
    </footer>

    <script>
        function switchTab(tabId) {
            const sections = ['content-basic', 'content-biografi'];
            sections.forEach(id => {
                document.getElementById(id).classList.add('hidden');
                document.getElementById(id).classList.remove('block');
            });

            const buttons = ['btn-basic', 'btn-biografi'];
            buttons.forEach(id => {
                document.getElementById(id).classList.remove('active-tab');
                document.getElementById(id).classList.add('text-on-surface-variant');
            });

            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('content-' + tabId).classList.add('block');
            document.getElementById('btn-' + tabId).classList.add('active-tab');
            document.getElementById('btn-' + tabId).classList.remove('text-on-surface-variant');
        }
    </script>
</body>
</html>