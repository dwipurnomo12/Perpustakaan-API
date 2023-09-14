<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PemesananController;
use App\Http\Controllers\Api\PeminjamanBukuController;
use App\Http\Controllers\Api\VerifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('profil', [AuthController::class, 'profil']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['middleware'  => ['auth:api', 'CheckRole:Penerbit']], function(){
        Route::resource('buku', BukuController::class);
    });

    Route::group(['middleware'  => ['auth:api', 'CheckRole:Admin Cafe']], function(){
        Route::get('list-buku', [PeminjamanBukuController::class, 'listBuku']);
        Route::post('pinjam-buku', [PeminjamanBukuController::class, 'pinjamBuku']);
        Route::PUT('kembalikan-buku', [PeminjamanBukuController::class, 'kembalikanBuku']);
    });

    Route::group(['middleware'  => ['auth:api', 'CheckRole:Pelanggan']], function(){
        Route::post('pemesanan', [PemesananController::class, 'tambahPesanan']);
    });

    Route::group(['middleware'  => ['auth:api', 'CheckRole:Bartender']], function(){
        Route::PUT('/verifikasi', [VerifikasiController::class, 'verifikasi']);
    });
});

