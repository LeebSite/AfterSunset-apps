<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AkunKasirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KeuanganController;

// Autentikasi Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'autentic']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard dan Keuangan
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/keuangan', function () {
    return view('keuangan');
})->name('keuangan');

// Menu Routes  
Route::resource('menu', MenuController::class)->except(['create', 'show']);

// Akun Kasir Routes (dalam grup middleware 'auth')
Route::middleware(['auth'])->group(function () {
    Route::resource('akunkasir', AkunKasirController::class);
});

// Pemesanan Routes
Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');

// Riwayat Routes
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
Route::get('/riwayat/search', [RiwayatController::class, 'search'])->name('riwayat.search');

// Keuangan Routes
Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
Route::post('/keuangan/laporan', [KeuanganController::class, 'getLaporan'])->name('keuangan.laporan');
Route::get('/keuangan/detail/{tanggal}', [KeuanganController::class, 'getDetail'])->name('keuangan.detail');
Route::get('/keuangan/download', [KeuanganController::class, 'downloadPdf'])->name('keuangan.download');
