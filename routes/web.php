<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AiapplicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentspageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CryptocurrencyController;

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
        Route::get('/index-5','index5')->name('index5');
        Route::get('/kelola-gedung','index6')->name('index6');
        Route::get('/pengelolaan-ruang','index7')->name('index7');
        Route::get('/index-8','index8')->name('index8');
        Route::get('/index-9','index9')->name('index9');
    });
});