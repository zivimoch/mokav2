<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Klien;
use App\Models\Notifikasi;
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

    public function index(Request $request)
    {
        if($request->ajax()) {
       }
    }

    //untuk select2 list petugas, dia methodnya POST
    public function get_petugas(Request $request)
    {
        $search = $request->search;
        if($search == ''){
            $data = DB::table('users as a')
                         ->leftJoin('petugas as b', 'b.user_id', 'a.id')
                         ->whereNull('a.deleted_at')
                         ->whereNull('b.deleted_at')
                        ->where('a.jabatan','!=' ,'Supervisor Kasus') // filter agar tidak bisa milih satpel
                        ->groupBy('a.id', 'a.name')
                         ->select('a.id','a.name');
             if ($request->klien_id != null && Auth::user()->jabatan != 'Super Admin') {
                 $data = $data->where('b.klien_id', $request->klien_id);
             }
             $data = $data->limit(100)->get();
        }else{
           $data = DB::table('users as a')
                        ->leftJoin('petugas as b', 'b.user_id', 'a.id')
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->where('a.jabatan','!=' ,'Supervisor Kasus') // filter agar tidak bisa milih satpel
                         ->groupBy('a.id','a.name')
                         ->select('a.id','a.name')
                        ->where('a.name', 'like', '%' .$search . '%');
            if ($request->klien_id != null && Auth::user()->jabatan != 'Super Admin') {
                $data = $data->where('b.klien_id', $request->klien_id);
            }
            $data = $data->limit(100)->get();
        }
  
        $response = array();
        foreach($data as $value){
            $response[] = array(
                 "id"=>$value->id,
                 "text"=>$value->name
            );
         }
        return response()->json($response); 
    }

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
                // jika Petugas Penerima Pengaduan / MK sudah mendaftarkan SPV & MK maka tasknya (T2) selesai
                NotifHelper::read_notif(
                    0, // receiver_id
                    $klien->id, // klien_id
                    'T2', // kode
                    'task' // type_notif
                );
            }

            $receiver = User::where('id', $request->user_id)->first();

            if ($receiver->jabatan == 'Penerima Pengaduan') {
                // jika yang ditambah adalah peneria pengaduan maka ubah created by di kasus dan kliennya
                $klien->created_by = $request->user_id;
                $klien->save();
            }

            $check_kelengkapan_spp = (new KasusController)->check_kelengkapan_spp($klien->id);
            $check_kelengkapan_asesmen = (new KasusController)->check_kelengkapan_asesmen($klien->id);
            if (($receiver->jabatan == 'Supervisor Kasus') && ($klien->no_klien == NULL)) {
                // jika yang ditambahkan adalah Supervisor Kasus & tidak ada no kliennya (belum di approve)
                $message = 'Kasus baru. Meminta persetujuan Supervisor';
                $kode = 'T3';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=settings&persetujuan-supervisor=1');
                $message_status = 'Pelaksanaan intervensi';
            } else if ($receiver->jabatan == 'Manajer Kasus' && !($check_kelengkapan_asesmen)) {
                // jika yang ditambahkan adalah MK dan asesmen belum ada
                $message = 'Kasus baru. Silahkan periksa kelengkapan kasus (Data Kasus, SPP, dll) & Segera inputkan asesmen BPSS';
                $kode = 'T6';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=kasus-asesmen&tambah-asesmen=1&kolom-kelengkapan=1');
                $message_status = 'Menunggu tanda tangan klien';
            }else{
                // jika yang ditambahkan adalah Petugas lain atau MK yang SPP sudah ada maka
                $message = Auth::user()->name.' menambahkan anda pada kasus. Silahkan lihat / riview kasus dan atau menambahkan informasi kasus dan atau membuat agenda layanan';
                $kode = 'T8';
                $url =  url('/kasus/show/'.$klien->uuid.'?tab=kasus&kasus-all=1&kode='.$kode.'&type_notif=task');
                $message_status = 'Pelaksanaan intervensi';
            }
             
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            NotifHelper::push_notif(
                $request->user_id , //receiver_id
                $klien->id, //klien_id
                $kode, //kode
                'task', //type_notif
                $klien->no_klien ? $klien->no_klien : NULL, //noregis
                Auth::user()->name, //from
                $message, //message
                $klien->nama, //nama korban 
                isset($klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                $url, //url
                1, //kirim ke diri sendiri 0 / 1
                Auth::user()->id, // created_by
                NULL // agenda_id
            );
            // untuk kirim realtime notifikasi
            if ($request->user_id != Auth::user()->id) {
                $notif_receiver[] = 'user_'.$request->user_id;
            }
            $notifjson = urlencode(json_encode($notif_receiver));

            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menambahkan '.$receiver->name.' pada kasus', 
                //klien_id
                $klien->id 
            );
            // update status klien //////////////////////////////////////////////////////////////////////
            StatusHelper::push_status($klien->id, $message_status);
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);

            // untuk menghindari dobel encoding terhadap notifjson, jadi cara returnnya seperti ini
            $url = url('/kasus/show/' . $klien->uuid . '?tab=kasus-petugas&tabel-petugas=1&notif='.$notifjson);
            return redirect($url)
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
            $petugas = Petugas::where('id', $id)->first();
            $klien = Klien::where('id', $petugas->klien_id)->first();
            if (isset($petugas)) {
                //delete petugas
                $proses = Petugas::where('id', $id)->delete();
            }else{
                return abort(404);
            }

            //hapus task di notifikasi
            $proses = Notifikasi::where('receiver_id', $petugas->user_id)
                        ->where('klien_id', $klien->id)
                        ->update(['read' => 1]);
            
            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            //kirim ke user yang ada di dihapus
            NotifHelper::push_notif(
                $petugas->user_id , //receiver_id
                ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                'N8', //kode
                'notif', //type_notif
                ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                Auth::user()->name, //from
                Auth::user()->name.' telah menghapus akses anda dari kasus', //message
                ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                url('/kasus?klien_id='.$klien->id.'&user_id='.$petugas->user_id.'&kode=N8&type_notif=notif'), //url
                0, //kirim ke diri sendiri 0 / 1
                Auth::user()->id, // created_by
                NULL // agenda_id
            );

            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                Auth::user()->name.' menghapus akses '.$petugas->name.' dari kasus',
                //klien_id
                ($klien && $klien->id)? $klien->id : NULL
            );

            //return response
            $response =  response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses  
            ]);

            // untuk menghindari dobel encoding terhadap notifjson, jadi cara returnnya seperti ini
            $url = url('/kasus/show/' . $klien->uuid . '?tab=kasus-petugas&tabel-petugas=1');
            return redirect($url)
                    ->with('success', true)
                    ->with('response', $response);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
