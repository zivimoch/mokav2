<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Asesmen;
use App\Models\Klien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class AsesmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = DB::table('asesmen as a')
                    ->leftJoin('users as b', 'b.id', 'a.created_by')
                    ->where('a.klien_id', $klien->id)
                    ->orderBy('a.id')
                    ->get(['a.*', 'b.name as petugas', 'b.jabatan']);
        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Didapatkan!',
            'data'    => $data  
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'fisik' => 'required',
                'sosial' => 'required',
                'psikologis' => 'required',
                'hukum' => 'required',
                'lainnya' => 'required',
                'upaya' => 'required',
                'pendukung' => 'required',
                'hambatan' => 'required',
                'harapan' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();

                //create post
                $proses = Asesmen::updateOrCreate(['uuid' => $request->uuid],[
                    'klien_id'   => $klien->id, 
                    'fisik'     => $request->fisik, 
                    'sosial'   => $request->sosial, 
                    'psikologis'   => $request->psikologis, 
                    'hukum'   => $request->hukum, 
                    'lainnya'   => $request->lainnya, 
                    'upaya'   => $request->upaya, 
                    'pendukung'   => $request->pendukung, 
                    'hambatan'   => $request->hambatan, 
                    'harapan'   => $request->harapan, 
                    'created_by'   => Auth::user()->id
                ]);

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            // jika petugas sudah membuat asesmen maka tasknya (T6) selesai
            NotifHelper::read_notif(
                0, // receiver_id
                $klien->id, // klien_id
                'T6', // kode
                'task' // type_notif
            );
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menambahkan {{user_name}} pada kasus', 
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
