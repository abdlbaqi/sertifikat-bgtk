<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\SertifikatAdminController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. HALAMAN BERANDA / LANDING STUDIO
// ==========================================
Route::get('/', [SertifikatController::class, 'index'])->name('sertifikat.beranda');
Route::get('/verifikasi/{kode}', [SertifikatController::class, 'verifikasi'])->name('sertifikat.verifikasi');
Route::get('/sertifikat/{kode}/cetak', [SertifikatController::class, 'cetak'])->name('sertifikat.cetak');

// ==========================================
// 2. AUTENTIKASI ADMIN
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. PANEL ADMIN & GENERATOR SERTIFIKAT MASAL
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Generator Sertifikat Masal (Input Banyak Nama Sekaligus)
    Route::get('/generator', [SertifikatAdminController::class, 'generator'])->name('sertifikat.generator');
    Route::post('/generator', [SertifikatAdminController::class, 'prosesMasal'])->name('sertifikat.proses-masal');
    Route::get('/kegiatan/{kegiatan}/cetak-masal', [SertifikatAdminController::class, 'cetakMasal'])->name('kegiatan.cetak-masal');

    // CMS Template Desain Sertifikat
    Route::resource('template', TemplateController::class);
    // Kanvas Editor Drag-and-Drop per Template
    Route::get('/template/{template}/canvas', [TemplateController::class, 'canvas'])->name('template.canvas');
    Route::post('/template/{template}/canvas', [TemplateController::class, 'saveCanvas'])->name('template.saveCanvas');

    // Manajemen Kegiatan Pelatihan / Bimtek
    Route::resource('kegiatan', KegiatanController::class);

    // Manajemen Data Sertifikat Peserta
    Route::resource('sertifikat', SertifikatAdminController::class);
});
