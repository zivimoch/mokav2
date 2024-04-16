<?php

namespace App\Http\Controllers;

use App\Models\MBentukKekerasan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingBentukKekerasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DB::table('m_jenis_kekerasan as a')
                    ->select('a.kode as jenis_kode', 'a.nama as jenis_nama', 'b.uuid as uuid', 'b.kode as bentuk_kode', 'b.nama as bentuk_nama')
                    ->rightJoin('m_bentuk_kekerasan as b', 'a.kode', 'b.jenis_kekerasan_kode')
                    ->whereNull('b.deleted_at')
                    ->orderBy('b.jenis_kekerasan_kode', 'DESC')
                    ->orderBy('b.id', 'DESC');
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
                $kode = (MBentukKekerasan::orderBy('id','DESC')->pluck('id')->first() * 10) + 1;
            }else{
                // jika ada berarti edit, kode tetap sama tidak berubah
                $kode = $request->kode;
            }

            //create data
            $proses = MBentukKekerasan::updateOrCreate(['uuid' => $request->uuid],[
                'jenis_kekerasan_kode'   => $request->jenis_kode, 
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
        $data = MBentukKekerasan::where('uuid', $uuid)
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
            $proses = MBentukKekerasan::where('uuid', $uuid)
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
