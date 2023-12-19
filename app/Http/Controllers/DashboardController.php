<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanIsi;
use App\Models\User;
use Illuminate\Http\Request;
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
                        ->whereNull('tandatangan')
                        ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        return view('dashboard')->with('jabatan', (new OpsiController)->api_jabatan());
    }
}
