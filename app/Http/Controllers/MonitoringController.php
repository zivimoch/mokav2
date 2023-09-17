<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Klien;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = DB::table('monitoring as a')
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
                'kemajuan' => 'required',
                'tujuan' => 'required',
                'rencana' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();

                //create post
                $proses = Monitoring::updateOrCreate(['uuid' => $request->uuid],[
                    'klien_id'   => $klien->id, 
                    'kemajuan'     => $request->kemajuan, 
                    'tujuan'   => $request->tujuan, 
                    'rencana'   => $request->rencana,
                    'created_by'   => Auth::user()->id
                ]);

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menambahkan laporan hasil monitoring', 
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
