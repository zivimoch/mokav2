<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Klien;
use App\Models\PublicUrl;
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
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = PublicUrl::where('klien_id', $klien->id)->get();

        foreach ($data as $value) {
            # code...
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

    public function show(Request $request, $uuid)
    {
        $url = PublicUrl::where('uuid', $uuid)->first();
        switch ($url->function) {
            case 'url-kasus':
                $this->kasus($url->klien_id);
              break;
            default:
                return abort(404);
          }
    }

    public function kasus($klien_id)
    {
        $klien = Klien::find($klien_id);
        dd($klien);
    }
}
