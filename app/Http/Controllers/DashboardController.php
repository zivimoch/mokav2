<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanIsi;
use App\Models\Petugas;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $jumlah_terminasi = DB::table('klien as a')
                            ->leftJoin('petugas as b', 'a.id', 'b.klien_id')
                            ->leftJoin('terminasi as c', 'a.id', 'c.klien_id')
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->where('a.arsip', 0)
                            ->where('b.user_id', Auth::user()->id)
                            ->whereNotNull('c.validated_by')
                            ->count();
        $jumlah_kasus = DB::table('klien as a')
                            ->leftJoin('petugas as b', 'a.id', 'b.klien_id')
                            ->whereNull('a.deleted_at')
                            ->whereNull('b.deleted_at')
                            ->where('a.arsip', 0)
                            ->where('b.user_id', Auth::user()->id)
                            ->count();
        $jumlah_agenda = TindakLanjut::where('created_by', Auth::user()->id)->count();

        // hapus ini setelah evaluasi selesai dan tercapai
        if (Auth::user()->jabatan == 'Manajer Kasus') {
            $user_id = Auth::user()->id;

            $rekap_agenda = "SELECT 
                a.name, 
                COALESCE(z.jumlah, 0) AS dibuat_MK, 
                COALESCE(y.jumlah, 0) AS tak_dibuat_MK
            FROM 
                users a 
            LEFT JOIN 
                (
                SELECT
                    b.id, 
                    COUNT(*) AS jumlah
                FROM
                    agenda a 
                LEFT JOIN 
                    users b ON a.created_by = b.id 
                WHERE 
                    b.id = $user_id
                    AND 
                    a.deleted_at IS NULL
                    AND 
                    a.klien_id IS NOT NULL 
                GROUP BY
                    b.id
                ) z ON a.id = z.id
            LEFT JOIN 
                (
                SELECT 
                    d.id, 
                    COUNT(*) AS jumlah
                FROM
                    agenda a 
                LEFT JOIN 
                    klien b ON a.klien_id = b.id
                LEFT JOIN 
                    petugas c ON b.id = c.klien_id
                LEFT JOIN 
                    users d ON d.id = c.user_id
                WHERE 
                    a.deleted_at IS NULL 
                    AND 
                    a.klien_id IS NOT NULL 
                    AND 
                    d.id = $user_id
                GROUP BY
                    d.id
                ) y ON a.id = y.id
            WHERE 
                a.id = $user_id
                AND 
                a.deleted_at IS NULL";
            $result = DB::selectOne(DB::raw($rekap_agenda));
            $dibuatMK = $result->dibuat_MK;  // 1
            $takDibuatMK = $result->tak_dibuat_MK; // 2
            $total = $dibuatMK + $takDibuatMK; // 3
            
            $dibuatMK = number_format($dibuatMK / $total * 100, 2);
            $takDibuatMK = number_format($takDibuatMK / $total * 100, 2);
        } else {
            $dibuatMK = 0;
            $takDibuatMK = 0;
        }

        return view('dashboard')->with('jabatan', (new OpsiController)->api_jabatan())
                                ->with('jumlah_terminasi', $jumlah_terminasi)
                                ->with('jumlah_kasus', $jumlah_kasus)
                                ->with('jumlah_agenda', $jumlah_agenda)
                                ->with('dibuatMK', $dibuatMK)
                                ->with('takDibuatMK', $takDibuatMK)
                                ;
    }
}
