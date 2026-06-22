<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\PersonController as AdminPersonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. RUTE AKSES PUBLIK (Ala PDDIKTI)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/person/{id}', [PublicController::class, 'show'])->name('person.detail');
// Rute untuk melihat halaman silsilah/trah penuh
Route::get('/person/{id}/trah', [App\Http\Controllers\HomeController::class, 'trah'])->name('person.trah');

/*
|--------------------------------------------------------------------------
| 2. RUTE BAWAAN BREEZE (Modifikasi Pengalihan)
|--------------------------------------------------------------------------
*/
// Ketika user biasa atau admin mengakses /dashboard, kita alihkan langsung ke /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| 3. RUTE KHUSUS ADMIN (Diproteksi Auth & Middleware Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Halaman Utama Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Otomatis membuat rute CRUD: admin.people.index, admin.people.create, dll.
    Route::resource('people', AdminPersonController::class);
});

/*
|--------------------------------------------------------------------------
| 4. RUTE UTILITY PROFILE (Bawaan Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';