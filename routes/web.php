<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KebunController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\TahapController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'bacaSemua'])->name('notifikasi.baca-semua');
    Route::post('/notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'baca'])->name('notifikasi.baca');

    // Khusus admin (didaftarkan lebih dulu agar /kebun/create tidak tertangkap /kebun/{kebun})
    Route::middleware(AdminOnly::class)->group(function () {
        Route::resource('petani', PetaniController::class)->except('show');
        Route::resource('pengguna', PenggunaController::class)->except('show');
        Route::resource('panduan', PanduanController::class)->except('show');
        Route::resource('kebun', KebunController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/kebun/{kebun}/tahap', [TahapController::class, 'edit'])->name('kebun.tahap');
        Route::post('/kebun/{kebun}/tahap', [TahapController::class, 'update'])->name('kebun.tahap.update');
        Route::get('/laporan/siap-replanting', [LaporanController::class, 'siapReplanting'])->name('laporan.siap');
        Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    // Admin & petani (petani hanya bisa melihat kebun miliknya, dicek di controller)
    Route::resource('kebun', KebunController::class)->only(['index', 'show']);
});
