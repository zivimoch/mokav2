<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Kabupaten;
use Laravolt\Indonesia\Models\Kecamatan;
use Laravolt\Indonesia\Models\Kelurahan;

class WilayahController extends Controller
{
    public function getKotkab()
    {
 
        if (!request()->get('province_code')) {
            $response = array(
                'status' => 400,
                'data' => []
            );
            return response()->json($response, 400);
        }
        
        $kotkab = Kabupaten::where('province_code', request()->get('province_code'))->get();
        $response = array(
            'status' => 200,
            'data' => $kotkab
        );
        
        return response()->json($response, 200);   
    }

    public function getKecamatan()
    {
 
        if (!request()->get('kota_code')) {
            $response = array(
                'status' => 400,
                'data' => []
            );
            return response()->json($response, 400);
        }
        
        $kecamatan = Kecamatan::where('city_code', request()->get('kota_code'))->get();
        $response = array(
            'status' => 200,
            'data' => $kecamatan
        );
        
        return response()->json($response, 200);   
    }

    public function getKelurahan()
    {
 
        if (!request()->get('kecamatan_code')) {
            $response = array(
                'status' => 400,
                'data' => []
            );
            return response()->json($response, 400);
        }
        
        $kelurahan = Kelurahan::where('district_code', request()->get('kecamatan_code'))->get();
        $response = array(
            'status' => 200,
            'data' => $kelurahan
        );
        
        return response()->json($response, 200);   
    }
}
