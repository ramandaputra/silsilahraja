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

        // 1. Buat Satu-satunya Akun Admin Utama
        User::create([
            'name' => 'Admin Silsilah',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Ganti dengan password pilihan Anda
            'role' => 'admin',
        ]);

        // 2. Buat Akun Operator
        User::create([
            'name' => 'Operator Silsilah',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'operator',
        ]);
    }
}