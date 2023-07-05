<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormPenerimaPengaduan;
use App\Http\Controllers\KasusController;
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
Route::get('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'index'])->name('formpenerimapengaduan.index');
Route::post('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'store'])->name('formpenerimapengaduan.store');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // edit data formulir / data master 
    Route::put('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'update'])->name('formpenerimapengaduan.update');
    // kasus
    Route::get('/kasus', [KasusController::class, 'index'])->name('kasus');
    Route::get('/kasus/show/{uuid}', [KasusController::class, 'show'])->name('kasus.show');
    // Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    Route::view('notifikasi','/notifikasi')->name('notifikasi');
    Route::view('dokumen','dokumen/index')->name('dokumen');
    Route::view('dokumen/add','dokumen/add')->name('dokumen.add');
    Route::view('dokumen/create','dokumen/create')->name('dokumen.create');
    Route::view('dokumen/createpsi','dokumen/createpsi')->name('dokumen.createpsi');
    Route::view('dokumen/createhkm','dokumen/createhkm')->name('dokumen.createhkm');
    
    Route::view('template','template/index')->name('template');
    Route::view('template/createpsi','template/createpsi.php')->name('template.createpsi');

    Route::view('agenda/index','agenda/index')->name('agenda');
    Route::view('kinerja','agenda/kinerja')->name('kinerja');
    Route::get('kinerja', [AgendaController::class, 'kinerja'])->name('kinerja');
    Route::get('kinerja/detail', [AgendaController::class, 'kinerja_detail'])->name('kinerja.detail');
    Route::post('agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::get('kinerja/ajax', [AgendaController::class, 'ajax'])->name('ajax');

    Route::get('/userdatatable', [DashboardController::class, 'userdatatable'])->name('userdatatable');
    Route::get('/dashboard-datatables', [DashboardController::class, 'datatable'])->name('dashboard.datatables');

    Route::view('statistik','statistik/index')->name('statistik');
});

require __DIR__.'/auth.php';
