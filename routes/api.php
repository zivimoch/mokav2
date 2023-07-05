<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\KasusController;
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

//agenda
Route::get('agenda', [AgendaController::class, 'api_index']);

Route::prefix('v1')->group(function () {
    Route::namespace('API')->group(function () {
        Route::get('/kotkab', [WilayahController::class, 'getKotkab'])->name('api.v1.kotkab');
    });
    Route::namespace('API')->group(function () {
        Route::get('/kecamatan', [WilayahController::class, 'getKecamatan'])->name('api.v1.kecamatan');
    });
});

