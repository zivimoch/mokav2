<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OpsiController;
use App\Http\Controllers\WilayahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::namespace('API')->group(function () {
        // alamat
        Route::get('/kotkab', [WilayahController::class, 'getKotkab'])->name('api.v1.kotkab');
        Route::get('/kecamatan', [WilayahController::class, 'getKecamatan'])->name('api.v1.kecamatan');
        Route::get('/kelurahan', [WilayahController::class, 'getKelurahan'])->name('api.v1.kelurahan');
        // jenis kekerasan (digunakan di from)
        Route::get('/jeniskekerasan', [OpsiController::class, 'jenis_kekerasan'])->name('api.v1.jeniskekerasan');
        Route::get('/bentukkekerasan', [OpsiController::class, 'bentuk_kekerasan'])->name('api.v1.bentukkekerasan');
        Route::get('/kategorikasus', [OpsiController::class, 'kategori_kasus'])->name('api.v1.kategorikasus');
        // monitor
        // Route::get('/monitoringkasus', [MonitoringController::class, 'monitoring_kasus'])->name('api.v1.monitoringkasus');
        Route::get('/jumlahkorban', [MonitoringController::class, 'jumlah_korban'])->name('api.v1.jumlahkorban');
        Route::get('/jumlahkorbanwilayah', [MonitoringController::class, 'jumlah_korban_wilayah'])->name('api.v1.jumlahkorbanwilayah');
        Route::get('/jumlahkorbanklasifikasi', [MonitoringController::class, 'jumlah_korban_klasifikasi'])->name('api.v1.jumlahkorbanklasifikasi');
        Route::get('/jumlahkorbankategorilokasi', [MonitoringController::class, 'jumlah_korban_kategori_lokasi'])->name('api.v1.jumlahkorbankategorilokasi');
        Route::get('/jumlahkorbanidentitas', [MonitoringController::class, 'jumlah_korban_identitas'])->name('api.v1.jumlahkorbanidentitas');
    });
});

