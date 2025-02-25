<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Asesmen;
use App\Models\Catatan;
use App\Models\CatatanHukum;
use App\Models\Kasus;
use App\Models\Klien;
use App\Models\Notifikasi;
use App\Models\Pemantauan;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use App\Models\RHubunganTerlaporKlien;
use App\Models\RiwayatKejadian;
use App\Models\TBentukKekerasan;
use App\Models\Terlapor;
use App\Models\Terminasi;
use App\Models\TJenisKekerasan;
use App\Models\TKategoriKasus;
use App\Models\TPasal;
use App\Models\TTipeDisabilitas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Exception;
use Google\Service\ContainerAnalysis\Assessment;
use Illuminate\Support\Facades\Schema;
use Laravolt\Indonesia\Models\City;

class KasusController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            // Getting date range
            $daterange = $request->get('tanggal') ? explode(" - ", $request->get('tanggal')) : [date("Y") . '-01-01', date("Y-m-d")];
            $from = $daterange[0];
            $to = $daterange[1];

            // Selecting basis tanggal
            $basis_tanggal = $request->basis_tanggal == 'tanggal_approve' ? 'a.tanggal_approve' : 'b.' . $request->basis_tanggal;

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

            $today = Carbon::today();

            $data = DB::table('klien as a')
                ->select(
                    'a.uuid', 
                    'b.tanggal_pelaporan', 
                    'a.no_klien', 
                    'a.nama', 
                    'a.jenis_kelamin', 
                    'a.tanggal_lahir', 
                    DB::raw("TIMESTAMPDIFF(YEAR, a.tanggal_lahir, $penguarang) as usia"), 
                    'a.status', 
                    'd.name as petugas',
                    'y.jatuh_tempo',
                    'x.jumlah_terminasi',
                    'w.jumlah_intervensiku'
                )
                ->leftJoin('kasus as b', 'b.id', '=', 'a.kasus_id')
                ->leftJoin('petugas as c', 'a.id', '=', 'c.klien_id')
                ->leftJoin('users as d', 'd.id', '=', 'a.created_by')
                ->leftJoin(DB::raw('(SELECT b.klien_id  
                                    FROM users a 
                                    LEFT JOIN petugas b ON a.id = b.user_id
                                    WHERE a.jabatan = "Supervisor Kasus"
                                    AND b.deleted_at IS NULL) z'), 'z.klien_id', '=', 'a.id')
                ->leftJoin(DB::raw("(SELECT a.id as klien_id, 
                                    COALESCE(DATEDIFF(?, p1.created_at), DATEDIFF(?, a.tanggal_approve)) as jatuh_tempo
                                    FROM klien a
                                    LEFT JOIN (
                                        SELECT klien_id, MAX(created_at) as latest_created_at
                                        FROM pemantauan
                                        GROUP BY klien_id
                                    ) p2 ON a.id = p2.klien_id
                                    LEFT JOIN pemantauan p1 ON p1.klien_id = p2.klien_id AND p1.created_at = p2.latest_created_at) y"), 'y.klien_id', '=', 'a.id')
                ->leftJoin(DB::raw('(SELECT klien_id, COUNT(*) AS jumlah_terminasi  
                                    FROM terminasi
                                    WHERE validated_by IS NOT NULL
                                    AND deleted_at IS NULL GROUP BY klien_id) x'), 'x.klien_id', '=', 'a.id')
                ->leftJoin(DB::raw('(SELECT klien_id, COUNT(*) AS jumlah_intervensiku  
                                    FROM agenda a 
                                    LEFT JOIN tindak_lanjut b ON a.id = b.agenda_id 
                                    WHERE b.created_by = '.Auth::user()->id.'
                                    AND a.deleted_at IS NULL 
                                    AND b.deleted_at IS NULL GROUP BY a.klien_id) w'), 'w.klien_id', '=', 'a.id')
                
                ->whereNull('a.deleted_at')
                ->whereNull('c.deleted_at')
                ->groupBy('a.uuid', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 'a.jenis_kelamin', 'a.tanggal_lahir', 'a.status', 'd.name', 'y.jatuh_tempo', 'x.jumlah_terminasi', 'w.jumlah_intervensiku')
                ->addBinding($today->toDateString(), 'select')
                ->addBinding($today->toDateString(), 'select');

            // Filter by date
            if ($request->basis_tanggal) {
                $data->whereBetween($basis_tanggal, [$from, $to]);
            }

            // Filter for laporKBG cases
            if ($request->laporkbg == 1) {
                $data->whereNull('a.created_by');
            }

            // Filter by wilayah
            if ($request->wilayah != 'default') {
                if ($request->basis_wilayah == 'tkp') {
                    $data->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? '=' : '!=', $request->wilayah != 'luar' ? $request->wilayah : env('id_provinsi'));
                } elseif ($request->basis_wilayah == 'ktp') {
                    $data->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? '=' : '!=', $request->wilayah != 'luar' ? $request->wilayah : env('id_provinsi'));
                } elseif ($request->basis_wilayah == 'satpel') {
                    $data->where('z.kotkab_id', $request->wilayah);
                }
            }

            // Filter for logged-in user cases
            if (!$request->anda && $request->laporkbg != 1) { 
                $data->where('c.user_id', Auth::user()->id);
            }

            // Filter for cases without user intervention
            if ($request->intervensiku) { 
                $data->whereNull('w.jumlah_intervensiku');
            }

            // Filter by kategori klien
            if ($request->kategoriklien == 'dewasa') {
                $data->whereRaw("TIMESTAMPDIFF(YEAR, a.tanggal_lahir, ".$penguarang.") >= 18");
            } elseif ($request->kategoriklien == 'anak') {
                $data->whereRaw("TIMESTAMPDIFF(YEAR, a.tanggal_lahir, ".$penguarang.") < 18");
            }

            // Filter for Pemantauan & Evaluasi
            if ($request->pemantauan) {
                $data->where('y.jatuh_tempo', '>=', 172)
                    ->where(function($q) {
                        $q->where('x.jumlah_terminasi', '=', 0)
                        ->orWhereNull('x.jumlah_terminasi');
                    });
            }

            // Filter for Terminasi
            if ($request->terminasi) {
                $data->where('x.jumlah_terminasi', '>', 0);
            }

            // Filter by arsip status
            $data->where('a.arsip', $request->arsip ? 1 : 0);

            $datas = $data->orderByRaw('a.no_klien IS NOT NULL, CAST(SUBSTRING_INDEX(a.no_klien, "/", 1) AS UNSIGNED) DESC')
                            ->get();

            foreach ($datas as $datas2) {
                // Format tanggal pelaporan
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
                            ->whereNull('a.deleted_at') // seluruh petugas dimunculkan, akan ada keterangan aktif / non
                            ->whereNull('b.deleted_at')
                            ->whereNotNull('b.nama')
                            ->groupBy('b.id')
                            ->orderby('b.id','desc')
                            ;
        if($search != ''){
            $data = $data->where('b.nama', 'like', '%' .$search . '%');
            if ($request->no_klien) {
                $data = $data->orWhere('b.no_klien', 'like', '%' .$search . '%');
            }
        }
        if ((Auth::user()->jabatan != 'Super Admin' && $request->petugas == null) || (Auth::user()->jabatan != 'Super Admin' && $search == '')) {
            // super admin dapat memilih seluruh klien
            $data = $data->where('a.user_id', Auth::user()->id);
        }
        $data = $data->select('b.id','b.uuid','b.nama','b.no_klien')->limit(10)->get();

        $response = array();
        foreach($data as $value){
            if ($request->uuid) {
                // jika yang diminta uuid
                $id = $value->uuid;
            } else {
                // jika yang diminta id
                $id = $value->id;
            }
            
           $response[] = array(
                "id"=>$id,
                "text"=>$value->nama,
                "no_klien" => $value->no_klien == null ? '' : $value->no_klien
           );
        }
        return response()->json($response); 
        
    }

    public function show(Request $request, $uuid)
    {
        if($request->ajax()) { //dipakai di datatable buat liat hightlight kasus
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
            'a.status', 'a.intervensi_ke', 'a.uuid', 'd.name as petugas', 'a.arsip']);

            $data->list_petugas = DB::table('petugas as a')
                                    ->select('b.id','b.uuid','b.name','b.jabatan')
                                    ->leftJoin('users as b', 'a.user_id', 'b.id')
                                    // ->whereNull('a.deleted_at') // seluruh petugas dimunculkan, akan ada keterangan aktif / non
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
       $kedaruratan =  (new OpsiController)->api_kedaruratan();
       $pengadilan_negri =  (new OpsiController)->api_pengadilan_negri();
       $pasal = (new OpsiController)->api_pasal();
       $tipe_disabilitas = (new OpsiController)->api_difabel_type();
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
           'j.value as kedaruratan',
           DB::raw('(SELECT GROUP_CONCAT(" ", value) FROM t_kedaruratan WHERE klien_id = a.id) as t_kedaruratan'),
           DB::raw('(SELECT GROUP_CONCAT(" ", value) FROM t_tindak_lanjut WHERE klien_id = a.id) as t_tindak_lanjut'),
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
       ->leftJoin('t_kedaruratan as j', 'a.id', 'j.klien_id')
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

       // data catatan layanan hukum
       $catatan_hukum = DB::table('catatan_hukum as a')
            ->leftJoin('users as b', 'a.created_by', 'b.id')
            ->select('a.*', 'b.name')
            ->where('klien_id', $klien->id)
            ->first();

        if (!$catatan_hukum) {
            $catatan_hukum = (object) [
                'name' => null,
                'no_lp' => null,
                'pengadilan_negeri' => null,
                'isi_putusan' => null,
                'lpsk' => null,
                'proses_hukum' => null
            ];
            $catatan_hukum->pasal = null;
        } else {
            $catatan_hukum_pasal = TPasal::where('klien_id', $klien->id)->get();
            $catatan_hukum->pasal = $catatan_hukum_pasal;
        }

        $catatan_psikologis = DB::table('catatan_psikologis as a')
            ->leftJoin('users as b', 'a.created_by', 'b.id')
            ->select('a.*', 'b.name')
            ->where('klien_id', $klien->id)
            ->first();
        
        if (!$catatan_psikologis) {
            $catatan_psikologis = (object) [
                'name' => null,
                'disabilitas' => 0,
                // Add other properties with default values here
            ];
            $catatan_psikologis->disabilitases = null;
        } else {
            $catatan_psikologis_disabilitas = TTipeDisabilitas::where('klien_id', $klien->id)->get();
            $catatan_psikologis->disabilitases = $catatan_psikologis_disabilitas;
        }
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
                            ->groupBy('b.kode','a.value','b.nama')
                            ->get();
        // data bentuk kekerasan
        $bentuk_kekerasan = DB::table('t_bentuk_kekerasan as a')
                                ->select('a.value','b.nama')
                                ->leftJoin('m_bentuk_kekerasan as b', 'a.value', 'b.kode')
                                ->where('a.klien_id', $klien->id)
                                ->groupBy('b.kode','a.value','b.nama')
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
                                ->groupBy('b.kode','a.value','b.nama')
                                ->get();
        
        //data petugas
        $petugas = DB::table('petugas as a')
                    ->select(DB::raw('a.*, b.name, b.foto, b.jabatan'))
                    ->leftJoin('users as b','a.user_id', 'b.id')
                    ->where('a.klien_id', $klien->id)
                    ->whereNULL('a.deleted_at')
                    ->orderBy('a.active', 'desc')
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
        // spesifik ke yang task & notif
        $notif_data = [
            ['kode' => 'T4', 'type_notif' => 'task'],
            // ['kode' => 'T8', 'type_notif' => 'task'],
            ['kode' => 'T11', 'type_notif' => 'task'],
            ['kode' => 'T13', 'type_notif' => 'task'],
            ['kode' => 'N10', 'type_notif' => 'notif'],
            ['kode' => 'N11', 'type_notif' => 'notif']
        ];
        foreach ($notif_data as $notif) {
            NotifHelper::read_notif(
                Auth::user()->id, // receiver_id
                $klien->id, // klien_id
                $notif['kode'], // kode
                $notif['type_notif'], // type_notif
                NULL // agenda_id
            );
        }

        // read notif sesuai url
        // sementara di hide dulu, karna ada notif T12 yang hilang sebelum diTL
        // NotifHelper::read_notif(
        //     Auth::user()->id, // receiver_id
        //     $klien->id, // klien_id
        //     $request->kode, // kode ini request dari link 
        //     $request->type_notif, // type_notif
        //     $request->agenda_id // agenda_id
        // );
        /////////////////////////////////////////////////////////////////////////////////////////////
       $detail['kelengkapan_petugas'] = $kelengkapan_petugas;

       // cek pemantauan & evaluasi terakhir apakah memilih terminasi atau tidak. 
       // untuk formulir pengajuan terminasi
    
    // hapus persetujuan isi yang lebih dari 2 hari. hari created di tambah 2, kemudian cari selisih dengan dikurangi dengan hari ini. jika < 1 maka delete
    PersetujuanIsi::whereRaw('TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(created_at, INTERVAL 3 DAY)) < 1')
                    ->where('klien_id', $klien->id)
                    ->whereNull('tandatangan')
                    ->update(['deleted_at' => date('Y-m-d H:i:s')]);
    $pengajuan_terminasi_terakhir = DB::table('pemantauan as p')
                                    ->join(DB::raw('(SELECT klien_id, MAX(created_at) AS max_created_at 
                                                    FROM pemantauan 
                                                    GROUP BY klien_id) as max_p'), function($join) {
                                        $join->on('p.klien_id', '=', 'max_p.klien_id')
                                            ->on('p.created_at', '=', 'max_p.max_created_at');
                                    })
                                    ->where('p.klien_id', $klien->id)
                                    ->where('p.action_pemantauan', 'ajukan_terminasi')
                                    ->select('p.klien_id', 'p.created_at', 'p.action_pemantauan')
                                    ->count();
       
       return view('kasus.show')
                ->with('klien', $klien)
                ->with('catatan_hukum', $catatan_hukum)
                ->with('catatan_psikologis', $catatan_psikologis)
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
                ->with('kedaruratan', $kedaruratan)
                ->with('pengadilan_negri', $pengadilan_negri)
                ->with('pasal', $pasal)
                ->with('tipe_disabilitas', $tipe_disabilitas)
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
                ->with('akses_petugas', $akses_petugas)
                ->with('pengajuan_terminasi_terakhir', $pengajuan_terminasi_terakhir);
    }

    // untuk ajax rekap kasus yang bisa dicopas buat WA
    public function rekap(Request $request)
    {
        $klien = DB::table('klien as a')->selectRaw('a.id, b.id as kasus_id, a.no_klien, b.tanggal_pelaporan, a.nama, a.tanggal_lahir, TIMESTAMPDIFF(YEAR, a.tanggal_lahir, CURDATE()) as usia, 
                        a.jenis_kelamin, c.name as kotkab_tkp, d.name as kotkab_ktp, GROUP_CONCAT(DISTINCT " ",f.nama) as kategori_kasus, GROUP_CONCAT(DISTINCT " ",h.nama) as jenis_kekerasan,
                        GROUP_CONCAT(DISTINCT CONCAT(j.name, " (", j.jabatan, ")") ORDER BY i.created_at SEPARATOR ", ") as petugas')
                        ->leftJoin('kasus as b', 'a.kasus_id', 'b.id')
                        ->leftJoin('indonesia_cities as c', 'c.code', 'b.kotkab_id')
                        ->leftJoin('indonesia_cities as d', 'd.code', 'a.kotkab_id_ktp')
                        ->leftJoin('t_kategori_kasus as e', 'e.klien_id', 'a.id')
                        ->leftJoin('m_kategori_kasus as f', 'f.kode', 'e.value')
                        ->leftJoin('t_jenis_kekerasan as g', 'g.klien_id', 'a.id')
                        ->leftJoin('m_jenis_kekerasan as h', 'h.kode', 'g.value')
                        ->leftJoin('petugas as i', 'i.klien_id','a.id')
                        ->leftJoin('users as j', 'j.id', 'i.user_id')
                        ->groupBy('a.id')
            ->where('a.uuid', $request->uuid)
            ->first();

        $terlapor = DB::table('terlapor as a')->selectRaw('a.nama, a.jenis_kelamin, TIMESTAMPDIFF(YEAR, a.tanggal_lahir, CURDATE()) as usia, b.value as hubungan')
                    ->leftJoin('r_hubungan_terlapor_klien as b', 'a.id', 'b.terlapor_id')
                    ->where('a.kasus_id', $klien->kasus_id)
                    ->whereNull('a.deleted_at')
                    ->get();

        $riwayat = RiwayatKejadian::where('klien_id', $klien->id)
            ->whereNull('deleted_at')
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        $verif_data = PersetujuanIsi::where('klien_id', $klien->id)
            ->where('persetujuan_template_id', 1)
            ->whereNull('deleted_at')
            ->whereNotNull('tandatangan')
            ->value('updated_at');

        $spp = PersetujuanIsi::where('klien_id', $klien->id)
            ->where('persetujuan_template_id', 2)
            ->whereNull('deleted_at')
            ->whereNotNull('tandatangan')
            ->value('updated_at');

        $asesmen_awal = RiwayatKejadian::where('klien_id', $klien->id)
            ->whereNull('deleted_at')
            ->value('created_at');

        $intervensi = DB::table('t_keyword as a')
            ->selectRaw("DATE_FORMAT(d.tanggal_mulai, '%d %b %Y') as date, GROUP_CONCAT(DISTINCT b.keyword ORDER BY b.keyword SEPARATOR ', ') as activity")
            ->leftJoin('m_keyword as b', 'a.value', 'b.id')
            ->leftJoin('tindak_lanjut as c', 'c.id', 'a.tindak_lanjut_id')
            ->leftJoin('agenda as d', 'd.id', 'c.agenda_id')
            ->where('d.klien_id', $klien->id)
            ->whereNull('c.deleted_at')
            ->whereNull('d.deleted_at')
            ->groupBy('d.tanggal_mulai')
            ->get();

        // TIMELINE KASUS
        $timeline = collect([
            (object) ['date' => $klien->tanggal_pelaporan ? date('d M Y', strtotime($klien->tanggal_pelaporan)) : '', 'activity' => 'Penerimaan Laporan'],
            (object) ['date' => $verif_data ? date('d M Y', strtotime($verif_data)) : '', 'activity' => 'Tanda Tangan Surat Verifikasi Data'],
            (object) ['date' => $spp ? date('d M Y', strtotime($spp)) : '', 'activity' => 'Tanda Tangan Surat Pernyataan Persetujuan'],
            (object) ['date' => $asesmen_awal ? date('d M Y', strtotime($asesmen_awal)) : '', 'activity' => 'Asesmen Awal'],
        ])->merge($intervensi);

        // Merge all data & group by date
        $groupedActivities = $timeline->filter(fn($item) => !empty($item->date)) // Remove empty dates
                            ->sortBy(fn($item) => Carbon::parse($item->date)) // Sort by actual date
                            ->groupBy('date')
                            ->map(fn($items, $date) => [
                                'date' => $date,
                                'activities' => $items->pluck('activity')->toArray(),
                            ])->values();

        if ($request->samarkan_nama_klien) {
            $nama = $klien->nama;
            $text = $klien->nama;
            $nama_klien = $this->samarkan_nama($text, $nama);
        } else {
            $nama_klien = $klien->nama;
        }
        // Generate message
        $message = "<b>[ RINGKASAN KASUS ]</b><br>";
        $message .= "<b>Direkap pada tanggal :</b> " . now()->format('d M Y H:i') . "<br>";
        $message .= "=============================<br>";
        $message .= "<b>DATA KASUS</b><br>";
        $message .= "<b>Nama Klien :</b> {$nama_klien} ({$klien->jenis_kelamin}, {$klien->usia} tahun)<br>";
        $message .= "<b>No Reg. Klien :</b> {$klien->no_klien}<br>";
        $message .= $klien->tanggal_pelaporan ? "<b>Tanggal Pelaporan :</b> " . date('d M Y', strtotime($klien->tanggal_pelaporan)) . "<br>" : "";
        $message .= "<b>Kategori Kasus :</b> {$klien->kategori_kasus}<br>";
        $message .= "<b>Jenis Kekerasan :</b> {$klien->jenis_kekerasan}<br>";
        $message .= "<b>TKP :</b> {$klien->kotkab_tkp}<br>";
        $message .= "<b>KTP :</b> {$klien->kotkab_ktp}<br>";
        $message .= "<b>Terlapor :</b><br>";
        foreach ($terlapor as $value) {
            if ($request->samarkan_nama_klien) {
                $nama = $value->nama;
                $text = $value->nama;
                $nama_terlapor = $this->samarkan_nama($text, $nama);
            } else {
                $nama_terlapor = $value->nama;
            }
            $message .= "- {$nama_terlapor} ({$value->jenis_kelamin}, {$value->usia} tahun) — {$value->hubungan}<br>";
        }
        $message .= "=============================<br>";
        if ($request->tampilkan_kronologi) {
            $message .= "<b>KRONOLOGI KEJADIAN</b><br>";
            foreach ($riwayat as $value) {
                if ($request->samarkan_nama_klien) {
                    $nama = $klien->nama;
                    $text = $value->keterangan;
                    $keterangan = $this->samarkan_nama($text, $nama);
                } else {
                    $keterangan = $value->keterangan;
                }
                $message .= "<b>" . date('d M Y', strtotime($value->tanggal)) . " {$value->jam}</b><br>";
                $message .= strip_tags($keterangan) . "<br>"; 
            }
            $message .= "<br>";
            $message .= "=============================<br>";
        }
        $message .= "<b>TIMELINE KASUS</b><br>";

        foreach ($groupedActivities as $value) {
            $message .= "<b>{$value['date']}</b><br>";
            foreach ($value['activities'] as $activity) {
                $message .= "- {$activity}<br>";
            }
        }

        $message .= "=============================<br>";
        $message .= "<b>PETUGAS</b><br>";
        $message .= "{$klien->petugas}<br>";

        return response()->json(['message' => $message]);
    }

    function samarkan_nama($text, $nama) {
        // Normalize name by trimming and converting to lowercase
        $nama = trim(preg_replace('/\s+/', ' ', $nama)); // Remove extra spaces
    
        // Split the name into words
        $words = explode(' ', $nama);
    
        // Extract initials
        if (count($words) > 1) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($words[0], 0, 2)); // Take first two letters for a single-word name
        }
    
        // Define regex pattern to match the full name case-insensitively
        $pattern = '/' . preg_quote($nama, '/') . '/i';
    
        // Replace full name occurrences with initials
        return preg_replace($pattern, $initials, $text);
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
            ) / 80 * 100), 2) as kelengkapan_data')
            ->leftJoin('klien as b', 'a.id', '=', 'b.kasus_id')
            ->leftJoin('pelapor as c', 'c.kasus_id', '=', 'a.id')
            ->leftJoin('r_hubungan_terlapor_klien as d', 'd.klien_id', '=', 'b.id')
            ->leftJoin('terlapor as e', 'd.terlapor_id', '=', 'e.id')
            ->whereNull('b.deleted_at')
            // ->where('b.arsip', 0)
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
        $persetujuan_template = PersetujuanTemplate::withTrashed()->where('kategori', 'persetujuan pelayanan')->pluck('id');
        $persetujuan_isi = PersetujuanIsi::whereIn('persetujuan_template_id', $persetujuan_template)
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
        $klien = Klien::find($klien_id);
        // dapatkan jumlah perencanan berdasarkan intervensi yang sedang berlangsung sekarang
        $perencanaan = DB::table(('agenda as a'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                            ->where('a.klien_id', $klien_id)
                            ->where('a.intervensi_ke', $klien->intervensi_ke)
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
        $klien = Klien::find($klien_id);
        // dapatkan jumlah perencanan berdasarkan intervensi yang sedang berlangsung sekarang
        $pelaksanaan = DB::table(('agenda as a'))
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->where('a.klien_id', $klien_id)
                        ->where('a.intervensi_ke', $klien->intervensi_ke)
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
        $klien = Klien::where('id', $klien_id)->first();
        $pemantauan = [];

        // untuk centang indikator pemantauan (hanya tercentang jika ada pemantauan di intervensi terakhir). 
        // Seperti intervensi, ketika telah dimonev akan mereset jadi 0 lagi. Pemantauan juga jadi 0 lagi. 
        $pemantauan_terakhir = Pemantauan::where('klien_id', $klien->id)->where('intervensi_ke', $klien->intervensi_ke)->count();
        $pemantauan['pemantauan_terakhir'] = $pemantauan_terakhir;

        $terakhir_pemantauan = Pemantauan::where('klien_id', $klien->id)->orderBy('created_at', 'DESC')->first();
        if ($terakhir_pemantauan) {
            $pemantauan['terakhir_pemantauan'] = Carbon::parse($terakhir_pemantauan->created_at)->format('d-m-Y H:i');
            $dateMonitoring = Carbon::parse($terakhir_pemantauan->created_at);
        } else {
            $pemantauan['terakhir_pemantauan'] = null;
            $dateMonitoring = Carbon::parse($klien->tanggal_approve);
        }

        $today = Carbon::today();
        $hari_setelah_monev_terakhir = $dateMonitoring->diffInDays($today, false) + 1; // ditambah 1 untuk menyamakan perhitungan di ajax datatable (function index)
        $message_pemantauan = '';
        
        if ($hari_setelah_monev_terakhir >= 172 && $hari_setelah_monev_terakhir < 182) {
            // 6 bulan kurang lebih 182, 10 hari sebelumnya sudah diperingatkan
            $berapa_hari_lagi_expired = 182 - $hari_setelah_monev_terakhir;
            $message_pemantauan = 'Batas waktu Pemantauan & Evaluasi selanjutnya adalah ' . $berapa_hari_lagi_expired . ' hari lagi';
        } elseif ($hari_setelah_monev_terakhir > 182) {
            $message_pemantauan = 'Sudah lebih dari 6 bulan sejak Pemantauan & Evaluasi terakhir / sejak diapprove. Segera dibuat Laporan Pemantauan & Evaluasi!';
        }

        // kalau sudah terminasi, makaa deadline_pemantauan dibikin 0 aja, biar warning tidak muncul 
        $terminasi = Terminasi::where('klien_id', $klien->id)
                            ->whereNotNull('validated_by')
                            ->first();
        if ($terminasi) {
            $hari_setelah_monev_terakhir = 0;
        }

        $pemantauan['deadline_pemantauan'] = $hari_setelah_monev_terakhir;
        $pemantauan['message_pemantauan'] = $message_pemantauan;
        
        // Return jumlah pemantauan
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