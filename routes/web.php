<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AkunKasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KeuanganController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AutoLock;

// Autentikasi Routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'autentic']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk lockscreen
Route::get('/lockscreen', [LoginController::class, 'lockScreen'])->middleware('auth')->name('lockscreen');
Route::post('/lockscreen/submit', [LoginController::class, 'unlockScreen'])->name('lockscreen.submit');

// Daftarkan middleware
Route::middleware(['auth', AutoLock::class])->group(function () {
    Route::get('/beranda', function () { return view('beranda'); })->name('beranda');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/search', [RiwayatController::class, 'search'])->name('riwayat.search');

    // Routes untuk administrator
    Route::middleware([RoleMiddleware::class . ':Administrator'])->group(function () {
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
        Route::post('/keuangan/laporan', [KeuanganController::class, 'getLaporan'])->name('keuangan.laporan');
        Route::get('/keuangan/laporan', [KeuanganController::class, 'getLaporan'])->name('keuangan.laporan');
        Route::resource('menu', MenuController::class);
        Route::resource('akunkasir', AkunKasirController::class);
    });

    // Routes untuk kasir
    Route::middleware([RoleMiddleware::class . ':Kasir'])->group(function () {
        Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
        Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    });
});