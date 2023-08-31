<?php
namespace App\Helpers;

use App\Models\Notifikasi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifHelper
{
    
    public static function push_notif($receiver_id, $klien_id, $type_notif, $no_reg, $from, $message, $korban_nama, $tgl_lahir, $url, $created_by = NULL)
    {
        $korban_umur = $tgl_lahir ? Carbon::parse($tgl_lahir)->age : '';
        $kasus_data = $korban_nama.' ('.$korban_umur.')';
        $data_notif = [
            'receiver_id' => $receiver_id,
            'klien_id' => $klien_id,
            'type_notif' => $type_notif,
            'no_reg' => $no_reg,
            'from' => $from,
            'message' => $message,
            'kasus' => $kasus_data,
            'url' => $url,
            'created_by' => $created_by,
        ];

        $notif = Notifikasi::create($data_notif);

        return $notif->id;
    }

    public static function pull_notif()
    {        
        return Notifikasi::where('receiver_id', Auth::user()->id)->orderBy('notifikasi.id','DESC');
    }

    public static function read_notif($receiver_id, $kasus_id, $tahapan)
    {
        return Notifikasi::where('receiver_id',$receiver_id)
        ->where('kasus_id',$kasus_id)
        // ->where('tahapan', '<=', $tahapan)
        ->update(['read' => 1, 'updated_at' => date("Y-m-d H:i:s")]);
    }
}