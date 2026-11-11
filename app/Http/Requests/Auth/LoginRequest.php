<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = $this->string('email');
        $inputPassword = $this->string('password');

        // Otomatis perbaiki jika ada password di database yang masih plain-text atau hash MD5 lama (misal '526e34d04735124f05a090181f3e6e8a')
        $user = User::where('email', $email)->first();
        if ($user && !empty($user->password)) {
            $info = password_get_info($user->password);
            if ($info['algoName'] !== 'bcrypt') {
                $isMatch = false;

                // 1. Cek jika password di DB masih berupa teks biasa
                if ($user->password === (string) $inputPassword) {
                    $isMatch = true;
                }
                // 2. Cek jika password di DB berupa hash MD5 (32 hex characters)
                elseif (strlen($user->password) === 32 && ctype_xdigit($user->password)) {
                    if (md5((string) $inputPassword) === strtolower($user->password)) {
                        $isMatch = true;
                    }
                }

                // Jika cocok, update langsung di DB ke Bcrypt yang valid
                if ($isMatch) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['password' => Hash::make($inputPassword)]);
                }
            }
        }

        try {
            if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        } catch (\RuntimeException $e) {
            // Tangani jika format hash di DB rusak atau bukan Bcrypt agar tidak memicu 500 error
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Format kata sandi akun tidak valid di sistem. Silakan periksa kembali atau reset kata sandi.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
