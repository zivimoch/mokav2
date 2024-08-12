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
        $layanan = DB::table('t_keyword as a')
                        ->leftJoin('m_keyword as b', 'a.value', 'b.id')
                        ->where('a.created_by', Auth::user()->id)
                        ->where('b.jenis_agenda', 'Layanan')
                        ->count();
        $manajemen_layanan = DB::table('t_keyword as a')
                        ->leftJoin('m_keyword as b', 'a.value', 'b.id')
                        ->where('a.created_by', Auth::user()->id)
                        ->where('b.jenis_agenda', 'Manajemen Layanan')
                        ->count();

        // hapus ini setelah evaluasi selesai dan tercapai
        if (Auth::user()->jabatan == 'Manajer Kasus') {
            $user_id = Auth::user()->id;

            $rekap_agenda = "SELECT 
                u.name AS user_name,
                COUNT(CASE WHEN a.created_by = u.id THEN 1 END) AS dibuat_MK,
                COUNT(CASE WHEN a.created_by != u.id THEN 1 END) AS tak_dibuat_MK,
                ROUND(
                    COUNT(CASE WHEN a.created_by = u.id THEN 1 END) * 100.0 /
                    NULLIF(COUNT(a.id), 0), 2
                ) AS percentage_dibuatMK,
                ROUND(
                    COUNT(CASE WHEN a.created_by != u.id THEN 1 END) * 100.0 /
                    NULLIF(COUNT(a.id), 0), 2
                ) AS percentage_takDibuatMK
            FROM 
                users u
            JOIN 
                petugas p ON p.user_id = u.id
            JOIN 
                agenda a ON a.klien_id = p.klien_id
            WHERE 
                u.jabatan = 'Manajer Kasus'
                AND
                                MONTH(a.created_at) > 6
                                AND
                                MONTH(a.tanggal_mulai) > 6
                                AND u.id = $user_id
            GROUP BY 
            u.id;";
            $result = DB::selectOne(DB::raw($rekap_agenda));
            if ($result != null) {
                $dibuatMK = $result->dibuat_MK;  // 1
                $takDibuatMK = $result->tak_dibuat_MK; // 2
                // dd($takDibuatMK);
                $total = $dibuatMK + $takDibuatMK; // 3
                if ($total != 0) {
                    $dibuatMK = number_format($dibuatMK / $total * 100, 2);
                    $takDibuatMK = number_format($takDibuatMK / $total * 100, 2);
                }
            } else {
                $dibuatMK = 0;
                $takDibuatMK = 0;
            }
        } else {
            $dibuatMK = 0;
            $takDibuatMK = 0;
        }

        return view('dashboard')->with('jabatan', (new OpsiController)->api_jabatan())
                                ->with('jumlah_terminasi', $jumlah_terminasi)
                                ->with('jumlah_kasus', $jumlah_kasus)
                                ->with('layanan', $layanan)
                                ->with('manajemen_layanan', $manajemen_layanan)
                                ->with('dibuatMK', $dibuatMK)
                                ->with('takDibuatMK', $takDibuatMK)
                                ;
    }
}
