<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Silsilah Keluarga</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#bdc7d6",
                        "on-surface-variant": "#43474f",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#151f29",
                        "on-error-container": "#93000a",
                        "surface-bright": "#fbf9f8",
                        "on-secondary-fixed": "#001a41",
                        "on-primary-fixed-variant": "#1f477b",
                        "surface-container-highest": "#e4e2e2",
                        "on-surface": "#1b1c1c",
                        "primary-fixed": "#d5e3ff",
                        "background": "#fbf9f8",
                        "secondary": "#0059bb",
                        "surface-dim": "#dbd9d9",
                        "on-secondary-fixed-variant": "#004493",
                        "on-tertiary-fixed": "#131c27",
                        "on-primary-fixed": "#001b3c",
                        "secondary-fixed-dim": "#adc7ff",
                        "secondary-container": "#0070ea",
                        "surface-container": "#efeded",
                        "on-tertiary-fixed-variant": "#3e4853",
                        "inverse-primary": "#a7c8ff",
                        "surface-container-high": "#eae8e7",
                        "on-primary-container": "#799dd6",
                        "on-error": "#ffffff",
                        "primary": "#001e40",
                        "on-secondary": "#ffffff",
                        "primary-container": "#003366",
                        "inverse-surface": "#303030",
                        "tertiary-container": "#2a343f",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#929caa",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-primary": "#ffffff",
                        "surface-tint": "#3a5f94",
                        "tertiary-fixed": "#d9e3f2",
                        "surface-container-low": "#f5f3f3",
                        "surface": "#fbf9f8",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#f2f0f0",
                        "outline-variant": "#c3c6d1",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed": "#d8e2ff",
                        "on-background": "#1b1c1c",
                        "on-secondary-container": "#fefcff",
                        "outline": "#737780"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "20px",
                        "base": "4px",
                        "xs": "8px",
                        "margin-desktop": "40px",
                        "margin-mobile": "16px",
                        "md": "24px",
                        "xl": "48px",
                        "sm": "16px",
                        "lg": "32px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Montserrat"],
                        "data-table": ["Inter"],
                        "headline-md": ["Montserrat"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "display-lg": ["Montserrat"],
                        "body-lg": ["Inter"],
                        "title-lg": ["Inter"]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .bento-card { background: #ffffff; border: 1px solid #E1E4E8; border-radius: 8px; transition: all 0.2s ease-in-out; }
        .bento-card:hover { box-shadow: 0 12px 12px rgba(0, 51, 102, 0.08); transform: translateY(-2px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #003366; border-radius: 10px; }
    </style>
</head>
<body class="bg-background font-body-md text-on-surface flex overflow-hidden h-screen">

    <aside class="hidden md:flex flex-col p-md gap-xs bg-surface-container dark:bg-tertiary h-screen w-64 left-0 top-0 border-r border-outline-variant dark:border-on-tertiary-container z-40 fixed">
        <div class="mb-lg px-xs">
            <h1 class="font-headline-md text-[20px] font-black text-primary">Silsilah Keluarga</h1>
            <div class="mt-md flex items-center gap-sm">
                <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-white font-bold uppercase text-xs">
                    {{ Str::substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="font-headline-md text-[14px] font-bold text-primary">Pusat Kendali Admin</p>
                    <p class="font-label-md text-label-md text-on-surface-variant truncate max-w-[140px]">{{ auth()->user()->name ?? 'Administrator' }}</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 flex flex-col gap-xs">
            <a class="flex items-center gap-sm px-md py-sm {{ request()->is('admin/dashboard') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="/admin/dashboard">
                <span class="material-symbols-outlined" style="{{ request()->is('admin/dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-sm px-md py-sm {{ request()->is('admin/people*') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="{{ route('admin.people.index') }}">
                <span class="material-symbols-outlined" style="{{ request()->is('admin/people*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">groups</span>
                <span class="font-label-md text-label-md">Data Anggota</span>
            </a>
        </nav>

        <div class="mt-auto">
            <a href="{{ route('admin.people.create') }}" class="w-full bg-secondary text-on-secondary py-sm rounded-xl font-bold flex items-center justify-center gap-xs hover:opacity-90 active:scale-95 transition-all shadow-xl text-center text-xs">
                <span class="material-symbols-outlined">add</span>
                <span class="font-label-md">Tambah Data Baru</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 md:ml-64 overflow-y-auto h-screen bg-surface-bright custom-scrollbar flex flex-col justify-between">
        <div class="w-full flex-1">
            <header class="sticky top-0 z-30 flex items-center justify-between px-margin-desktop py-md bg-surface/80 backdrop-blur-md border-b-2 border-primary">
                <div>
                    <h2 class="font-headline-md text-[20px] font-bold text-primary">@yield('page-title', 'Pusat Kendali')</h2>
                    <span class="inline-flex items-center px-xs py-0.5 rounded-full bg-primary-container text-on-primary-container text-[11px] font-bold uppercase tracking-wider mt-xs">Otoritas Tunggal</span>
                </div>
                <div class="flex items-center gap-md">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-error font-semibold hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">logout</span> Keluar
                        </button>
                    </form>
                    <div class="h-8 w-px bg-outline-variant"></div>
                    <div class="flex items-center gap-xs text-on-surface-variant">
                        <span class="font-label-md text-label-md">{{ Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
                        <span class="material-symbols-outlined text-primary">calendar_today</span>
                    </div>
                </div>
            </header>

            <div class="p-margin-desktop">
                {{ $slot }}
            </div>
        </div>

        <footer class="w-full py-xl px-margin-desktop grid grid-cols-1 md:grid-cols-2 justify-between items-center bg-primary text-on-primary mt-auto">
            <div>
                <h4 class="font-headline-md text-[16px] font-bold mb-xs">Silsilah Keluarga</h4>
                <p class="font-body-md text-[13px] text-on-primary/80">© {{ date('Y') }} Silsilah Keluarga (PDDIKTI Style) - Pusat Data Genealogi Digital</p>
            </div>
            <div class="flex md:justify-end gap-lg mt-md md:mt-0 text-[13px]">
                <span class="font-label-md text-secondary bg-secondary-fixed px-xs py-0.5 rounded-full font-bold">Status: Admin Aktif</span>
            </div>
        </footer>
    </main>

</body>
</html>