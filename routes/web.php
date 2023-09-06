<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FormPenerimaPengaduan;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RiwayatKejadianController;
use App\Http\Controllers\TemplateController;
use App\Models\Agenda;
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
Route::get('persetujuan/persetujuan_pelayanan/{uuid}', [PersetujuanController::class, 'persetujuan_pelayanan'])->name('persetujuan.persetujuan_pelayanan');
Route::post('persetujuan', [PersetujuanController::class, 'store'])->name('persetujuan.store');
Route::get('persetujuan/donepelayanan/{uuid}', [PersetujuanController::class, 'donepelayanan'])->name('persetujuan.done');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // edit data formulir / data master 
    Route::put('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'update'])->name('formpenerimapengaduan.update');
    // kasus
    Route::get('kasus', [KasusController::class, 'index'])->name('kasus');
    Route::get('kasus/show/{uuid}', [KasusController::class, 'show'])->name('kasus.show');
    Route::post('kasus/approval/{uuid}', [KasusController::class, 'approval'])->name('kasus.approval');
    // Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    // persetujuan
    Route::post('persetujuan/create/{uuid}', [PersetujuanController::class, 'create'])->name('persetujuan.create');
    // persetujuan_pelayanan
    Route::post('petugas/store/{uuid}', [PetugasController::class, 'store'])->name(('petugas.store'));
    Route::delete('petugas/destroy/{id}', [PetugasController::class, 'destroy'])->name(('petugas.destroy'));
    // riwayat kejadian
    Route::get('riwayatkejadian/index/', [RiwayatKejadianController::class, 'index'])->name('riwayatkejadian');
    Route::post('riwayatkejadian/store/', [RiwayatKejadianController::class, 'store'])->name('riwayatkejadian.store');
    Route::get('riwayatkejadian/edit/{id}', [RiwayatKejadianController::class, 'edit'])->name('riwayatkejadian.edit');
    Route::delete('riwayatkejadian/destroy/{id}', [RiwayatKejadianController::class, 'destroy'])->name('riwayatkejadian.destroy');
    // asesmen
    Route::get('asesmen/index/', [AsesmenController::class, 'index'])->name('asesmen');
    Route::post('asesmen/store/', [AsesmenController::class, 'store'])->name('asesmen.store');
    //notifikasi
    Route::view('notifikasi','/notifikasi')->name('notifikasi');
    Route::get('/Notifikasi/pull_notif', [NotifikasiController::class, 'pull_notif'])->name('notifikasi.pull_notif');
    // dokumen
    Route::get('dokumen',[DokumenController::class, 'index'])->name('dokumen');
    Route::get('dokumen/add',[DokumenController::class, 'add'])->name('dokumen.add');
    Route::get('dokumen/create',[DokumenController::class, 'create'])->name('dokumen.create');
    Route::post('dokumen/store',[DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('dokumen/show/{uuid}',[DokumenController::class, 'show'])->name('dokumen.show');
    // template
    Route::get('template', [TemplateController::class, 'index'])->name('template');
    Route::get('template/create', [TemplateController::class, 'create'])->name('template.create');
    Route::post('template/store', [TemplateController::class, 'store'])->name('template.store');
    // agenda & kinerja
    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda');
    Route::get('agenda/api_index', [AgendaController::class, 'api_index']);
    Route::get('agenda/show/{uuid}', [AgendaController::class, 'show'])->name('agenda.show');
    Route::get('agenda/showdate/{date}', [AgendaController::class, 'showdate'])->name('agenda.showdate');
    Route::post('agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::view('kinerja','agenda/kinerja')->name('kinerja');
    Route::get('kinerja', [AgendaController::class, 'kinerja'])->name('kinerja');
    Route::get('kinerja/detail', [AgendaController::class, 'kinerja_detail'])->name('kinerja.detail');
    Route::get('kinerja/ajax', [AgendaController::class, 'ajax'])->name('ajax');

    Route::view('monitoring','monitoring/index')->name('monitoring');
});

require __DIR__.'/auth.php';
