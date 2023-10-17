<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Agenda;
use App\Models\DokumenTl;
use App\Models\Klien;
use App\Models\TindakLanjut;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use PhpParser\Node\Expr\New_;
use Yajra\DataTables\Facades\DataTables;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax()) {
       
            // $data = DB::table('agenda as a')
            //             ->select(DB::raw('CONCAT(COUNT(a.id), " agenda") as title, a.tanggal_mulai as start'))
            //             ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
            //             ->whereDate('a.tanggal_mulai', '>=', $request->start)
            //             ->whereDate('a.tanggal_mulai', '<=', $request->end)
            //             ->groupBy('a.tanggal_mulai')
            //             ->get();
            $data = Agenda::select(DB::raw('CONCAT(COUNT(*), " agenda") as title, tanggal_mulai as start'))
                            ->whereDate('tanggal_mulai', '>=', $request->start)
                            ->whereDate('tanggal_mulai', '<=', $request->end)
                            ->groupBy('tanggal_mulai')
                            ->get();
            return response()->json($data);
       }
 
       return view('agenda.index');
    }

    //untuk select2 list agenda, dia methodnya POST
    public function get_agenda(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $data = DB::table('agenda as a')
                        ->select(DB::raw('a.*, b.uuid as uuid_tindak_lanjut'))
                        ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                        ->where('b.created_by', Auth::user()->id)
                        ->whereNull('b.deleted_at')
                        ->orderBy('a.tanggal_mulai', 'DESC')
                        ->orderBy('a.jam_mulai', 'DESC')
                        ->limit(10)->get();
        }else{
            $data = DB::table('agenda as a')
                             ->select(DB::raw('a.*, b.uuid as uuid_tindak_lanjut'))
                             ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id')
                             ->where('b.created_by', Auth::user()->id)
                             ->where('a.judul_kegiatan', 'like', '%' .$search . '%')
                             ->whereNull('b.deleted_at')
                             ->orderBy('a.tanggal_mulai', 'DESC')
                             ->orderBy('a.jam_mulai', 'DESC')
                             ->limit(10)->get();
        }
  
        $response = array();
        foreach($data as $value){
           $response[] = array(
                "id"=>$value->uuid_tindak_lanjut,
                "text"=>$value->judul_kegiatan." (Tanggal ".date('d M Y', strtotime($value->tanggal_mulai)).", Pukul ".$value->jam_mulai.")"
           );
        }
        return response()->json($response); 
        
    }

    public function api_index(Request $request)
    { 
        // digunakan di datatable detail kasus & agenda
        // nanti benerin lagi, buat lebih sederhana masukin ke function show
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        }else{
            $user_id = Auth::user()->id;
        }
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->leftJoin('users as d','d.id','b.created_by')
                    ->leftJoin(DB::raw('(
                        SELECT 
                        a.tindak_lanjut_id, GROUP_CONCAT(CONCAT(",|"),b.judul) AS judul, GROUP_CONCAT(CONCAT(",|"),b.uuid) AS uuid_dokumen
                        FROM dokumen_tl a LEFT JOIN dokumen b ON a.dokumen_id = b.id
                        WHERE b.deleted_at IS NULL
                        GROUP BY a.tindak_lanjut_id) z'), 
                    function($join)
                    {
                    $join->on('z.tindak_lanjut_id', '=', 'b.id');
                    })
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->whereNotNull('b.id')
                    ->orderBy('a.tanggal_mulai')
                    ->orderBy('a.jam_mulai')
                    ->select(DB::raw('b.uuid, a.tanggal_mulai, a.jam_mulai, a.klien_id, b.tanggal_selesai, 
                    b.jam_selesai, a.judul_kegiatan, a.keterangan, a.uuid, b.lokasi, b.catatan, b.terlaksana, c.name, b.created_by, z.judul, z.uuid_dokumen, d.name as petugas, d.jabatan'));

                    if ($request->uuid) { //ini untuk di halaman map klien digital
                        $klien = Klien::where('uuid', $request->uuid)->first();
                        $data->where('a.klien_id', $klien->id);
                    } else { //ini untuk di halaman kinerja masing2 user
                        $data->where('b.created_by', $user_id)
                            ->whereYear('a.tanggal_mulai', $request->tahun)
                            ->whereMonth('a.tanggal_mulai', $request->bulan);
                    }

        $datas = $data->get();
        foreach ($datas as $datas2) {
            $datas2->tanggal_mulai_formatted = date('d M Y', strtotime($datas2->tanggal_mulai));
        }
        return DataTables::of($datas)->make(true);
    }

    public function kinerja(Request $request)
    {
        try {
            return view('agenda.kinerja');
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()], 404);
            die();
        }
    }

    public function kinerja_detail(Request $request)
    {
        if ($request->get('bulan') == null) {
            return redirect('kinerja');
        }

        // ===========================================================================================
        // Proses read, push notif & log activity ////////////////////////////////////////////////////
        // Jika sudah melihat halaman agenda maka tasknya (T10, N5, N7) selesai
        if (in_array($request->kode, ['T10','N5','N7'])) {
            NotifHelper::read_notif(
                Auth::user()->id, // receiver_id
                NULL, // klien_id
                $request->kode, // kode
                $request->type_notif, // type_notif
                $request->agenda_id // agenda_id
            );
        }
        /////////////////////////////////////////////////////////////////////////////////////////////


        return view('agenda.kinerja_detail');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $notif_receiver = NULL;
            $validator = Validator::make($request->all(), [
                'judul_kegiatan' => 'required',
                'tanggal_mulai' => 'required',
                'jam_mulai' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                // untuk kebutuhan notifikasi
                $klien = Klien::where('id', $request->klien_id)->first();
                $tahun = date('Y', strtotime($request->tanggal_mulai));
                $bulan = date('m', strtotime($request->tanggal_mulai));

                //simpan data agenda
                $proses = Agenda::updateOrCreate(['uuid' => $request->uuid],[
                    'klien_id'     => $request->klien_id, 
                    'judul_kegiatan'   => $request->judul_kegiatan, 
                    'tanggal_mulai'   => $request->tanggal_mulai,
                    'jam_mulai'   => $request->jam_mulai,
                    'keterangan'   => $request->keterangan,
                    'created_by'   => Auth::user()->id
                ]);

                $perubahan = array_keys($proses->getChanges());
                $variabel_agenda = ['klien_id', 'judul_kegiatan', 'tanggal_mulai', 'jam_mulai', 'keterangan'];
                if (count(array_intersect($perubahan, $variabel_agenda)) > 0) {
                    // jika ada perubahan (selain created_by, updated_at) maka kirim notif
                    // ===========================================================================================
                    //Proses read, push notif & log activity ////////////////////////////////////////////////////
                    //push notifikasi ///////////////////////////////////////////////////////////////////////////
                    //kirim ke seluruh user yang ada di agenda
                    foreach ($request->user_id as $value) {
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            'T10', //kode
                            'task', //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            Auth::user()->name.' telah merubah agenda yang berkaitan dengan anda', //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode=T10&type_notif=task&agenda_id='.$proses->id), //url
                            0, //kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $proses->id // agenda_id
                        );
                        // untuk kirim realtime notifikasi
                        if ($value != Auth::user()->id) {
                            $notif_receiver[] = 'user_'.$value;
                        }
                        //write log activity ////////////////////////////////////////////////////////////////////////
                        $petugas = User::where('id', $value)->first();
                        LogActivityHelper::push_log(
                            //message
                            Auth::user()->name.' merubah agenda '.$request->judul_kegiatan,
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }
                    /////////////////////////////////////////////////////////////////////////////////////////////

                }

                $jumlah_agenda = Agenda::where('tanggal_mulai', $request->tanggal_mulai)
                                        ->count();
                $proses->jumlah_agenda = $jumlah_agenda." Agenda"; //untuk fullcalendar

                $hapus_user = 1;
                if (!empty($request->user_id)) {
                    $petugas_lama = TindakLanjut::where('agenda_id', $proses->id)->pluck('created_by')->toArray();
                    $petugas_baru = array_diff($request->user_id, $petugas_lama);
                    $petugas_baru = array_values($petugas_baru);
                    // input tindak_lanjut
                    foreach ($request->user_id as $value) {
                        if (!isset($request->uuid)) { 
                            //jika tidak ada maka tambah
                            TindakLanjut::create([
                                'agenda_id' => $proses->id,
                                'created_by' => $value
                            ]);

                            //kirim notifikasi "anda ditambahkan ke agenda. silahkan isi tindak lanjutnya"
                        }else{
                            // buat baru saat edit, cek dulu sudah ada apa belum
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->first();
                            if (empty($tindak_lanjut)) {
                                TindakLanjut::create([
                                    'agenda_id' => $proses->id,
                                    'created_by' => $value
                                ]);

                                //kirim notifikasi "anda ditambahkan ke agenda. silahkan isi tindak lanjutnya"
                            }
                        }

                        if ($value == Auth::user()->id) {
                            // jika edit dan id usernya adalah dirinya sendiri meka edit 
                            $perubahan_tl = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)
                                                        ->update([
                                                            'lokasi' => $request->lokasi,
                                                            'tanggal_selesai' => $request->tanggal_mulai, //tanggal selesai = tanggal mulai, karna kita main jadwanya per tanggal
                                                            'jam_selesai' => $request->jam_selesai,
                                                            'catatan' => $request->catatan,
                                                            'terlaksana' => $request->terlaksana
                                                        ]);

                            if (isset($request->dokumen_pendukung)) {
                            $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->first();
                            // hapus dulu dokumen_tl pada tindak lanjut ini, kemudian tambahkan lagi
                            DokumenTl::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();

                            foreach ($request->dokumen_pendukung as $value_dokumen) {
                                    DokumenTl::create([
                                        'tindak_lanjut_id' => $tindak_lanjut->id,
                                        'dokumen_id' => $value_dokumen
                                    ]);
                                }
                            }else{
                                $tindak_lanjut = TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->first();
                                // hapus Dokumen Pendukung 
                                DokumenTl::where('tindak_lanjut_id', $tindak_lanjut->id)->delete();
                            }
                            $hapus_user = 0;
                        }
                    }
                }else{
                    // jika tidak ada orang sama sekali maka hapus agenda, tindak lanjut dan buat semua notif read
                    $agenda = Agenda::where('uuid', $request->uuid)->first();
                    // hapus TL
                    TindakLanjut::where('agenda_id', $agenda->id)->delete();
                    // hapus agenda 
                    $agenda->delete();
                    // read all notif
                    NotifHelper::read_notif(
                        0, // receiver_id
                        NULL, // klien_id
                        'T9', // kode ini request dari link 
                        'task', // type_notif
                        $proses->id // agenda_id. ini bisa dikosongkan karna defaultnya NULL
                    );
                }
                // jika tidak ada user_id sesuai dengan yg login, berarti hapus user_id yg login pada tabel tindak lanjut
                // tidak bisa hapus agenda orang lain
                if ($hapus_user) {
                    TindakLanjut::where('created_by', Auth::user()->id)->where('agenda_id', $proses->id)->delete();
                }

             // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim ke seluruh user yang ada di agenda
            $send_notif = 1;
            $send_log = 1;
            if (!empty($request->user_id)) {
                foreach ($request->user_id as $value) {
                    $petugas = User::where('id', $value)->whereNull('deleted_at')->first();
                    if ($hapus_user) {
                    // jika hapus sama dengan 1 
                        $message_notif = Auth::user()->name.' telah menghapus dirinya dari agenda "'.$request->judul_kegiatan.'" tanggal '.$request->tanggal_mulai;
                        $kode = 'N7';
                        $type_notif = 'notif';
                        $url = url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode='.$kode.'&type_notif='.$type_notif.'&agenda_id='.$proses->id);
                        $kirim_ke_diri = 0;

                        $message_log = Auth::user()->name.' menghapus dirinya dari agenda "'.$request->judul_kegiatan.'" tanggal '.$request->tanggal_mulai;
                    }else if (!$request->uuid || ($request->uuid && !empty($petugas_baru))){
                        // jika tidak ada uuidnya berarti tambah, atau kalaupun edit jika ada $petugas barunya maka kirim notif ini
                        if ($value == Auth::user()->id) {
                            $message_notif = 'Anda telah membuat agenda untuk diri anda. Silahkan buat laporan tindak lanjutnya';
                        } else {
                            $message_notif = Auth::user()->name.' telah membuat agenda untuk anda. Silahkan buat laporan tindak lanjutnya';
                        }

                        $kode = 'T9';
                        $type_notif = 'task';
                        $url = url('/kinerja/detail?tahun='.$tahun.'&bulan='.$bulan.'&user_id='.$value.'&row-agenda='.$proses->uuid.'&kode='.$kode.'&type_notif='.$type_notif.'&agenda_id='.$proses->id);
                        $kirim_ke_diri = 1;
                        $message_log = Auth::user()->name.' membuat agenda untuk '.$petugas->name;
                        if (!(in_array($value, $petugas_baru)) && isset($request->uuid)) {
                            // jika id petugas yang sedang dilooping tidak ada di array petugas baru maka jangan kirim notif
                            // dan jika sifatnya update bukan add
                            $send_notif = 0;
                            $send_log = 0;
                        }
                        // dd(!(in_array($value, $petugas_baru)));
                        // untuk kirim realtime notifikasi
                        if ($value != Auth::user()->id) {
                            $notif_receiver[] = 'user_'.$value;
                        }
                    }else if($request->jam_selesai && $request->klien_id){
                        // jika ada jam selesainya maka menginputkan kinerja maka kirim ke MK (untuk kasus penjadawalan layanan)
                        $message_notif = Auth::user()->name.' telah mengupdate laporan tindak lanjut. Silahkan lihat isinya untuk update informasi kasus.';
                        $kode = 'N5';
                        $type_notif = 'notif';
                        $url = url('/kasus/show/'.$klien->uuid.'?tab=kasus-layanan&row-layanan='.$proses->uuid.'&kode='.$kode.'&type_notif='.$type_notif.'&agenda_id='.$proses->id);
                        $kirim_ke_diri = 0;

                        if ($petugas->jabatan != 'Manajer Kasus') {
                            // jika jabatannya bukan MK maka tidak kirim notif, hanya kirim ke MK saja
                            // $kirim_ke_diri bukan untuk ini
                            $send_notif = 0;
                        }

                        $message_log = Auth::user()->name.' membuat laporan tindak lanjut';
                    }else{
                        // jika hanya klik simpan tanpa melakukan apapun.
                        // menambahkan petugas di agenda yg sudah ada itu sudah di handle di atas
                        $send_notif = 0;
                        $send_log = 0;
                    }

                    if ($send_notif) {
                        // jika perlu kirim notif maka kirim
                        NotifHelper::push_notif(
                            $value , //receiver_id
                            ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                            $kode, //kode
                            $type_notif, //type_notif
                            ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                            Auth::user()->name, //from
                            $message_notif, //message
                            ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                            ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                            $url, //url
                            $kirim_ke_diri, // kirim ke diri sendiri 0 / 1
                            Auth::user()->id, // created_by
                            $proses->id // agenda_id
                        );
                    }
                    //write log activity ////////////////////////////////////////////////////////////////////////
                    if ($send_log) {
                        LogActivityHelper::push_log(
                            //message
                            $message_log,
                            //klien_id
                            ($klien && $klien->id)? $klien->id : NULL
                        );
                    }

                    // reset flag lagi
                    $send_notif = 1;
                    $send_log = 1;
                }
            }
            
            if ($request->jam_selesai) {
                // jika petugas sudah membuat tindak lanjut maka tasknya (T9) selesai
                NotifHelper::read_notif(
                    Auth::user()->id, // receiver_id
                    NULL, // klien_id
                    'T9', // kode ini request dari link 
                    'task', // type_notif
                    $proses->id // agenda_id. ini bisa dikosongkan karna defaultnya NULL
                );
            }
            // update status klien //////////////////////////////////////////////////////////////////////
            if (isset($klien->id)) {
                StatusHelper::push_status($klien->id, 'Pelaksanaan intervensi');
            }
            /////////////////////////////////////////////////////////////////////////////////////////////
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses,
                'notif_receiver' => $notif_receiver
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid) //buat menampilkan agenda (nanti benerin lagi coba)
    {
        try {
            $agenda = DB::table('agenda as a')
                            ->select(DB::raw('a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, b.lokasi, b.jam_selesai, b.catatan'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->where('b.uuid', $uuid)
                            ->where('b.created_by', Auth::user()->id)
                            ->first();
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Success',
                'data'    => $agenda  
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    public function showdate($date)
    {
        try {
            $agenda_semua = DB::table('agenda as a')
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, GROUP_CONCAT(" ", d.name) as petugas'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->leftJoin('users as d', 'd.id', 'b.created_by')
                            ->where('a.tanggal_mulai', $date)
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderBy('a.jam_mulai')
                            ->groupBy('a.id')
                            ->get();

            $agenda_saya = DB::table('agenda as a')
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama, b.lokasi, b.jam_selesai, b.catatan'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
                            ->where('a.tanggal_mulai', $date)
                            ->where('b.created_by', Auth::user()->id)
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->orderBy('a.jam_mulai')
                            ->get();
            $agenda = array('agenda_semua' => $agenda_semua, 
                            'agenda_saya' => $agenda_saya);
            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Success',
                'data'    => $agenda  
            ]);
        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()]);
            die();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->leftJoin('klien as d', 'a.klien_id', 'd.id')
                    ->where('b.created_by', Auth::user()->id)
                    ->where('a.uuid', $uuid)
                    ->whereNull('b.deleted_at')
                    ->select(DB::raw('a.id, b.id as tindak_lanjut_id, a.tanggal_mulai, a.jam_mulai, a.klien_id, d.nama, a.uuid, b.tanggal_selesai, b.jam_selesai, a.judul_kegiatan, a.keterangan, b.lokasi, b.catatan, c.name, b.created_by'))
                    ->first();
        $user_id = DB::table('tindak_lanjut as a')
                        ->leftJoin('users as b', 'a.created_by','b.id')
                        ->where('a.agenda_id', $data->id)
                        ->select('b.id', 'b.name')
                        ->whereNull('a.deleted_at')
                        ->get();
        $data->user_id = $user_id;
        $dokumen_id = DB::table('dokumen_tl as a')
                    ->leftJoin('dokumen as b', 'a.dokumen_id','b.id')
                    ->where('a.tindak_lanjut_id', $data->tindak_lanjut_id)
                    ->whereNull('b.deleted_at')
                    ->select('b.id', 'b.judul')
                    ->get();
        $data->dokumen_id = $dokumen_id;
        
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
