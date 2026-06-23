<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// Publik
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\AboutController;

// Auth & Admin
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\PersonController as AdminPersonController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;


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

Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');


/*
|--------------------------------------------------------------------------
| 2. SISTEM PROTEKSI & ROUTING (AUTH BREEZE / REDIRECT)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->name('dashboard.redirect');


/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (Bisa Diakses Admin & Operator)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'cek_operator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Utama Admin
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

        // Manajemen Data Keturunan (CRUD Silsilah)
        Route::resource('people', AdminPersonController::class);

        // Pengatur Konten Teks Beranda (CMS Lama)
        Route::get('/cms', [CmsController::class, 'index'])->name('cms.index');
        Route::post('/cms', [CmsController::class, 'update'])->name('cms.update');

        // Pengaturan Situs Satu Pintu (Mengelola Beranda & about.blade.php)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Pengaturan Slot Tim Ahli Dinamis
        Route::post('/settings/team', [SettingController::class, 'storeTeam'])->name('settings.team.store');
        Route::delete('/settings/team/{team}', [SettingController::class, 'destroyTeam'])->name('settings.team.destroy');

        /*
        |--------------------------------------------------------------------------
        | KHUSUS ADMIN UTAMA (USER MANAGEMENT)
        |--------------------------------------------------------------------------
        */
        Route::middleware(['cek_admin'])->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

    });


/*
|--------------------------------------------------------------------------
| 4. MANAJEMEN PROFIL (BREEZE PROFILE)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| 5. AUTHENTICATION ROUTES (BREEZE REGISTER & LOGIN)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';