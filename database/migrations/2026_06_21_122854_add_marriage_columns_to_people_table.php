<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah'])->default('Belum Menikah')->after('jenis_kelamin');
            $table->string('nama_pasangan')->nullable()->after('status_pernikahan');
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn(['status_pernikahan', 'nama_pasangan']);
        });
    }
};