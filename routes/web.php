<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormPenerimaPengaduan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'index'])->name('formpenerimapengaduan.index');

    Route::view('kasus/index','/kasus/index')->name('kasus');
    Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    Route::view('notifikasi','/notifikasi')->name('notifikasi');
    Route::view('dokumen','dokumen/index')->name('dokumen');
    Route::view('dokumen/add','dokumen/add')->name('dokumen.add');
    Route::view('dokumen/create','dokumen/create')->name('dokumen.create');
    Route::view('dokumen/createpsi','dokumen/createpsi')->name('dokumen.createpsi');
    Route::view('agenda/index','agenda/index')->name('agenda');
});

require __DIR__.'/auth.php';
