<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data user lama agar bersih (Opsional)
        User::truncate();

        // 1. Buat Satu-satunya Akun Superadmin
        User::create([
            'name' => 'Superadmin Silsilah',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Ganti dengan password pilihan Anda
            'role' => 'superadmin',
        ]);

        // 2. Buat Akun Admin
        User::create([
            'name' => 'Admin Silsilah',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}