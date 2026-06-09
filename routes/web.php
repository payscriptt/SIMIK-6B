<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController; // Tulis ini untuk memanggil controller admin
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\SupplierController;


/*
|--------------------------------------------------------------------------
| rute GUEST (Hanya bisa diakses jika BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest:admin')->group(function () {
    // Arahkan halaman login ke Controller Admin yang baru kita buat
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    // Jika kamu masih butuh register untuk admin, aktifkan ini:
    // Route::get('/register', function () { return view('auth.register'); });
});


/*
|--------------------------------------------------------------------------
| rute PROTECTED (Hanya bisa diakses jika SUDAH login sebagai Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    // Tombol Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Halaman Utama / Dashboard
    Route::get('/', function () {
        return view('dashboard.index');
    });

    // Barang
 Route::get('/barang', [BarangController::class, 'index']);
 Route::delete('/barang/{id_barang}', [BarangController::class, 'destroy']);
    // Barang Masuk
    Route::get('/barang_masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::post('/barang_masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
    Route::delete('/barang_masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');

    // Barang Keluar
   Route::get('/barang_keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
Route::post('/barang_keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');

    // Supplier
  Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/supplier/create', [SupplierController::class, 'create']);
Route::post('/supplier', [SupplierController::class, 'store']);
Route::delete('/supplier/{id_supplier}', [SupplierController::class, 'destroy']);



// Route untuk memuat halaman dashboard pertama kali
Route::get('/dashboard', [DashboardController::class, 'index']);

// Route API yang dipanggil oleh JavaScript Fetch di Blade untuk realtime
Route::get('/api/dashboard-stats', [DashboardController::class, 'getStatsRealtime']);
});