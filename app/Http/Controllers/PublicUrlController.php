<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Klien;
use App\Models\PublicUrl;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class PublicUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // hapus yang lebih dari 10 hari. hari created di tambah 10, kemudian cari selisih dengan dikurangi dengan hari ini. jika < 1 maka delete
        PublicUrl::whereRaw('TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(created_at, INTERVAL 3 DAY)) < 1')
                ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = PublicUrl::where('klien_id', $klien->id)->get();
        //return response
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'Data Berhasil Didapatkan!',
            'data'    => $data  
        ]);
    }

    public function show(Request $request, $uuid)
    {
        try {
            $url = PublicUrl::where('uuid', $uuid)->first();
            switch ($url->function) {
                case 'url-kasus':
                    $this->kasus($url->klien_id);
                break;
                default:
                    return abort(404);
            }
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), []);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $request->uuid_klien)->first();
                //create 
                $proses = PublicUrl::create([
                    'klien_id'     => $klien->id, 
                    'function'     => $request->function,
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

    public function kasus($klien_id)
    {
        $klien = Klien::find($klien_id);
    }
}
