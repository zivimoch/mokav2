<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\FormPenerimaPengaduan;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\LogActivityControler;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PemantauanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PublicUrlController;
use App\Http\Controllers\RiwayatKejadianController;
use App\Http\Controllers\SettingBentukKekerasanController;
use App\Http\Controllers\SettingJenisKekerasanController;
use App\Http\Controllers\SettingKategoriKasusController;
use App\Http\Controllers\SettingUsersController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TerminasiController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WebSettingsController;
use App\Models\Agenda;
use App\Models\Petugas;
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
// penerimaan pengaduan
Route::get('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'index'])->name('formpenerimapengaduan.index');
Route::post('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'store'])->name('formpenerimapengaduan.store');
// persetujuan
Route::get('persetujuan/show/{uuid}', [PersetujuanController::class, 'show'])->name('persetujuan.show');
Route::post('persetujuan', [PersetujuanController::class, 'store'])->name('persetujuan.store');
Route::get('persetujuan/donepelayanan/{uuid}', [PersetujuanController::class, 'donepelayanan'])->name('persetujuan.done');
Route::view('blankpage','blankpage')->name('blankpage');
// carik
Route::get('carik/{id}', [FormPenerimaPengaduan::class, 'carik'])->name('carik');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
     // pengumuman
     Route::get('pengumuman/index/', [PengumumanController::class, 'index'])->name('pengumuman');
     Route::post('pengumuman/store/', [PengumumanController::class, 'store'])->name('pengumuman.store');
     Route::get('pengumuman/edit/{uuid}',[PengumumanController::class, 'edit'])->name('pengumuman.edit');
     // edit data formulir / data master 
    Route::put('formpenerimapengaduan', [FormPenerimaPengaduan::class, 'update'])->name('formpenerimapengaduan.update');
    Route::post('formpenerimapengaduan/storeterlapor', [FormPenerimaPengaduan::class, 'store_terlapor'])->name('formpenerimapengaduan.store_terlapor');
    Route::post('formpenerimapengaduan/deleteterlapor/', [FormPenerimaPengaduan::class, 'deleteterlapor'])->name('formpenerimapengaduan.deleteterlapor');
    // kasus
    Route::get('kasus', [KasusController::class, 'index'])->name('kasus');
    Route::get('kasus/show/{uuid}', [KasusController::class, 'show'])->name('kasus.show');
    Route::post('kasus/approval/{uuid}', [KasusController::class, 'approval'])->name('kasus.approval');
    Route::get('/check_kelengkapan_data/{id}', [KasusController::class, 'check_kelengkapan_data'])->name('check_kelengkapan_data');
    // Route::view('kasus/detail/','/kasus/detail')->name('kasus.detail');
    Route::post('/get_klien', [KasusController::class, 'get_klien'])->name('get_klien');
    // hapus klien dari kasus
    Route::delete('kasus/destroy/{id}', [KasusController::class, 'destroy'])->name('kasus.destroy');
    Route::put('kasus/arsip/{uuid}', [KasusController::class, 'arsip'])->name('kasus.arsip');
    // persetujuan
    Route::post('persetujuan/create/{uuid}', [PersetujuanController::class, 'create'])->name('persetujuan.create');
    Route::delete('persetujuan/destroy/{id}', [PersetujuanController::class, 'destroy'])->name(('persetujuan.destroy'));
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
    Route::put('asesmen', [AsesmenController::class, 'update'])->name('asesmen.update');
    Route::get('asesmen/index/', [AsesmenController::class, 'index'])->name('asesmen');
    Route::post('asesmen/store/', [AsesmenController::class, 'store'])->name('asesmen.store');
    Route::delete('asesmen/destroy/{id}', [AsesmenController::class, 'destroy'])->name('asesmen.destroy');
    // pemantauan
    Route::get('pemantauan/index/', [PemantauanController::class, 'index'])->name('pemantauan');
    Route::post('pemantauan/store/', [PemantauanController::class, 'store'])->name('pemantauan.store');
    Route::delete('pemantauan/destroy/{id}', [PemantauanController::class, 'destroy'])->name('pemantauan.destroy');
    //notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/pull_notif', [NotifikasiController::class, 'pull_notif'])->name('notifikasi.pull_notif');
    Route::get('/notifikasi/pull_all', [NotifikasiController::class, 'pull_all'])->name('notifikasi.pull_all');
    // dokumen
    Route::get('dokumen',[DokumenController::class, 'index'])->name('dokumen');
    Route::post('/get_dokumen', [DokumenController::class, 'get_dokumen'])->name('get_dokumen');
    Route::get('dokumen/add',[DokumenController::class, 'add'])->name('dokumen.add');
    Route::get('dokumen/create',[DokumenController::class, 'create'])->name('dokumen.create');
    Route::get('dokumen/edit/{uuid}',[DokumenController::class, 'edit'])->name('dokumen.edit');
    Route::put('dokumen/update/{uuid}',[DokumenController::class, 'update'])->name('dokumen.update');
    Route::post('dokumen/store',[DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('dokumen/show/{uuid}',[DokumenController::class, 'show'])->name('dokumen.show');
    Route::delete('dokumen/destroy/{id}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    // template
    Route::get('template', [TemplateController::class, 'index'])->name('template');
    Route::get('template/create', [TemplateController::class, 'create'])->name('template.create');
    Route::get('template/edit/{uuid}',[TemplateController::class, 'edit'])->name('template.edit');
    Route::post('template/store', [TemplateController::class, 'store'])->name('template.store');
    Route::get('template/show/{uuid}',[TemplateController::class, 'show'])->name('template.show');
    Route::put('template/update/{uuid}',[TemplateController::class, 'update'])->name('template.update');
    Route::delete('template/destroy/{id}', [TemplateController::class, 'destroy'])->name('template.destroy');
    // agenda & kinerja
    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda');
    Route::get('agenda/api_index', [AgendaController::class, 'api_index']);
    Route::get('agenda/resume_layanan', [AgendaController::class, 'resume_layanan']);
    Route::get('agenda/show/{uuid}', [AgendaController::class, 'show'])->name('agenda.show');
    Route::get('agenda/showdate/{date}', [AgendaController::class, 'showdate'])->name('agenda.showdate');
    Route::post('agenda/store', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('agenda/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::get('agenda/pdf_kinerja', [AgendaController::class, 'pdf_kinerja'])->name('pdf_kinerja');
    Route::post('/get_keyword', [AgendaController::class, 'get_keyword'])->name('get_keyword');
    Route::get('kinerja', [AgendaController::class, 'kinerja'])->name('kinerja');
    Route::get('kinerja/detail', [AgendaController::class, 'kinerja_detail'])->name('kinerja.detail');
    Route::get('kinerja/ajax', [AgendaController::class, 'kinerja_ajax'])->name('kinerja_ajax');
    Route::post('kinerja/valid', [AgendaController::class, 'kinerja_valid'])->name('kinerja_valid');
    Route::post('/get_agenda', [AgendaController::class, 'get_agenda'])->name('get_agenda');
    // terminasi
    Route::get('terminasi/index', [TerminasiController::class, 'index'])->name('terminasi');
    Route::post('terminasi/store/', [TerminasiController::class, 'store'])->name('terminasi.store');
    // catatan
    Route::get('catatan/index/', [CatatanController::class, 'index'])->name('catatan');
    Route::post('catatan/store/', [CatatanController::class, 'store'])->name('catatan.store');
    Route::get('catatan/edit/{uuid}',[CatatanController::class, 'edit'])->name('catatan.edit');
    Route::post('catatan/store_hukum/',[CatatanController::class, 'store_hukum'])->name('catatan.store_hukum');
    Route::post('catatan/store_psikologis/',[CatatanController::class, 'store_psikologis'])->name('catatan.store_psikologis');
    // check kelengkapan
    Route::get('/check_kelengkapan_data/{id}', [KasusController::class, 'check_kelengkapan_data'])->name('check_kelengkapan_data');
    Route::get('/check_kelengkapan_persetujuan_spv/{id}', [KasusController::class, 'check_kelengkapan_persetujuan_spv'])->name('check_kelengkapan_persetujuan_spv');
    Route::get('/check_kelengkapan_spp/{id}', [KasusController::class, 'check_kelengkapan_spp'])->name('check_kelengkapan_spp');
    Route::get('/check_kelengkapan_asesmen/{id}', [KasusController::class, 'check_kelengkapan_asesmen'])->name('check_kelengkapan_asesmen');
    Route::get('/check_kelengkapan_perencanaan/{id}', [KasusController::class, 'check_kelengkapan_perencanaan'])->name('check_kelengkapan_perencanaan');
    Route::get('/check_kelengkapan_pelaksanaan/{id}', [KasusController::class, 'check_kelengkapan_pelaksanaan'])->name('check_kelengkapan_pelaksanaan');
    Route::get('/check_kelengkapan_pemantauan/{id}', [KasusController::class, 'check_kelengkapan_pemantauan'])->name('check_kelengkapan_pemantauan');
    Route::get('/check_kelengkapan_terminasi/{id}', [KasusController::class, 'check_kelengkapan_terminasi'])->name('check_kelengkapan_terminasi');
    // untuk url persetujuan
    Route::get('publicurl/index/', [PublicUrlController::class, 'index'])->name('publicurl');
    Route::post('publicurl/store/', [PublicUrlController::class, 'store'])->name('publicurl.store');
    Route::get('publicurl/show/{uuid}',[PublicUrlController::class, 'show'])->name('publicurl.show');
    Route::get('publicurl/kasus',[PublicUrlController::class, 'kasus'])->name('publicurl.kasus');
    // pemantauan untuk statistik
    Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('monitoring/monitoringkasus', [MonitoringController::class, 'monitoring_kasus'])->name('monitor.monitoringkasus');
    Route::get('monitoring/sheets', [MonitoringController::class, 'sheets'])->name('monitor.sheets');
    // log activity
    Route::get('logactivity/index/', [LogActivityControler::class, 'index'])->name('logactivity');
    // users, setting individual user
    Route::get('users/show/{uuid}', [UsersController::class, 'show'])->name('users.show');
    Route::get('users/websettings/{uuid}', [UsersController::class, 'websettings'])->name('users.websettings');
    Route::put('users', [UsersController::class, 'update'])->name('users.update');
    Route::post('users/cropimage', [UsersController::class, 'cropImageUploadAjax']);
    // web settings
    Route::get('websettings', [WebSettingsController::class, 'index'])->name('websettings');
    Route::get('websettings/kategorikasus', [WebSettingsController::class, 'kategori_kasus'])->name('websettings.kategorikasus');
    Route::get('settingjeniskekerasan', [SettingJenisKekerasanController::class, 'index'])->name('settingjeniskekerasan');
    Route::post('settingjeniskekerasan/store/', [SettingJenisKekerasanController::class, 'store'])->name('settingjeniskekerasan.store');
    Route::get('settingjeniskekerasan/edit/{id}', [SettingJenisKekerasanController::class, 'edit'])->name('settingjeniskekerasan.edit');
    Route::delete('settingjeniskekerasan/destroy/{id}', [SettingJenisKekerasanController::class, 'destroy'])->name('settingjeniskekerasan.destroy');
    Route::get('settingbentukkekerasan', [SettingBentukKekerasanController::class, 'index'])->name('settingbentukkekerasan');
    Route::post('settingbentukkekerasan/store/', [SettingBentukKekerasanController::class, 'store'])->name('settingbentukkekerasan.store');
    Route::get('settingbentukkekerasan/edit/{id}', [SettingBentukKekerasanController::class, 'edit'])->name('settingbentukkekerasan.edit');
    Route::delete('settingbentukkekerasan/destroy/{id}', [SettingBentukKekerasanController::class, 'destroy'])->name('settingbentukkekerasan.destroy');
    Route::get('settingkategorikasus', [SettingKategoriKasusController::class, 'index'])->name('settingkategorikasus');
    Route::post('settingkategorikasus/store/', [SettingKategoriKasusController::class, 'store'])->name('settingkategorikasus.store');
    Route::get('settingkategorikasus/edit/{id}', [SettingKategoriKasusController::class, 'edit'])->name('settingkategorikasus.edit');
    Route::delete('settingkategorikasus/destroy/{id}', [SettingKategoriKasusController::class, 'destroy'])->name('settingkategorikasus.destroy');
    Route::get('websettings/users', [WebSettingsController::class, 'users'])->name('websettings.users');
    Route::get('settingusers', [SettingUsersController::class, 'index'])->name('settingusers');
    Route::post('settingusers/store/', [SettingUsersController::class, 'store'])->name('settingusers.store');
    Route::get('settingusers/edit/{id}', [SettingUsersController::class, 'edit'])->name('settingusers.edit');
    Route::delete('settingusers/destroy/{id}', [SettingUsersController::class, 'destroy'])->name('settingusers.destroy');
    // auto fill (hapus fungsi ini kelak)
    Route::get('autofillnokas', [KasusController::class, 'autofill_nokas'])->name('autofillnokas');
});

require __DIR__.'/auth.php';
