<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanIsi;
<<<<<<< HEAD
use App\Models\Petugas;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\User;
use Illuminate\Http\Request;
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // hapus persetujuan isi yang lebih dari 2 hari. hari created di tambah 2, kemudian cari selisih dengan dikurangi dengan hari ini. jika < 1 maka delete
        PersetujuanIsi::whereRaw('TIMESTAMPDIFF(DAY, NOW(), DATE_ADD(created_at, INTERVAL 3 DAY)) < 1')
<<<<<<< HEAD
                        ->whereNull('tandatangan')
                        ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $jumlah_kasus = Petugas::where('user_id', Auth::user()->id)->count();
        $jumlah_agenda = TindakLanjut::where('created_by', Auth::user()->id)->count();
        return view('dashboard')->with('jabatan', (new OpsiController)->api_jabatan())
                                ->with('jumlah_kasus', $jumlah_kasus)
                                ->with('jumlah_agenda', $jumlah_agenda)
                                ;
=======
                        ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return view('dashboard');
>>>>>>> a5b8b868dc63aecbff731d58b225d84c5f17745f
    }
}
