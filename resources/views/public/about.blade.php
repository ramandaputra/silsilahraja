<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Profil Penyusun - Silsilah Keluarga</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
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

@include('public.partials.navbar')

    <main class="pt-16 sm:pt-20">
        <!-- Tombol Kembali Mobile -->
        <div class="block md:hidden px-4 py-3 bg-surface-container-lowest border-b border-outline-variant/40">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all min-h-[38px]">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
        <section class="hero-gradient py-10 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto relative z-10 py-6 sm:py-lg">
                <div class="w-full md:w-2/3">
                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold mb-3 sm:mb-sm leading-tight tracking-tight">Profil Penyusun</h1>
                    <p class="text-xs sm:text-sm md:text-base text-on-primary-container leading-relaxed">
                        {{ $settings['about_hero_description'] ?? 'Mendedikasikan teknologi untuk melestarikan memori kolektif bangsa melalui dokumentasi silsilah keluarga yang akurat, sistematis, dan terintegrasi secara digital. Kami percaya bahwa memahami akar adalah langkah awal membangun masa depan.' }}
                    </p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[300px]" style="font-variation-settings: 'wght' 100;">account_tree</span>
            </div>
        </section>

        <section class="py-10 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-md items-start">
                <div class="md:col-span-7 space-y-3 sm:space-y-sm text-on-surface-variant leading-relaxed">
                    <h2 class="text-xl sm:text-2xl md:text-headline-lg font-bold text-primary mb-2 sm:mb-md">
                        {{ $settings['about_history_title'] ?? 'Dedikasi terhadap Integritas Genealogi' }}
                    </h2>
                    <p class="text-xs sm:text-sm md:text-base leading-relaxed text-justify">
                        {{ $settings['about_history_body_1'] ?? 'Berawal dari sebuah inisiatif penelitian sejarah lisan di lingkungan akademis, proyek Silsilah Keluarga tumbuh menjadi sebuah platform institusional yang mengedepankan akurasi data. Kami menyadari bahwa sejarah keluarga bukan sekadar daftar nama, melainkan warisan budaya yang membutuhkan sistem penyimpanan yang aman dan terstruktur.' }}
                    </p>
                    <p class="text-xs sm:text-sm md:text-base leading-relaxed text-justify">
                        {{ $settings['about_history_body_2'] ?? 'Melalui metodologi yang diadaptasi dari standar arsip nasional, setiap fitur dalam aplikasi ini dirancang untuk meminimalisir redundansi data dan memastikan hubungan antar-generasi tercatat secara logis. Fokus kami adalah memberikan kemudahan bagi setiap keluarga Indonesia untuk membangun repositori sejarah mereka sendiri dengan standar profesional.' }}
                    </p>
                </div>
                
                <div class="md:col-span-5 w-full">
                    <div class="bg-surface-container-low p-5 sm:p-lg border border-outline-variant rounded-xl shadow-xs">
                        <h3 class="text-base sm:text-lg font-bold text-secondary mb-3 border-b border-outline-variant pb-2">Misi Kami</h3>
                        <ul class="space-y-2.5">
                            <li class="flex gap-2 items-start">
                                <span class="material-symbols-outlined text-secondary text-base sm:text-lg mt-0.5 shrink-0">check_circle</span>
                                <span class="text-xs sm:text-sm text-on-surface-variant">Digitalisasi arsip keluarga fisik menjadi basis data terenkripsi.</span>
                            </li>
                            <li class="flex gap-2 items-start">
                                <span class="material-symbols-outlined text-secondary text-base sm:text-lg mt-0.5 shrink-0">check_circle</span>
                                <span class="text-xs sm:text-sm text-on-surface-variant">Visualisasi hubungan kekerabatan melalui antarmuka bento grid modern.</span>
                            </li>
                            <li class="flex gap-2 items-start">
                                <span class="material-symbols-outlined text-secondary text-base sm:text-lg mt-0.5 shrink-0">check_circle</span>
                                <span class="text-xs sm:text-sm text-on-surface-variant">Penyediaan alat riset sejarah bagi peneliti genealogis independen.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-10 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop bg-surface-container-low border-t border-outline-variant/30">
            <div class="max-w-7xl mx-auto space-y-10 sm:space-y-xl">
                
                <div>
                    <h2 class="text-primary text-xl sm:text-2xl font-bold mb-4 border-b border-outline-variant/40 pb-2">Tim Ahli &amp; Penyusun</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-gutter">
                        @forelse($ahli as $member)
                            <div class="bento-card bg-white p-5 border border-outline-variant rounded-xl flex flex-col items-center text-center shadow-xs">
                                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden mb-4 border-4 border-primary-fixed bg-gray-100 flex items-center justify-center shadow-inner">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-primary text-4xl sm:text-5xl">person</span>
                                    @endif
                                </div>
                                <h3 class="text-base sm:text-lg font-bold text-primary mb-1">{{ $member->name }}</h3>
                                <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-2">{{ $member->role }}</p>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">{{ $member->description }}</p>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-400 bg-white border border-dashed border-outline-variant rounded-xl">
                                <span class="material-symbols-outlined text-3xl mb-1 text-gray-300">group_off</span>
                                <p class="text-xs">Belum ada data anggota tim penyusun yang dimasukkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h2 class="text-primary text-xl sm:text-2xl font-bold mb-4 border-b border-outline-variant/40 pb-2">Tim Pengembang Teknologi</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-gutter">
                        @forelse($developers as $dev)
                            <div class="bento-card bg-white p-5 border border-outline-variant rounded-xl flex flex-col items-center text-center shadow-xs">
                                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden mb-4 border-4 border-secondary shadow-xs bg-gray-100 flex items-center justify-center shadow-inner">
                                    @if($dev->photo)
                                        <img src="{{ asset('storage/' . $dev->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-secondary text-4xl sm:text-5xl">code</span>
                                    @endif
                                </div>
                                <h3 class="text-base sm:text-lg font-bold text-primary mb-1">{{ $dev->name }}</h3>
                                <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-2">{{ $dev->role }}</p>
                                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">{{ $dev->description }}</p>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-400 bg-white border border-dashed border-outline-variant rounded-xl">
                                <span class="material-symbols-outlined text-3xl mb-1 text-gray-300">code_off</span>
                                <p class="text-xs">Belum ada data tim pengembang teknologi yang dimasukkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </section>
    </main>

    <footer class="w-full mt-auto py-8 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop bg-primary text-white border-t-4 border-secondary">
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
        document.querySelectorAll('.bento-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                const img = card.querySelector('img');
                const icon = card.querySelector('.material-symbols-outlined');
                if(img) {
                    img.style.transform = 'scale(1.08)';
                    img.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                }
                if(icon) {
                    icon.style.transform = 'scale(1.15)';
                    icon.style.transition = 'transform 0.3s ease';
                }
            });
            card.addEventListener('mouseleave', () => {
                const img = card.querySelector('img');
                const icon = card.querySelector('.material-symbols-outlined');
                if(img) img.style.transform = 'scale(1)';
                if(icon) icon.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>