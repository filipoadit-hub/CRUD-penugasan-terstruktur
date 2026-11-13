<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/anggota', [App\Http\Controllers\LaporanController::class, 'anggota'])
        ->name('laporan.anggota');
    Route::get('/laporan/transaksi', [App\Http\Controllers\LaporanController::class, 'transaksi'])
        ->name('laporan.transaksi');

    Route::resource('anggota', App\Http\Controllers\AnggotaController::class)
        ->parameters(['anggota' => 'anggota']);
    Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
});