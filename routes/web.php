<?php

use Illuminate\Support\Facades\Route;

// Import Controllers Publik
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RelationController;

// Import Controllers Admin & Auth
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\PersonController as AdminPersonController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK / PENGUNJUNG
|--------------------------------------------------------------------------
*/

// Halaman Beranda Utama (Menggunakan HomeController agar data statistik & bento terisi)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Detail Profil Anggota Silsilah
Route::get('/person/{id}', [PublicController::class, 'show'])->name('person.detail');

// Halaman Bagan Silsilah / Pohon Trah Keluarga
Route::get('/person/{id}/trah', [HomeController::class, 'trah'])->name('person.trah');

// Fitur Pencari Relasi Kekerabatan / Jarak Hubungan
Route::get('/cari-relasi', [RelationController::class, 'index'])->name('relation.index');
Route::get('/proses-relasi', [RelationController::class, 'process'])->name('relation.process');


/*
|--------------------------------------------------------------------------
| 2. SISTEM PROTEKSI & ROUTING (AUTH BREEZE / ADMIN)
|--------------------------------------------------------------------------
*/

// Redirect otomatis dari halaman /dashboard bawaan Breeze menuju dashboard admin kita
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard.redirect');

// Kelompok Rute Khusus Admin (Hanya bisa diakses jika sudah Login & Lolos Middleware Admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Utama Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Manajemen Data Keturunan (CRUD Silsilah)
        Route::resource('people', AdminPersonController::class);

        // Pengatur Konten Teks Beranda (CMS Dinamis)
        Route::get('/cms', [CmsController::class, 'index'])->name('cms.index');
        Route::post('/cms', [CmsController::class, 'update'])->name('cms.update');
    });

// Kelompok Rute Manajemen Akun Pengguna / Profil (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| 3. AUTHENTICATION ROUTE (BREEZE REGISTER & LOGIN)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

// Jalankan import Controller di bagian atas file bersama controller lainnya
use App\Http\Controllers\AboutController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK / PENGUNJUNG
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/person/{id}', [PublicController::class, 'show'])->name('person.detail');
Route::get('/person/{id}/trah', [HomeController::class, 'trah'])->name('person.trah');
Route::get('/cari-relasi', [RelationController::class, 'index'])->name('relation.index');
Route::get('/proses-relasi', [RelationController::class, 'process'])->name('relation.process');

// RUTE BARU: Halaman Profil Penyusun / Tentang Kami
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');