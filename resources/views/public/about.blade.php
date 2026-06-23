<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Profil Penyusun - Silsilah Keluarga</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary": "#151f29",
                        "outline": "#737780",
                        "on-secondary-fixed": "#001a41",
                        "surface-container": "#efeded",
                        "on-primary-container": "#799dd6",
                        "secondary": "#0059bb",
                        "on-tertiary-fixed": "#131c27",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-secondary-fixed-variant": "#004493",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#fefcff",
                        "inverse-on-surface": "#f2f0f0",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed": "#d8e2ff",
                        "on-tertiary-container": "#929caa",
                        "surface-bright": "#fbf9f8",
                        "outline-variant": "#c3c6d1",
                        "inverse-surface": "#303030",
                        "error": "#ba1a1a",
                        "surface-tint": "#3a5f94",
                        "on-error": "#ffffff",
                        "surface-container-low": "#f5f3f3",
                        "secondary-fixed-dim": "#adc7ff",
                        "inverse-primary": "#a7c8ff",
                        "on-surface-variant": "#43474f",
                        "primary": "#001e40",
                        "on-error-container": "#93000a",
                        "on-surface": "#1b1c1c",
                        "background": "#fbf9f8",
                        "surface": "#fbf9f8",
                        "surface-dim": "#dbd9d9",
                        "primary-fixed": "#d5e3ff",
                        "primary-container": "#003366",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#2a343f",
                        "surface-container-highest": "#e4e2e2",
                        "on-background": "#1b1c1c",
                        "tertiary-fixed": "#d9e3f2",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#0070ea",
                        "on-primary-fixed-variant": "#1f477b",
                        "on-primary-fixed": "#001b3c",
                        "tertiary-fixed-dim": "#bdc7d6",
                        "surface-variant": "#e4e2e2",
                        "surface-container-high": "#eae8e7",
                        "on-tertiary-fixed-variant": "#3e4853"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "xl": "48px",
                        "margin-mobile": "16px",
                        "margin-desktop": "40px",
                        "lg": "32px",
                        "sm": "16px",
                        "base": "4px",
                        "xs": "8px",
                        "md": "24px",
                        "gutter": "20px"
                    },
                    "fontFamily": {
                        "headline-md": ["Montserrat"],
                        "body-md": ["Inter"],
                        "display-lg": ["Montserrat"],
                        "title-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-lg-mobile": ["Montserrat"],
                        "body-lg": ["Inter"],
                        "data-table": ["Inter"],
                        "headline-lg": ["Montserrat"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "60px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "title-lg": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "data-table": ["13px", {"lineHeight": "18px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .bento-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bento-card:hover {
            box-shadow: 0 12px 24px rgba(0, 51, 102, 0.08);
            transform: translateY(-2px);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #001e40 0%, #003366 100%);
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface">

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

    <main class="pt-20">
        <section class="hero-gradient py-xl px-margin-mobile md:px-margin-desktop text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto relative z-10 py-lg">
                <div class="w-full md:w-2/3">
                <h1 class="font-display-lg text-display-lg mb-sm">Profil Penyusun</h1>
                    <p class="font-body-lg text-body-lg text-on-primary-container leading-relaxed">
                    {{ $settings['about_hero_description'] ?? 'Mendedikasikan teknologi untuk melestarikan memori kolektif bangsa melalui dokumentasi silsilah keluarga yang akurat, sistematis, dan terintegrasi secara digital. Kami percaya bahwa memahami akar adalah langkah awal membangun masa depan.' }}
                    </p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[300px]" style="font-variation-settings: 'wght' 100;">account_tree</span>
            </div>
        </section>

        <section class="py-xl px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
            <div class="md:col-span-7">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-md">
                    {{ $settings['about_history_title'] ?? 'Dedikasi terhadap Integritas Genealogi' }}
                </h2>
                <div class="space-y-sm text-on-surface-variant leading-relaxed">
                <p class="font-body-lg text-body-lg">
                    {{ $settings['about_history_body_1'] ?? 'Berawal dari sebuah inisiatif penelitian sejarah lisan di lingkungan akademis, proyek Silsilah Keluarga tumbuh menjadi sebuah platform institusional yang mengedepankan akurasi data. Kami menyadari bahwa sejarah keluarga bukan sekadar daftar nama, melainkan warisan budaya yang membutuhkan sistem penyimpanan yang aman dan terstruktur.' }}
                </p>
                <p class="font-body-lg text-body-lg">
                    {{ $settings['about_history_body_2'] ?? 'Melalui metodologi yang diadaptasi dari standar arsip nasional, setiap fitur dalam aplikasi ini dirancang untuk meminimalisir redundansi data dan memastikan hubungan antar-generasi tercatat secara logis. Fokus kami adalah memberikan kemudahan bagi setiap keluarga Indonesia untuk membangun repositori sejarah mereka sendiri dengan standar profesional.' }}
                </p>
                </div>
            </div>
                <div class="md:col-span-5">
                    <div class="bg-surface-container-low p-lg border border-outline-variant rounded-xl">
                        <h3 class="font-title-lg text-title-lg text-secondary mb-sm border-b border-outline-variant pb-xs">Misi Kami</h3>
                        <ul class="space-y-xs">
                            <li class="flex gap-xs items-start">
                                <span class="material-symbols-outlined text-secondary text-sm mt-1">check_circle</span>
                                <span class="font-body-md text-body-md">Digitalisasi arsip keluarga fisik menjadi basis data terenkripsi.</span>
                            </li>
                            <li class="flex gap-xs items-start">
                                <span class="material-symbols-outlined text-secondary text-sm mt-1">check_circle</span>
                                <span class="font-body-md text-body-md">Visualisasi hubungan kekerabatan melalui antarmuka bento grid modern.</span>
                            </li>
                            <li class="flex gap-xs items-start">
                                <span class="material-symbols-outlined text-secondary text-sm mt-1">check_circle</span>
                                <span class="font-body-md text-body-md">Penyediaan alat riset sejarah bagi peneliti genealogis independen.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl px-margin-mobile md:px-margin-desktop bg-surface-container-low">
            <div class="max-w-7xl mx-auto">
                <div class="mb-lg text-center md:text-left">
                    <h2 class="font-headline-lg text-headline-lg text-primary">Tim Ahli & Penyusun</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Sinergi antara ahli kearsipan, peneliti sejarah, dan pengembang teknologi.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    <div class="bento-card bg-white p-md border border-outline-variant rounded-xl flex flex-col items-center text-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-md border-4 border-primary-fixed shadow-sm bg-gray-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-5xl">person</span>
                        </div>
                        <h3 class="font-title-lg text-title-lg text-primary">Dr. Handoko Wiratama</h3>
                        <p class="font-label-md text-label-md text-secondary uppercase tracking-wider mb-sm">Ketua Arsiparis</p>
                        <p class="font-body-md text-body-md text-on-surface-variant">Pakar dokumentasi sejarah dengan pengalaman lebih dari 15 tahun di lembaga kearsipan nasional.</p>
                    </div>
                    <div class="bento-card bg-white p-md border border-outline-variant rounded-xl flex flex-col items-center text-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-md border-4 border-primary-fixed shadow-sm bg-gray-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-5xl">engineering</span>
                        </div>
                        <h3 class="font-title-lg text-title-lg text-primary">Siti Aminah, M.Kom</h3>
                        <p class="font-label-md text-label-md text-secondary uppercase tracking-wider mb-sm">Pengembang Sistem</p>
                        <p class="font-body-md text-body-md text-on-surface-variant">Arsitek sistem informasi yang fokus pada integritas data dan keamanan basis data digital terdistribusi.</p>
                    </div>
                    <div class="bento-card bg-white p-md border border-outline-variant rounded-xl flex flex-col items-center text-center">
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-md border-4 border-primary-fixed shadow-sm bg-gray-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-5xl">history_edu</span>
                        </div>
                        <h3 class="font-title-lg text-title-lg text-primary">Prof. Baskoro Jati</h3>
                        <p class="font-label-md text-label-md text-secondary uppercase tracking-wider mb-sm">Peneliti Sejarah</p>
                        <p class="font-body-md text-body-md text-on-surface-variant">Konsultan utama untuk validasi metodologi penelusuran garis keturunan dan konteks sejarah lokal.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-xl px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter text-center">
                <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                    <span class="block font-display-lg text-display-lg text-secondary">{{ max(15, $totalFamilies) }}+</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase">Keluarga Besar</span>
                </div>
                <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                    <span class="block font-display-lg text-display-lg text-secondary">{{ $totalNodes }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase">Node Individu</span>
                </div>
                <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                    <span class="block font-display-lg text-display-lg text-secondary">99%</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase">Akurasi Data</span>
                </div>
                <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                    <span class="block font-display-lg text-display-lg text-secondary">24/7</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase">Dukungan Sistem</span>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full py-lg px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-sm bg-tertiary">
        <div class="flex flex-col gap-base text-center md:text-left">
            <div class="flex items-center gap-xs justify-center md:justify-start">
                <span class="material-symbols-outlined text-white text-xl">account_tree</span>
                <span class="font-title-lg text-title-lg text-tertiary-fixed">Silsilah Keluarga</span>
            </div>
            <p class="font-label-md text-label-md text-on-tertiary-container">© 2026 Silsilah Keluarga. Institusi Arsip Genealogi Digital.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-md">
            <a class="font-label-md text-label-md text-on-tertiary-container hover:text-white transition-all" href="#">Kebijakan Privasi</a>
            <a class="font-label-md text-label-md text-on-tertiary-container hover:text-white transition-all" href="#">Syarat Layanan</a>
            <a class="font-label-md text-label-md text-on-tertiary-container hover:text-white transition-all" href="#">Bantuan</a>
            <a class="font-label-md text-label-md text-on-tertiary-container hover:text-white transition-all" href="#">Kontak Kami</a>
        </div>
    </footer>

    <script>
        // Efek mikro interaksi zoom avatar tim ketika di-hover
        document.querySelectorAll('.bento-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) {
                    icon.style.transform = 'scale(1.15)';
                    icon.style.transition = 'transform 0.3s ease';
                }
            });
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) icon.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>