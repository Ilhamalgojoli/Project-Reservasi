<?php

use App\Http\Controllers\ApproveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\DataPeminjamanController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'index')->name('index');
        Route::get('/peminjaman-ruangan', 'index3')->name('index3');
        Route::get('/index-8', 'index8')->name('index8');
    });

    Route::controller(GedungController::class)->group(function () {
        Route::get('kelola-gedung', 'index')->name('index6');
        Route::get('/edit-gedung/{id}', [GedungController::class, 'edit']);
        Route::post('/update/gedung', [GedungController::class, 'update'])->name('update.gedung');
        Route::post('/tambah-gedung', 'store')->name('tambah.gedung');
        Route::delete('/delete/{id}', [GedungController::class, 'destroy']);
        Route::get('/pilih-gedung', 'show')->name('index2');
    });

    Route::controller(RuanganController::class)->group(function () {
        Route::get('/dashboard/kelola-ruang/{id}', [RuanganController::class, 'index'])->name('kelola-ruang');
        Route::get('edit-ruangan/{id}', [RuanganController::class, 'edit']);
        Route::post('/update/ruang', 'update')->name('update.ruang');
        Route::post('tambah-ruang', [RuanganController::class, 'store'])->name('tambah.ruang');
        Route::delete('/delete-asset/{id}', [RuanganController::class, 'destroyAsset']);
        Route::delete('delete-ruangan/{id}', [RuanganController::class, 'destroyRuangan']);
        Route::get('get-asset/{id}', [RuanganController::class, 'getAssetByRuangan']);
    });

    Route::controller(DataPeminjamanController::class)->group(function () {
        Route::get('/dashboard/pilih-ruang/{id}', [DataPeminjamanController::class, 'index'])->name('pilih-ruang');
        Route::post('/pinjam-ruang', [DataPeminjamanController::class, 'store'])->name('store.pinjamRuang');
        Route::get('/history-peminjaman', [DataPeminjamanController::class, 'show'])->name('history-peminjaman');
        Route::get('/data-ruangan/{id}', [DataPeminjamanController::class, 'ruangan'])->name('data.ruangan');
        Route::delete('cancel-booking/{id}', [DataPeminjamanController::class, 'cancelBooking']);
    });

    Route::controller(ApproveController::class)->group(function() {
        Route::get('/approve', [ApproveController::class,'index'])->name('approve-reservasi');
        Route::post('/approve/{id}', [ApproveController::class, 'approve']);
        Route::post('/reject/{id}', [ApproveController::class, 'reject'])->name('reject');
    }); 
});
