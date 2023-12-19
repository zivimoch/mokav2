<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Catatan;
use App\Models\Klien;
use App\Models\Petugas;
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
            foreach ($petugas as $key => $value) {
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
}
