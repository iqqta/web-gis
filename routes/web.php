<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SawahController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\TambahController;

Route::get('/', [SawahController::class, 'index']);

Route::get('/sawah', [SawahController::class, 'index'])->name('sawah');
Route::get('/jalan', [JalanController::class, 'index'])->name('jalan');
Route::get('/wisata', [WisataController::class, 'index'])->name('wisata');
Route::get('/addsawah', [TambahController::class, 'sawah'])->name('addsawah');
Route::get('/addjalan', [TambahController::class, 'jalan'])->name('addjalan');
Route::get('/addwisata', [TambahController::class, 'wisata'])->name('addwisata');

Route::post('/store/sawah', [TambahController::class, 'storeSawah'])->name('store.sawah');
Route::post('/store/jalan', [TambahController::class, 'storeJalan'])->name('store.jalan');
Route::post('/store/wisata', [TambahController::class, 'storeWisata'])->name('store.wisata');