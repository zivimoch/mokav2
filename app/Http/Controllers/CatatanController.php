<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Catatan;
use App\Models\CatatanHukum;
use App\Models\CatatanPsikologi;
use App\Models\Klien;
use App\Models\Petugas;
use App\Models\TPasal;
use App\Models\TTipeDisabilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class CatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = DB::table('catatan as a')
                    ->leftJoin('users as b', 'b.id', 'a.created_by')
                    ->where('a.klien_id', $klien->id)
                    ->whereNull('a.deleted_at')
                    ->orderBy('a.id')
                    ->get(['a.*', 'b.name as petugas', 'b.jabatan']);
        foreach ($data as $datas) {
            $datas->created_at_formatted = date('d M Y', strtotime($datas->created_at));
        }
        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Didapatkan!',
            'data'    => $data  
        ]);
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
            $validator = Validator::make($request->all(), [
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();
                
                if ($request->uuid) {
                    // jika ada berarti delete
                    $proses = Catatan::where('uuid', $request->uuid)->delete();
                    $message_log = Auth::user()->name.' menghapus catatan pada kasus';
                } else {
                    //create post
                    $proses = Catatan::create([
                        'klien_id'   => $klien->id, 
                        'catatan'     => $request->catatan, 
                        'created_by'   => Auth::user()->id
                    ]);
                    $message_log = Auth::user()->name.' menambahkan catatan pada kasus';
                }
                

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim ke seluruh user yang ada di kasus
            $petugas = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', 'b.id')
                        ->where('a.klien_id', $klien->id)
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->pluck('b.id');

            $notif_receiver = [];
            if ($request->user_id) {
                foreach ($request->user_id as $value) {
                    NotifHelper::push_notif(
                        $value , //receiver_id
                        ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                        'T11', //kode
                        'task', //type_notif
                        ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                        Auth::user()->name, //from
                        Auth::user()->name.' menambahkan catatan pada kasus. Silahkan lihat catatan kasus untuk update informasi kasus', //message
                        ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                        ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                        url('/kasus/show/'.$klien->uuid.'?catatan-kasus=1&user_id='.$value.'&kode=T11&type_notif=task'), //url
                        0, //kirim ke diri sendiri 0 / 1
                        Auth::user()->id, // created_by
                        NULL // agenda_id
                    );

                    // untuk kirim realtime notifikasi
                    if ($value != Auth::user()->id) {
                        $notif_receiver[] = 'user_'.$value;
                    }
                }
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
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses,
                'notif_receiver' => $notif_receiver  
            ]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
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
        $data = Catatan::where('uuid',$uuid)->first();
        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Ditampilkan!',
            'data'    => $data  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // catatan hukum
    public function store_hukum(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();
                if ($request->laporan_polisi == 0) {
                    $request->merge(['no_lp' => null]);
                }

                // delete pasal
                TPasal::where('klien_id', $klien->id)->delete();

                if ($request->laporan_polisi == 0) {
                    $request->merge(['pengadilan_negeri' => null]);
                    $request->merge(['isi_putusan' => null]);
                }else{
                    // input pasal
                    if ($request->pasal) {
                        $pasal = array_unique($request->pasal);
                        foreach ($pasal as $value) {
                            TPasal::create([
                                'klien_id' => $klien->id,
                                'value' => $value
                            ]);
                        }
                    }
                }

                $proses = CatatanHukum::updateOrCreate(['klien_id' => $klien->id],[
                    'klien_id'     => $klien->id, 
                    'no_lp'   => $request->no_lp, 
                    'pengadilan_negeri'   => $request->pengadilan_negeri,
                    'isi_putusan'   => $request->isi_putusan,
                    'lpsk'   => $request->lpsk,
                    'proses_hukum'   => $request->proses_hukum,
                    'created_by'   => Auth::user()->id
                ]);
                

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim ke seluruh user yang ada di kasus
            $petugas = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', 'b.id')
                        ->where('a.klien_id', $klien->id)
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->pluck('b.id');
            
            $notif_receiver = [];
            foreach ($petugas as $key => $value) {
                NotifHelper::push_notif(
                    $value , //receiver_id
                    ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                    'N11', //kode
                    'notif', //type_notif
                    ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                    Auth::user()->name, //from
                    Auth::user()->name.' membuat / update cacatan '.$request->nama_layanan.'. Silahkan lihat catatan '.$request->nama_layanan.' untuk update informasi kasus', //message
                    ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                    ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    url('/kasus/show/'.$klien->uuid.'?catatan-layanan='.$request->nama_layanan.'&user_id='.$value.'&kode=T15&type_notif=task'), //url
                    0, //kirim ke diri sendiri 0 / 1
                    Auth::user()->id, // created_by
                    NULL // agenda_id
                );

                // untuk kirim realtime notifikasi
                if ($value != Auth::user()->id) {
                    $notif_receiver[] = 'user_'.$value;
                }
            }
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' membuat / update cacatan '.$request->nama_layanan,
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response = "Berhasil mengupdate data";
            $url = url('/kasus/show/' . $klien->uuid . '?tab=kasus&catatan-layanan='.$request->nama_layanan);
            return redirect($url)
                    ->with('success', true)
                    ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // catatan psikologis
    public function store_psikologis(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();
                // delete disabilitas
                TTipeDisabilitas::where('klien_id', $klien->id)->delete();

                if ($request->disabilitas != 0) {
                    // input disabilitas
                    if ($request->tipe_disabilitas) {
                        $tipe_disabilitas = array_unique($request->tipe_disabilitas);
                        foreach ($tipe_disabilitas as $value) {
                            TTipeDisabilitas::create([
                                'klien_id' => $klien->id,
                                'value' => $value
                            ]);
                        }
                    }
                }
                
                $proses = CatatanPsikologi::updateOrCreate(['klien_id' => $klien->id],[
                    'klien_id'     => $klien->id, 
                    'disabilitas'   => $request->disabilitas,
                    'created_by'   => Auth::user()->id
                ]);
                

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim ke seluruh user yang ada di kasus
            $petugas = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', 'b.id')
                        ->where('a.klien_id', $klien->id)
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->pluck('b.id');
            
            $notif_receiver = [];
            foreach ($petugas as $key => $value) {
                NotifHelper::push_notif(
                    $value , //receiver_id
                    ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                    'N11', //kode
                    'notif', //type_notif
                    ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                    Auth::user()->name, //from
                    Auth::user()->name.' membuat / update cacatan '.$request->nama_layanan.'. Silahkan lihat catatan '.$request->nama_layanan.' untuk update informasi kasus', //message
                    ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                    ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    url('/kasus/show/'.$klien->uuid.'?catatan-layanan='.$request->nama_layanan.'&user_id='.$value.'&kode=T15&type_notif=task'), //url
                    0, //kirim ke diri sendiri 0 / 1
                    Auth::user()->id, // created_by
                    NULL // agenda_id
                );

                // untuk kirim realtime notifikasi
                if ($value != Auth::user()->id) {
                    $notif_receiver[] = 'user_'.$value;
                }
            }
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' membuat / update cacatan '.$request->nama_layanan,
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response = "Berhasil mengupdate data";
            $url = url('/kasus/show/' . $klien->uuid . '?tab=kasus&catatan-layanan='.$request->nama_layanan);
            return redirect($url)
                    ->with('success', true)
                    ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
