<?php
namespace App\Helpers;

use App\Models\Notifikasi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifHelper
{
    
    public static function push_notif($receiver_id, $klien_id, $kode, $type_notif, $no_reg, $from, $message, $korban_nama, $tgl_lahir, $url, $kirim_ke_diri, $created_by = NULL, $agenda_id = NULL)
    {
        if (($kirim_ke_diri == 0 && Auth::user()->id != $receiver_id) || $kirim_ke_diri == 1) {

            $korban_umur = $tgl_lahir ? Carbon::parse($tgl_lahir)->age : NULL;
            if ($korban_umur) {
                $korban_umur =  ' ('.$korban_umur.')';
            }
            $kasus_data = $korban_nama.$korban_umur;
            // isu http jadi https karna json encode
            $url = str_replace('http://', 'https://', $url);
            
            $data_notif = [
                'receiver_id' => $receiver_id,
                'klien_id' => $klien_id,
                'agenda_id' => $agenda_id,  
                'kode' => $kode,
                'type_notif' => $type_notif,
                'no_reg' => $no_reg,
                'from' => $from,
                'message' => $message,
                'kasus' => $kasus_data,
                'url' => (string) $url,
                'created_by' => $created_by,
            ];
            $notif = Notifikasi::create($data_notif);
            return $notif->id;
        }
    }

    // public static function pull_notif()
    // {        
    //     return Notifikasi::where('receiver_id', Auth::user()->id)->orderBy('notifikasi.id','DESC');
    // }

    public static function read_notif($receiver_id, $klien_id, $kode, $type_notif, $agenda_id = NULL)
    {
        $update = Notifikasi::where('read',0)
                            ->where('kode', $kode)
                            ->where('type_notif', $type_notif)
                            ->where('agenda_id', $agenda_id);
        if ($receiver_id != 0) {
            // jika sama dengan 0 maka semua notifikasi dengan kode dan tipe notif yang ditentukan akan hilang tidak peduli receivernya siapa
            $update->where('receiver_id',$receiver_id);
        }
        if ($klien_id) {
            // jika ada $klien_id nya maka klien_id menjadi penting untuk dicari
            $update->where('klien_id',$klien_id);
        }
        return $update->update(['read' => 1, 'updated_at' => date("Y-m-d H:i:s")]);
    }
}