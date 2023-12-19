<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class MonitoringController extends Controller
{
    public function index()
    {
        $kota = City::where('province_code', env('id_provinsi'))->get();
        return view('monitoring/index')
                ->with('kota', $kota);
    }

    public function jumlah_korban(Request $request)
    {
        // mendapatkan filter
        $allAttributes = $request->all();
        foreach ($allAttributes as $key => $value) {
            $filter[$key] = $value;
        }

        // mendapatkan periode
        if ($request->get('tanggal') != null) {
            $daterange = explode (" - ", $request->get('tanggal')); 
        }else{
            $daterange[0] = date("Y").'-01-01';
            $daterange[1] = date("Y-m-d");
        }
        $from = $daterange[0];
        $to = $daterange[1];
        $periode_grafik = [];

        if ($request->pengelompokan == 'tahun') {
            // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
            $from_grafik = (int) date("Y", strtotime($from));
            while ($from_grafik <= date("Y", strtotime($to))) {
                $periode_grafik[] = $from_grafik;
                $from_grafik++;
            }
        } else {
            $from_grafik = date("M Y",strtotime($from));
            while (strtotime($from_grafik) <= strtotime($to)) {
                $periode_grafik[] = $from_grafik;
                $from_grafik = date ("M Y", strtotime("+1 month", strtotime($from_grafik)));
            }
        }
        
        $periode = $periode_grafik;

        // filter pengelompokan
        if ($request->pengelompokan == 'tahun') {
            $filter_pengelompokan = 'YEAR';
            $filter_group = '';
        } else {
            $filter_pengelompokan = 'MONTH';
            $filter_group = ', MONTH(b.'.$request->basis_tanggal.')';
        }

        // filter basis perhitungan usia klien
        if ($request->penghitungan_usia == 'lapor') {
            $penguarang = 'b.tanggal_pelaporan';
        } elseif ($request->penghitungan_usia == 'kejadian') {
            $penguarang = 'b.tanggal_kejadian';
        } elseif ($request->penghitungan_usia == 'input') {
            $penguarang = 'b.created_at';
        } else {
            $penguarang = 'CURDATE()';
        }

        // jumlah klien berdasarkan kategori klien / korban
        $seluruh_klien = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'a.kasus_id', '=', 'b.id')
                        ->leftJoin(DB::raw('(SELECT a.id, a.kotkab_id, b.klien_id  
                                            FROM users a 
                                            LEFT JOIN petugas b ON a.id = b.user_id
                                            WHERE a.jabatan = "Supervisor Kasus") z'), 'z.klien_id', '=', 'a.id')
                        ->select(
                            DB::raw($filter_pengelompokan.'(b.'.$request->basis_tanggal.') AS PERIODE'),
                            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18 AND a.jenis_kelamin = "perempuan" THEN 1 ELSE 0 END) AS dewasa_perempuan'),
                            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') < 18 AND a.jenis_kelamin = "perempuan" THEN 1 ELSE 0 END) AS anak_perempuan'),
                            DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') < 18 AND a.jenis_kelamin = "laki-laki" THEN 1 ELSE 0 END) AS anak_laki'),
                            DB::raw('COUNT(*) AS total')
                        )
                        // filter tanggal
                        ->whereBetween('b.'.$request->basis_tanggal, [$from, $to])
                        ->groupBy(DB::raw('YEAR(b.'.$request->basis_tanggal.')'.$filter_group))
                        ->orderBy('PERIODE');
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }
        
        // data chart
        $data['periode'] = $seluruh_klien->pluck('PERIODE');
        $data['seluruh_klien'] = $seluruh_klien->pluck('total');
        $data['dewasa_perempuan'] = $seluruh_klien->pluck('dewasa_perempuan');
        $data['anak_perempuan'] = $seluruh_klien->pluck('anak_perempuan');
        $data['anak_laki'] = $seluruh_klien->pluck('anak_laki');

        $response = array(
            'status' => 200,
            'data' => $data,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200);  
    }
}
