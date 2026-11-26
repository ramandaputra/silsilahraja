<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ \App\Models\Setting::get('site_title', 'Silsilah Keluarga - Pusat Data Genealogi Digital') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
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
        /* Animasi Pop / Pulse saat Rolling Selesai */
        @keyframes counterPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }
        .counter-pulse {
            animation: counterPulse 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>
<body class="bg-background text-on-background font-sans antialiased overflow-x-hidden">

@include('public.partials.navbar')

<main class="pt-16 sm:pt-20">
    <!-- Hero Section dengan Gambar Latar Belakang Kustom Admin -->
    @php
        $bgImage = \App\Models\Setting::get('hero_background');
    @endphp
    <section class="relative w-full min-h-[440px] sm:min-h-[500px] flex flex-col items-center justify-center hero-gradient text-white overflow-hidden px-4 sm:px-margin-mobile md:px-margin-desktop py-10 sm:py-16"
             style="@if($bgImage) background-image: linear-gradient(135deg, rgba(0, 30, 64, 0.88) 0%, rgba(0, 89, 187, 0.85) 100%), url('{{ asset('storage/' . $bgImage) }}'); background-position: center; background-size: cover; background-repeat: no-repeat; @endif">
        
        <div class="relative z-10 text-center max-w-4xl w-full">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold mb-3 sm:mb-md leading-tight tracking-tight">
                {!! nl2br(e(\App\Models\Setting::get('hero_title', "Temukan Akar & \n Warisan Agung Keluarga Raja"))) !!}
            </h1>
            <p class="text-sm sm:text-base md:text-lg text-primary-fixed mb-6 sm:mb-xl opacity-90 max-w-2xl mx-auto leading-relaxed">
                {{ \App\Models\Setting::get('hero_subtitle', 'Arsip digital silsilah keturunan Kesultanan Riau-Lingga yang aman, terstruktur, dan terverifikasi.') }}
            </p>
            
            <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-2xl mx-auto group shadow-xl sm:shadow-2xl rounded-full">
                <div class="absolute inset-y-0 left-4 sm:left-6 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined text-xl sm:text-2xl">search</span>
                </div>
                <input name="search" class="w-full pl-11 sm:pl-16 pr-24 sm:pr-32 py-3 sm:py-4 bg-surface-container-lowest text-on-surface text-sm sm:text-base rounded-full border-none focus:ring-4 focus:ring-secondary/30 transition-all outline-none" placeholder="Cari Nama Keturunan..." type="text" value="{{ request('search') }}" autocomplete="off"/>
                <button type="submit" class="absolute inset-y-1.5 sm:inset-y-2 right-1.5 sm:right-2 px-4 sm:px-6 bg-secondary text-white rounded-full text-xs sm:text-sm font-semibold hover:bg-secondary-container active:scale-95 transition-all flex items-center justify-center">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <!-- Hasil Pencarian -->
    @if(request('search'))
    <section class="py-lg px-4 sm:px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-md">
            <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-primary flex items-center gap-2">
                <i class="fa-solid fa-square-poll-horizontal text-secondary"></i> 
                <span>Hasil Pencarian: "{{ request('search') }}"</span>
            </h3>
            @if(isset($results) && !$results->isEmpty())
                <span class="text-xs bg-secondary/10 text-secondary px-3 py-1 rounded-full font-semibold">
                    {{ count($results) }} tokoh ditemukan
                </span>
            @endif
        </div>

        @if(isset($results) && !$results->isEmpty())
            <div class="space-y-3">
                @foreach($results as $res)
                <a href="{{ route('person.detail', $res->id) }}" class="block p-4 sm:p-5 bg-white border border-outline-variant rounded-xl hover:border-secondary hover:shadow-md transition-all group">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <span class="font-bold text-on-surface text-base sm:text-lg group-hover:text-secondary transition-colors">
                                    {{ $res->nama_lengkap }}
                                    @if($res->has_duplicate_name && $res->nasab)
                                        <span class="text-secondary font-semibold">{{ $res->nasab }}</span>
                                    @elseif(!empty($res->gelar_pembeda))
                                        <span class="text-primary font-semibold">({{ $res->gelar_pembeda }})</span>
                                    @endif
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5 text-xs sm:text-sm text-on-surface-variant">
                                <div><span class="font-medium text-outline">Asal Lahir:</span> {{ $res->tempat_lahir ?? '-' }}</div>
                                <div><span class="font-medium text-outline">Jenis Kelamin:</span> 
                                    @if($res->jenis_kelamin == 'L')
                                        <span class="inline-flex items-center gap-1 font-medium"><i class="bi bi-gender-male text-secondary"></i> Laki-laki</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 font-medium"><i class="bi bi-gender-female text-rose-600"></i> Perempuan</span>
                                    @endif
                                </div>
                                <div><span class="font-medium text-outline">Nama Ayah:</span> {{ $res->father->nama_lengkap ?? '-' }}</div>
                                <div><span class="font-medium text-outline">Nama Ibu:</span> {{ $res->nama_ibu_non_raja ?? ($res->mother->nama_lengkap ?? '-') }}</div>
                            </div>
                        </div>
                        <span class="inline-flex items-center justify-center self-start sm:self-center px-4 py-2 bg-primary text-white text-xs font-semibold rounded-full shrink-0 transition-colors group-hover:bg-secondary min-h-[36px]">
                            Buka Profil &nbsp;&rarr;
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        @else
            <div class="p-8 bg-surface-container text-center rounded-xl text-on-surface-variant border border-outline-variant/50">
                <span class="material-symbols-outlined text-4xl text-outline mb-2 block">person_search</span>
                <p class="font-semibold text-primary mb-1">Tidak ada data keturunan dengan nama tersebut.</p>
                <p class="text-xs text-on-surface-variant">Coba gunakan kata kunci nama yang lebih umum atau periksa ejaan nama tokoh.</p>
            </div>
        @endif
    </section>
    @endif

    <!-- Sejarah Section -->
    <section class="py-10 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-gutter items-start mb-8 sm:mb-xl">
            <div class="md:col-span-7 space-y-md">
                <h2 class="text-xl sm:text-3xl md:text-4xl font-extrabold text-primary leading-tight">
                    {{ \App\Models\Setting::get('about_history_title', 'Sejarah & Warisan Agung Keluarga Raja') }}
                </h2>
                <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed text-justify">
                    {{ \App\Models\Setting::get('about_history_body_1', 'Perjalanan sejarah keluarga raja bukan sekadar silsilah nama, melainkan sebuah narasi agung tentang kepemimpinan dan identitas budaya.') }}
                </p>
            </div>
            <div class="md:col-span-5 md:sticky md:top-24">
                <div class="bg-surface-container-low p-5 sm:p-lg border border-outline-variant rounded-xl shadow-sm">
                    <h3 class="text-base sm:text-lg font-bold text-secondary mb-sm border-b border-outline-variant/60 pb-xs tracking-wide">Pilar Pelestarian</h3>
                    <ul class="space-y-sm">
                        <li class="flex gap-2 items-start text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary text-xl shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm sm:text-base">Sistem Kekerabatan Adat Melayu Riau</span>
                        </li>
                        <li class="flex gap-2 items-start text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary text-xl shrink-0 mt-0.5">check_circle</span>
                            <span class="text-sm sm:text-base">Visualisasi Garis Keturunan & Trah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Statistik Counter dengan Animasi Rolling -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-gutter mt-6 sm:mt-lg">
            <div class="p-6 sm:p-lg bg-surface-container border border-outline-variant rounded-xl shadow-sm flex flex-col justify-center items-center hover:border-secondary hover:shadow-md transition-all group cursor-pointer" onclick="rerollCounters()" title="Sentuh untuk memutar ulang animasi angka">
                <span class="rolling-counter block text-3xl sm:text-4xl font-black text-secondary mb-1 tabular-nums" data-target="{{ $totalNodes }}">{{ $totalNodes }}</span>
                <span class="text-xs font-bold text-on-surface-variant tracking-wider uppercase text-center group-hover:text-secondary transition-colors">Total Keturunan</span>
                <span class="text-[10px] text-outline mt-1 font-normal">(Sentuh kartu untuk memutar ulang)</span>
            </div>
            <div class="p-6 sm:p-lg bg-surface-container border border-outline-variant rounded-xl shadow-sm flex flex-col justify-center items-center hover:border-secondary hover:shadow-md transition-all group cursor-pointer" onclick="rerollCounters()" title="Sentuh untuk memutar ulang animasi angka">
                <span class="rolling-counter block text-3xl sm:text-4xl font-black text-secondary mb-1 tabular-nums" data-target="{{ $totalLeluhur }}">{{ $totalLeluhur }}</span>
                <span class="text-xs font-bold text-on-surface-variant tracking-wider uppercase text-center group-hover:text-secondary transition-colors">Leluhur Utama</span>
                <span class="text-[10px] text-outline mt-1 font-normal">(Sentuh kartu untuk memutar ulang)</span>
            </div>
        </div>
    </section>

    <!-- Pembaruan Terakhir (Reflow: 1 kol di ponsel, 2 kol di tablet, 3 kol di desktop) -->
    <section class="py-10 sm:py-xl bg-surface-container-low px-4 sm:px-margin-mobile md:px-margin-desktop border-t border-outline-variant/30">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6 sm:mb-lg">
                <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-primary mb-1">Pembaruan Tokoh Terakhir</h2>
                <p class="text-on-surface-variant text-xs sm:text-sm md:text-base">Daftar tokoh silsilah keluarga raja yang baru saja diperbarui dalam pangkalan data arsip.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-lg">
                @foreach($recentUpdates as $ru)
                <div class="bento-card bg-white p-5 rounded-xl flex flex-col justify-between shadow-sm group">
                    <div class="space-y-2">
                        <span class="bg-secondary/10 text-secondary text-[10px] tracking-wider uppercase font-bold px-2.5 py-1 rounded inline-block">Terverifikasi</span>
                        <h3 class="text-base sm:text-lg font-bold text-primary group-hover:text-secondary transition-colors line-clamp-1">{{ $ru->nama_lengkap }}</h3>
                        <p class="text-on-surface-variant text-xs sm:text-sm line-clamp-2">Status Pernikahan: {{ $ru->status_pernikahan ?? 'Belum Menikah' }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-outline-variant/60 mt-4 text-xs">
                        <span class="text-outline font-medium">
                            {{ $ru->created_at->diffForHumans() }}
                        </span>
                        <a class="text-secondary font-bold inline-flex items-center gap-1 hover:underline py-1" href="{{ route('person.trah', $ru->id) }}">
                            <span>Lihat Pohon</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<footer class="w-full py-8 sm:py-xl px-4 sm:px-margin-mobile md:px-margin-desktop bg-primary text-white border-t-4 border-secondary">
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
    function setupRollingCounters() {
        const counters = document.querySelectorAll('.rolling-counter');
        if (!counters.length) return;

        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'), 10) || 0;
            // Durasi: untuk angka satuan (4) 800ms, untuk puluhan/ratusan 1200ms
            const duration = target < 10 ? 800 : 1200;
            const startTime = performance.now();
            el.classList.remove('counter-pulse');

            function step(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // easeOutExpo: berputar cepat di awal lalu melambat halus tepat di target
                const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                const current = Math.floor(target * ease);

                el.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = target;
                    el.classList.add('counter-pulse');
                }
            }

            requestAnimationFrame(step);
        }

        // Jalankan saat elemen masuk viewport
        let hasAnimated = false;
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasAnimated) {
                        hasAnimated = true;
                        counters.forEach(c => animateCounter(c));
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.2 });

            counters.forEach(c => observer.observe(c));
        } else {
            counters.forEach(c => animateCounter(c));
        }

        // Pengunjung bisa klik kartu untuk memutar ulang animasi
        window.rerollCounters = function() {
            counters.forEach(c => animateCounter(c));
        };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupRollingCounters);
    } else {
        setupRollingCounters();
    }
</script>

</body>
</html>