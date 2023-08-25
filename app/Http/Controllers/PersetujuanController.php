<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Models\PersetujuanIsi;
use App\Models\PersetujuanItem;
use App\Models\PersetujuanTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PersetujuanController extends Controller
{
    public function persetujuan_pelayanan($uuid)
    {
        $persetujuan_isi = PersetujuanIsi::where('uuid', $uuid)->first();
        $persetujuan_template = PersetujuanTemplate::where('id', $persetujuan_isi->persetujuan_template_id)->first();
        $persetujuan_item = PersetujuanItem::where('persetujuan_template_id', $persetujuan_template->id)
                            ->where('parent_id', 0)
                            ->with('children')
                            ->get();

        if ($persetujuan_isi->tandatangan != null) {
            return redirect('persetujuan/donepelayanan/'.$uuid);
        }

        $klien = Klien::where('id', $persetujuan_isi->klien_id)->first();
        return view('persetujuan.pelayanan')
                ->with('persetujuan_item', $persetujuan_item)
                ->with('klien', $klien);
    }

    public function persetujuan_terminasi()
    {
        return view('persetujuan.terminasi');
    }

    public function create($uuid, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'persetujuan_template_uuid' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

                $klien = Klien::where('uuid', $uuid)->first();
                $persetujuan_template = PersetujuanTemplate::where('uuid', $request->persetujuan_template_uuid)->first();

                //create persetujuan
                $proses = PersetujuanIsi::create([
                    'klien_id'   => $klien->id, 
                    'persetujuan_template_id' => $persetujuan_template->id, 
                    'created_by'   => Auth::user()->id
                ]);

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $uuid, 'tab' => 'kasus-persetujuan'])
            ->with('success', true)
            ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_penandatangan' => 'required',
                'no_telp' => 'required',
                'alamat' => 'required'
                ]);
                if ($validator->fails())
                {
                    throw new Exception($validator->errors());
                }

            // handle statement
            $statement = [
                'setuju' => [],
                'tidak_setuju' => [],
            ];
            if (count($request->statement) > 0) {
                foreach ($request->statement as $key => $value) {
                    if ($value == 1) {
                        $statement['setuju'][] = $key;
                    }
                    if ($value == 0) {
                        $statement['tidak_setuju'][] = $key;
                    }
                }
            }

            //simpan tandatangan
            $folderPath = public_path('img/tandatangan/');
            $image_parts = explode(";base64,", $request->tandatangan);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = uniqid() . '.'.$image_type;
            $filepath = $folderPath . $file;
            file_put_contents($filepath, $image_base64);

            $data = [
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'isi' =>  json_encode($statement),
                'catatan' => $request->catatan,
                'tandatangan' => $file,
                'nama_penandatangan' => $request->nama_penandatangan
            ];
    
            $proses = PersetujuanIsi::updateOrCreate(['uuid' => $request->uuid], $data);

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect('persetujuan/donepelayanan/'.$request->uuid.'?success=1');
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }

    public function donepelayanan($uuid)
    {
        $persetujuan_isi = PersetujuanIsi::where('uuid', $uuid)->first();
        $persetujuan_template = PersetujuanTemplate::where('id', $persetujuan_isi->persetujuan_template_id)->first();
        $persetujuan_item = PersetujuanItem::where('persetujuan_template_id', $persetujuan_template->id)
                            ->where('parent_id', 0)
                            ->with('children')
                            ->get();

        $klien = Klien::where('id', $persetujuan_isi->klien_id)->first();
        return view('persetujuan.donepelayanan')
                ->with('persetujuan_isi', $persetujuan_isi)
                ->with('persetujuan_item', $persetujuan_item)
                ->with('klien', $klien);
    }
}
