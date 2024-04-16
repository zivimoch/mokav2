<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Asesmen;
use App\Models\Kasus;
use App\Models\Klien;
use App\Models\Notifikasi;
use App\Models\Pemantauan;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use App\Models\RHubunganTerlaporKlien;
use App\Models\TBentukKekerasan;
use App\Models\Terlapor;
use App\Models\Terminasi;
use App\Models\TJenisKekerasan;
use App\Models\TKategoriKasus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Exception;
use Illuminate\Support\Facades\Schema;
use Laravolt\Indonesia\Models\City;

class KasusController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            // mendapatkan periode
            if ($request->get('tanggal') != null) {
                $daterange = explode (" - ", $request->get('tanggal')); 
            }else{
                $daterange[0] = date("Y").'-01-01';
                $daterange[1] = date("Y-m-d");
            }
            $from = $daterange[0];
            $to = $daterange[1];

            $data = DB::table('klien as a')
                        ->select('a.uuid', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 'a.jenis_kelamin', 'a.tanggal_lahir', 'a.status', 'd.name as petugas')
                        ->leftJoin('kasus as b', 'b.id', 'a.kasus_id')
                        ->leftJoin('petugas as c', 'a.id', 'c.klien_id')
                        ->leftJoin('users as d', 'd.id', 'a.created_by')
                        ->leftJoin(DB::raw('(SELECT a.id, a.kotkab_id, b.klien_id  
                                            FROM users a 
                                            LEFT JOIN petugas b ON a.id = b.user_id
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL) z'), 'z.klien_id', '=', 'a.id')
                        ->whereNull('a.deleted_at')
                        ->whereNull('c.deleted_at')
                        ->groupBy('a.uuid', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 'a.jenis_kelamin', 'a.tanggal_lahir', 'a.status', 'd.name')
                        ;
        
            // filter tanggal 
            if (isset($request->basis_tanggal)) {
                # jika ada, jika tidak ada berarti untuk tabel LaporKBG (gpp itu tahun berapapun)
                $data->whereBetween('b.'.$request->basis_tanggal, [$from, $to]);
            }
            // jika lapor KBG == 1 maka tampilkan kasus yang laporKBG
            if ($request->laporkbg == 1) {
                $data->whereNull(('a.created_by'));
            }
            // filter basis wilayah & wilayah
            if ($request->wilayah != 'default') {
                if ($request->basis_wilayah == 'tkp') {
                    $data->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
                } elseif ($request->basis_wilayah == 'ktp') {
                    $data->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
                } elseif ($request->basis_wilayah == 'satpel') {
                    $data->where('z.kotkab_id', $request->wilayah);
                }
            }
            // filter untuk memunculkan kasus sesuai yang login saja
            if (!$request->anda && $request->laporkbg != 1) { 
                $data->where('c.user_id', Auth::user()->id);
            }
            // filter arsip, sebagai default arsip = 0
            if ($request->arsip) {
                $arsip = 1;
            }else{
                $arsip = 0;
            }
            // Filter basis perhitungan usia klien
            if ($request->penghitungan_usia == 'lapor') {
                $penguarang = 'b.tanggal_pelaporan';
            } elseif ($request->penghitungan_usia == 'kejadian') {
                $penguarang = 'b.tanggal_kejadian';
            } elseif ($request->penghitungan_usia == 'input') {
                $penguarang = 'b.created_at';
            } else {
                $penguarang = 'CURDATE()'; // Default to current date
            }

            // Filter kategori klien
            if ($request->kategoriklien == 'dewasa') {
                $data->whereRaw("TIMESTAMPDIFF(YEAR, a.tanggal_lahir, ".$penguarang.") >= 18"); 
            } elseif ($request->kategoriklien == 'anak') {
                $data->whereRaw("TIMESTAMPDIFF(YEAR, a.tanggal_lahir, ".$penguarang.") < 18"); 
            }
            // $data->orderBy('a.updated_at');
            $data->where('a.arsip', $arsip);
            
            $datas = $data->get();
            foreach ($datas as $datas2) {
                $datas2->tanggal_pelaporan_formatted = date('d M Y', strtotime($datas2->tanggal_pelaporan));
            }

            return DataTables::of($datas)->make(true);
       }
       
       // ===========================================================================================
        //Proses read, push notif & log activity ////////////////////////////////////////////////////
        // jika petugas sudah melihat data kasus maka tasknya (T3, T6) selesai
        NotifHelper::read_notif(
            Auth::user()->id, // receiver_id
            $request->klien_id, // klien_id
            $request->kode, // kode ini request dari link 
            $request->type_notif, // type_notif
            $request->agenda_id // agenda_id
        );
        /////////////////////////////////////////////////////////////////////////////////////////////

        $kota = City::where('province_code', env('id_provinsi'))->get();
        return view('kasus.index')
                    ->with('kota', $kota);
    }

    //untuk select2 list klien, dia methodnya POST
    public function get_klien(Request $request)
    {
        $search = $request->search;

        $data = DB::table('petugas as a')
                            ->leftJoin('klien as b', 'b.id','a.klien_id')
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderby('a.created_at','asc');
        if($search != ''){
            $data = $data->where('b.nama', 'like', '%' .$search . '%');
        }
        if (Auth::user()->jabatan != 'Super Admin') {
            // super admin dapat memilih seluruh klien
            $data = $data->where('user_id', Auth::user()->id);
        }
        $data = $data->select('b.id','b.nama')->limit(10)->get();
  
        $response = array();
        foreach($data as $value){
           $response[] = array(
                "id"=>$value->id,
                "text"=>$value->nama
           );
        }
        return response()->json($response); 
        
    }

    public function show(Request $request, $uuid)
    {
        if($request->ajax()) { //dipakai di datatable
            $data = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'b.id', 'a.kasus_id')
                        ->leftJoin('petugas as c', 'a.id', 'c.klien_id')
                        ->leftJoin('users as d', 'd.id', 'a.created_by')
                        ->leftJoin('terlapor as e', 'b.id', 'e.kasus_id');
            if ($request->klien_id) {
                // jika ada maka cari berdasarkan id. digunakan di modal agenda buat memunculkan detail data klien
                $data = $data->where('a.id', $request->klien_id);
            }else{
                // jika ada maka cari berdasarkan uuid. digunakan di index list klien
                $data = $data->where('a.uuid', $request->uuid);
            }

            $data = $data->first(['a.id', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 
            'a.jenis_kelamin', 'a.tanggal_lahir', 'a.jenis_kelamin', 
            'a.status', 'a.uuid', 'd.name as petugas', 'a.arsip']);

            $data->list_petugas = DB::table('petugas as a')
                                    ->leftJoin('users as b', 'a.user_id', 'b.id')
                                    ->whereNull('a.deleted_at')
                                    ->where('a.klien_id', $data->id)
                                    ->get();
            
            return $data;
       }

       $status_pendidikan =  (new OpsiController)->api_status_pendidikan();
       $pendidikan_terakhir =  (new OpsiController)->api_pendidikan_terakhir();
       $kelas =  (new OpsiController)->api_kelas();
       $agama =  (new OpsiController)->api_agama();
       $suku =  (new OpsiController)->api_suku();
       $pekerjaan =  (new OpsiController)->api_pekerjaan();
       $status_perkawinan =  (new OpsiController)->api_status_perkawinan();
       $hubungan_dengan_terlapor =  (new OpsiController)->api_hubungan_dengan_terlapor();
       $hubungan_dengan_klien =  (new OpsiController)->api_hubungan_dengan_klien();
       $kekhususan =  (new OpsiController)->api_kekhususan();
       $pengadilan_negri =  (new OpsiController)->api_pengadilan_negri();
       $pasal = (new OpsiController)->api_pasal();
       $media_pengaduan =  (new OpsiController)->api_media_pengaduan();
       $sumber_rujukan =  (new OpsiController)->api_sumber_rujukan();
       $sumber_informasi =  (new OpsiController)->api_sumber_infromasi();
       $program_pemerintah =  (new OpsiController)->api_program_pemerintah();
       $kategori_lokasi =  (new OpsiController)->api_kategori_lokasi();
       $users =  (new OpsiController)->api_petugas(); //untuk tambah petugas
       $provinsi = Province::get();

       //data klien 
       $klien = DB::table('klien as a')
       ->select(
           'a.*',
           'b.name as provinsi', // domisili
           'c.name as kota', // domisili
           'd.name as kecamatan', // domisili
           'e.name as kelurahan', // domisili
           'f.name as provinsi_ktp',
           'g.name as kota_ktp',
           'h.name as kecamatan_ktp',
           'i.name as kelurahan_ktp',
           DB::raw('(SELECT GROUP_CONCAT(" ", value) FROM t_kedaruratan WHERE klien_id = a.id) as t_kedaruratan'),
           DB::raw('(SELECT GROUP_CONCAT(" ", value) FROM t_kategori_kasus WHERE klien_id = a.id) as t_kategori_kasus'),
           DB::raw('(SELECT GROUP_CONCAT(" ", value) FROM t_program_pemerintah WHERE klien_id = a.id) as t_program_pemerintah')
       )
       ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
       ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
       ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
       ->leftJoin('indonesia_villages as e', 'a.kelurahan_id', 'e.code')
       ->leftJoin('indonesia_provinces as f', 'a.provinsi_id_ktp', 'f.code')
       ->leftJoin('indonesia_cities as g', 'a.kotkab_id_ktp', 'g.code')
       ->leftJoin('indonesia_districts as h', 'a.kecamatan_id_ktp', 'h.code')
       ->leftJoin('indonesia_villages as i', 'a.kelurahan_id_ktp', 'i.code')
       ->where('a.uuid', $uuid)
       ->limit(1)
       ->first();
   

        // hanya petugas yang ada di list petugas yang dapat mengakses
        // $akses = Petugas::where('klien_id', $klien->id)->where('user_id', Auth::user()->id)->first();
        // if (!isset($akses) && !in_array(Auth::user()->jabatan, ['Super Admin', 'Tenaga Ahli', 'Kepala Instansi', 'Tim Data'])) {
        //     return abort(404);
        // }

       //data kasus 
       $kasus = DB::table('kasus as a')
                    ->select(DB::raw(
                        'a.*,
                        b.name as provinsi,
                        c.name as kota,
                        d.name as kecamatan,
                        e.name as kelurahan'
                    ))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->leftJoin('indonesia_villages as e', 'a.kelurahan_id', 'e.code')
                    ->where('a.id', $klien->kasus_id)
                    ->first();
       //data pelapor
       $pelapor = DB::table('pelapor as a')
                    ->select(DB::raw(
                        'a.*,
                        b.name as provinsi,
                        c.name as kota,
                        d.name as kecamatan,
                        e.name as kelurahan,
                        f.name as provinsi_ktp,
                        g.name as kota_ktp,
                        h.name as kecamatan_ktp,
                        i.name as kelurahan_ktp',
                    ))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->leftJoin('indonesia_villages as e', 'a.kelurahan_id', 'e.code')
                    ->leftJoin('indonesia_provinces as f', 'a.provinsi_id_ktp', 'f.code')
                    ->leftJoin('indonesia_cities as g', 'a.kotkab_id_ktp', 'g.code')
                    ->leftJoin('indonesia_districts as h', 'a.kecamatan_id_ktp', 'h.code')
                    ->leftJoin('indonesia_villages as i', 'a.kelurahan_id_ktp', 'i.code')
                    ->where('a.kasus_id', $klien->kasus_id)
                    ->first();
        //data terlapor
        $terlapor = DB::table('terlapor as a')
                    ->select(DB::raw(
                        'a.*,
                        b.name as provinsi,
                        c.name as kota,
                        d.name as kecamatan,
                        e.name as kelurahan,
                        f.name as provinsi_ktp,
                        g.name as kota_ktp,
                        h.name as kecamatan_ktp,
                        i.name as kelurahan_ktp,
                        j.value as hubungan_terlapor
                        '
                        ))
                    ->leftJoin('indonesia_provinces as b', 'a.provinsi_id', 'b.code')
                    ->leftJoin('indonesia_cities as c', 'a.kotkab_id', 'c.code')
                    ->leftJoin('indonesia_districts as d', 'a.kecamatan_id', 'd.code')
                    ->leftJoin('indonesia_villages as e', 'a.kelurahan_id', 'e.code')
                    ->leftJoin('indonesia_provinces as f', 'a.provinsi_id_ktp', 'f.code')
                    ->leftJoin('indonesia_cities as g', 'a.kotkab_id_ktp', 'g.code')
                    ->leftJoin('indonesia_districts as h', 'a.kecamatan_id_ktp', 'h.code')
                    ->leftJoin('indonesia_villages as i', 'a.kelurahan_id_ktp', 'i.code')
                    ->leftJoin('r_hubungan_terlapor_klien as j', 'j.terlapor_id', 'a.id')
                    ->where('a.kasus_id', $klien->kasus_id)
                    ->whereNull('a.deleted_at')
                    ->get();
        // data rekam kasus
        $rekam_kasus = Asesmen::where('klien_id', $klien->id)->first();

        // data jenis kekerasan
        $jenis_kekerasan = DB::table('t_jenis_kekerasan as a')
                            ->select('a.value','b.nama')
                            ->leftJoin('m_jenis_kekerasan as b', 'a.value', 'b.kode')
                            ->where('a.klien_id', $klien->id)
                            ->get();
        // data bentuk kekerasan
        $bentuk_kekerasan = DB::table('t_bentuk_kekerasan as a')
                                ->select('a.value','b.nama')
                                ->leftJoin('m_bentuk_kekerasan as b', 'a.value', 'b.kode')
                                ->where('a.klien_id', $klien->id)
                                ->get();
        $bentuk_kekerasans = DB::table('m_jenis_kekerasan as a')
                            ->select('a.nama as jenis_nama', 'c.nama as bentuk_nama')
                            ->join('t_jenis_kekerasan as b', 'a.kode', '=', 'b.value')
                            ->join('m_bentuk_kekerasan as c', 'c.jenis_kekerasan_kode', '=', 'a.kode')
                            ->join('t_bentuk_kekerasan as d', 'c.kode', '=', 'd.value')
                            ->where('b.klien_id', $klien->id)
                            ->where('d.klien_id', $klien->id)
                            ->get();
        // Organize the data for easier processing
        $bentuk_kekerasan_sets = [];
        foreach ($bentuk_kekerasans as $data) {
            $jenisNama = $data->jenis_nama;
            $bentukNama = $data->bentuk_nama;

            if (!isset($bentuk_kekerasan_sets[$jenisNama])) {
                $bentuk_kekerasan_sets[$jenisNama] = [];
            }

            $bentuk_kekerasan_sets[$jenisNama][] = $bentukNama;
        }

        // data kategori kasus
        $kategori_kasus = DB::table('t_kategori_kasus as a')
                                ->select('a.value','b.nama')
                                ->leftJoin('m_kategori_kasus as b', 'a.value', 'b.kode')
                                ->where('a.klien_id', $klien->id)
                                ->get();
        
        //data petugas
        $petugas = DB::table('petugas as a')
                    ->select(DB::raw('a.*, b.name, b.foto, b.jabatan'))
                    ->leftJoin('users as b','a.user_id', 'b.id')
                    ->where('a.klien_id', $klien->id)
                    ->whereNULL('a.deleted_at')
                    ->orderBy('a.created_at')
                    ->get();
        if ($petugas->contains('user_id', Auth::user()->id) || Auth::user()->jabatan == 'Super Admin'){
            // check apakah yang login ini adalah petugas kasus ini, kalo bukan maka hidden menu2nya
            $akses_petugas = 1;
        }else{
            $akses_petugas = 0;
        }
        //data surat persetujuan
        $persetujuan = DB::table('persetujuan_isi as a')
                    ->select(DB::raw('a.*, b.judul'))
                    ->leftJoin('persetujuan_template as b', 'a.persetujuan_template_id', 'b.id')
                    ->where('a.klien_id', $klien->id)
                    ->orderBy('a.created_at')
                    ->get();
        //data surat template persetujuan 
        $persetujuan_template = PersetujuanTemplate::whereNULL('deleted_at')->get();
       //Cek apakah kasus terdiri dari minimal 1 Petugas Penerima Pengaduan, 1 Supervisor & 1 MK
       $kelengkapan_petugas = $this->check_kelengkapan_petugas($klien->id);
       
       $kasus_terkait = $this->kasus_terkait($klien->kasus_id, $klien->id);
       // ===========================================================================================
        //Proses read, push notif & log activity ////////////////////////////////////////////////////
        // jika petugas sudah melihat data kasus maka tasknya (T8, T11) selesai
        $task = ['T8', 'T11'];
        foreach ($task as $item) {
            NotifHelper::read_notif(
                Auth::user()->id, // receiver_id
                $klien->id, // klien_id
                $item, // kode ini request dari link 
                'task', // type_notif
                NULL // agenda_id
            );   
        }
        // spesifik ke yang notif
        NotifHelper::read_notif(
            Auth::user()->id, // receiver_id
            $klien->id, // klien_id
            'N10', // kode ini request dari link 
            'notif', // type_notif
            NULL // agenda_id
        ); 
        // read notif sesuai url
        NotifHelper::read_notif(
            Auth::user()->id, // receiver_id
            $klien->id, // klien_id
            $request->kode, // kode ini request dari link 
            $request->type_notif, // type_notif
            $request->agenda_id // agenda_id
        );
        /////////////////////////////////////////////////////////////////////////////////////////////
       $detail['kelengkapan_petugas'] = $kelengkapan_petugas;
       return view('kasus.show')
                ->with('klien', $klien)
                ->with('pelapor', $pelapor)
                ->with('terlapor', $terlapor)
                ->with('kasus', $kasus)
                ->with('jenis_kekerasan', $jenis_kekerasan)
                ->with('bentuk_kekerasan', $bentuk_kekerasan)
                ->with('bentuk_kekerasan_sets', $bentuk_kekerasan_sets)
                ->with('kategori_kasus', $kategori_kasus)
                ->with('rekam_kasus', $rekam_kasus)
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
                ->with('pengadilan_negri', $pengadilan_negri)
                ->with('pasal', $pasal)
                ->with('media_pengaduan', $media_pengaduan)
                ->with('sumber_rujukan', $sumber_rujukan)
                ->with('sumber_informasi', $sumber_informasi)
                ->with('program_pemerintah', $program_pemerintah)
                ->with('kategori_lokasi',$kategori_lokasi)
                ->with('users',$users)
                ->with('petugas',$petugas)
                ->with('persetujuan',$persetujuan)
                ->with('persetujuan_template',$persetujuan_template)
                ->with('detail', $detail)
                ->with('kasus_terkait', $kasus_terkait)
                ->with('akses_petugas', $akses_petugas);
    }

    public function approval($uuid, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'approval' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }
                $klien = Klien::where('uuid', $uuid)->first();
                $kasus = Kasus::where('id', $klien->kasus_id)->first();
                
                if ($klien->no_klien != null) {
                // jika sudah ada no regisnya maka tidak boleh bikin no regis ulang 
                // agar tidak terjadi perubahan no klien yang menyebabkan nomor sebelumnya hilang
                    return redirect(403);
                }
                // jika kasus diapprove maka generate no regis klien
                if ($request->approval) {
                    // buat & simpan no klien
                    $no_klien = $this->generate_noreg();
                    $klien->no_klien = $no_klien;
                    $klien->tanggal_approve = Carbon::now();
                    $klien->save();
                    
                    // buat & simpan no kasus
                    if ($kasus->no_reg == null || $kasus->no_reg == '') {
                        // jika kasusnya sudah ada no kasusnya maka tidak bikin lagi no kasus 
                        $no_kasus = $this->generate_nokas();
                        $kasus->no_reg = $no_kasus;
                        $kasus->save();
                    }

                    $kode = 'T4';
                    $url = url('/kasus/show/'.$klien->uuid.'?tab=kasus&catatan-kasus=1&kode=T4&type_notif=task');
                    $message_notif = Auth::user()->name.' menyetujui kasus. Nomor regis berhasil dibuat. Silahkan periksa catatan supervisor bila ada.';
                    $message_log = Auth::user()->name.' menyetujui kasus. Nomor regis berhasil dibuat';
                    $message_status = 'Supervisor menyetujui kasus';
                }else{
                    $no_klien = '[REJECTED]';
                    $klien->no_klien = $no_klien;
                    $klien->save();

                    $kode = 'T5';
                    $url = url('/kasus/show/'.$klien->uuid.'?tab=settings&kolom-terminasi=1');
                    $message_notif = Auth::user()->name.' tidak menyetujui kasus. Silahkan lakukan terminasi sepihak / kasus ditutup';
                    $message_log = Auth::user()->name.' tidak menyetujui kasus. Proses terminasi';
                    $message_status = 'Proses terminasi';
                }
            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            // jika supervisor sudah menekan tombol approval maka tasknya (T3) selesai
            NotifHelper::read_notif(
                Auth::user()->id, // receiver_id
                $klien->id, // klien_id
                'T3', // kode
                'task' // type_notif
            );
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim notifikasi ke MK, MK bisa jadi lebih dari 1
            $mk = DB::table('petugas as a')
                    ->leftJoin('users as b', 'a.user_id', 'b.id')
                    ->where('b.jabatan', 'Manajer Kasus')
                    ->where('a.klien_id', $klien->id)
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->pluck('b.id');
                    
            $notif_receiver = [];
            foreach ($mk as $key => $value) {
                NotifHelper::push_notif(
                    $value , //receiver_id
                    $klien->id, //klien_id
                    $kode, //kode
                    'task', //type_notif
                    $klien->no_klien ? $klien->no_klien : NULL, //noregis
                    Auth::user()->name, //from
                    $message_notif, //message
                    $klien->nama, //nama korban 
                    isset($klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    $url, //url
                    1, //kirim ke diri sendiri 0 / 1
                    Auth::user()->id, // created_by
                    NULL // agenda_id
                );
                // untuk kirim realtime notifikasi
                if ($value != Auth::user()->id) {
                    $notif_receiver[] = 'user_'.$value;
                }
                $notifjson = urlencode(json_encode($notif_receiver));
            }
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                $message_log,
                //klien_id
                $klien->id 
            );
            // update status klien //////////////////////////////////////////////////////////////////////
            StatusHelper::push_status($klien->id, $message_status);
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!'
            ]);
            
             // untuk menghindari dobel encoding terhadap notifjson, jadi cara returnnya seperti ini
             $url = url('/kasus/show/' . $klien->uuid . '?tab=settings&persetujuan-supervisor=1&notif='.$notifjson);
             return redirect($url)
                     ->with('success', true)
                     ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function check_kelengkapan_petugas($klien_id)
    {
        $supervisor = DB::table('petugas as a')
                            ->leftJoin('users as b', 'a.user_id', '=', 'b.id')
                            ->where('a.klien_id', $klien_id)
                            ->where('b.jabatan', 'Supervisor Kasus')
                            ->whereNull('a.deleted_at')
                            ->count();
        $mk = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', '=', 'b.id')
                        ->where('a.klien_id', $klien_id)
                        ->where('b.jabatan', 'Manajer Kasus')
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->count();
        $penerima_pengaduan = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', '=', 'b.id')
                        ->where('a.klien_id', $klien_id)
                        ->where('b.jabatan', 'Penerima Pengaduan')
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->count();
        if (($supervisor > 0) && ($mk > 0)  && ($penerima_pengaduan > 0)) {
            return true;
        }else{
            return false;
        }
    }

    public function check_kelengkapan_data($klien_id)
    {
        $data = DB::table('kasus as a')
        ->select('b.id as klien_id')
        ->selectRaw('ROUND(((
            SUM(CASE WHEN a.sumber_rujukan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.media_pengaduan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.sumber_informasi IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.tanggal_pelaporan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.tanggal_kejadian IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.kategori_lokasi IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.ringkasan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN a.alamat IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.no_klien IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.nik IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.nama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.alamat IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.agama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.no_telp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.kedisabilitasan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN b.hubungan_pelapor IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.nik IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.nama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.alamat IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.agama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN c.no_telp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.nik IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.nama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.alamat IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.agama IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
            SUM(CASE WHEN e.no_telp IS NOT NULL THEN 1 ELSE 0 END)
            ) / 81 * 100), 2) as kelengkapan_data')
            ->leftJoin('klien as b', 'a.id', '=', 'b.kasus_id')
            ->leftJoin('pelapor as c', 'c.kasus_id', '=', 'a.id')
            ->leftJoin('r_hubungan_terlapor_klien as d', 'd.klien_id', '=', 'b.id')
            ->leftJoin('terlapor as e', 'd.terlapor_id', '=', 'e.id')
            ->whereNull('b.deleted_at')
            ->where('b.arsip', 0)
            ->where('b.id', $klien_id)
            ->groupBy('b.id', 'a.id', 'c.id', 'd.id', 'e.id')
            ->first();
                        
      return $data->kelengkapan_data;
    }

    public function check_kelengkapan_persetujuan_spv($klien_id)
    {
        // jika pada klien ada no klien artinya sudah di approve
        $klien = Klien::where('id', $klien_id)->first();
        if ($klien->no_klien != NULL) {
            return true;
        } else {
            return false;
        }
    }

    public function check_kelengkapan_spp($klien_id)
    {
        $persetujuan_template = PersetujuanTemplate::where('kategori', 'persetujuan pelayanan')->pluck('id');
        $persetujuan_isi = PersetujuanIsi::whereIn('persetujuan_template_id', [$persetujuan_template])
                                        ->where('klien_id', $klien_id)
                                        ->whereNotNull('tandatangan')
                                        ->whereNull('deleted_at')
                                        ->count();
        if ($persetujuan_isi > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_kelengkapan_asesmen($klien_id)
    {
        $asesmen = Asesmen::where('klien_id', $klien_id)
                            ->whereNotNull('fisik')
                            ->whereNotNull('psikologis')
                            ->whereNotNull('sosial')
                            ->whereNotNull('hukum')
                            ->whereNotNull('upaya')
                            ->whereNotNull('pendukung')
                            ->whereNotNull('hambatan')
                            ->whereNotNull('harapan')
                            ->whereNull('deleted_at')
                            ->count();
        if ($asesmen > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_kelengkapan_perencanaan($klien_id)
    {
        // perencanaan intervensi
        $perencanaan = DB::table(('agenda as a'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                            ->where('a.klien_id', $klien_id)
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->whereNotNull('b.id')
                            ->count();
        // return jumlah perencanaan untuk menghitung persentase
        return $perencanaan;
    }

    public function check_kelengkapan_pelaksanaan($klien_id)
    {
        // pelaksanaan intervensi
        $pelaksanaan = DB::table(('agenda as a'))
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->where('a.klien_id', $klien_id)
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->whereNotNull('b.jam_selesai')
                        ->whereNotNull('b.id')
                        ->count();
        // return jumlah pelaksanaan untuk menghitung persentase
        return $pelaksanaan;
    }

    public function check_kelengkapan_pemantauan($klien_id)
    {
        // pelaksanaan pemantauan
        $pemantauan = Pemantauan::where('klien_id', $klien_id)->count();
        // return jumlah pemantauan
        return $pemantauan;
    }

    public function check_kelengkapan_terminasi($klien_id)
    {
        // pelaksanaan terminasi
        $terminasi = Terminasi::where('klien_id', $klien_id)
                            ->whereNotNull('validated_by')
                            ->first();
        // return jumlah terminasi
        return $terminasi;
    }

    public function kasus_terkait($kasus_id, $klien_id)
    {
        $data = Klien::where('kasus_id', $kasus_id)
                        ->where('uuid', '!=', $klien_id)
                        ->whereNull('deleted_at')
                        ->where('id', '!=', $klien_id)
                        ->get();
        $kasus = Kasus::where('id', $kasus_id)->pluck('no_reg');
        $terlapor = Terlapor::where('kasus_id', $kasus_id)->pluck('nama');
        $data->no_reg = $kasus[0];
        $data->terlapor = $terlapor;
        return $data;
    }

    public function generate_noreg()
    {
        // 1. Jumlahkan klien yang ada no regisnya dan bukan empty
        // 2. Cari yang tahun ini saja
        // 3. Jumlahnya tambah 1
        // 4. Kombinasikan dengan bulan dan tahun saat ini

        // bisa terjadi : 
        // tadinya jumlah kasus 100
        // yang sudah di regis 50 
        // di approve maka no regisnya 51
        // tapi ternyata yang sebelumnya jadi arsip / dihapus
        // jadi jumlahnya 49
        // atau bisa terjadi : 
        // satpel submit approve berbarengan, sehingga sistem yang melihat ada no yang ganda akan otomatis menambah 1

        $kasus_regis = Klien::whereNull('deleted_at')
                            ->where('arsip', 0)
                            ->whereNotNull('no_klien')
                            ->whereYear('created_at', date('Y'))
                            ->count();

        $urutan_regis = $kasus_regis + 1;

        do {
            if ($urutan_regis < 10) {
                $urutan_regis_str = '00' . $urutan_regis;
            } else if ($urutan_regis < 100) {
                $urutan_regis_str = '0' . $urutan_regis;
            } else {
                $urutan_regis_str = (string) $urutan_regis;
            }

            $no_klien = $urutan_regis_str . '/' . date('m') . '/' . date('Y');

            $existingRecord = Klien::where('no_klien', $no_klien)->first();

            if ($existingRecord) {
                $urutan_regis++;
            } else {
                break;
            }
        } while (true);

        return $no_klien;
    }

    public function generate_nokas()
    {
        // 1. Jumlahkan kasus yang ada no regisnya dan bukan empty
        // 2. Cari yang tahun ini saja
        // 3. Jumlahnya tambah 1
        // 4. Kombinasikan dengan bulan dan tahun saat ini

        $kasus_regis = Kasus::whereNull('deleted_at')
                            ->whereNull('no_reg')
                            ->whereYear('created_at', date('Y'))
                            ->count();

        $urutan_regis = $kasus_regis + 1;

        do {
            if ($urutan_regis < 10) {
                $urutan_regis_str = '00' . $urutan_regis;
            } else if ($urutan_regis < 100) {
                $urutan_regis_str = '0' . $urutan_regis;
            } else {
                $urutan_regis_str = (string) $urutan_regis;
            }

            $no_kasus = $urutan_regis_str . '/' . date('m') . '/' . date('Y');

            // Check if $no_klien already exists
            $existingRecord = Kasus::where('no_reg', $no_kasus)->first();

            if ($existingRecord) {
                // Increment $urutan_regis and retry
                $urutan_regis++;
            } else {
                // Break the loop if $no_klien is unique
                break;
            }
        } while (true);

        return $no_kasus;
    }

    public function destroy($uuid)
    {
        try {
            $klien = Klien::where('uuid', $uuid)->first();
            $proses = Klien::where('id', $klien->id)->delete();

            //hapus task di notifikasi untuk semua kasus ini
            $proses = Notifikasi::where('klien_id', $klien->id)
                        ->update(['read' => 1]);

            if (!$proses) {
                throw new Exception($proses);
            }        
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Dihapus!',
                'data'    => $proses  
            ]);

        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function arsip($uuid)
    {
        try {
            $klien = Klien::where('uuid', $uuid)->first();
            if (!$klien) {
                throw new Exception('Not Found');
            }

            // jika diarsipkan maka untuk menghapus notif di spv untuk approve kasus itu lebih baik di hapus saja akun spv dari list petugas.
            // sehingga otomatis notifikasi2nya hilang dan memang seharusnya satpel tersebut tidak ada di kasus itu
        
            // Toggle the "active" column value
            $klien->arsip = !$klien->arsip;
            $proses = $klien->save();

            if (!$proses) {
                throw new Exception($proses);
            }        
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Dirubah!',
                'data'    => $proses ,
                'arsip'   => $klien->arsip 
            ]);

        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    // fungsi untuk update no kasus semua kasus secara otomatis
    // fungsi ini dibuat karena hingga maret masih banyak yang belum paham konsep 1 kasus banyak korban
    // fungsi ini tidak boleh digunakan lagi ketika no kasus sudah digunakan dan user sudah paham konsepnya
    public function autofill_nokas(Request $request)
    {
        if ($request->pass == 'runautofillnokas') {
            $data = DB::table('kasus as a')
                        ->select(DB::raw(
                            'a.no_reg,
                            b.kasus_id,
                            b.no_klien,
                            b.tanggal_approve,
                            CASE
                                WHEN MONTH(b.tanggal_approve) = 1 THEN "01"
                                WHEN MONTH(b.tanggal_approve) = 2 THEN "02"
                                WHEN MONTH(b.tanggal_approve) = 3 THEN "03"
                                WHEN MONTH(b.tanggal_approve) = 4 THEN "04"
                                WHEN MONTH(b.tanggal_approve) = 5 THEN "05"
                                WHEN MONTH(b.tanggal_approve) = 6 THEN "06"
                                WHEN MONTH(b.tanggal_approve) = 7 THEN "07"
                                WHEN MONTH(b.tanggal_approve) = 8 THEN "08"
                                WHEN MONTH(b.tanggal_approve) = 9 THEN "09"
                                ELSE MONTH(b.tanggal_approve)
                            END AS bulan,
                            YEAR(b.tanggal_approve) as tahun'
                        ))
                        ->leftJoin('klien as b', 'a.id', 'b.kasus_id')
                        ->whereNotNull('b.no_klien')
                        ->whereNull('b.deleted_at')
                        ->whereNull('a.deleted_at')
                        ->orderBy('b.kasus_id')
                        ->get();

            $no = 1;
            echo '<table border="1"><tr><td>no</td><td>no_reg</td><td>kasus_id</td><td>no_klien</td><td>proses update</td></tr>';
            $kasus_id_sebelum = null;
            $no_reg = null;
            $style = null;
            foreach ($data as $key => $value ) {
                if ($no < 10) {
                    $urutan_regis_str = '00' . $no;
                } else if ($no < 100) {
                    $urutan_regis_str = '0' . $no;
                } else {
                    $urutan_regis_str = (string) $no;
                }
    
                $no_reg_update = $urutan_regis_str . '/' . $value->bulan . '/' . $value->tahun;

                if ($value->kasus_id == $kasus_id_sebelum) {
                    $no_reg = $no_reg;
                    $style = 'style="background-color:yellow"';
                } else {
                    $no_reg = $no_reg_update;
                    $no++;
                }

                echo '<tr '.$style.'>';
                echo '<td>'.$no.'</td><td>'.$no_reg.'</td><td>'.$value->kasus_id.'</td><td> '.$value->no_klien.'</td><td></td>';
                echo '</tr>';
                
                $kasus_id_sebelum = $value->kasus_id;
                $style = null;
            }
            echo '</table>';
        } else {
            return redirect(404);
        }
    }
}
