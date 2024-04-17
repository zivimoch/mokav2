<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class NotifikasiController extends Controller
{
    public function index()
    {
        return view('notifikasi');
    }

    public static function pull_notif()
    {   
        //tasks  
        $tasks = DB::table('notifikasi as a')
                    ->leftJoin('klien as b', 'a.klien_id', 'b.id')
                    ->where('a.type_notif', 'task')
                    ->where('a.receiver_id', Auth::user()->id)
                    ->where('a.read', 0)
                    ->where('b.arsip', 0)
                    ->select('a.*')
                    ->get();
        // $tasks =  Notifikasi::where('type_notif', 'task')
        //                     ->where('receiver_id', Auth::user()->id)
        //                     ->where('read', 0)
        //                     ->get();
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
    
    public function pull_all(Request $request)
    {
        $data = DB::table('notifikasi as a')
                    ->select(DB::raw('a.*, b.name'))
                    ->leftJoin('users as b', 'a.receiver_id', 'b.id')
                    ->where('a.receiver_id', Auth::user()->id)
                    ->orderBy('a.id');
        $data = $data->where('type_notif', $request->tipe) 
                    ->get();
        foreach ($data as $datas) {
            $datas->formattedDate = Carbon::parse($datas->created_at)->diffForHumans(null, true);
        }
        return DataTables::of($data)->make(true);
    }
}
