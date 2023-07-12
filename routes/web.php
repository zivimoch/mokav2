<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AsesmenConntroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FormPenerimaPengaduan;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\RiwayatKejadianController;
use App\Http\Controllers\TemplateController;
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
    Route::get('kasus', [KasusController::class, 'index'])->name('kasus');
    Route::get('kasus/show/{uuid}', [KasusController::class, 'show'])->name('kasus.show');
    // Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    // riwayat kejadian
    Route::get('riwayatkejadian/index/', [RiwayatKejadianController::class, 'index'])->name('riwayatkejadian');
    Route::post('riwayatkejadian/store/', [RiwayatKejadianController::class, 'store'])->name('riwayatkejadian.store');
    Route::get('riwayatkejadian/edit/{id}', [RiwayatKejadianController::class, 'edit'])->name('riwayatkejadian.edit');
    Route::delete('riwayatkejadian/destroy/{id}', [RiwayatKejadianController::class, 'destroy'])->name('riwayatkejadian.destroy');
    
    Route::view('notifikasi','/notifikasi')->name('notifikasi');
    //dokumen
    Route::view('dokumen','dokumen/index')->name('dokumen');
    Route::get('dokumen/add',[DokumenController::class, 'add'])->name('dokumen.add');
    Route::get('dokumen/create',[DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('dokumen/store',[DokumenController::class, 'store'])->name('dokumen.store');
    //template
    Route::get('template', [TemplateController::class, 'index'])->name('template');
    Route::get('template/create', [TemplateController::class, 'create'])->name('template.create');
    Route::post('template/store', [TemplateController::class, 'store'])->name('template.store');

    Route::view('agenda/index','agenda/index')->name('agenda');
    Route::view('kinerja','agenda/kinerja')->name('kinerja');
    Route::get('kinerja', [AgendaController::class, 'kinerja'])->name('kinerja');
    Route::get('kinerja/detail', [AgendaController::class, 'kinerja_detail'])->name('kinerja.detail');
    Route::post('agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::get('kinerja/ajax', [AgendaController::class, 'ajax'])->name('ajax');

    Route::get('userdatatable', [DashboardController::class, 'userdatatable'])->name('userdatatable');
    Route::get('dashboard-datatables', [DashboardController::class, 'datatable'])->name('dashboard.datatables');

    Route::view('monitoring','monitoring/index')->name('monitoring');
});

require __DIR__.'/auth.php';
