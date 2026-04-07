<?php

use App\Http\Controllers\ApproveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\RoleOption;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

Route::middleware(['middleware' => 'ensuretoken'])->group(function () {
    Route::controller(RoleOption::class)->group(function () {
        Route::get('/role-option', 'index')->name('role-option');
        Route::post('/role-choice', 'choseRole')->name('chooseRole');
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'index')->name('index');
        Route::get('/peminjaman-ruangan', 'index3')->name('index3');
        Route::get('/index-8', 'index8')->name('index8');
    });

    Route::controller(GedungController::class)->group(function () {
        Route::get('/pilih-gedung', 'show')->name('index2');
    });

    Route::group(['middleware' => ['ensuretoken', 'rolecheck:SUPERADMIN,KEPALA URUSAN ADMINISTRASI AKADEMIK']], function () {
        Route::get('/kelola-gedung', [GedungController::class, 'index'])->name('pengelolaan-gedung');

        Route::controller(RuanganController::class)->group(function () {
            Route::get('/dashboard/ruangan/{id}', [RuanganController::class, 'index'])->name('kelola-ruang');
            Route::get('/ruangan/detail/{id}', [RuanganController::class, 'edit']);
            Route::post('/ruangan/ubah-data', 'update')->name('update.ruang');
            Route::post('/ruangan/baru', [RuanganController::class, 'store'])->name('tambah.ruang');
            Route::delete('/asset/{id}', [RuanganController::class, 'destroyAsset']);
            Route::delete('/ruangan/{id}', [RuanganController::class, 'destroyRuangan']);
            Route::get('/asset/{id}', [RuanganController::class, 'getAssetByRuangan']);
        });
    });

    Route::controller(DataPeminjamanController::class)->group(function () {
        Route::get('/dashboard/pilih-ruang/{id}', [DataPeminjamanController::class, 'index'])->name('pilih-ruang');
        Route::get('/history-peminjaman', [DataPeminjamanController::class, 'show'])->name('history-peminjaman');
    });

    Route::controller(ApproveController::class)->group(function () {
        Route::get('/approve', [ApproveController::class, 'index'])->name('approve-reservasi');
        Route::post('/approve/{id}', [ApproveController::class, 'approve']);
        Route::post('/reject/{id}', [ApproveController::class, 'reject'])->name('reject');
    });
});

Route::get('/authentication/sign-in', [AuthController::class, 'index'])->name('login');
Route::post('/authentication/sign-in', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});