<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Klien;
use App\Models\Pelapor;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Province;
use Yajra\DataTables\Facades\DataTables;


class KasusController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('klien as a')
                        ->select('a.uuid', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 'a.jenis_kelamin', 'a.tanggal_lahir', 'a.status', 'a.uuid', 'd.name as petugas')
                        ->leftJoin('kasus as b', 'b.id', 'a.kasus_id')
                        ->leftJoin('petugas as c', 'a.id', 'c.klien_id')
                        ->leftJoin('users as d', 'd.id', 'a.created_by')
                        ->groupBy('a.id');
            if (Auth::user()->supervisor_id != 0) { // petugas penerima pengaduan tidak masalah bisa melihat semua kasus
                $data->where('c.user_id', Auth::user()->id);
            }
            return DataTables::of($data->get())->make(true);
       }

       return view('kasus.index');
    }

    public function show(Request $request, $uuid)
    {
        if($request->ajax()) { //dipakai di datatable
            $data = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'b.id', 'a.kasus_id')
                        ->leftJoin('petugas as c', 'a.id', 'c.klien_id')
                        ->leftJoin('users as d', 'd.id', 'a.created_by')
                        ->leftJoin('terlapor as e', 'b.id', 'e.kasus_id')
                        ->where('a.uuid', $request->uuid)
                        ->first(['b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 
                        'a.jenis_kelamin', 'a.tanggal_lahir', 'a.jenis_kelamin', 
                        'a.status', 'a.uuid', 'd.name as petugas']);
            return $data;
       }

       $status_pendidikan =  app('App\Http\Controllers\OpsiController')->api_status_pendidikan();
       $pendidikan_terakhir =  app('App\Http\Controllers\OpsiController')->api_pendidikan_terakhir();
       $kelas =  app('App\Http\Controllers\OpsiController')->api_kelas();
       $agama =  app('App\Http\Controllers\OpsiController')->api_agama();
       $suku =  app('App\Http\Controllers\OpsiController')->api_suku();
       $pekerjaan =  app('App\Http\Controllers\OpsiController')->api_pekerjaan();
       $status_perkawinan =  app('App\Http\Controllers\OpsiController')->api_status_perkawinan();
       $hubungan_dengan_terlapor =  app('App\Http\Controllers\OpsiController')->api_hubungan_dengan_terlapor();
       $hubungan_dengan_klien =  app('App\Http\Controllers\OpsiController')->api_hubungan_dengan_klien();
       $kekhususan =  app('App\Http\Controllers\OpsiController')->api_kekhususan();
       $difabel_type =  app('App\Http\Controllers\OpsiController')->api_difabel_type();
       $kategori_kasus =  app('App\Http\Controllers\OpsiController')->api_kategori_kasus();
       $tindak_kekerasan =  app('App\Http\Controllers\OpsiController')->api_tindak_kekerasan();
       $pengadilan_negri =  app('App\Http\Controllers\OpsiController')->api_pengadilan_negri();
       $pasal = app('App\Http\Controllers\OpsiController')->api_pasal();
       $media_pengaduan =  app('App\Http\Controllers\OpsiController')->api_media_pengaduan();
       $sumber_rujukan =  app('App\Http\Controllers\OpsiController')->api_sumber_rujukan();
       $sumber_informasi =  app('App\Http\Controllers\OpsiController')->api_sumber_infromasi();
       $program_pemerintah =  app('App\Http\Controllers\OpsiController')->api_program_pemerintah();
       $tempat_kejadian =  app('App\Http\Controllers\OpsiController')->api_tempat_kejadian();
       $users =  app('App\Http\Controllers\OpsiController')->api_petugas(); //untuk tambah petugas
       $provinsi = Province::get();

       //data klien (nanti edit lagi)
       $klien = DB::table('klien as a')
                    ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan, e.difabel_type, f.kondisi_khusus'))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->leftJoin(DB::raw('(SELECT klien_id, GROUP_CONCAT(" ", value) as difabel_type FROM difabel_type GROUP BY klien_id) as e'), 'a.id', 'e.klien_id')
                    ->leftJoin(DB::raw('(SELECT klien_id, GROUP_CONCAT(" ", value) as kondisi_khusus FROM kondisi_khusus GROUP BY klien_id) as f'), 'a.id', 'f.klien_id')
                    ->where('a.uuid', $uuid)
                    ->groupBy('a.id')
                    ->first();
        $akses = Petugas::where('klien_id', $klien->id)->where('user_id', Auth::user()->id)->first();
        if (!isset($akses)) {
            return abort(404);
        }

       //data kasus (nanti edit lagi)
       $kasus = DB::table('kasus as a')
                    ->where('a.uuid', $klien->kasus_id)
                    ->select(DB::raw('a.id'))
                    ->first();
       //data pelapor
       $pelapor = DB::table('pelapor as a')
                    ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->first();
        //data terlapor
        $terlapor = DB::table('terlapor as a')
                    ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->where('a.kasus_id', $klien->kasus_id)
                    ->get();
        //data petugas
        $petugas = DB::table('petugas as a')
                    ->select(DB::raw('a.*, b.name, b.jabatan'))
                    ->leftJoin('users as b','a.user_id', 'b.id')
                    ->where('a.klien_id', $klien->id)
                    ->whereNULL('a.deleted_at')
                    ->orderBy('a.created_at')
                    ->get();
        //data surat persetujuan
        $persetujuan = DB::table('persetujuan_isi as a')
                    ->select(DB::raw('a.*, b.judul'))
                    ->leftJoin('persetujuan_template as b', 'a.persetujuan_template_id', 'b.id')
                    ->where('a.klien_id', $klien->id)
                    ->whereNULL('a.deleted_at')
                    ->orderBy('a.created_at')
                    ->get();
        //data surat template persetujuan 
        $persetujuan_template = PersetujuanTemplate::whereNULL('deleted_at')->get();

        $status['jumlah_layanan'] = DB::table(('agenda as a'))
                                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                                        ->where('a.klien_id', $klien->id)
                                        ->whereNull('a.deleted_at')
                                        ->whereNull('b.deleted_at')
                                        ->count();
        $status['jumlah_layanan_selesai'] = DB::table(('agenda as a'))
                                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                                        ->where('a.klien_id', $klien->id)
                                        ->whereNull('a.deleted_at')
                                        ->whereNull('b.deleted_at')
                                        ->whereNotNull('b.tanggal_selesai')
                                        ->count();

       return view('kasus.show')
                ->with('klien', $klien)
                ->with('pelapor', $pelapor)
                ->with('terlapor', $terlapor)
                ->with('provinsi', $provinsi)
                ->with('status_pendidikan', $status_pendidikan)
                ->with('pendidikan_terakhir', $pendidikan_terakhir)
                ->with('kelas', $kelas)
                ->with('agama', $agama)
                ->with('suku', $suku)
                ->with('pekerjaan', $pekerjaan)
                ->with('status_perkawinan', $status_perkawinan)
                ->with('hubungan_dengan_terlapor', $hubungan_dengan_terlapor)
                ->with('hubungan_dengan_klien', $hubungan_dengan_klien)
                ->with('kekhususan', $kekhususan)
                ->with('difabel_type', $difabel_type)
                ->with('kategori_kasus', $kategori_kasus)
                ->with('tindak_kekerasan', $tindak_kekerasan)
                ->with('pengadilan_negri', $pengadilan_negri)
                ->with('pasal', $pasal)
                ->with('media_pengaduan', $media_pengaduan)
                ->with('sumber_rujukan', $sumber_rujukan)
                ->with('sumber_informasi', $sumber_informasi)
                ->with('program_pemerintah', $program_pemerintah)
                ->with('tempat_kejadian',$tempat_kejadian)
                ->with('users',$users)
                ->with('petugas',$petugas)
                ->with('persetujuan',$persetujuan)
                ->with('persetujuan_template',$persetujuan_template)
                ->with('status',$status);
    }

    public function set_status($uuid)
    {
        $klien = Klien::where('uuid', $uuid)->first();

        // $petugas ;
        if ($klien = '') {
            # code...
        }
    }
}
