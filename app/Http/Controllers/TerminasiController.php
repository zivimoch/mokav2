<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivityHelper;
use App\Helpers\NotifHelper;
use App\Helpers\StatusHelper;
use App\Models\Klien;
use App\Models\Terminasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class TerminasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $klien = Klien::where('uuid', $request->uuid)->first();
        $data = DB::table('terminasi as a')
                    ->leftJoin('users as b', 'b.id', 'a.created_by')
                    ->where('a.klien_id', $klien->id)
                    ->whereNull('a.deleted_at')
                    ->orderBy('a.id')
                    ->get(['a.*', 'b.name as petugas', 'b.jabatan']);
        foreach ($data as $datas) {
            $datas->created_at_formatted = date('d M Y', strtotime($datas->created_at));
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
                
                if (!$request->uuid) {
                    // jika tidak ada uuid berarti tambah / mengajukan terminasi
                    $data_request = array('klien_id'   => $klien->id, 
                    'jenis_terminasi' => $request->jenis_terminasi, 
                    'alasan' => $request->alasan,
                    'created_by' => Auth::user()->id);
                    $message_log = Auth::user()->name.' mengajukan terminasi';
                    $kirim_ke_petugas = 0;
                    $jabatan = 'Supervisor Kasus';
                    $kode = 'T12';
                    $message_notif = Auth::user()->name.' mengajukan terminasi. Silahkan terima / tolak terminasi';
                    $message_status = 'Proses terminasi';
                    // jika MK sudah mengajukan Terminasi maka tasknya (T5) selesai
                    NotifHelper::read_notif(
                        0, // receiver_id
                        $klien->id, // klien_id
                        'T5', // kode
                        'task' // type_notif
                    );
                }else if($request->alasan_approve){
                    // jika ada uuid & ada alasan_approve berarti edit tidak setuju terminasi
                    $data_request = array('alasan_approve' => $request->alasan_approve);
                    $message_log = Auth::user()->name.' tidak menyetujui terminasi';
                    $kirim_ke_petugas = 0;
                    $jabatan = 'Manajer Kasus';
                    $kode = 'T14';
                    $message_notif = Auth::user()->name.' tidak menyetujui terminasi. SIlahkan lihat catatan supervisor';
                    $message_status = 'Proses terminasi';
                }else{
                    // jika ada uuid & ada alasan_approve berarti edit setuju terminasi
                    $data_request = array('validated_by' => Auth::user()->id);
                    $message_log = Auth::user()->name.' menyetujui terminasi';
                    $kirim_ke_petugas = 1;
                    $kode = 'T13';
                    $message_notif = Auth::user()->name.' menyetujui terminasi. <b>Kasus ditutup / selesai</b>';
                    $message_status = 'Kasus berhasil diTerminasi';
                }

                //create post
                $proses = Terminasi::updateOrCreate(['uuid' => $request->uuid], $data_request);

            // ===========================================================================================
            //Proses read, push notif & log activity ////////////////////////////////////////////////////
            //push notifikasi ///////////////////////////////////////////////////////////////////////////
            
            $petugas = DB::table('petugas as a')
                        ->leftJoin('users as b', 'a.user_id', 'b.id')
                        ->where('a.klien_id', $klien->id)
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at');
            if ($kirim_ke_petugas == 0) {
                //kirim ke seluruh user yang ada di kasus
                $petugas = $petugas->where('b.jabatan', $jabatan);
            }
            $petugas = $petugas->pluck('b.id');
            foreach ($petugas as $key => $value) {
                NotifHelper::push_notif(
                    $value , //receiver_id
                    ($klien && $klien->id) ? $klien->id : NULL, //klien_id
                    $kode, //kode
                    'task', //type_notif
                    ($klien && $klien->no_klien) ? $klien->no_klien : NULL, //noregis
                    Auth::user()->name, //from
                    $message_notif, //message
                    ($klien && $klien->nama) ? $klien->nama : NULL,  //nama korban 
                    ($klien && $klien->tanggal_lahir) ? $klien->tanggal_lahir : NULL, //tanggal lahir korban
                    url('/kasus/show/'.$klien->uuid.'?tab=settings&kolom-terminasi=1&user_id='.$value.'&kode='.$kode.'&type_notif=task'), //url
                    0, //kirim ke diri sendiri 0 / 1
                    Auth::user()->id, // created_by
                    NULL // agenda_id
                );
                // untuk kirim realtime notifikasi
                if ($value != Auth::user()->id) {
                    $notif_receiver[] = 'user_'.$value;
                }
            }
            //write log activity ////////////////////////////////////////////////////////////////////////
            LogActivityHelper::push_log(
                //message
                $message_log, 
                //klien_id
                $klien->id 
            );
            // update status klien //////////////////////////////////////////////////////////////////////
            StatusHelper::push_status($klien->id, $message_status);
            /////////////////////////////////////////////////////////////////////////////////////////////

            //return response
            return response()->json([
                'success' => true,
                'code'    => 200,
                'message' => 'Data Berhasil Disimpan!',
                'data'    => $proses,
                'notif_receiver' => $notif_receiver 
            ]);
        } catch (Exception $e){
            return response()->json(['message' => $e->getMessage()]);
            die();
        }
    }
}
