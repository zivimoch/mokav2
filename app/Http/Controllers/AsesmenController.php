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
                    ->whereNull('a.deleted_at')
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
                Auth::user()->name.' membuat asesmen', 
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
    public function update(Request $request)
    {
         try {
            $data_update = $request->data_update ;
            $klien = Klien::where('uuid', $request->uuid_klien)->first();
            //create post
            $data = Asesmen::updateOrCreate(['uuid' => $request->uuid],[
                'fisik'   => $request->fisik, 
                'psikologis'     => $request->psikologis, 
                'sosial'   => $request->sosial, 
                'hukum'   => $request->hukum,
                'upaya'   => $request->upaya,
                'pendukung'   => $request->pendukung,
                'hambatan'   => $request->hambatan,
                'harapan'   => $request->harapan,
                'lainnya'   => $request->lainnya,
                'created_by'   => Auth::user()->id
            ]);

            $perubahan = $data->getChanges();

            if (!empty($perubahan)) {
                $perubahan['pengubah'] = Auth::user()->name;
                $perubahan[$data_update] = '';
            }

            $perubahan = array_keys($perubahan);
            
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
                Auth::user()->name.' membuat asesmen', 
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            // untuk menghindari dobel encoding terhadap notifjson, jadi cara returnnya seperti ini
            $url = url('/kasus/show/' . $klien->uuid . '?tab=kasus-asesmen');
            return redirect($url)
                    ->with('success', true)
                    ->with('response', $data);

        } catch (Exception $e){
            return response()->json(['msg' => $e->getMessage()], 500);
            dd($e->getMessage());
            return redirect()->route('kasus.show', $klien->uuid)
                    ->with('error', true)
                    ->with('response', $e->getMessage());
            die();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $proses = Asesmen::where('uuid', $uuid)->delete();
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
