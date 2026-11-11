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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
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

    <aside id="admin-sidebar" class="hidden md:flex flex-col p-4 md:p-md gap-xs bg-surface-container dark:bg-tertiary h-screen w-64 left-0 top-0 border-r border-outline-variant dark:border-on-tertiary-container z-40 fixed overflow-y-auto custom-scrollbar">
        <div class="mb-4 md:mb-lg px-xs flex items-center justify-between">
            <div class="min-w-0">
                <h1 class="font-headline-md text-lg md:text-[20px] font-black text-primary truncate">Silsilah Keluarga</h1>
                <div class="mt-2 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-white font-bold uppercase text-xs shrink-0">
                        {{ Str::substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-headline-md text-xs font-bold text-primary">Pusat Kendali</p>
                        <p class="font-label-md text-[11px] text-on-surface-variant truncate max-w-[130px]">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    </div>
                </div>
            </div>
            <!-- Tombol Tutup Sidebar Khusus Mobile -->
            <button type="button" onclick="toggleSidebar()" class="md:hidden p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-primary transition-colors" title="Tutup Menu">
                <span class="material-symbols-outlined text-[22px]">close</span>
            </button>
        </div>
        
        <nav class="flex-1 flex flex-col gap-1">
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->is('admin/dashboard') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="/admin/dashboard">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->is('admin/dashboard') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">dashboard</span>
                <span class="font-label-md text-xs md:text-sm">Dashboard</span>
            </a>
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->is('admin/people*') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="{{ route('admin.people.index') }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->is('admin/people*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">groups</span>
                <span class="font-label-md text-xs md:text-sm">Data Anggota</span>
            </a>
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" href="{{ route('admin.settings.index') }}" 
            class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('admin.settings.*') ? 'bg-secondary text-white font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined text-[20px] shrink-0" style="{{ request()->routeIs('admin.settings.*') ? 'font-variation-settings: \'FILL\' 1; color: white;' : '' }}">settings</span>
                <span class="font-label-md text-xs md:text-sm">Pengaturan Aplikasi</span>
            </a>
            @if(auth()->check() && auth()->user()->role === 'superadmin')
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->is('admin/users*') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="{{ route('admin.users.index') }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->is('admin/users*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">manage_accounts</span>
                <span class="font-label-md text-xs md:text-sm">Kelola Pengguna</span>
            </a>
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" class="flex items-center gap-2.5 px-3 py-2.5 {{ request()->is('admin/logs*') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }} rounded-xl transition-all" href="{{ route('admin.logs.index') }}">
                <span class="material-symbols-outlined text-[20px]" style="{{ request()->is('admin/logs*') ? 'font-variation-settings: \'FILL\' 1;' : '' }}">history</span>
                <span class="font-label-md text-xs md:text-sm">Log Aktivitas</span>
            </a>
            @endif
            
            <div class="h-px bg-outline-variant/40 my-1"></div>
            
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 text-on-surface-variant hover:text-primary hover:bg-surface-container-high rounded-xl transition-all" title="Buka Halaman Depan">
                <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                <span class="font-label-md text-xs md:text-sm">Lihat Website</span>
            </a>
        </nav>

        <div class="mt-auto pt-3">
            <a onclick="if(window.innerWidth < 768) toggleSidebar()" href="{{ route('admin.people.create') }}" class="w-full bg-primary hover:bg-secondary text-white py-2.5 rounded-xl font-bold flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-md text-center text-xs">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span class="font-label-md">Tambah Data Baru</span>
            </a>
        </div>
    </aside>

    <!-- Overlay Backdrop Sidebar Mobile -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden backdrop-blur-xs transition-opacity"></div>

    <main class="flex-1 md:ml-64 overflow-y-auto h-screen bg-surface-bright custom-scrollbar flex flex-col justify-between">
        <div class="w-full flex-1">
            <header class="sticky top-0 z-30 flex items-center justify-between px-3 sm:px-6 md:px-8 py-3 bg-surface/90 backdrop-blur-md border-b-2 border-primary">
                <div class="flex items-center gap-2 min-w-0">
                    <!-- Tombol Toggle Sidebar Mobile -->
                    <button type="button" onclick="toggleSidebar()" class="md:hidden inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary border border-outline-variant/60 shadow-xs active:scale-95 transition-all shrink-0" title="Menu Navigasi">
                        <span class="material-symbols-outlined text-[20px]">menu</span>
                    </button>
                    <div class="min-w-0">
                        <h2 class="font-headline-md text-sm sm:text-base md:text-[18px] font-bold text-primary truncate">{{ $page_title ?? (${'page-title'} ?? ($__data['page-title'] ?? (View::yieldContent('page-title') ?: 'Pusat Kendali'))) }}</h2>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container text-[10px] sm:text-[11px] font-bold uppercase tracking-wider">
                            {{ auth()->user()?->role === 'superadmin' ? 'Superadmin' : 'Admin' }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-error font-semibold hover:underline flex items-center gap-1 p-1" title="Keluar">
                            <span class="material-symbols-outlined text-sm">logout</span> <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                    <div class="hidden lg:block h-6 w-px bg-outline-variant"></div>
                    <div class="hidden lg:flex items-center gap-1.5 text-on-surface-variant text-xs">
                        <span class="material-symbols-outlined text-primary text-[16px]">calendar_today</span>
                        <span>{{ Carbon\Carbon::now()->isoFormat('D MMM Y') }}</span>
                    </div>
                </div>
            </header>

            <div class="p-3 sm:p-5 md:p-8">
                {{ $slot }}
            </div>
        </div>

        <footer class="w-full py-4 sm:py-6 px-4 sm:px-6 md:px-8 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-4 bg-primary text-on-primary mt-auto text-center sm:text-left">
            <div>
                <h4 class="font-headline-md text-sm font-bold">Silsilah Keluarga</h4>
                <p class="font-body-md text-xs text-on-primary/80">© {{ date('Y') }} Silsilah Keluarga - Pusat Data Genealogi Digital</p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="font-label-md text-secondary bg-secondary-fixed px-2.5 py-0.5 rounded-full font-bold">Status: {{ auth()->user()?->role === 'superadmin' ? 'Superadmin Aktif' : 'Admin Aktif' }}</span>
            </div>
        </footer>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex', 'z-50');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex', 'z-50');
                backdrop.classList.add('hidden');
            }
        }
    </script>
</body>
</html>