<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Asesmen;
use App\Models\Kasus;
use App\Models\Klien;
use App\Models\Monitoring;
use App\Models\Pelapor;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanTemplate;
use App\Models\Petugas;
use App\Models\Terlapor;
use App\Models\Terminasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Exception;
use Illuminate\Support\Facades\Schema;

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
                        ->whereNull('a.deleted_at')
                        ->groupBy('a.id');
            if (Auth::user()->supervisor_id != 0) { // petugas penerima pengaduan tidak masalah bisa melihat semua kasus
                $data->where('c.user_id', Auth::user()->id);
            }
            $datas = $data->get();
            foreach ($datas as $datas2) {
                $datas2->tanggal_pelaporan_formatted = date('d M Y', strtotime($datas2->tanggal_pelaporan));
            }
            return DataTables::of($datas)->make(true);
       }

       return view('kasus.index');
    }

    //untuk select2 list klien, dia methodnya POST
    public function get_klien(Request $request)
    {
        $search = $request->search;

        if($search == ''){
           $data = DB::table('petugas as a')
                            ->leftJoin('klien as b', 'b.id','a.klien_id')
                            ->where('user_id', Auth::user()->id)
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderby('a.created_at','asc')
                            ->select('b.id','b.nama')
                            ->limit(10)->get();
        }else{
            $data = DB::table('petugas as a')
                             ->leftJoin('klien as b', 'b.id','a.klien_id')
                             ->where('user_id', Auth::user()->id)
                             ->whereNull('a.deleted_at')
                             ->whereNull('b.deleted_at')
                             ->where('b.nama', 'like', '%' .$search . '%')
                             ->orderby('a.created_at','asc')
                             ->select('b.id','b.nama')
                             ->limit(10)->get();
        }
  
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
                        ->leftJoin('terlapor as e', 'b.id', 'e.kasus_id')
                        ->where('a.uuid', $request->uuid)
                        ->first(['a.id', 'b.tanggal_pelaporan', 'a.no_klien', 'a.nama', 
                        'a.jenis_kelamin', 'a.tanggal_lahir', 'a.jenis_kelamin', 
                        'a.status', 'a.uuid', 'd.name as petugas']);
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
       $difabel_type =  (new OpsiController)->api_difabel_type();
       $kategori_kasus =  (new OpsiController)->api_kategori_kasus();
       $tindak_kekerasan =  (new OpsiController)->api_tindak_kekerasan();
       $pengadilan_negri =  (new OpsiController)->api_pengadilan_negri();
       $pasal = (new OpsiController)->api_pasal();
       $media_pengaduan =  (new OpsiController)->api_media_pengaduan();
       $sumber_rujukan =  (new OpsiController)->api_sumber_rujukan();
       $sumber_informasi =  (new OpsiController)->api_sumber_infromasi();
       $program_pemerintah =  (new OpsiController)->api_program_pemerintah();
       $tempat_kejadian =  (new OpsiController)->api_tempat_kejadian();
       $users =  (new OpsiController)->api_petugas(); //untuk tambah petugas
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
       //Cek apakah kasus terdiri dari minimal 1 Petugas Penerima Pengaduan, 1 Supervisor & 1 MK
       $kelengkapan_petugas = $this->check_kelengkapan_petugas($klien->id);
       
       $kasus_terkait = $this->kasus_terkait($klien->kasus_id, $klien->id);
       // ===========================================================================================
        //Proses read, push notif & log activity ////////////////////////////////////////////////////
        // jika petugas sudah melihat data kasus maka tasknya (T3, T6) selesai
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
                ->with('detail', $detail)
                ->with('kasus_terkait', $kasus_terkait);
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
                // jika kasus diapprove maka generate no regis klien
                if ($request->approval) {
                    //buat & simpan no regis
                    $no_klien = $this->generate_noreg();
                    $klien->no_klien = $no_klien;
                    $klien->save();
                    $message_notif = Auth::user()->name.' menyetujui kasus. Nomor regis berhasil dibuat. Silahkan lihat catatan supervisor';
                    $message_log = Auth::user()->name.' menyetujui kasus. Nomor regis berhasil dibuat';
                    $kode = 'T4';
                    $url = url('/kasus/show/'.$klien->uuid.'?tab=kasus&catatan-kasus=1&kode=T4&tipe=task');
                }else{
                    $message_notif = Auth::user()->name.' tidak menyetujui kasus. Silahkan lakukan terminasi sepihak / kasus ditutup';
                    $message_log = Auth::user()->name.' {tidak menyetujui kasus. Proses terminasi';
                    $kode = 'T5';
                    $url = url('/kasus/show/'.$klien->uuid.'?tab=settings&kolom-terminasi=1');
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
            }
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                $message_log,
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!'
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $uuid, 'tab' => 'settings', 'persetujuan-supervisor' => 1])
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
        if (($supervisor > 0) && ($mk > 0)) {
            return true;
        }else{
            return false;
        }
    }

    public function check_kelengkapan_data($klien_id)
    {
        // kelengkapan klien 
        $klien = Klien::where('id', $klien_id)->first();
        $nullKlien = [];
        $atribut_klien = $klien->getAttributes();
        foreach ($atribut_klien as $key => $value) {
            if ($value === null) {
                $nullKlien[] = $key;
            }
        }
        $removeKlien = ["desil", "kelas", "pekerjaan", "penghasilan", "status_kawin", "anak_ke", "jumlah_anak", "nama_ibu", "tempat_lahir_ibu", "tanggal_lahir_ibu", "nama_ayah", "tempat_lahir_ayah", "tanggal_lahir_ayah", "created_by", "created_at", "updated_at", "deleted_at"];
        $nullKlien = array_values(array_diff($nullKlien, $removeKlien));
        $kolomKlien = count(Schema::getColumnListing('klien'));

        // kelengkapan kasus
        $kasus = Kasus::where('id', $klien->kasus_id)->first();
        $nullKasus = [];
        $atribut_kasus = $kasus->getAttributes();
        foreach ($atribut_kasus as $key => $value) {
            if ($value === null) {
                $nullKasus[] = $key;
            }
        }
        $removeKasus = ["created_by", "created_at", "updated_at", "deleted_at"];
        $nullKasus = array_values(array_diff($nullKasus, $removeKasus));
        $kolomKasus = count(Schema::getColumnListing('kasus'));

        // kelengkapan pelapor
        $pelapor = Pelapor::where('kasus_id', $klien->kasus_id)->first();
        $nullPelapor = [];
        $atribut_pelapor = $pelapor->getAttributes();
        foreach ($atribut_pelapor as $key => $value) {
            if ($value === null) {
                $nullPelapor[] = $key;
            }
        }
        $removePelapor = ["desil", "created_by", "created_at", "updated_at", "deleted_at"];
        $nullPelapor = array_values(array_diff($nullPelapor, $removePelapor));
        $kolomPelapor = count(Schema::getColumnListing('pelapor'));

        $data = array('nullKlien' => $nullKlien, 'kolomKlien' => $kolomKlien, 'nullKasus' => $nullKasus, 'kolomKasus' => $kolomKasus, 'nullPelapor' => $nullPelapor, 'kolomPelapor' => $kolomPelapor);

        return $data;
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

    public function check_kelengkapan_monitoring($klien_id)
    {
        // pelaksanaan monitoring
        $monitoring = Monitoring::where('klien_id', $klien_id)->count();
        // return jumlah monitoring
        return $monitoring;
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
                        ->get();
        $kasus = Kasus::where('id', $kasus_id)->pluck('no_reg');
        $terlapor = Terlapor::where('kasus_id', $kasus_id)->pluck('nama');
        $data->no_reg = $kasus[0];
        $data->terlapor = $terlapor;
        return $data;
    }

    public function generate_noreg()
    {
        // 1. Jumlahkan kasus yang ada no regisnya dan bukan empty
        // 2. Cari yang tahun ini saja
        // 3. Jumlahnya tambah 1
        // 4. Kombinasikan dengan bulan dan tahun saat ini

        $kasus_regis = Klien::whereNull('deleted_at')
                            ->whereIn('no_klien', ['',NULL])
                            ->whereYear('created_at', date('Y'))
                            ->count();
        $urutan_regis = $kasus_regis + 1;
        if ($urutan_regis < 10) {
            $urutan_regis = '00'.$urutan_regis;
        }else if($urutan_regis < 100){
            $urutan_regis = '0'.$urutan_regis;
        }else{
            $urutan_regis = $urutan_regis;
        }
        $no_klien = $urutan_regis.'/'.date('m').'/'.date('Y');

        return $no_klien;
    }

    public function destroy($uuid)
    {
        try {
            $proses = Klien::where('uuid', $uuid)->delete();

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
}
