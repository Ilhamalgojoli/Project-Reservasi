<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'index')->name('index');
        Route::get('/pilih-gedung', 'index2')->name('index2');
        Route::get('/peminjaman-ruangan', 'index3')->name('index3');
        Route::get('/approve', 'index4')->name('index4');
        Route::get('/index-5', 'index5')->name('index5');
        Route::get('/index-8', 'index8')->name('index8');
        Route::get('/index-9', 'index9')->name('index9');
    });

    Route::controller(GedungController::class)->group(function () {
        Route::get('kelola-gedung', 'index')->name('index6');
        Route::get('/edit/{id}', [GedungController::class, 'edit']);
        Route::post('/update', 'update')->name('update.gedung');
        Route::post('/tambah-gedung', 'store')->name('tambah.gedung');
        Route::delete('/delete/{id}', [GedungController::class, 'destroy']);
    });

    Route::controller(RuanganController::class)->group(function () {
        Route::get('/dashboard/kelola-ruang/{id}', [RuanganController::class, 'index'])->name('kelola-ruang');
    });
});
