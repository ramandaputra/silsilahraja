<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            // 1. Ubah role 'admin' lama menjadi 'superadmin'
            DB::table('users')->where('role', 'admin')->update(['role' => 'superadmin']);

            // 2. Ubah role 'operator' lama menjadi 'admin'
            DB::table('users')->where('role', 'operator')->update(['role' => 'admin']);

            // 3. Pastikan role lain yang tidak dikenal disesuaikan menjadi 'admin'
            DB::table('users')->whereNotIn('role', ['superadmin', 'admin'])->update(['role' => 'admin']);

            // 4. Jika belum ada superadmin, angkat pengguna pertama menjadi superadmin
            $hasSuperadmin = DB::table('users')->where('role', 'superadmin')->exists();
            if (!$hasSuperadmin) {
                $first = DB::table('users')->orderBy('id', 'asc')->first();
                if ($first) {
                    DB::table('users')->where('id', $first->id)->update(['role' => 'superadmin']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'superadmin')->update(['role' => 'admin']);
        }
    }
};

