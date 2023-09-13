<?php

namespace App\Http\Controllers;

use App\Helpers\NotifHelper;
use App\Models\Agenda;
use App\Models\DokumenTl;
use App\Models\Klien;
use App\Models\TindakLanjut;
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

    public function api_index(Request $request)
    { // nanti benerin lagi, buat lebih sederhana masukin ke function show
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        }else{
            $user_id = Auth::user()->id;
        }
        $data = DB::table('agenda as a')
                    ->leftJoin('tindak_lanjut as b', 'b.agenda_id', 'a.id')
                    ->leftJoin('users as c', 'c.id', 'b.validated_by')
                    ->leftJoin(DB::raw('(
                        SELECT 
                        a.tindak_lanjut_id, GROUP_CONCAT(CONCAT(",|"),b.judul) AS judul
                        FROM dokumen_tl a LEFT JOIN dokumen b ON a.dokumen_id = b.id
                        GROUP BY a.tindak_lanjut_id) z'), 
                    function($join)
                    {
                    $join->on('z.tindak_lanjut_id', '=', 'b.id');
                    })
                    ->whereNull('a.deleted_at')
                    ->whereNull('b.deleted_at')
                    ->orderBy('a.tanggal_mulai')
                    ->orderBy('a.jam_mulai')
                    ->select(DB::raw('b.uuid, a.tanggal_mulai, a.jam_mulai, a.klien_id, b.tanggal_selesai, 
                    b.jam_selesai, a.judul_kegiatan, a.keterangan, a.uuid, b.lokasi, b.catatan, c.name, b.created_by, z.judul'));

                    if ($request->uuid) { //ini untuk di halaman map klien digital
                        $klien = Klien::where('uuid', $request->uuid)->first();
                        $data->where('a.klien_id', $klien->id);
                    } else { //ini untuk di halaman kinerja masing2 user
                        $data->where('b.created_by', $user_id)
                            ->whereYear('a.tanggal_mulai', $request->tahun)
                            ->whereMonth('a.tanggal_mulai', $request->bulan);
                    }
        return DataTables::of($data->get())->make(true);
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
        // dd($request);
        try {
            $validator = Validator::make($request->all(), [
                'judul_kegiatan' => 'required',
                'tanggal_mulai' => 'required',
                'jam_mulai' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                //simpan data agenda
                $proses = Agenda::updateOrCreate(['uuid' => $request->uuid],[
                    'klien_id'     => $request->klien_id, 
                    'judul_kegiatan'   => $request->judul_kegiatan, 
                    'tanggal_mulai'   => $request->tanggal_mulai,
                    'jam_mulai'   => $request->jam_mulai,
                    'keterangan'   => $request->keterangan,
                    'created_by'   => Auth::user()->id
                ]);

                $jumlah_agenda = Agenda::where('tanggal_mulai', $request->tanggal_mulai)
                                        ->count();
                $proses->jumlah_agenda = $jumlah_agenda." Agenda"; //untuk fullcalendar

                $hapus_user = 1;
                if (!empty($request->user_id)) {
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
                            TindakLanjut::where('created_by', $value)->where('agenda_id', $proses->id)->update([
                                'lokasi' => $request->lokasi,
                                'tanggal_selesai' => $request->tanggal_mulai, //tanggal selesai = tanggal mulai, karna kita main jadwanya per tanggal
                                'jam_selesai' => $request->jam_selesai,
                                'catatan' => $request->catatan
                            ]);

                            if (isset($request->dokumen_pendukung)) {
                                foreach ($request->dokumen_pendukung as $value_dokumen) {
                                    DokumenTl::create([
                                        'tindak_lanjut_id' => $value,
                                        'dokumen_id' => $value_dokumen
                                    ]);
                                }
                            }
                            $hapus_user = 0;
                        }
                    }
                }
                // jika tidak ada user_id sesuai dengan yg login, berarti hapus user_id yg login pada tabel tindak lanjut
                // tidak bisa hapus agenda orang lain
                if ($hapus_user) {
                    TindakLanjut::where('created_by', Auth::user()->id)->where('agenda_id', $proses->id)->delete();
                }

             // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            // $klien = Klien::where('id', $request->klien_id)->whereNull('deleted_at')->first();
            // //kirim ke seluruh user yang ada di agenda
            // foreach ($request->user_id as $value) {
            //     if ($value == Auth::user()->id) {
            //         $message = 'Anda telah membuat agenda. Silahkan buat laporan tindak lanjutnya';
            //     }else{
            //         $message = Auth::user()->name.' membuat agenda untuk anda. Silahkan buat laporan tindak lanjutnya';
            //     }
            //     NotifHelper::push_notif(
            //         $value , //receiver_id
            //         $klien->id ? $klien->id : '', //klien_id
            //         'T9', //kode
            //         'task', //type_notif
            //         $klien->no_klien ? $klien->no_klien : '', //noregis
            //         Auth::user()->name, //from
            //         $message, //message
            //         $klien->nama ? $klien->nama : '',  //nama korban 
            //         isset($klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
            //         url('/kinerja/detail/'.$klien->uuid.'?tab=settings&kolom-terminasi=1'), //url
            //         1, //kirim ke diri sendiri 0 / 1
            //         Auth::user()->id //created_by
            //     );
            // }
            // //write log activity ////////////////////////////////////////////////////////////////////////
            // LogActivityHelper::push_log(
            //     //message
            //     $message_log,
            //     //klien_id
            //     $klien->id 
            // );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
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
                            ->select(DB::raw('a.uuid, a.judul_kegiatan, a.tanggal_mulai, a.jam_mulai, a.keterangan, c.nama'))
                            ->leftJoin('tindak_lanjut as b', 'a.id', 'b.agenda_id') 
                            ->leftJoin('klien as c', 'c.id', 'a.klien_id')
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
