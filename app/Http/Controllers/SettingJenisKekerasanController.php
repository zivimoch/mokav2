<?php

namespace App\Http\Controllers;

use App\Models\MJenisKekerasan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingJenisKekerasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = MJenisKekerasan::whereNull('deleted_at')->orderBy('id');
        return DataTables::of($data)->make(true);
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
                'nama' => 'required'
            ]);
            if ($validator->fails())
            {
                throw new Exception($validator->errors());
            }
            
            if (!isset($request->uuid)) {
                // jika tidak ada uuid berarti tambah
                $kode = (MJenisKekerasan::orderBy('id','DESC')->pluck('id')->first() * 10) + 1;
            }else{
                // jika ada berarti edit, kode tetap sama tidak berubah
                $kode = $request->kode;
            }

            //create data
            $proses = MJenisKekerasan::updateOrCreate(['uuid' => $request->uuid],[
                'kode'   => $kode, 
                'nama'     => $request->nama, 
                'created_by'   => Auth::user()->id
            ]);

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
        $data = MJenisKekerasan::where('uuid', $uuid)
                    ->select('*')
                    ->first();
        
        return response()->json($data);
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
            $proses = MJenisKekerasan::where('uuid', $uuid)
                                        ->delete();

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
