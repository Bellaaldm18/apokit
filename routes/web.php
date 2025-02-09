<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanObatController;
use App\Http\Controllers\ManajemenObatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('test', function() {
    return view('admin.dashboard.index');
});

Route::get('/', function () {
    return redirect()->route('login');
});


Route::controller(ProfileController::class)->group(function() {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::put('/profile/{id}', 'update')->name('profile.update');
});

// Auth::routes();

// L
Route::controller(AuthController::class)->group(function() {
    Route::get('login', 'index');
    Route::post('login', 'authenticate')->name('login');
    Route::post('logout', 'logout')->name('logout')->middleware('admin','kasir');
});


// Admin
Route::middleware(['auth','admin'])->group(function() {
    Route::prefix('dashboard')->group(function() {
        // default
        Route::controller(DashboardController::class)->group(function() {
            Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
            Route::get('/weekly-revenue-chart', [DashboardController::class, 'weeklyRevenue'])->name('weekly.revenue.chart');
        });

        // K
        Route::controller(KategoriController::class)->name('kategori')->group(function () {
            Route::get('load-data-kategori', 'viewdatas');
            Route::get('kategori', 'index')->name('.index');
            Route::post('kategori/{id?}', 'store')->name('.store');
            Route::get('kategori/form', 'create')->name('.form');
            Route::get('kategori/edit/{id}', 'edit')->name('.edit');
            Route::delete('kategori/{id}', 'destroy')->name('.delete');
        });

        // L
        Route::controller(LaporanController::class)->group(function() {
            Route::get('laporan-keuangan', 'index');
            Route::get('load-laporan-bulan', 'monthlyTransaction');
            Route::get('export-laporan-bulanan', 'exportMonthly');
        });

        Route::controller(LaporanObatController::class)->group(function() {
            Route::get('laporan-obat', 'index');
            Route::get('obat-kadaluarsa', 'cariKadaluarsa');
            Route::get('obat-terlaris', 'obatTerlaris');
            Route::get('export-laporan-obat-kadaluarsa', 'exportExpired');
            Route::get('export-laporan-obat-terlaris', 'exportBestSelling');
        });

        // M
        Route::controller(ManajemenObatController::class)->name('manajemen-obat')->group(function () {
            Route::get('load-data-obat', 'viewdatas');
            Route::get('manajemen-obat', 'index')->name('.index');
            Route::post('manajemen-obat/{id?}', 'store')->name('.store');
            Route::get('manajemen-obat/form', 'create')->name('.form');
            Route::get('manajemen-obat/edit/{id}', 'edit')->name('.edit');
            Route::delete('manajemen-obat/{id}', 'destroy')->name('.delete');
        });

        // U
        Route::controller(UserController::class)->name('user')->group(function () {
            Route::get('load-data-user', 'viewDatas');
            Route::get('user', 'index')->name('.index');
            Route::post('user/{id?}', 'store')->name('.store');
            Route::get('user/form', 'create')->name('.form');
            Route::get('user/edit/{id}', 'edit')->name('.edit');
            Route::delete('user/{id}', 'destroy')->name('.delete');
            Route::put('aktivasi-user/{id}', 'is_active');
        });
    });
});


// Kasir
Route::middleware(['auth','kasir', 'web'])->group(function() {

    // K
    Route::controller(KasirController::class)->group(function() {
        Route::get('pesanan', 'index');
        Route::get('search-obat', 'search')->name('search-obat');
        Route::post('simpan-keranjang', 'simpanKeranjang')->name('simpan-keranjang');
    });

    // P
    Route::controller(PembayaranController::class)->group(function() {
        Route::get('pembayaran', 'index');
        Route::get('keranjang', 'getKeranjang');
        Route::post('pembayaran', 'store');
    });

    // R
    Route::controller(RiwayatController::class)->group(function() {
        Route::get('riwayat', 'index');
        Route::get('load-data-riwayat', 'viewDatas');
        Route::get('detail/{id?}', 'transactionDetails')->name('detail');
    });
});






// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
