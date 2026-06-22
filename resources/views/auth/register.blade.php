<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Akun Baru - Silsilah Keluarga</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "outline": "#737780", "on-primary": "#ffffff", "secondary": "#0059bb",
                "on-secondary-fixed-variant": "#004493", "on-primary-fixed": "#001b3c", "background": "#fbf9f8",
                "secondary-container": "#0070ea", "on-background": "#1b1c1c", "on-surface-variant": "#43474f",
                "on-surface": "#1b1c1c", "surface-container-low": "#f5f3f3", "surface-container-lowest": "#ffffff",
                "secondary-fixed-dim": "#adc7ff", "primary-container": "#003366", "on-tertiary-fixed-variant": "#3e4853",
                "on-error-container": "#93000a", "inverse-primary": "#a7c8ff", "tertiary": "#151f29",
                "primary-fixed-dim": "#a7c8ff", "surface-container-high": "#eae8e7", "on-secondary-fixed": "#001a41",
                "inverse-on-surface": "#f2f0f0", "tertiary-fixed": "#d9e3f2", "outline-variant": "#c3c6d1",
                "surface-dim": "#dbd9d9", "on-tertiary-container": "#929caa", "error-container": "#ffdad6",
                "surface-bright": "#fbf9f8", "primary-fixed": "#d5e3ff", "on-primary-container": "#799dd6",
                "on-secondary": "#ffffff", "on-secondary-container": "#fefcff", "on-tertiary": "#ffffff",
                "on-primary-fixed-variant": "#1f477b", "surface-container-highest": "#e4e2e2", "error": "#ba1a1a",
                "on-tertiary-fixed": "#131c27", "tertiary-container": "#2a343f", "on-error": "#ffffff",
                "surface-container": "#efeded", "surface": "#fbf9f8", "secondary-fixed": "#d8e2ff",
                "primary": "#001e40", "tertiary-fixed-dim": "#bdc7d6", "surface-variant": "#e4e2e2",
                "surface-tint": "#3a5f94", "inverse-surface": "#303030"
            },
            "borderRadius": { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
            "spacing": { "base": "4px", "xs": "8px", "xl": "48px", "sm": "16px", "md": "24px", "lg": "32px", "gutter": "20px", "margin-mobile": "16px", "margin-desktop": "40px" },
            "fontFamily": { "display-lg": ["Montserrat"], "headline-lg-mobile": ["Montserrat"], "headline-md": ["Montserrat"], "body-lg": ["Inter"], "body-md": ["Inter"], "title-lg": ["Inter"], "headline-lg": ["Montserrat"], "label-md": ["Inter"], "data-table": ["Inter"] }
          }
        }
      }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        .bento-card { border: 1px solid #E1E4E8; transition: all 0.2s ease-in-out; }
        .bento-card:hover { box-shadow: 0 12px 24px -4px rgba(0, 51, 102, 0.08); }
        .bg-institutional { background: linear-gradient(135deg, #001e40 0%, #003366 100%); }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface min-h-screen flex flex-col">

<main class="flex-grow flex flex-col md:flex-row">
    
    <section class="hidden md:flex md:w-1/2 lg:w-3/5 bg-institutional relative overflow-hidden items-center justify-center p-xl">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://www.transparenttextures.com/patterns/black-thread.png')"></div>
        </div>
        <div class="relative z-10 text-center space-y-md max-w-lg">
            <div class="inline-flex items-center justify-center p-sm bg-white/10 backdrop-blur-md rounded-xl mb-md">
                <span class="material-symbols-outlined text-[48px] text-on-primary">account_tree</span>
            </div>
            <h1 class="font-headline-lg text-headline-lg text-on-primary font-bold">Silsilah Keluarga</h1>
            <p class="font-title-lg text-title-lg text-on-primary/80">Pusat Data Genealogi Digital</p>
            <div class="pt-lg border-t border-on-primary/20">
                <p class="font-body-md text-body-md text-on-primary/60 leading-relaxed italic">
                    "Menjaga warisan, menghubungkan generasi, dan mendokumentasikan sejarah keluarga dalam integritas data digital yang aman."
                </p>
            </div>
        </div>
    </section>

    <section class="flex-grow flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface">
        <div class="w-full max-w-md space-y-md py-md">
            
            <div class="md:hidden flex flex-col items-center mb-md space-y-xs">
                <span class="material-symbols-outlined text-primary text-[40px]">account_tree</span>
                <h2 class="font-headline-md text-headline-md text-primary font-bold">Silsilah Keluarga</h2>
            </div>

            <header class="space-y-xs">
                <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Daftar Akun Admin</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Bergabunglah dalam jaringan pelestarian sejarah trah keluarga Anda.</p>
            </header>

            <div class="bento-card bg-surface-container-lowest p-lg rounded-xl">
                <form method="POST" action="{{ route('register') }}" class="space-y-sm">
                    @csrf

                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant block" for="name">Nama Lengkap</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-outline text-[20px]">person</span>
                            <input class="w-full pl-[44px] pr-sm py-2 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none transition-all font-body-md text-body-md" 
                                id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Raden Mas Dananjaya" required autofocus autocomplete="name" />
                        </div>
                        @if($errors->has('name'))
                            <p class="text-xs text-error mt-1 font-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant block" for="email">Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                            <input class="w-full pl-[44px] pr-sm py-2 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none transition-all font-body-md text-body-md" 
                                id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autocomplete="username" />
                        </div>
                        @if($errors->has('email'))
                            <p class="text-xs text-error mt-1 font-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant block" for="password">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                            <input class="w-full pl-[44px] pr-sm py-2 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none transition-all font-body-md text-body-md" 
                                id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                        @if($errors->has('password'))
                            <p class="text-xs text-error mt-1 font-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <div class="space-y-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant block" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-outline text-[20px]">lock_reset</span>
                            <input class="w-full pl-[44px] pr-sm py-2 rounded-lg border border-outline-variant focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none transition-all font-body-md text-body-md" 
                                id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                        @if($errors->has('password_confirmation'))
                            <p class="text-xs text-error mt-1 font-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <div class="flex items-start gap-sm pt-xs">
                        <div class="flex items-center h-5">
                            <input class="w-4 h-4 text-secondary border-outline-variant rounded focus:ring-secondary focus:ring-offset-0 cursor-pointer" id="terms" type="checkbox" required />
                        </div>
                        <label class="font-body-md text-[13px] text-on-surface-variant select-none cursor-pointer" for="terms">
                            Saya menyetujui <a class="text-secondary hover:underline font-semibold" href="#">Syarat & Ketentuan</a> platform.
                        </label>
                    </div>

                    <button class="w-full bg-primary text-on-primary py-sm rounded-lg font-headline-md text-headline-md hover:bg-secondary transition-colors flex items-center justify-center gap-xs mt-md shadow-sm" type="submit">
                        <span>Daftar Sekarang</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>
            </div>

            <footer class="text-center space-y-md">
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Sudah punya akun? 
                    <a class="text-secondary font-bold hover:underline" href="{{ route('login') }}">Masuk</a>
                </p>
                <div class="pt-sm border-t border-surface-container-high flex flex-wrap justify-center gap-md">
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="#">Bantuan</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary" href="#">Kebijakan Privasi</a>
                </div>
            </footer>
        </div>
    </section>
</main>

<footer class="w-full py-md px-margin-desktop bg-primary flex flex-col md:flex-row justify-between items-center gap-sm">
    <p class="font-body-md text-body-md text-on-primary/80">© 2026 Silsilah Keluarga (Royal Edition) - Pusat Data Genealogi Digital</p>
    <div class="flex gap-md">
        <a class="font-label-md text-label-md text-on-primary/80 hover:text-on-primary transition-colors hover:underline" href="/">Beranda</a>
        <a class="font-label-md text-label-md text-on-primary/80 hover:text-on-primary transition-colors hover:underline" href="#">Arsip Digital</a>
    </div>
</footer>

<script>
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('mousedown', function() { this.style.transform = 'scale(0.98)'; });
        button.addEventListener('mouseup', function() { this.style.transform = 'scale(1)'; });
        button.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; });
    });
</script>
</body>
</html>