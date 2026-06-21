<x-guest-layout>
    <h4 class="fw-bold text-center mb-3">Daftar Akun Admin</h4>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a class="text-sm text-secondary text-decoration-none" href="{{ route('login') }}">
                Sudah punya akun?
            </a>
            <button type="submit" class="btn btn-primary">
                Daftar
            </button>
        </div>
    </form>
</x-guest-layout>