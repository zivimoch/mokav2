<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FormPenerimaPengaduan;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PublicUrlController;
use App\Http\Controllers\RiwayatKejadianController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TerminasiController;
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
Route::get('blankpage', [DashboardController::class, 'blankpage'])->name('blankpage');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // edit data formulir / data master 
    Route::put('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'update'])->name('formpenerimapengaduan.update');
    // kasus
    Route::get('kasus', [KasusController::class, 'index'])->name('kasus');
    Route::get('kasus/show/{uuid}', [KasusController::class, 'show'])->name('kasus.show');
    Route::post('kasus/approval/{uuid}', [KasusController::class, 'approval'])->name('kasus.approval');
    Route::get('/check_kelengkapan_data/{id}', [KasusController::class, 'check_kelengkapan_data'])->name('check_kelengkapan_data');
    // Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    Route::post('/get_klien', [KasusController::class, 'get_klien'])->name('get_klien');
    // hapus klien dari kasus
    Route::delete('kasus/destroy/{id}', [KasusController::class, 'destroy'])->name('kasus.destroy');
    // persetujuan
    Route::post('persetujuan/create/{uuid}', [PersetujuanController::class, 'create'])->name('persetujuan.create');
    // persetujuan_pelayanan
    Route::get('petugas/index/', [PetugasController::class, 'index'])->name(('petugas'));
    Route::post('/get_petugas', [PetugasController::class, 'get_petugas'])->name('get_petugas');
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
    // monitoring
    Route::get('monitoring/index/', [MonitoringController::class, 'index'])->name('monitoring');
    Route::post('monitoring/store/', [MonitoringController::class, 'store'])->name('monitoring.store');
    //notifikasi
    Route::view('notifikasi','/notifikasi')->name('notifikasi');
    Route::get('/Notifikasi/pull_notif', [NotifikasiController::class, 'pull_notif'])->name('notifikasi.pull_notif');
    // dokumen
    Route::get('dokumen',[DokumenController::class, 'index'])->name('dokumen');
    Route::post('/get_dokumen', [DokumenController::class, 'get_dokumen'])->name('get_dokumen');
    Route::get('dokumen/add',[DokumenController::class, 'add'])->name('dokumen.add');
    Route::get('dokumen/create',[DokumenController::class, 'create'])->name('dokumen.create');
    Route::get('dokumen/edit/{uuid}',[DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::post('dokumen/store',[DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('dokumen/show/{uuid}',[DokumenController::class, 'show'])->name('dokumen.show');
    Route::delete('dokumen/destroy/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
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
    Route::post('/get_agenda', [AgendaController::class, 'get_agenda'])->name('get_agenda');
    // monitoring untuk statistik
    Route::view('monitoring','monitoring/index')->name('monitoring');
    // terminasi
    Route::get('terminasi/index/', [TerminasiController::class, 'index'])->name('terminasi');
    Route::post('terminasi/store/', [TerminasiController::class, 'store'])->name('terminasi.store');
    // catatan
    Route::get('catatan/index/', [CatatanController::class, 'index'])->name('catatan');
    Route::post('catatan/store/', [CatatanController::class, 'store'])->name('catatan.store');
    Route::get('catatan/edit/{uuid}',[CatatanController::class, 'edit'])->name('catatan.edit');
    // check kelengkapan
    Route::get('/check_kelengkapan_data/{id}', [KasusController::class, 'check_kelengkapan_data'])->name('check_kelengkapan_data');
    Route::get('/check_kelengkapan_persetujuan_spv/{id}', [KasusController::class, 'check_kelengkapan_persetujuan_spv'])->name('check_kelengkapan_persetujuan_spv');
    Route::get('/check_kelengkapan_spp/{id}', [KasusController::class, 'check_kelengkapan_spp'])->name('check_kelengkapan_spp');
    Route::get('/check_kelengkapan_asesmen/{id}', [KasusController::class, 'check_kelengkapan_asesmen'])->name('check_kelengkapan_asesmen');
    Route::get('/check_kelengkapan_perencanaan/{id}', [KasusController::class, 'check_kelengkapan_perencanaan'])->name('check_kelengkapan_perencanaan');
    Route::get('/check_kelengkapan_pelaksanaan/{id}', [KasusController::class, 'check_kelengkapan_pelaksanaan'])->name('check_kelengkapan_pelaksanaan');
    Route::get('/check_kelengkapan_monitoring/{id}', [KasusController::class, 'check_kelengkapan_monitoring'])->name('check_kelengkapan_monitoring');
    Route::get('/check_kelengkapan_terminasi/{id}', [KasusController::class, 'check_kelengkapan_terminasi'])->name('check_kelengkapan_terminasi');
    // monitoring untuk statistik
    Route::get('publicurl/index/', [PublicUrlController::class, 'index'])->name('publicurl');
    Route::post('publicurl/store/', [PublicUrlController::class, 'store'])->name('publicurl.store');
    Route::get('publicurl/show/{uuid}',[PublicUrlController::class, 'show'])->name('publicurl.show');
    Route::get('publicurl/kasus',[PublicUrlController::class, 'kasus'])->name('publicurl.kasus');
});

require __DIR__.'/auth.php';
