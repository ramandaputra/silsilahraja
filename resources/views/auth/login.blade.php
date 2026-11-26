<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Silsilah Raja Institutional Archive</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1e293b;
            overflow-x: hidden;
            position: relative;
            padding: 20px;
        }

        /* Elemen Dekorasi Cahaya Blur */
        .decoration-circle-1, .decoration-circle-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .decoration-circle-1 {
            width: 320px;
            height: 320px;
            top: -80px;
            left: -80px;
            background: rgba(0, 51, 102, 0.12);
        }
        .decoration-circle-2 {
            width: 280px;
            height: 280px;
            bottom: -60px;
            right: -60px;
            background: rgba(0, 112, 234, 0.14);
        }

        /* Container Login Minimalis */
        .login-container {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 30, 64, 0.10), 0 5px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            width: 100%;
            max-width: 420px;
            text-align: center;
            position: relative;
            z-index: 1;
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-container.animate-in {
            opacity: 1;
            transform: scale(1);
        }

        /* Logo Emblem */
        .logo-wrapper {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #f0f6ff;
            border: 1px solid #cce3ff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 51, 102, 0.08);
            transition: transform 0.3s ease;
        }

        .logo-wrapper:hover {
            transform: scale(1.05);
        }

        .logo-wrapper img {
            width: 48px;
            height: 48px;
        }

        .login-container h2 {
            margin-bottom: 6px;
            color: #001e40;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .login-container p.subtitle {
            margin-bottom: 26px;
            color: #64748b;
            font-size: 13px;
            font-weight: 400;
        }

        /* Input Group */
        .input-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
        }

        .input-group input[type="text"],
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 13px 45px 13px 48px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14.5px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            background-color: #ffffff;
            color: #1e293b;
        }

        .input-group input:focus {
            border-color: #0070ea;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 112, 234, 0.15);
        }

        /* Ikon Input */
        .input-group .icon,
        .input-group .toggle-password {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 20px;
            z-index: 5;
            user-select: none;
        }

        .input-group .icon {
            left: 15px;
        }

        .input-group .toggle-password {
            right: 15px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .input-group .toggle-password:hover {
            color: #001e40;
        }

        /* Sembunyikan ikon mata bawaan browser */
        input[type="password"]::-webkit-password-revelation-button {
            -webkit-appearance: none;
            appearance: none;
            display: none;
        }
        input[type="password"]::-ms-reveal {
            display: none;
        }

        /* Opsi Form (Ingat Saya & Lupa Sandi) */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            font-size: 12.5px;
            color: #64748b;
        }

        .form-options label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            user-select: none;
        }

        .form-options input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #003366;
            cursor: pointer;
        }

        .form-options a {
            color: #0059bb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .form-options a:hover {
            text-decoration: underline;
            color: #001e40;
        }

        /* Tombol Login */
        button[type="submit"] {
            background: linear-gradient(135deg, #003366 0%, #0059bb 100%);
            color: #ffffff;
            padding: 13px 28px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            width: 100%;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 14px rgba(0, 51, 102, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, #001e40 0%, #003366 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 51, 102, 0.35);
        }

        button[type="submit"]:active {
            transform: scale(0.98);
        }

        /* Alert Status & Error */
        .status-message {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
        }

        .error-message {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-top: 18px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .field-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            padding-left: 2px;
        }

        /* Link Bawah */
        .register-link {
            margin-top: 22px;
            font-size: 13px;
            color: #64748b;
        }

        .register-link a {
            color: #0059bb;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-link {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #001e40;
        }

        .back-link a .material-symbols-outlined {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="decoration-circle-1"></div>
    <div class="decoration-circle-2"></div>

    <div class="login-container" id="loginContainer">
        
        <div class="logo-wrapper">
            <img src="{{ asset('favicon.svg') }}" alt="Logo Silsilah Raja">
        </div>

        <h2>Silsilah Raja</h2>
        <p class="subtitle">Pusat Data Genealogi Kesultanan Riau - Lingga</p>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Input Email / Pengguna -->
            <div class="input-group">
                <span class="material-symbols-outlined icon">person</span>
                <input 
                    type="email" 
                    id="namauser" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Alamat Email Pengguna" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
                @if($errors->has('email'))
                    <div class="field-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <!-- Input Kata Sandi -->
            <div class="input-group">
                <span class="material-symbols-outlined icon">lock</span>
                <input 
                    type="password" 
                    id="passworduser" 
                    name="password" 
                    placeholder="Kata Sandi" 
                    required 
                    autocomplete="current-password"
                >
                <span class="material-symbols-outlined toggle-password" id="togglePassword" title="Lihat/Sembunyikan Sandi">visibility</span>
                @if($errors->has('password'))
                    <div class="field-error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <!-- Opsi Ingat Saya & Lupa Sandi -->
            <div class="form-options">
                <label for="remember_me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <span>Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa Sandi?</a>
                @endif
            </div>

            <button type="submit">
                <span>Masuk Aplikasi</span>
                <span class="material-symbols-outlined" style="font-size: 19px;">login</span>
            </button>

            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="error-message">
                    <span class="material-symbols-outlined" style="font-size: 18px;">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif
        </form>

        @if (Route::has('register'))
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('home') }}">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Kembali ke Beranda Silsilah</span>
            </a>
        </div>

    </div>

    <script>
        // Fitur Toggle Password (Lihat / Sembunyikan Kata Sandi)
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passworduser');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.textContent = (type === 'password') ? 'visibility' : 'visibility_off';
        });

        // Animasi Masuk Halus (Smooth Entrance Animation)
        const loginContainer = document.querySelector('#loginContainer');
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                loginContainer.classList.add('animate-in');
            }, 100);
        });
    </script>
</body>
</html>
