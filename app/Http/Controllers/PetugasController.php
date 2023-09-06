<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Models\Klien;
use App\Models\PersetujuanIsi;
use App\Models\Petugas;
use App\Models\User;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            $check_kelengkapan_petugas = (new KasusController)->check_kelengkapan_petugas($klien->id);
            if ($check_kelengkapan_petugas) {
                // jika Petugas Penerima Pengaduan sudah mendaftarkan SPV & MK maka tasknya (T2) selesai
                NotifHelper::read_notif(
                    Auth::user()->id, // receiver_id
                    $klien->id, // klien_id
                    'T2', // kode
                    'task' // type_notif
                );
            }
            $receiver = User::where('id', $request->user_id)->first();
            $check_kelengkapan_spp = (new KasusController)->check_kelengkapan_spp($klien->id);
            if ($receiver->jabatan == 'Supervisor Kasus') {
                // jika yang ditambahkan adalah Supervisor Kasus
                $message = 'Kasus baru. Meminta persetujuan Supervisor';
                $kode = 'T3';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=settings&persetujuan-supervisor=1');
            } else if ($receiver->jabatan == 'Manajer Kasus' && !($check_kelengkapan_spp)) {
                // jika yang ditambahkan adalah MK & belum ada sorat persetujuan 
                $message = 'Kasus baru. Silahkan buat Surat Persetujuan Pelayanan';
                $kode = 'T6';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=kasus-persetujuan&tambah-persetujuan=1');
            }else{
                // jika yang ditambahkan adalah Petugas lain atau MK yang SPP sudah ada maka
                $message = Auth::user()->name.' menambahkan anda pada kasus. Silahkan lihat / riview kasus dan atau menambahkan informasi kasus dan atau membuat agenda layanan';
                $kode = 'T11';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=kasus&kasus-all=1&kode=T11&tipe=task');
            }
             
             //push notifikasi ///////////////////////////////////////////////////////////////////////////
             NotifHelper::push_notif(
                $request->user_id , //receiver_id
                $klien->id, //klien_id
                $kode, //kode
                'task', //type_notif
                $klien->no_klien ? $klien->no_klien : '', //noregis
                Auth::user()->name, //from
                $message, //message
                $klien->nama, //nama korban 
                isset($klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                $url, //url
                Auth::user()->id //created_by
            );
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menambahkan '.$receiver->name.' pada kasus', 
                //klien_id
                $klien->id 
            );
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);
            
            return redirect()->route('kasus.show', ['uuid' => $uuid, 'tab' => 'kasus-petugas', 'tabel-petugas' => 1])
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
