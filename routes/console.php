<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:reset-password {email=admin@gmail.com} {password=password123}', function ($email, $password) {
    $user = User::where('email', $email)->first();
    if (!$user) {
        $this->error("Pengguna dengan email [{$email}] tidak ditemukan di database.");
        return 1;
    }

    DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => Hash::make($password)]);

    $this->info("Berhasil! Kata sandi untuk [{$email}] telah di-update dengan hash Bcrypt.");
    $this->comment("Password baru: {$password}");
    return 0;
})->purpose('Reset password pengguna ke format Bcrypt yang valid');

Artisan::command('users:fix-passwords', function () {
    $users = DB::table('users')->get();
    $fixedCount = 0;

    foreach ($users as $u) {
        $info = password_get_info($u->password);
        if ($info['algoName'] !== 'bcrypt') {
            $rawPass = $u->password;
            // Deteksi jika berupa hash MD5 untuk kata 'raja'
            if (strtolower($u->password) === '526e34d04735124f05a090181f3e6e8a') {
                $rawPass = 'raja';
            }
            $newHash = Hash::make($rawPass);
            DB::table('users')
                ->where('id', $u->id)
                ->update(['password' => $newHash]);
            $this->info("Memperbaiki password untuk user [{$u->email}] ke format Bcrypt.");
            $fixedCount++;
        }
    }

    if ($fixedCount === 0) {
        $this->info("Semua password pengguna di database sudah menggunakan algoritma Bcrypt yang valid.");
    } else {
        $this->info("Selesai! Sebanyak {$fixedCount} password akun berhasil diperbaiki ke format Bcrypt.");
    }
    return 0;
})->purpose('Memperbaiki password plain-text semua pengguna di database ke format Bcrypt');

Artisan::command('users:set-role {email} {role}', function ($email, $role) {
    if (!in_array($role, ['superadmin', 'admin'])) {
        $this->error("Role tidak valid. Hanya boleh 'superadmin' atau 'admin'.");
        return 1;
    }

    $user = DB::table('users')->where('email', $email)->first();
    if (!$user) {
        $this->error("Pengguna dengan email [{$email}] tidak ditemukan.");
        return 1;
    }

    DB::table('users')->where('id', $user->id)->update(['role' => $role]);
    $this->info("Berhasil! Role untuk [{$user->name}] ({$email}) diubah menjadi '{$role}'.");
    return 0;
})->purpose('Mengubah role pengguna secara manual');

Artisan::command('users:list', function () {

    $users = DB::table('users')->get(['id', 'name', 'email', 'role']);
    foreach ($users as $u) {
        $this->line("ID: {$u->id} | Name: {$u->name} | Email: {$u->email} | Role: {$u->role}");
    }
})->purpose('Menampilkan seluruh data pengguna beserta rolenya');

Artisan::command('roles:sync', function () {

    // 1. Ubah role 'admin' lama menjadi 'superadmin' jika belum ada superadmin
    $hasSuperadmin = DB::table('users')->where('role', 'superadmin')->exists();
    if (!$hasSuperadmin) {
        $oldAdmin = DB::table('users')->where('role', 'admin')->first()
            ?? DB::table('users')->orderBy('id', 'asc')->first();
        if ($oldAdmin) {
            DB::table('users')->where('id', $oldAdmin->id)->update(['role' => 'superadmin']);
            $this->info("Pengguna [{$oldAdmin->email}] berhasil diangkat menjadi 'superadmin'.");
        }
    }

    // 2. Ubah semua role 'operator' dan 'admin' tambahan menjadi 'admin'
    $adminCount = DB::table('users')->where('role', 'superadmin')->count();
    $opUpdated = DB::table('users')->where('role', 'operator')->update(['role' => 'admin']);
    if ($opUpdated > 0) {
        $this->info("Sebanyak {$opUpdated} akun dengan role 'operator' telah dialihkan menjadi 'admin'.");
    }

    // 3. Pastikan role lain yang tidak dikenal disesuaikan menjadi 'admin'
    DB::table('users')->whereNotIn('role', ['superadmin', 'admin'])->update(['role' => 'admin']);

    $this->info("Sinkronisasi selesai! Sistem kini hanya menggunakan 2 role: 'superadmin' dan 'admin'.");
    return 0;
})->purpose('Sinkronisasi role pengguna ke sistem 2 role: superadmin dan admin');

Artisan::command('logs:seed', function () {
    $superadmin = \App\Models\User::where('role', 'superadmin')->first();
    \App\Models\ActivityLog::create([
        'user_id' => $superadmin?->id,
        'user_name' => $superadmin?->name ?? 'Admin Silsilah',
        'user_role' => 'superadmin',
        'action' => 'LOGIN',
        'module' => 'Autentikasi',
        'description' => 'Inisialisasi sistem log aktivitas audit silsilah raja.',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Console Seeder',
    ]);
    $this->info("Berhasil membuat catatan log awal!");
    return 0;
})->purpose('Membuat data awal catatan log aktivitas');



