<header class="fixed top-0 left-0 w-full z-50 bg-surface/90 backdrop-blur-md border-b border-primary/20 transition-all no-print">
    <nav class="max-w-7xl mx-auto flex justify-between items-center px-4 sm:px-6 md:px-margin-desktop h-20">
        <!-- Logo / Brand Link -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 group transition-transform active:scale-98">
            <span class="material-symbols-outlined text-primary text-3xl group-hover:text-secondary transition-colors">account_tree</span>
            <span class="text-xl md:text-2xl font-bold text-primary tracking-tight group-hover:text-secondary transition-colors">Silsilah Keluarga</span>
        </a>

        <!-- Desktop Navigation Tabs -->
        <div class="hidden md:flex items-center gap-6 lg:gap-8">
            <a class="text-sm tracking-wide transition-all duration-200 {{ request()->routeIs('home') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary font-medium' }}" href="{{ route('home') }}">
                Beranda
            </a>
            <a class="text-sm tracking-wide transition-all duration-200 {{ request()->routeIs('relation.*') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary font-medium' }}" href="{{ route('relation.index') }}">
                Cari Relasi
            </a>
            <a class="text-sm tracking-wide transition-all duration-200 {{ request()->routeIs('about') ? 'text-secondary border-b-2 border-secondary pb-1 font-bold' : 'text-on-surface-variant hover:text-secondary font-medium' }}" href="{{ route('about') }}">
                Tentang Kami
            </a>
        </div>

        <!-- Right Side Actions & Mobile Menu Toggle -->
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="material-symbols-outlined text-primary p-2 hover:bg-surface-container-highest rounded-full transition-all text-2xl" title="{{ auth()->check() ? 'Panel Admin' : 'Login / Akun' }}">account_circle</a>

            <!-- Tombol Toggle Menu Mobile -->
            <button type="button" onclick="togglePublicMobileMenu()" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-primary hover:bg-surface-container-high border border-outline-variant/60 active:scale-95 transition-all" aria-label="Buka Menu" id="public-menu-btn">
                <span class="material-symbols-outlined text-2xl" id="public-menu-icon">menu</span>
            </button>
        </div>
    </nav>

    <!-- Dropdown Menu Mobile -->
    <div id="public-mobile-menu" class="hidden md:hidden border-t border-outline-variant/50 bg-surface/98 backdrop-blur-md px-4 py-3 space-y-1 shadow-lg transition-all">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('home') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-xl">home</span>
            <span>Beranda</span>
        </a>
        <a href="{{ route('relation.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('relation.*') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-xl">device_hub</span>
            <span>Cari Relasi</span>
        </a>
        <a href="{{ route('about') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('about') ? 'bg-primary-container text-on-primary-container font-bold' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
            <span class="material-symbols-outlined text-xl">info</span>
            <span>Tentang Kami</span>
        </a>
        <div class="h-px bg-outline-variant/40 my-2"></div>
        <a href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold text-primary hover:bg-surface-container-high transition-all">
            <span class="material-symbols-outlined text-xl">account_circle</span>
            <span>{{ auth()->check() ? 'Panel Admin' : 'Login / Akun' }}</span>
        </a>
    </div>
</header>

<script>
    function togglePublicMobileMenu() {
        const menu = document.getElementById('public-mobile-menu');
        const icon = document.getElementById('public-menu-icon');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.innerText = 'close';
        } else {
            menu.classList.add('hidden');
            icon.innerText = 'menu';
        }
    }
</script>
