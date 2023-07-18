<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Models\Petugas;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function store($uuid, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $uuid)->first();

                $filter = Petugas::where('klien_id', $klien->id)
                                ->where('user_id', $request->user_id)
                                ->first();

                if (!isset($filter)) {
                    //create petugas
                    $proses = Petugas::create([
                        'klien_id'   => $klien->id, 
                        'user_id'     => $request->user_id, 
                        'created_by'   => Auth::user()->id
                    ]);
                }else{
                    $proses = false;
                }

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $uuid, 'tab' => 'kasus-petugas'])
            ->with('success', true)
            ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function destroy($id)
    {
        try {
            $filter = Petugas::where('id', $id)->first();
            $klien = Klien::where('id', $filter->klien_id)->first();

            if (isset($filter)) {
                //delete petugas
                $proses = Petugas::where('id', $id)->delete();
            }else{
                $proses = false;
            }


            //hapus task di notifikasi
            // Notifikasi::where('receiver_id', $filter->user_id)
                        // ->where('klien_id', $filter->klien_id)
                        // ->delete();

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $klien->uuid, 'tab' => 'kasus-petugas'])
            ->with('success', true)
            ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
