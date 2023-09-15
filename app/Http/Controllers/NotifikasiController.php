<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public static function pull_notif()
    {   
        //tasks  
        $tasks =  Notifikasi::where('type_notif', 'task')
                            ->where('receiver_id', Auth::user()->id)
                            ->where('read', 0)
                            ->get();
        foreach ($tasks as $task) {
            $task->formattedDate = Carbon::parse($task->created_at)->diffForHumans(null, true);
        }
        //notifs
        $notifs =  Notifikasi::where('type_notif', 'notif')
                            ->where('receiver_id', Auth::user()->id)
                            ->where('read', 0)
                            ->get();
        foreach ($notifs as $notif) {
            $notif->formattedDate = Carbon::parse($notif->created_at)->diffForHumans(null, true);
        }
        $data = array('task' => $tasks, 
                        'notif' => $notifs, 
                        );
        return json_encode($data);
    }
}
