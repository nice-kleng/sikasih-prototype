<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DeteksiRisikoController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest routes (untuk yang belum login)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes untuk ibu hamil (menggunakan guard 'web')
Route::middleware(['auth:web', 'ibu_hamil'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Frontend Pages
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes (Unified in ProfileController)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Riwayat Pemeriksaan
    Route::get('/riwayat', [ProfileController::class, 'riwayat'])->name('riwayat');

    // Konsultasi
    Route::get('/konsultasi', [DashboardController::class, 'konsultasi'])->name('konsultasi');

    // Konsultasi Store
    Route::post('/konsultasi', [DashboardController::class, 'konsultasiStore'])->name('konsultasi.store');

    // Perawatan
    Route::get('/perawatan', [DashboardController::class, 'perawatan'])->name('perawatan');

    // Deteksi Risiko
    Route::get('/deteksi-risiko', [DeteksiRisikoController::class, 'index'])->name('deteksi-risiko');
    Route::post('/deteksi-risiko', [DeteksiRisikoController::class, 'store'])->name('deteksi-risiko.store');

    // Jadwal Pemeriksaan
    Route::get('/jadwal', [DashboardController::class, 'jadwal'])->name('jadwal');

    // Edukasi Artikel & video
    Route::get('edukasi', [EdukasiController::class, 'index'])->name('edukasi');
    // Route::get('artikel', [EdukasiController::class, 'artikelIndex'])->name('artikel.index');
    Route::get('artikel/{slug}', [EdukasiController::class, 'showArtikel'])->name('artikel.show');
    // Route::get('video', [EdukasiController::class, 'videoIndex'])->name('video.index');
    Route::get('video/{slug}', [EdukasiController::class, 'showVideo'])->name('video.show');
});

// Filament akan otomatis handle routes untuk admin panel di /admin
