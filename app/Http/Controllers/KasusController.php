<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Pelapor;
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
                        ->leftJoin('kasus as b', 'b.id', 'a.kasus_id')
                        ->leftJoin('petugas as c', 'a.id', 'c.klien_id')
                        ->leftJoin('users as d', 'd.id', 'a.created_by')
                        ->get(['a.uuid', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 'a.jenis_kelamin', 'a.tanggal_lahir', 'a.status', 'a.uuid', 'd.name as petugas']);
            if (Auth::user()->supervisor_id != 0) { // petugas penerima pengaduan tidak masalah bisa melihat semua kasus
                $data->where('c.user_id', Auth::user()->id);
            }
            return DataTables::of($data)->make(true);
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
       $pasal =  app('App\Http\Controllers\OpsiController')->api_pasal();
       $media_pengaduan =  app('App\Http\Controllers\OpsiController')->api_media_pengaduan();
       $sumber_rujukan =  app('App\Http\Controllers\OpsiController')->api_sumber_rujukan();
       $sumber_informasi =  app('App\Http\Controllers\OpsiController')->api_sumber_infromasi();
       $program_pemerintah =  app('App\Http\Controllers\OpsiController')->api_program_pemerintah();
       $provinsi = Province::get();

       //data klien (nanti edit lagi)
       $klien = DB::table('klien as a')
                    ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'c.province_code', 'b.code')
                    ->leftJoin('indonesia_districts as d', 'd.city_code', 'c.code')
                    ->where('a.uuid', $uuid)
                    ->first();

       //data kasus (nanti edit lagi)
       $kasus = DB::table('kasus as a')
                    ->where('a.uuid', $klien->kasus_id)
                    ->select(DB::raw('a.id'))
                    ->first();
       //data pelapor
       $pelapor = DB::table('pelapor as a')
                    ->select(DB::raw('a.*, b.name as provinsi, c.name as kota, d.name as kecamatan'))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'c.province_code', 'b.code')
                    ->leftJoin('indonesia_districts as d', 'd.city_code', 'c.code')
                    ->first();

       return view('kasus.show')
                ->with('klien', $klien)
                ->with('pelapor', $pelapor)
                ->with('provinsi', $provinsi)
                ->with('status_pendidikan', $status_pendidikan)
                ->with('pendidikan_terakhir', $pendidikan_terakhir)
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
                ->with('program_pemerintah', $program_pemerintah);
    }
}
