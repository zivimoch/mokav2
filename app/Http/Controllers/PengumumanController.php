<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $data = Pengumuman::select('pengumuman.*','users.name')
                            ->leftJoin('users', 'pengumuman.created_by', 'users.id')
                            ->get();
        foreach ($data as $datas) {
            $datas->created_at_formatted = Carbon::parse($datas->created_at)->diffForHumans(null, true);
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

                if ($request->uuid) {
                    // jika ada berarti delete
                    $proses = Pengumuman::where('uuid', $request->uuid)->delete();
                    $message_log = Auth::user()->name.' menghapus sebuah pengumuman';
                } else {
                    //create post
                    $proses = Pengumuman::create([
                        'judul'   => $request->judul, 
                        'konten'     => $request->konten, 
                        'kategori'     => $request->kategori, 
                        'created_by'   => Auth::user()->id
                    ]);
                    $message_log = Auth::user()->name.' membuat sebuah pengumuman';
                }
                

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                $message_log,
                //klien_id
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data = Pengumuman::where('uuid',$uuid)->first();
        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Ditampilkan!',
            'data'    => $data  
        ]);
    }
}
