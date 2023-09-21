<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Klien;
use App\Models\Terminasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class TerminasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = DB::table('terminasi as a')
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
            $validator = Validator::make($request->all(), []);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();
                
                if (!$request->uuid) {
                    // jika tidak ada uuid berarti tambah
                    $data_request = array('klien_id'   => $klien->id, 
                    'jenis_terminasi' => $request->jenis_terminasi, 
                    'alasan' => $request->alasan,
                    'created_by' => Auth::user()->id);
                }else if($request->alasan_approve){
                    // jika ada uuid & ada alasan_approve berarti edit tidak setuju terminasi
                    $data_request = array('alasan_approve' => $request->alasan_approve);
                }else{
                    // jika ada uuid & ada alasan_approve berarti edit setuju terminasi
                    $data_request = array('validated_by' => Auth::user()->id);
                }

                //create post
                $proses = Terminasi::updateOrCreate(['uuid' => $request->uuid], $data_request);

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' mengajukan terminasi', 
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
