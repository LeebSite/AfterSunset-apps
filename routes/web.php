<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AkunKasirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KeuanganController;
use App\Http\Middleware\RoleMiddleware;

// Autentikasi Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'autentic']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Daftarkan middleware
Route::middleware(['auth'])->group(function () {
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
