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
<body class="bg-background text-on-background font-sans antialiased overflow-x-hidden">

<header class="fixed top-0 left-0 w-full z-50 bg-surface/80 glass-nav border-b border-primary/20">
    <nav class="max-w-7xl mx-auto flex justify-between items-center px-margin-mobile md:px-margin-desktop h-20">
        <div class="flex items-center gap-xs">
            <span class="material-symbols-outlined text-primary text-3xl">account_tree</span>
            <span class="text-xl md:text-2xl font-bold text-primary tracking-tight">Silsilah Keluarga</span>
        </div>
        <div class="hidden md:flex items-center gap-lg">
            <a class="text-sm tracking-wide transition-colors duration-200 {{ request()->routeIs('home') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary' }}" href="{{ route('home') }}">Beranda</a>
            <a class="text-sm tracking-wide transition-colors duration-200 {{ request()->routeIs('relation.*') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary' }}" href="{{ route('relation.index') }}">Cari Relasi</a>
            <a class="text-sm tracking-wide transition-colors duration-200 {{ request()->routeIs('about') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary' }}" href="{{ route('about') }}">Tentang Kami</a>
        </div>
        <div class="flex items-center gap-sm">
            <a href="{{ route('login') }}" class="material-symbols-outlined text-primary p-xs hover:bg-surface-container-highest rounded-full transition-all" title="Login / Akun">account_circle</a>
        </div>
    </nav>
</header>

<main class="pt-20">
    <!-- Hero Section dengan Gambar Latar Belakang Kustom Admin -->
    @php
        $bgImage = \App\Models\Setting::get('hero_background');
    @endphp
    <section class="relative w-full min-h-[500px] flex flex-col items-center justify-center hero-gradient text-white overflow-hidden px-margin-mobile md:px-margin-desktop"
             style="@if($bgImage) background-image: linear-gradient(135deg, rgba(0, 30, 64, 0.88) 0%, rgba(0, 89, 187, 0.85) 100%), url('{{ asset('storage/' . $bgImage) }}'); background-position: center; background-size: cover; background-repeat: no-repeat; @endif">
        
        <div class="relative z-10 text-center max-w-4xl w-full py-12">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-md leading-tight tracking-tight">
                {!! nl2br(e(\App\Models\Setting::get('hero_title', "Temukan Akar & \n Warisan Agung Keluarga Raja"))) !!}
            </h1>
            <p class="text-base md:text-lg text-primary-fixed mb-xl opacity-90 max-w-2xl mx-auto leading-relaxed">
                {{ \App\Models\Setting::get('hero_subtitle', 'Arsip digital silsilah keturunan Kesultanan Riau-Lingga yang aman, terstruktur, dan terverifikasi.') }}
            </p>
            
            <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-2xl mx-auto group shadow-2xl rounded-full">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input name="search" class="w-full pl-16 pr-32 py-4 bg-surface-container-lowest text-on-surface text-base rounded-full border-none focus:ring-4 focus:ring-secondary/30 transition-all outline-none" placeholder="Cari Nama Keturunan..." type="text" value="{{ request('search') }}"/>
                <button type="submit" class="absolute inset-y-2 right-2 px-6 bg-secondary text-white rounded-full text-sm font-semibold hover:bg-secondary-container active:scale-95 transition-all">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <!-- Hasil Pencarian -->
    @if(request('search'))
    <section class="py-lg px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <h3 class="text-xl md:text-2xl font-bold text-primary mb-md flex items-center gap-2">
            <i class="fa-solid fa-square-poll-horizontal text-secondary"></i> Hasil Pencarian untuk "{{ request('search') }}"
        </h3>
        @if(isset($results) && !$results->isEmpty())
            <div class="space-y-3">
                @foreach($results as $res)
                <a href="{{ route('person.detail', $res->id) }}" class="block p-5 bg-white border border-outline-variant rounded-xl hover:border-secondary hover:shadow-md transition-all group">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-md">
                        <div>
                            <span class="font-bold text-on-surface text-lg block mb-2 group-hover:text-secondary transition-colors">{{ $res->nama_lengkap }}</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 text-sm text-on-surface-variant">
                                <div><span class="font-medium">Asal Lahir:</span> {{ $res->tempat_lahir ?? '-' }}</div>
                                <div><span class="font-medium">Jenis Kelamin:</span> {{ $res->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                <div><span class="font-medium">Nama Ayah:</span> {{ $res->father->nama_lengkap ?? '-' }}</div>
                                <div><span class="font-medium">Nama Ibu:</span> {{ $res->nama_ibu_non_raja ?? ($res->mother->nama_lengkap ?? '-') }}</div>
                            </div>
                        </div>
                        <span class="inline-flex items-center self-start sm:self-center px-4 py-2 bg-primary text-white text-xs font-semibold rounded-full shrink-0 transition-colors group-hover:bg-secondary">
                            Buka Profil &nbsp;&rarr;
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="p-8 bg-surface-container text-center rounded-xl text-on-surface-variant border border-outline-variant/50">
                Tidak ada data keturunan dengan nama tersebut.
            </div>
        @endif
    </section>
    @endif

    <!-- Sejarah Section -->
    <section class="py-xl px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter items-start mb-xl">
            <div class="md:col-span-7 space-y-md">
                <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-tight">
                    {{ \App\Models\Setting::get('history_title', 'Sejarah & Warisan Agung Keluarga Raja') }}
                </h2>
                <p class="text-base text-on-surface-variant leading-relaxed text-justify">
                    {{ \App\Models\Setting::get('history_body_1', 'Perjalanan sejarah keluarga raja bukan sekadar silsilah nama, melainkan sebuah narasi agung tentang kepemimpinan dan identitas budaya.') }}
                </p>
            </div>
            <div class="md:col-span-5 md:sticky md:top-24">
                <div class="bg-surface-container-low p-lg border border-outline-variant rounded-xl shadow-sm">
                    <h3 class="text-lg font-bold text-secondary mb-sm border-b border-outline-variant/60 pb-xs tracking-wide">Pilar Pelestarian</h3>
                    <ul class="space-y-sm">
                        <li class="flex gap-xs items-start text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary text-xl shrink-0">check_circle</span>
                            <span class="text-sm md:text-base">Sistem Kekerabatan Adat Melayu Riau</span>
                        </li>
                        <li class="flex gap-xs items-start text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary text-xl shrink-0">check_circle</span>
                            <span class="text-sm md:text-base">Visualisasi Garis Keturunan & Trah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Statistik Counter -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-gutter mt-lg">
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl shadow-sm flex flex-col justify-center items-center">
                <span class="block text-3xl md:text-4xl font-black text-secondary mb-1">{{ $totalNodes }}</span>
                <span class="text-xs font-bold text-on-surface-variant tracking-wider uppercase text-center">Total Keturunan</span>
            </div>
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl shadow-sm flex flex-col justify-center items-center">
                <span class="block text-3xl md:text-4xl font-black text-secondary mb-1">{{ $totalLeluhur }}</span>
                <span class="text-xs font-bold text-on-surface-variant tracking-wider uppercase text-center">Leluhur Utama</span>
            </div>
            <div class="p-lg bg-surface-container border border-outline-variant rounded-xl shadow-sm flex flex-col justify-center items-center">
                <span class="block text-3xl md:text-4xl font-black text-emerald-600 mb-1">Online</span>
                <span class="text-xs font-bold text-on-surface-variant tracking-wider uppercase text-center">Akses Publik</span>
            </div>
        </div>
    </section>

    <!-- Pembaruan Terakhir -->
    <section class="py-xl bg-surface-container-low px-margin-mobile md:px-margin-desktop border-t border-outline-variant/30">
        <div class="max-w-7xl mx-auto">
            <div class="mb-lg">
                <h2 class="text-2xl md:text-3xl font-extrabold text-primary mb-xs">Pembaruan Tokoh Terakhir</h2>
                <p class="text-on-surface-variant text-sm md:text-base">Berikut adalah nama-nama anggota keluarga raja yang baru saja ditambahkan ke dalam pangkalan data arsip.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                @foreach($recentUpdates as $ru)
                <div class="bento-card bg-white p-5 rounded-xl flex flex-col justify-between shadow-sm group">
                    <div class="space-y-2">
                        <span class="bg-secondary/10 text-secondary text-[10px] tracking-wider uppercase font-bold px-2.5 py-1 rounded inline-block">Terverifikasi</span>
                        <h3 class="text-lg font-bold text-primary group-hover:text-secondary transition-colors line-clamp-1">{{ $ru->nama_lengkap }}</h3>
                        <p class="text-on-surface-variant text-sm line-clamp-2">Status Pernikahan: {{ $ru->status_pernikahan ?? 'Belum Menikah' }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-outline-variant/60 mt-4 text-xs">
                        <span class="text-outline font-medium">
                            {{ $ru->created_at->diffForHumans() }}
                        </span>
                        <a class="text-secondary font-bold inline-flex items-center gap-1 hover:underline" href="{{ route('person.trah', $ru->id) }}">
                            Lihat Pohon &rarr;
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<footer class="w-full py-xl px-margin-mobile md:px-margin-desktop bg-primary text-white border-t-4 border-secondary">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-lg">
        <div>
            <div class="text-xl md:text-2xl font-bold mb-xs tracking-tight">Silsilah Keluarga Raja</div>
            <p class="opacity-70 text-sm max-w-md leading-relaxed">
                Pusat Data Genealogi Digital untuk pelestarian sejarah keturunan nusantara dan warisan agung leluhur.
            </p>
        </div>
        <div class="text-xs opacity-50 font-medium">
            &copy; 2026 Silsilah Keluarga Digital. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

</body>
</html>