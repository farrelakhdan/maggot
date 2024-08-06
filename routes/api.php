<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAPIController;
use App\Http\Controllers\ProdukAPIController;

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

Route::post('/login', [UserAPIController::class, 'login'])->name('public_login');

//PRODUK
Route::post('/postProduk', [ProdukAPIController::class, 'store'])->name('post_produk');
Route::get('/getAllProduk', [ProdukAPIController::class, 'getAll'])->name('getAll_produk');
Route::get('/getProduk/{UID_Produk}', [ProdukAPIController::class, 'index'])->name('get_produk');
Route::post('/putProduk/{UID_Produk}', [ProdukAPIController::class, 'update'])->name('put_produk');
Route::get('/deleteProduk/{UID_Produk}', [ProdukAPIController::class, 'delete'])->name('delete_produk');