<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ \App\Models\Setting::get('site_title', 'Silsilah Keluarga - Pusat Data Genealogi Digital') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "tertiary-fixed-dim": "#bdc7d6", "on-surface-variant": "#43474f", "on-tertiary": "#ffffff",
                "tertiary": "#151f29", "on-error-container": "#93000a", "surface-bright": "#fbf9f8",
                "on-secondary-fixed": "#001a41", "on-primary-fixed-variant": "#1f477b", "surface-container-highest": "#e4e2e2",
                "on-surface": "#1b1c1c", "primary-fixed": "#d5e3ff", "background": "#fbf9f8", "secondary": "#0059bb",
                "surface-dim": "#dbd9d9", "on-secondary-fixed-variant": "#004493", "on-tertiary-fixed": "#131c27",
                "on-primary-fixed": "#001b3c", "secondary-fixed-dim": "#adc7ff", "secondary-container": "#0070ea",
                "surface-container": "#efeded", "on-tertiary-fixed-variant": "#3e4853", "inverse-primary": "#a7c8ff",
                "surface-variant": "#e4e2e2", "surface-container-high": "#eae8e7", "on-primary-container": "#799dd6",
                "on-error": "#ffffff", "primary": "#001e40", "on-secondary": "#ffffff", "primary-container": "#003366",
                "inverse-surface": "#303030", "tertiary-container": "#2a343f", "error": "#ba1a1a", "on-tertiary-container": "#929caa",
                "primary-fixed-dim": "#a7c8ff", "on-primary": "#ffffff", "surface-tint": "#3a5f94", "tertiary-fixed": "#d9e3f2",
                "surface-container-low": "#f5f3f3", "surface": "#fbf9f8", "error-container": "#ffdad6", "inverse-on-surface": "#f2f0f0",
                "outline-variant": "#c3c6d1", "surface-container-lowest": "#ffffff", "secondary-fixed": "#d8e2ff",
                "on-background": "#1b1c1c", "on-secondary-container": "#fefcff", "outline": "#737780"
            },
            "borderRadius": { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
            "spacing": { "gutter": "20px", "base": "4px", "xs": "8px", "margin-desktop": "40px", "margin-mobile": "16px", "md": "24px", "xl": "48px", "sm": "16px", "lg": "32px" }
          },
        },
      }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        .bento-card { border: 1px solid #E1E4E8; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .bento-card:hover { box-shadow: 0 12px 24px -10px rgba(0, 51, 102, 0.12); transform: translateY(-2px); }
        .hero-gradient { background: linear-gradient(135deg, #001e40 0%, #0059bb 100%); }
        .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased overflow-x-hidden">

<header class="fixed top-0 left-0 w-full z-50 bg-surface/80 glass-nav border-b-2 border-primary">
    <nav class="flex justify-between items-center w-full px-margin-desktop max-w-7xl mx-auto h-20">
        <div class="flex items-center gap-xs">
            <span class="font-headline-md text-headline-md font-bold text-primary">{{ \App\Models\Setting::get('nav_brand', 'Silsilah Raja') }}</span>
        </div>
        <div class="hidden md:flex items-center gap-lg">
            <a class="font-label-md text-label-md text-secondary font-bold border-b-2 border-secondary pb-1" href="{{ route('home') }}">Beranda</a>
            <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors" href="{{ route('relation.index') }}">Cari Relasi</a>
        </div>
        <div class="flex items-center gap-md">
            <a href="{{ route('admin.people.index') }}" class="hidden md:flex items-center gap-xs px-md py-xs bg-primary-container text-on-primary-container font-label-md text-label-md rounded-xl hover:bg-primary transition-all text-decoration-none">
                <span class="material-symbols-outlined text-[18px]">login</span> Panel Admin
            </a>
        </div>
    </nav>
</header>

<main class="pt-20">
    <section class="relative w-full min-h-[600px] flex flex-col items-center justify-center hero-gradient text-white overflow-hidden px-margin-mobile md:px-margin-desktop">
        <div class="relative z-10 text-center max-w-4xl w-full py-12">
            <h1 class="font-display-lg text-display-lg mb-md leading-tight">
                {!! nl2br(e(\App\Models\Setting::get('hero_title', "Temukan Akar & \n Warisan Agung Keluarga Raja"))) !!}
            </h1>
            <p class="font-body-lg text-body-lg text-on-primary-container mb-xl opacity-90 max-w-2xl mx-auto">
                {{ \App\Models\Setting::get('hero_subtitle', 'Arsip digital silsilah keturunan ningrat yang aman, terstruktur, dan terverifikasi.') }}
            </p>
            
            <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-2xl mx-auto group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-primary">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input name="search" class="w-full pl-16 pr-32 py-5 bg-surface-container-lowest text-on-surface font-body-md text-body-md rounded-full border-none shadow-2xl focus:ring-4 focus:ring-secondary/30 transition-all outline-none" placeholder="Cari Nama Keturunan..." type="text" value="{{ request('search') }}"/>
                <button type="submit" class="absolute inset-y-2 right-2 px-lg bg-secondary text-white rounded-full font-label-md text-label-md hover:bg-secondary-container transition-all">
                    Cari
                </button>
            </form>
        </div>
    </section>

    @if(request('search'))
    <section class="py-lg px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <h3 class="font-headline-md text-headline-md text-primary mb-md"><i class="fa-solid fa-square-poll-horizontal me-1"></i> Hasil Pencarian untuk "{{ request('search') }}"</h3>
        @if(isset($results) && !$results->isEmpty())
            <div class="list-group space-y-2">
                @foreach($results as $res)
                    <a href="{{ route('person.detail', $res->id) }}" class="block p-4 bg-white border border-outline-variant rounded-xl hover:border-primary transition-all text-decoration-none">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold text-dark text-lg block">{{ $res->nama_lengkap }}</span>
                                <small class="text-muted">Asal Lahir: {{ $res->tempat_lahir ?? '-' }}</small>
                            </div>
                            <span class="px-3 py-1 bg-primary text-white text-xs rounded-full">Buka Profil &rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="p-4 bg-surface-container text-center rounded-xl text-muted">Tidak ada data keturunan dengan nama tersebut.</div>
        @endif
    </section>
    @endif

    <section class="py-xl px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter items-center mb-xl">
            <div class="md:col-span-7">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-md">{{ \App\Models\Setting::get('history_title', 'Sejarah & Warisan Agung Keluarga Raja') }}</h2>
                <div class="space-y-sm text-on-surface-variant leading-relaxed">
                    <p class="font-body-lg text-body-lg text-justify">
                        {{ \App\Models\Setting::get('history_body_1', 'Perjalanan sejarah keluarga raja bukan sekadar silsilah nama, melainkan sebuah narasi agung tentang kepemimpinan dan identitas budaya.') }}
                    </p>
                </div>
            </div>
            <div class="md:col-span-5">
                <div class="bg-surface-container-low p-lg border border-outline-variant rounded-xl">
                    <h3 class="font-title-lg text-title-lg text-secondary mb-sm border-b border-outline-variant pb-xs">Pilar Pelestarian</h3>
                    <ul class="space-y-xs">
                        <li class="flex gap-xs items-start">
                            <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                            <span class="font-body-md text-body-md">Sistem Kekerabatan Adat Melayu Riau</span>
                        </li>
                        <li class="flex gap-xs items-start">
                            <span class="material-symbols-outlined text-primary text-sm mt-1">check_circle</span>
                            <span class="font-body-md text-body-md">Visualisasi Garis Keturunan & Trah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mb-xl">
            <div class="mb-lg text-center md:text-left">
                <h2 class="font-headline-lg text-headline-lg text-primary">Anggota Keluarga Terdata</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Daftar tokoh silsilah yang tercatat di dalam pangkalan data.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                @foreach($featuredPeople as $fp)
                <div class="bento-card bg-white p-md border border-outline-variant rounded-xl flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-md border-4 border-primary-fixed shadow-sm">
                        @if($fp->foto)
                            <img alt="Foto" class="w-full h-full object-cover" src="{{ asset('storage/' . $fp->foto) }}"/>
                        @else
                            <img alt="Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($fp->nama_lengkap) }}&size=150"/>
                        @endif
                    </div>
                    <h3 class="font-title-lg text-title-lg text-primary">{{ $fp->nama_lengkap }}</h3>
                    <p class="font-label-md text-label-md text-secondary uppercase tracking-wider mb-sm">Lahir di {{ $fp->tempat_lahir ?? '-' }}</p>
                    <a href="{{ route('person.detail', $fp->id) }}" class="mt-2 px-4 py-1 bg-primary text-white rounded-full text-xs hover:bg-secondary transition-all">Buka Profil</a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter text-center">
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                <span class="block font-display-lg text-display-lg text-secondary">{{ $totalNodes }}</span>
                <span class="font-label-md text-label-md text-on-surface-variant uppercase">Total Keturunan</span>
            </div>
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                <span class="block font-display-lg text-display-lg text-secondary">{{ $totalLeluhur }}</span>
                <span class="font-label-md text-label-md text-on-surface-variant uppercase">Leluhur Utama</span>
            </div>
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                <span class="block font-display-lg text-display-lg text-secondary">100%</span>
                <span class="font-label-md text-label-md text-on-surface-variant uppercase">Data Valid</span>
            </div>
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl">
                <span class="block font-display-lg text-display-lg text-secondary">Online</span>
                <span class="font-label-md text-label-md text-on-surface-variant uppercase">Akses Publik</span>
            </div>
        </div>
    </section>

    <section class="py-xl bg-surface-container-low px-margin-mobile md:px-margin-desktop">
        <div class="max-w-7xl mx-auto">
            <div class="mb-lg">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-xs">Pembaruan Tokoh Terakhir</h2>
                <p class="text-on-surface-variant font-body-md">Berikut adalah nama-nama anggota keluarga raja yang baru saja ditambahkan ke dalam pangkalan data arsip.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                @foreach($recentUpdates as $ru)
                <div class="bento-card bg-white overflow-hidden rounded-xl group p-4 flex flex-col justify-between">
                    <div>
                        <span class="bg-secondary text-white text-[10px] uppercase font-bold px-2 py-1 rounded inline-block mb-2">Terverifikasi</span>
                        <h3 class="font-title-lg text-title-lg text-primary mb-xs">{{ $ru->nama_lengkap }}</h3>
                        <p class="text-on-surface-variant font-body-md line-clamp-2">Status Pernikahan: {{ $ru->status_pernikahan ?? 'Belum Menikah' }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-outline-variant mt-4">
                        <span class="font-label-md text-label-md text-on-surface-variant">
                            {{ $ru->created_at->diffForHumans() }}
                        </span>
                        <a class="text-secondary font-label-md text-label-md font-bold flex items-center gap-base text-decoration-none" href="{{ route('person.trah', $ru->id) }}">
                            Lihat Pohon &rarr;
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<footer class="w-full py-xl px-margin-desktop bg-primary text-white grid grid-cols-1 md:grid-cols-2 justify-between items-center mt-12">
    <div>
        <div class="font-headline-md text-headline-md font-bold mb-xs">Silsilah Keluarga Raja</div>
        <p class="opacity-70 font-body-md text-body-md max-w-sm">
            Pusat Data Genealogi Digital untuk pelestarian sejarah keturunan nusantara dan warisan agung leluhur.
        </p>
    </div>
</footer>

</body>
</html>