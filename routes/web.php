<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\obatContrller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


// Auth proses
Route::get('/login', [authController::class, 'index'])->name('login')->middleware('guest');
Route::post('/loginProses', [authController::class, 'login'])->name('loginProses');
Route::get('/logout', [authController::class, 'logout'])->name('logout');

Route::prefix('/dashboard/admin')->middleware('isAdmin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::prefix('/obat')->group(function(){
        // Index halaman obat
        Route::get('/', [AdminController::class, 'obatIndex'])->name('obat');
        Route::post('/simpanObat', [AdminController::class, 'simpanObat'])->name('simpanObat');
        Route::get('/dataObat', [AdminController::class, 'dataObat'])->name('dataObat');
        Route::post('/hapusObat/{id_obat}', [AdminController::class, 'hapusObat'])->name('hapusObat');
        Route::get('/detail/{id_obat}', [AdminController::class, 'detailObat'])->name('detailObat');
        Route::get('/edit/{id_obat}', [AdminController::class, 'editDataObat'])->name('editDataObat');
        Route::post('/updateObat', [AdminController::class, 'editObat'])->name('editObat');
    
        // Obat masuk
        Route::get('/masuk', [AdminController::class, 'obatMasukIndex'])->name('obatMasuk');
        Route::post('/masuk', [AdminController::class, 'tambahObatMasuk'])->name('tambahObatMasuk');
        Route::get('/dataMasuk', [AdminController::class, 'dataObatMasuk'])->name('dataObatMasuk');
        
        // Obat keluar
        Route::get('/keluar', [AdminController::class, 'obatKeluarIndex'])->name('obatKeluar');
        Route::post('/keluar', [AdminController::class, 'tambahObatKeluar'])->name('tambahObatKeluar');
        Route::get('/dataKeluar', [AdminController::class, 'dataObatKeluar'])->name('dataObatKeluar');
    
        // Kategori
        Route::get('/kategori', [AdminController::class, 'katObatIndex'])->name('katObat');
        Route::get('/dataKat', [AdminController::class, 'dataKategori'])->name('katData');
        Route::post('/tambahKategori', [AdminController::class, 'tambahKategori'])->name('tambahKategori');
        Route::post('/hapusKat/{id_kategori}', [AdminController::class, 'hapusKategori'])->name('hapusKategori');
    });
});

Route::prefix('dashboard/dokter')->middleware('isDoctor')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('dashboard.dokter');
});

// Select 2
Route::get('/selectKat', [AdminController::class, 'selectKat'])->name('selectKat');
Route::get('/selectObat', [AdminController::class, 'selectObat'])->name('selectObat');
Route::get('/selectHargaObat/{id}', [AdminController::class, 'selectHargaObat'])->name('selectHargaObat');