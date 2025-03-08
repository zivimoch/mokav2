<?php

namespace App\Http\Controllers;

use App\Exports\DataDAK;
use App\Exports\DataLayananPerKeyword;
use App\Exports\DataMasterHubungan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Sheet;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
use Google_Service_Slides;
use Google_Service_Slides_BatchUpdatePresentationRequest;
use Google_Service_Slides_RefreshSheetsChartRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataMasterKlien;
use App\Exports\DataMasterTerlapor;
use App\Exports\DataProfile;

class MonitoringController extends Controller
{
    protected $slidesService;

    public function __construct()
    {
        // $client = new Google_Client();
        // $client->setApplicationName('Your Application Name');
        // $client->setScopes([Google_Service_Slides::PRESENTATIONS]);
        // $client->setAccessType('offline');
        // $client->setAuthConfig(storage_path('credentials.json'));

        // $this->slidesService = new Google_Service_Slides($client);
    }

    public function index()
    {
        try {
            // Attempt to get the latest update time for case monitoring
            $terakhir_update_monitoring_kasus = DB::table('mv_monitoring_kasus')
                                                ->select(DB::raw('TIME(jam_input) as jam_input'))
                                                ->first();

            // Get all cities in the province specified by the environment variable 'id_provinsi'
            $kota = City::where('province_code', env('id_provinsi'))->get();

            // Return the 'monitoring/index' view with the fetched data
            return view('monitoring/index')
                    ->with('terakhir_update_monitoring_kasus', $terakhir_update_monitoring_kasus->jam_input)
                    ->with('kota', $kota);

        } catch (QueryException $e) {
            // Log the error
            Log::error('QueryException: ' . $e->getMessage());

            // Set $terakhir_update_monitoring_kasus to NULL
            $terakhir_update_monitoring_kasus = null;

            // Get all cities in the province specified by the environment variable 'id_provinsi'
            $kota = City::where('province_code', env('id_provinsi'))->get();

            // Return the 'monitoring/index' view with $terakhir_update_monitoring_kasus set to NULL
            return view('monitoring/index')
                    ->with('terakhir_update_monitoring_kasus', $terakhir_update_monitoring_kasus)
                    ->with('kota', $kota);
        }
    }

    public function slide()
    {
        return view('monitoring.slide');
    }

    public function monitoring_kasus(Request $request)
    {
         // mendapatkan periode
         if ($request->get('tanggal') != null) {
            $daterange = explode (" - ", $request->get('tanggal')); 
        }else{
            $daterange[0] = date("Y").'-01-01';
            $daterange[1] = date("Y-m-d");
        }
        $from = $daterange[0];
        $to = $daterange[1];
        
        // filter untuk memunculkan kasus sesuai yang login saja
        if (!$request->anda) { 
            $anda = "AND p.user_id IS NOT NULL ";
        }else{
            $anda = "";
        }

        $data = DB::select("
        SELECT 
            a.id,
            a.uuid,
            p.user_id,
            b.tanggal_pelaporan,
            a.no_klien, 
            a.nama,
            y.penerima_pengaduan, x.manajer_kasus, w.supervisor_kasus,
            kelengkapan_data.kelengkapan_data,
            data_klasifikasi.data_klasifikasi,
            ROUND(((CASE WHEN y.penerima_pengaduan IS NOT NULL THEN 1 ELSE 0 END) + (CASE WHEN x.manajer_kasus IS NOT NULL THEN 1 ELSE 0 END) + (CASE WHEN w.supervisor_kasus IS NOT NULL THEN 1 ELSE 0 END))/3*100,2) 
            AS komponen_petugas,
            surat_persetujuan.surat_persetujuan,
            (CASE WHEN kronologis.kronologis IS NULL THEN 0 ELSE kronologis.kronologis END) AS kronologis,
            bpss.bpss,
            (CASE WHEN progres_layanan.progres_layanan IS NULL THEN 0 ELSE progres_layanan.progres_layanan END) AS progres_layanan,
            pemantauan_evaluasi.pemantauan_evaluasi,
            (CASE WHEN terminasi_kasus.terminasi_kasus IS NULL THEN 0 ELSE terminasi_kasus.terminasi_kasus END) AS terminasi_kasus,
            ROUND(
            (kelengkapan_data.kelengkapan_data +
            data_klasifikasi.data_klasifikasi +
            ROUND(((CASE WHEN y.penerima_pengaduan IS NOT NULL THEN 1 ELSE 0 END) + (CASE WHEN x.manajer_kasus IS NOT NULL THEN 1 ELSE 0 END) + (CASE WHEN w.supervisor_kasus IS NOT NULL THEN 1 ELSE 0 END))/3*100,2) + 
            surat_persetujuan.surat_persetujuan +
            (CASE WHEN kronologis.kronologis IS NULL THEN 0 ELSE kronologis.kronologis END) +
            bpss.bpss +
            (CASE WHEN progres_layanan.progres_layanan IS NULL THEN 0 ELSE progres_layanan.progres_layanan END) +
            pemantauan_evaluasi.pemantauan_evaluasi +
            (CASE WHEN terminasi_kasus.terminasi_kasus IS NULL THEN 0 ELSE terminasi_kasus.terminasi_kasus END)
            ) / 900 * 100,2
            ) AS skor 
        FROM 
            klien a 
        LEFT JOIN 
            kasus b ON a.kasus_id = b.id  
        LEFT JOIN
        (
            SELECT
            klien_id, user_id
            FROM petugas
            WHERE 
            user_id = ".$request->user_id."
        )p ON p.klien_id = a.id 
        LEFT JOIN 
        (SELECT a.klien_id, b.name AS penerima_pengaduan FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Penerima Pengaduan' AND a.deleted_at IS NULL AND b.deleted_at IS NULL) 
        y ON y.klien_id = a.id
        LEFT JOIN 
        (SELECT a.klien_id, b.name AS manajer_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Manajer Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL) 
        x ON x.klien_id = a.id
        LEFT JOIN 
        (SELECT a.klien_id, b.name AS supervisor_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Supervisor Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL) 
        w ON w.klien_id = a.id
        LEFT JOIN 
        (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS kategori_kasus FROM t_kategori_kasus a LEFT JOIN 
        m_kategori_kasus b ON a.value = b.kode GROUP BY a.klien_id) k ON k.klien_id = a.id
        LEFT JOIN 
        (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS jenis_kekerasan FROM t_jenis_kekerasan a LEFT JOIN 
        m_jenis_kekerasan b ON a.value = b.kode GROUP BY a.klien_id) l ON l.klien_id = a.id
        LEFT JOIN 
        (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS bentuk_kekerasan FROM t_bentuk_kekerasan a LEFT JOIN 
        m_bentuk_kekerasan b ON a.value = b.kode GROUP BY a.klien_id) m ON m.klien_id = a.id
        LEFT JOIN 
        (
        SELECT 
            b.id AS klien_id, 
            (
                ROUND (
                (
                SUM(CASE WHEN a.sumber_rujukan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.media_pengaduan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.sumber_informasi IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.tanggal_pelaporan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.tanggal_kejadian IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.kategori_lokasi IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.ringkasan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN a.alamat IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.no_klien IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.nik IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.nama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.alamat IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.agama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.no_telp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.kedisabilitasan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN b.hubungan_pelapor IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.nik IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.nama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.alamat IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.agama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN c.no_telp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.nik IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.nama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.tempat_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.tanggal_lahir IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.jenis_kelamin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.provinsi_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kotkab_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kecamatan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kelurahan_id_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.alamat_ktp IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.provinsi_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kotkab_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kecamatan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kelurahan_id IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.alamat IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.agama IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.status_kawin IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.pekerjaan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.kewarganegaraan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.status_pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.pendidikan IS NOT NULL THEN 1 ELSE 0 END) +
                SUM(CASE WHEN e.no_telp IS NOT NULL THEN 1 ELSE 0 END) 
            ) / 81 * 100, 2)
            ) AS kelengkapan_data
        FROM kasus a LEFT JOIN klien b ON a.id = b.kasus_id 
        LEFT JOIN pelapor c ON c.kasus_id = a.id
        LEFT JOIN r_hubungan_terlapor_klien d ON d.klien_id = b.id
        LEFT JOIN terlapor e ON d.terlapor_id = e.id
        WHERE b.deleted_at IS NULL AND b.arsip = 0 GROUP BY b.id, a.id, c.id, d.id, e.id
        ) kelengkapan_data ON kelengkapan_data.klien_id = a.id 
        LEFT JOIN 
        (
        SELECT
            klien_id,
            kategori_values,
            jenis_values,
            bentuk_values,
            ROUND((kategori_values + jenis_values + bentuk_values) / 3 * 100, 2) AS data_klasifikasi
        FROM (
            SELECT
                b.id AS klien_id,
                SUM(CASE WHEN (SELECT GROUP_CONCAT(c.value) FROM t_kategori_kasus c WHERE c.klien_id = b.id) IS NOT NULL THEN 1 ELSE 0 END) AS kategori_values,
                SUM(CASE WHEN (SELECT GROUP_CONCAT(d.value) FROM t_jenis_kekerasan d WHERE d.klien_id = b.id) IS NOT NULL THEN 1 ELSE 0 END) AS jenis_values,
                SUM(CASE WHEN (SELECT GROUP_CONCAT(e.value) FROM t_bentuk_kekerasan e WHERE e.klien_id = b.id) IS NOT NULL THEN 1 ELSE 0 END) AS bentuk_values
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 
            GROUP BY 
                b.id
        ) AS subquery_alias
        ) data_klasifikasi ON data_klasifikasi.klien_id = a.id
        LEFT JOIN 
        (SELECT
            klien_id,
            persetujuan_data,
            persetujuan_spp,
            ROUND((persetujuan_data + persetujuan_spp ) / 2 * 100, 2) AS surat_persetujuan
        FROM (
            SELECT
                b.id AS klien_id,
                SUM(CASE WHEN (SELECT GROUP_CONCAT(c.id) FROM persetujuan_isi c WHERE c.klien_id = b.id AND c.persetujuan_template_id = 1 AND c.tandatangan IS NOT NULL AND c.deleted_at IS NULL) IS NOT NULL THEN 1 ELSE 0 END) AS persetujuan_data,
                SUM(CASE WHEN (SELECT GROUP_CONCAT(d.id) FROM persetujuan_isi d WHERE d.klien_id = b.id AND d.persetujuan_template_id = 2 AND d.tandatangan IS NOT NULL AND d.deleted_at IS NULL) IS NOT NULL THEN 1 ELSE 0 END) AS persetujuan_spp
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 
            GROUP BY 
                b.id
        ) AS subquery_alias
        ) surat_persetujuan ON surat_persetujuan.klien_id = a.id
        LEFT JOIN 
        (
        SELECT
                b.id AS klien_id,
                ROUND((CASE WHEN COUNT(c.keterangan) > 0 THEN 1 ELSE 0 END) / 1 *100, 2) AS kronologis
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
                LEFT JOIN riwayat_kejadian c ON c.klien_id = b.id
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 AND 
                c.deleted_at IS NULL 
            GROUP BY 
                b.id
        ) kronologis ON kronologis.klien_id = a.id
        LEFT JOIN 
        (
        SELECT
                b.id AS klien_id,
                ROUND(
                (
                (CASE WHEN c.fisik IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.psikologis IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.sosial IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.hukum IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.upaya IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.pendukung IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.hambatan IS NOT NULL THEN 1 ELSE 0 END) + 
                (CASE WHEN c.harapan IS NOT NULL THEN 1 ELSE 0 END) 
                )
                / 8 *100
                ,2) AS bpss
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
                LEFT JOIN asesmen c ON c.klien_id = b.id
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 AND 
                c.deleted_at IS NULL 
            GROUP BY 
                b.id, c.fisik, c.psikologis, c.sosial, c.hukum, c.upaya, c.pendukung, c.hambatan, c.harapan
        ) bpss ON bpss.klien_id = a.id
        LEFT JOIN 
        (
        SELECT
            b.id AS klien_id, 
            ROUND(SUM(CASE WHEN d.jam_selesai IS NOT NULL THEN 1 ELSE 0 END) / COUNT(d.id) * 100, 2) AS progres_layanan
        FROM 
            klien b
            INNER JOIN kasus a ON a.id = b.kasus_id
            INNER JOIN agenda c ON c.klien_id = b.id
            LEFT JOIN tindak_lanjut d ON c.id = d.agenda_id 
        WHERE 
            b.deleted_at IS NULL AND 
            b.arsip = 0 AND 
            c.deleted_at IS NULL AND 
            d.deleted_at IS NULL 
        GROUP BY 
            b.id, b.nama
        ) progres_layanan ON progres_layanan.klien_id = a.id
        LEFT JOIN 
        (
        SELECT
                b.id AS klien_id,
                ROUND((CASE WHEN COUNT(c.kemajuan) > 0 THEN 1 ELSE 0 END) / 1 *100, 2) AS pemantauan_evaluasi
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
                LEFT JOIN pemantauan c ON c.klien_id = b.id
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 AND 
                c.deleted_at IS NULL 
            GROUP BY 
                b.id
        ) pemantauan_evaluasi ON pemantauan_evaluasi.klien_id = a.id
        LEFT JOIN 
        (
        SELECT
                b.id AS klien_id,
                ROUND((CASE WHEN COUNT(c.validated_by) > 0 THEN 1 ELSE 0 END) / 1 *100, 2) AS terminasi_kasus
            FROM 
                kasus a 
                LEFT JOIN klien b ON a.id = b.kasus_id 
                LEFT JOIN terminasi c ON c.klien_id = b.id
            WHERE 
                b.deleted_at IS NULL AND 
                b.arsip = 0 AND 
                c.validated_by IS NOT NULL 
            GROUP BY 
                b.id
        ) terminasi_kasus ON terminasi_kasus.klien_id = a.id
        WHERE 
            a.deleted_at IS NULL 
            AND 
            a.arsip = 0  
            AND
            b.".$request->basis_tanggal." BETWEEN '".$from."' AND '".$to."'
            ".$anda."
            GROUP BY a.id
        ORDER BY skor");
        return DataTables::of($data)->make(true);
    }

    // data monitoring kasus dari tabel materialized view
    public function monitoring_kasus_mv(Request $request)
    {
         // mendapatkan periode 
         if ($request->get('tanggal') != null) {
            $daterange = explode (" - ", $request->get('tanggal')); 
        }else{
            $daterange[0] = date("Y").'-01-01';
            $daterange[1] = date("Y-m-d");
        }
        $from = $daterange[0];
        $to = $daterange[1];
        
        // filter untuk memunculkan kasus sesuai yang login saja
        if (!$request->anda) { 
            $anda = "AND FIND_IN_SET('".Auth::user()->id."', user_id) > 0";
        }else{
            $anda = "";
        }

        $data =  DB::select("
                SELECT 
                * 
                FROM
                mv_monitoring_kasus
                WHERE 
                ".$request->basis_tanggal." BETWEEN '".$from."' AND '".$to."'
                ".$anda." ORDER BY skor");
        return DataTables::of($data)->make(true);
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


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
        }

        // filter pengelompokan
        if ($request->pengelompokan == 'tahun') {
            $filter_pengelompokan = 'YEAR';
            $filter_group = '';
        } else {
            $filter_pengelompokan = 'MONTH';
            $filter_group = ', MONTH('.$basis_tanggal.')';
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
                        ->leftJoin(DB::raw('(
                            SELECT DISTINCT b.klien_id, a.id, a.kotkab_id  
                            FROM users a 
                            LEFT JOIN petugas b ON a.id = b.user_id
                            WHERE a.jabatan = "Supervisor Kasus"
                            AND b.deleted_at IS NULL
                            AND b.active = 1
                        ) z'), 'z.klien_id', '=', 'a.id')
                        ->select(
                            DB::raw($filter_pengelompokan . '(' . $basis_tanggal . ') AS PERIODE'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) >= 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS dewasa_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS anak_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "laki-laki" THEN a.id 
                                    END) AS anak_laki'),
                            DB::raw('COUNT(DISTINCT a.id) AS total')
                        )
                        ->whereNull('a.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);
                        
        $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.')'.$filter_group))
                        ->orderBy('PERIODE');
        
        
        // $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.')'.$filter_group));
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }
        // data chart
        $data['periode'] = $seluruh_klien->pluck('PERIODE');
        $data['seluruh_klien'] = $seluruh_klien->pluck('total');
        $data['dewasa_perempuan'] = $seluruh_klien->pluck('dewasa_perempuan');
        $data['anak_perempuan'] = $seluruh_klien->pluck('anak_perempuan');
        $data['anak_laki'] = $seluruh_klien->pluck('anak_laki');

        if ($request->rekaptotal) {
            // digunakan untuk pie chart dan char lainnya yang bersifat total bukan progres
            $total_dewasa_perempuan = 0;
            foreach ($data['dewasa_perempuan'] as $key => $value_dewasa_perempuan) {
                $total_dewasa_perempuan = $total_dewasa_perempuan + $value_dewasa_perempuan;
            }
            $data['dewasa_perempuan'] = $total_dewasa_perempuan;

            $total_anak_perempuan = 0;
            foreach ($data['anak_perempuan'] as $key => $value_anak_perempuan) {
                $total_anak_perempuan = $total_anak_perempuan + $value_anak_perempuan;
            }
            $data['anak_perempuan'] = $total_anak_perempuan;

            $total_anak_laki = 0;
            foreach ($data['anak_laki'] as $key => $value_anak_laki) {
                $total_anak_laki = $total_anak_laki + $value_anak_laki;
            }
            $data['anak_laki'] = $total_anak_laki;

            $data['seluruh_klien'] = $data['dewasa_perempuan'] + $data['anak_perempuan'] + $data['anak_laki'];

        }

        // grafik jumlah korban berdasarkan basis wilayah
        if ($request->jumlah_korban_wilayah) {
            return $data;
        }


        $response = array(
            'status' => 200,
            'data' => $data,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200);  
    }

    // grafik jumlah korban berdasarkan basis wilayah
    public function jumlah_korban_wilayah(Request $request) 
    {
        $attribute = $request->all();
        if ($request->basis_wilayah == 'ktp') {
            $basis_wilayah = 'a.kotkab_id_ktp';
        } elseif ($request->basis_wilayah == 'domisili') {
            $basis_wilayah = 'a.kotkab_id';
        } else {
            $basis_wilayah = 'b.kotkab_id';
        } // else jika satpel maka tidak apa2 mengikuti tkp, karna 5 wilayah satpel pasti ada dan yang 0 akan dieliminasi
        $kota = DB::table('klien as a')
                        ->select(DB::raw('c.code, c.province_code, COALESCE(c.name, "Data Dalam Konfirmasi") AS name'))
                        ->leftJoin('kasus as b', 'a.kasus_id', '=', 'b.id')
                        ->leftJoin('indonesia_cities as c', 'c.code', '=', $basis_wilayah)
                        ->groupBy('c.name', 'c.code', 'c.province_code')
                        ->orderBy('c.province_code')
                        ->get()
                        ;

                        $luar_jkt = 0;
                        $null_tidak_diisi = 0;
                        $data = [];
                        $data_seluruh_kota = [];
                        
                        foreach ($kota as $key => $value) {
                            $attribute['basis_wilayah'] = $request->basis_wilayah;
                            $attribute['wilayah'] = $value->code;
                            $request->replace($attribute);
                            $request->merge(['jumlah_korban_wilayah' => true]);
                            $jumlah_korban = $this->jumlah_korban($request);
                        
                            if ($value->province_code == env('id_provinsi')) {
                                $data["$value->name"] = $jumlah_korban['seluruh_klien'];
                            } elseif ($value->province_code == null) {
                                $null_tidak_diisi = $jumlah_korban['seluruh_klien'] + $null_tidak_diisi;
                            } else {
                                $luar_jkt = $jumlah_korban['seluruh_klien'] + $luar_jkt;
                            }
                        
                            // untuk ditampilkan di data tabulasi
                            $data_seluruh_kota["$value->name"] = $jumlah_korban['seluruh_klien'];
                        }
                        
                        arsort($data);
                        $data["LUAR DKI JAKARTA"] = $luar_jkt;
                        $data["Data Dalam Konfirmasi"] = $null_tidak_diisi;
                        
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;
        foreach ($allAttributes as $key => $value) {
            $filter[$key] = $value;
        }
        
        // mencegah menampilkan yang valuenya 0
        $data = array_filter($data, function ($value) {
            return $value != 0;
        });
        $data_seluruh_kota = array_filter($data_seluruh_kota, function ($value) {
            return $value != 0;
        });

        $response = array(
            'status' => 200,
            'data' => $data,
            'data_seluruh_kota' => $data_seluruh_kota,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function jumlah_korban_klasifikasi(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
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
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->select(
                            DB::raw('YEAR('.$basis_tanggal.') AS PERIODE'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) >= 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS dewasa_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS anak_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "laki-laki" THEN a.id 
                                    END) AS anak_laki'),
                            DB::raw('COUNT(DISTINCT a.id) AS total')
                        )
                        ->whereNull('a.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);
        // tambahan karna untuk klasifikasi kasus            
        $seluruh_klien->selectRaw('COALESCE(y.nama, "Data Dalam Konfirmasi") AS nama');

        // jangan masukan Tidak Diketahui / Lainnya & Bukan Kekerasan
        $filter_kode = '';
        if ($request->klasifikasi == 'jenis_kekerasan') {
            $filter_kode = 'WHERE b.kode NOT IN (61, 105)';
        }
        
        $seluruh_klien->leftJoin(DB::raw('(SELECT a.klien_id, b.nama  
                        FROM t_'.$request->klasifikasi.' a 
                        LEFT JOIN m_'.$request->klasifikasi.' b ON a.value = b.kode
                        '.$filter_kode.'
                        ) y'), 'y.klien_id', '=', 'a.id');

        $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.'), y.nama'))
                        ->orderBy('total','DESC');
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        $datas = $seluruh_klien->get();

        $count = $lainnya = 0;
        $data = $data_seluruh = [];
        foreach ($datas as $key => $value) {
            if ($request->kategori_klien == 'dewasa_perempuan') {
                $kategori_klien = intval($value->dewasa_perempuan);
            } elseif ($request->kategori_klien == 'anak_perempuan'){
                $kategori_klien = intval($value->anak_perempuan);
            } elseif ($request->kategori_klien == 'anak_laki') {
                $kategori_klien = intval($value->anak_laki);
            } else {
                $kategori_klien = intval($value->total);
            }

            if ($count > 9) {
                $lainnya = $kategori_klien + $lainnya;
                $data["Lainnya"] = $lainnya;
            }else{
                $data["$value->nama"] = $kategori_klien;
            }
            $count++;
            // untuk ditampilkan di data tabulasi
            $data_seluruh["$value->nama"] = $kategori_klien;
        }

        $data = array_filter($data, function ($value) {
            return $value != 0;
        });
        $data_seluruh = array_filter($data_seluruh, function ($value) {
            return $value != 0;
        });

        $response = array(
            'status' => 200,
            'data' => $data,
            'data_seluruh' => $data_seluruh,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function jumlah_korban_kategori_lokasi(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
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
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->select(
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) >= 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS dewasa_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "perempuan" THEN a.id 
                                    END) AS anak_perempuan'),
                            DB::raw('COUNT(DISTINCT CASE 
                                    WHEN TIMESTAMPDIFF(YEAR, a.tanggal_lahir, b.tanggal_pelaporan) < 18
                                    AND a.jenis_kelamin = "laki-laki" THEN a.id 
                                    END) AS anak_laki'),
                            DB::raw('COUNT(DISTINCT a.id) AS total')
                        )
                        ->whereNull('a.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);
        // tambahan karna untuk klasifikasi kasus            
        $seluruh_klien->selectRaw('COALESCE(b.kategori_lokasi, "Data Dalam Konfirmasi") AS nama');

        $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.'), b.kategori_lokasi'))
                        ->orderBy('total','DESC');
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        // filter kategori klien
        $datas = $seluruh_klien->get();
        $count = $lainnya = 0;
        $data = $data_seluruh = [];
        foreach ($datas as $key => $value) {
            if ($request->kategori_klien == 'dewasa_perempuan') {
                $kategori_klien = intval($value->dewasa_perempuan);
            } elseif ($request->kategori_klien == 'anak_perempuan'){
                $kategori_klien = intval($value->anak_perempuan);
            } elseif ($request->kategori_klien == 'anak_laki') {
                $kategori_klien = intval($value->anak_laki);
            } else {
                $kategori_klien = intval($value->total);
            }

            if ($count > 9) {
                $lainnya = $kategori_klien + $lainnya;
                $data["Lainnya"] = $lainnya;
            }else{
                $data["$value->nama"] = $kategori_klien;
            }
            $count++;
            // untuk ditampilkan di data tabulasi
            $data_seluruh["$value->nama"] = $kategori_klien;
        }
        // mencegah menampilkan yang valuenya 0
        $data = array_filter($data, function ($value) {
            return $value != 0;
        });
        $data_seluruh = array_filter($data_seluruh, function ($value) {
            return $value != 0;
        });

        $response = array(
            'status' => 200,
            'data' => $data,
            'data_seluruh' => $data_seluruh,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function jumlah_korban_identitas(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
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
        
        // identitas pelapor, terlapor atau korban
        if ($request->basis_identitas == "hubungan") {
            $basis_identitas = 'e.value';
            $id_basis_identitas = 'e.id';
        } elseif ($request->basis_identitas == "pelapor") {
            $basis_identitas = 'c.'.$request->identitas;
            $id_basis_identitas = 'c.id';
        } elseif ($request->basis_identitas == "terlapor") {
            $basis_identitas = 'd.'.$request->identitas;
            $id_basis_identitas = 'd.id';
        } else {
            $basis_identitas = 'a.'.$request->identitas;
            $id_basis_identitas = 'a.id';
        }
        
        // jumlah klien berdasarkan kategori klien / korban
        $seluruh_klien = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'a.kasus_id', '=', 'b.id')
                        ->leftJoin('pelapor as c', 'b.id', '=', 'c.kasus_id')
                        ->leftJoin('terlapor as d', 'b.id', '=', 'd.kasus_id')
                        ->leftJoin(DB::raw('(SELECT a.id, a.kotkab_id, b.klien_id  
                                            FROM users a 
                                            LEFT JOIN petugas b ON a.id = b.user_id
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->whereNull('a.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to])
                        ->select(
                            DB::raw('YEAR('.$basis_tanggal.') AS PERIODE'),
                            DB::raw('COUNT(DISTINCT '.$id_basis_identitas.') AS total')
                        )
                        ->orderBy('total','DESC');

        // jika hubungan terlapor dan klien
        if ($request->identitas == "hubungan"){
            $seluruh_klien->leftJoin('r_hubungan_terlapor_klien as e', 'a.id', 'e.klien_id');
        }
        if ($request->identitas != "usia") {
            $seluruh_klien
            ->selectRaw('COALESCE('.$basis_identitas.', "Data Dalam Konfirmasi") AS nama')
           ->groupBy(DB::raw('YEAR('.$basis_tanggal.'), '.$basis_identitas));
        } else {
            $seluruh_klien
            ->selectRaw('COALESCE(TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.'), "Data Dalam Konfirmasi") AS nama')
            ->groupBy(DB::raw('YEAR('.$basis_tanggal.'), nama'));
        }

        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        // filter kategori klien
        if ($request->kategori_klien == 'dewasa_perempuan') {
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18');
        } elseif ($request->kategori_klien == 'anak_perempuan'){
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        } elseif ($request->kategori_klien == 'anak_laki') {
            $seluruh_klien->where('a.jenis_kelamin', 'laki-laki')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        }
        
        
        $datas = $seluruh_klien->get();
        $count = $lainnya = 0;
        $data["0 s/d 17 Tahun"] = 0;
        $data["18 s/d 24 Tahun"] = 0;
        $data["25 s/d 59 Tahun"] = 0;
        $data["60+ Tahun"] = 0;
        foreach ($datas as $key => $value) {
            $jumlah = intval($value->total);

            if ($count > 9 && $request->identitas != 'usia') {
                $lainnya = $jumlah + $lainnya;
                $data["Lainnya"] = $lainnya;
            }else{
                if ($request->identitas != 'usia') {
                    $data["$value->nama"] = $jumlah;
                } else {
                    $data["0 s/d 17 Tahun"] = intval($value->nama) <= 17 ? $data["0 s/d 17 Tahun"] + $value->total : $data["0 s/d 17 Tahun"];
                    $data["18 s/d 24 Tahun"] =  intval($value->nama) >= 18 && intval($value->nama) <= 24 ? $data["18 s/d 24 Tahun"] + $value->total : $data["18 s/d 24 Tahun"];
                    $data["25 s/d 59 Tahun"] =  intval($value->nama) >= 25 && intval($value->nama) <= 59 ? $data["25 s/d 59 Tahun"] + $value->total : $data["25 s/d 59 Tahun"];
                    $data["60+ Tahun"] =  intval($value->nama) >= 60 ? $data["60+ Tahun"] + $value->total : $data["60+ Tahun"];
                }
            }
            $count++;
            // untuk ditampilkan di data tabulasi
            $data_seluruh["$value->nama"] = $jumlah;
        }
        
        $data = array_filter($data, function ($value) {
            return $value != 0;
        });
        $data_seluruh_kota = array_filter($data_seluruh, function ($value) {
            return $value != 0;
        });

        $response = array(
            'status' => 200,
            'data' => $data,
            'data_seluruh' => $data_seluruh,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function jumlah_layanan(Request $request)
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

        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
        }
        
        // jumlah klien berdasarkan kategori klien / korban
        $seluruh_klien = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'a.kasus_id', '=', 'b.id')
                        ->leftJoin('agenda as c', 'a.id', '=', 'c.klien_id')
                        ->leftJoin('tindak_lanjut as d', 'd.agenda_id', '=', 'c.id')
                        ->leftJoin('t_keyword as e', 'd.id', '=', 'e.tindak_lanjut_id')
                        ->leftJoin('m_keyword as f', 'f.id', '=', 'e.value')
                        ->leftJoin(DB::raw('(SELECT a.id, a.kotkab_id, b.klien_id  
                                            FROM users a 
                                            LEFT JOIN petugas b ON a.id = b.user_id
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->whereNull('a.deleted_at')
                        ->whereNull('d.deleted_at')
                        ->whereNotNull('e.id')
                        ->selectRaw('e.jabatan, f.keyword as nama, COUNT(*) AS total')
                        ->groupBy(DB::raw('YEAR('.$basis_tanggal.'), e.jabatan, e.value'))
                        ->orderBy('e.jabatan')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);

        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
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

        if ($request->kategori_klien == 'dewasa_perempuan') {
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18');
        } elseif ($request->kategori_klien == 'anak_perempuan'){
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        } elseif ($request->kategori_klien == 'anak_laki') {
            $seluruh_klien->where('a.jenis_kelamin', 'laki-laki')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        }
        
        $data_seluruh = $seluruh_klien->get();
        
        // return response()->json($data_seluruh); 
        $response = array(
            'status' => 200,
            'data_seluruh' => $data_seluruh,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function jumlah_lp(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
        }

        // filter pengelompokan
        $filter_pengelompokan = 'YEAR';
        $filter_group = '';

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
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->leftJoin('catatan_hukum as c', 'c.klien_id', 'a.id')
                        ->select(
                            DB::raw($filter_pengelompokan.'('.$basis_tanggal.') AS PERIODE'),
                            DB::raw('SUM(CASE WHEN c.no_lp IS NOT NULL THEN 1 ELSE 0 END) AS ada_lp'),
                            DB::raw('SUM(CASE WHEN c.no_lp IS NULL THEN 1 ELSE 0 END) AS tidak_lp'),
                            DB::raw('COUNT(*) AS total')
                        )
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);
                        
        $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.')'.$filter_group))
                        ->orderBy('PERIODE');
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        // filter kategori klien
        if ($request->kategori_klien == 'dewasa_perempuan') {
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18');
        } elseif ($request->kategori_klien == 'anak_perempuan'){
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        } elseif ($request->kategori_klien == 'anak_laki') {
            $seluruh_klien->where('a.jenis_kelamin', 'laki-laki')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        }

        // data chart
        $data['periode'] = $seluruh_klien->pluck('PERIODE');
        $data['seluruh_klien'] = $seluruh_klien->pluck('total');
        $data['ada_lp'] = $seluruh_klien->pluck('ada_lp');
        $data['tidak_lp'] = $seluruh_klien->pluck('tidak_lp');

        // grafik jumlah korban berdasarkan basis wilayah
        if ($request->jumlah_korban_wilayah) {
            return $data;
        }


        $response = array(
            'status' => 200,
            'data' => $data,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200);  
    }

    public function jumlah_pos(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
        }

        // filter pengelompokan
        $filter_pengelompokan = 'YEAR';
        $filter_group = '';

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
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->leftJoin('users as c', 'c.id', 'a.created_by')
                        ->select(
                            DB::raw('c.name as PERIODE, COUNT(DISTINCT a.id) AS total')
                        )
                        ->whereNull('a.deleted_at')
                        ->whereNull('b.deleted_at')
                        ->whereNotIn('c.id', [90, 86, 89, 82, 88, 87]) // id penerima pengaduan kantor pusat
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to]);
                        
        $seluruh_klien->groupBy(DB::raw('a.created_by'))
                        ->orderBy('z.id');
        
        
        $seluruh_klien->groupBy(DB::raw('YEAR('.$basis_tanggal.')'.$filter_group));
        
        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        // filter kategori klien
        if ($request->kategori_klien == 'dewasa_perempuan') {
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18');
        } elseif ($request->kategori_klien == 'anak_perempuan'){
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        } elseif ($request->kategori_klien == 'anak_laki') {
            $seluruh_klien->where('a.jenis_kelamin', 'laki-laki')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        }

        // data chart
        $data['periode'] = $seluruh_klien->pluck('PERIODE');
        $data['seluruh_klien'] = $seluruh_klien->pluck('total');

        // grafik jumlah korban berdasarkan basis wilayah
        if ($request->jumlah_korban_wilayah) {
            return $data;
        }


        $response = array(
            'status' => 200,
            'data' => $data,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200);  
    }

    public function rangkuman_jumlah_kasus(Request $request)
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

        // jika pengelompokan adalah tahun maka set periode_grafiknya per tahun
        $from_grafik = (int) date("Y", strtotime($from));
        while ($from_grafik <= date("Y", strtotime($to))) {
            $periode_grafik[] = $from_grafik;
            $from_grafik++;
        }
        
        $periode = $periode_grafik;


        if ($request->basis_tanggal == 'tanggal_approve') {
            $basis_tanggal = 'a.'.$request->basis_tanggal;
        } else {
            $basis_tanggal = 'b.'.$request->basis_tanggal;
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
        
        // identitas pelapor, terlapor atau korban
        if ($request->basis_identitas == "pelapor") {
            $basis_identitas = 'c.'.$request->identitas;
            $id_basis_identitas = 'c.id';
        } elseif ($request->basis_identitas == "terlapor") {
            $basis_identitas = 'd.'.$request->identitas;
            $id_basis_identitas = 'd.id';
        } else {
            $basis_identitas = 'a.'.$request->identitas;
            $id_basis_identitas = 'a.id';
        }
        
        // jumlah klien berdasarkan kategori klien / korban
        $seluruh_klien = DB::table('klien as a')
                        ->leftJoin('kasus as b', 'a.kasus_id', '=', 'b.id')
                        ->leftJoin('pelapor as c', 'b.id', '=', 'c.kasus_id')
                        ->leftJoin('terlapor as d', 'b.id', '=', 'd.kasus_id')
                        ->leftJoin(DB::raw('(SELECT a.id, a.kotkab_id, b.klien_id  
                                            FROM users a 
                                            LEFT JOIN petugas b ON a.id = b.user_id
                                            WHERE a.jabatan = "Supervisor Kasus"
                                            AND b.deleted_at IS NULL
                            AND b.active = 1) z'), 'z.klien_id', '=', 'a.id')
                        ->whereNull('a.deleted_at')
                        // filter tanggal
                        ->whereBetween($basis_tanggal, [$from, $to])
                        ->select(
                            DB::raw('YEAR('.$basis_tanggal.') AS PERIODE'),
                            DB::raw('COUNT(DISTINCT '.$id_basis_identitas.') AS total')
                        )
                        ->orderBy('total','DESC');

        if ($request->identitas != "usia") {
            $seluruh_klien
            ->selectRaw('COALESCE('.$basis_identitas.', "Data Dalam Konfirmasi") AS nama')
           ->groupBy(DB::raw('YEAR('.$basis_tanggal.'), '.$basis_identitas));
        } else {
            $seluruh_klien
            ->selectRaw('COALESCE(TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.'), "Data Dalam Konfirmasi") AS nama')
            ->groupBy(DB::raw('YEAR('.$basis_tanggal.'), nama'));
        }

        // filter basis wilayah & wilayah
        if ($request->wilayah != 'default') {
            if ($request->basis_wilayah == 'tkp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'ktp') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id_ktp' : 'a.provinsi_id_ktp', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'domisili') {
                $seluruh_klien->where($request->wilayah != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id', $request->wilayah != 'luar' ? $request->wilayah : '!=', env('id_provinsi'));
            } elseif ($request->basis_wilayah == 'satpel') {
                $seluruh_klien->where('z.kotkab_id', $request->wilayah);
            }
        }

        // filter kasus ada no regis
        if ($request->regis != '0') {
            $seluruh_klien->whereNotNull('a.no_klien');
        }

        // filter arsip
        if ($request->arsip == '0') {
            $seluruh_klien->where('a.arsip', 0);
        }

        if ($request->kategori_klien == 'dewasa_perempuan') {
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') >= 18');
        } elseif ($request->kategori_klien == 'anak_perempuan'){
            $seluruh_klien->where('a.jenis_kelamin', 'perempuan')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        } elseif ($request->kategori_klien == 'anak_laki') {
            $seluruh_klien->where('a.jenis_kelamin', 'laki-laki')
                          ->whereRaw('TIMESTAMPDIFF(YEAR, a.tanggal_lahir, '.$penguarang.') <= 17');
        }
        
        
        $datas = $seluruh_klien->get();
        $count = $lainnya = 0;
        $data["0 s/d 17 Tahun"] = 0;
        $data["18 s/d 24 Tahun"] = 0;
        $data["25 s/d 59 Tahun"] = 0;
        $data["60+ Tahun"] = 0;
        foreach ($datas as $key => $value) {
            $jumlah = intval($value->total);

            if ($count > 9 && $request->identitas != 'usia') {
                $lainnya = $jumlah + $lainnya;
                $data["Lainnya"] = $lainnya;
            } else {
                if ($request->identitas != 'usia') {
                    $data["$value->nama"] = $jumlah;
                } else {
                    $data["0 s/d 17 Tahun"] = intval($value->nama) <= 17 ? $data["0 s/d 17 Tahun"] + $value->total : $data["0 s/d 17 Tahun"];
                    $data["18 s/d 24 Tahun"] =  intval($value->nama) >= 18 && intval($value->nama) <= 24 ? $data["18 s/d 24 Tahun"] + $value->total : $data["18 s/d 24 Tahun"];
                    $data["25 s/d 59 Tahun"] =  intval($value->nama) >= 25 && intval($value->nama) <= 59 ? $data["25 s/d 59 Tahun"] + $value->total : $data["25 s/d 59 Tahun"];
                    $data["60+ Tahun"] =  intval($value->nama) >= 60 ? $data["60+ Tahun"] + $value->total : $data["60+ Tahun"];
                }
            }
            $count++;
            // untuk ditampilkan di data tabulasi
            $data_seluruh["$value->nama"] = $jumlah;
        }
        
        $data = array_filter($data, function ($value) {
            return $value != 0;
        });
        $data_seluruh_kota = array_filter($data_seluruh, function ($value) {
            return $value != 0;
        });

        $response = array(
            'status' => 200,
            'data' => $data,
            'data_seluruh' => $data,
            'periode' => $periode,
            'filter' => $filter
        );
        
        return response()->json($response, 200); 
    }

    public function export_profile(Request $request) {
        $data = DataProfile::data($request);
        return Excel::download(new DataProfile($data), 'Data profile '.$request->tanggal.' ('.$request->basisTanggal.').'.$request->format);
    }

    public function rekap_profile(Request $request) {
        // initial init
        // basis tanggal dan periode tanggal tergantung inputan
        $request->merge(['pengelompokan' => 'perbulan']);
        $request->merge(['basis_wilayah' => 'default']);
        $request->merge(['wilayah' => 'default']);
        $request->merge(['penghitungan_usia' => 'lapor']);
        $request->merge(['regis' => 1]);
        $request->merge(['arsip' => 0]);
        $request->merge(['rekaptotal' => null]);
        $data = [];

        $data['korban_perbulan'] = $this->jumlah_korban($request);

        $request->merge(['pengelompokan' => 'pertahun']);
        $data['korban_pertahun'] = $this->jumlah_korban($request);

        $request->merge(['rekaptotal' => 1]);
        $request->merge(['basis_wilayah' => 'tkp']);
        $data['korban_wilayah_tkp'] = $this->jumlah_korban_wilayah($request);
        $request->merge(['basis_wilayah' => 'ktp']);
        $data['korban_wilayah_ktp'] = $this->jumlah_korban_wilayah($request);
        $request->merge(['basis_wilayah' => 'domisili']);
        $data['korban_wilayah_domisili'] = $this->jumlah_korban_wilayah($request);
        $request->merge(['basis_wilayah' => 'satpel']);
        $data['korban_wilayah_kasatpel'] = $this->jumlah_korban_wilayah($request);

        $request->merge(['wilayah' => 'default']);
        $request->merge(['basis_wilayah' => 'tkp']);
        $request->merge(['kategori_klien' => 'total']);
        $request->merge(['basis_identitas' => 'korban']);
        $request->merge(['identitas' => 'usia']);
        $data['korban_usia_korban'] = $this->jumlah_korban_identitas($request);
        $request->merge(['basis_identitas' => 'terlapor']);
        $data['korban_usia_terlapor'] = $this->jumlah_korban_identitas($request);

        $request->merge(['identitas' => 'pendidikan']);
        $request->merge(['basis_identitas' => 'korban']);
        $data['korban_pendidikan_korban'] = $this->jumlah_korban_identitas($request);
        $request->merge(['basis_identitas' => 'terlapor']);
        $data['korban_pendidikan_terlapor'] = $this->jumlah_korban_identitas($request);

        $request->merge(['identitas' => 'pekerjaan']);
        $request->merge(['basis_identitas' => 'korban']);
        $data['korban_pekerjaan_korban'] = $this->jumlah_korban_identitas($request);
        $request->merge(['basis_identitas' => 'terlapor']);
        $data['korban_pekerjaan_terlapor'] = $this->jumlah_korban_identitas($request);

        $request->merge(['identitas' => 'hubungan']);
        $request->merge(['basis_identitas' => 'hubungan']);
        $data['hubungan_korban_terlapor'] = $this->jumlah_korban_identitas($request);

        $data['jumlah_lp'] = $this->jumlah_lp($request);
        
        $data['jumlah_pos'] = $this->jumlah_pos($request);

        return response()->json($data, 200);  
    }

    public function export_data_master_klien(Request $request)
    {
        $data = DataMasterKlien::data($request);
        return Excel::download(new DataMasterKlien($data), 'Data master kasus per klien '.$request->tanggal.' ('.$request->basisTanggal.').'.$request->format);
    }

    public function export_data_master_terlapor(Request $request)
    {
        $data = DataMasterTerlapor::data($request);
        return Excel::download(new DataMasterTerlapor($data), 'Data master kasus per terlapor '.$request->tanggal.' ('.$request->basisTanggal.').'.$request->format);
    }

    public function export_data_master_hubungan(Request $request)
    {
        $data = DataMasterHubungan::data($request);
        return Excel::download(new DataMasterHubungan($data), 'Data master Hubungan Terlapor dengan Korban (Terlapor Siapanya Korban)'.$request->tanggal.' ('.$request->basisTanggal.').'.$request->format);
    }

    public function export_data_layanan_per_keyword(Request $request)
    {
        return Excel::download(new DataLayananPerKeyword($request), 'Data layanan seluruh petugas per detail layanan'.$request->tanggal.' (tanggal layanan).'.$request->format);
    }

    public function export_data_dak(Request $request)
    {
        $data = DataDAK::data($request);
        return Excel::download(new DataDAK($data), 'Template Dana Alokasi Khusus '.$request->tanggal.' (tanggal_layanan).'.$request->format);
    }

    public function sheets()
    {

        $sheet_url = 'https://docs.google.com/spreadsheets/d/1ehsXlQm859lUiktFZgd5h6mCsBXQDgZa3xVYhQOnHuw/edit#gid=1364826426';
        $sheet_id = '1ehsXlQm859lUiktFZgd5h6mCsBXQDgZa3xVYhQOnHuw';

        // READ DATA
        // $shhet = Sheets::spreadsheet($sheet_id)->sheet('Chart')->get();
        
        // $header = $shhet->pull(0);
        // $value = Sheets::collection($header,$shhet);
        // $data = array_values($value->toArray());

        // CREAD NEW SHEET
        // Sheets::spreadsheet($sheet_id)->addSheet('NamaSheet');

        // ADD DATA
        // $row = [
        //     ['id','name','email'],
        //     ['1','name1','email1'],
        //     ['2','name2','email2'],
        //     ['3','name3','email3'],
        // ];
        // Sheets::spreadsheet($sheet_id)->sheet('NamaSheet')->append($row);

        // DELETE SHEET
        // Sheets::spreadsheet($sheet_id)->deleteSheet('NamaSheet');

        // UPDATE VALUE OF DATA
        $row = [
            ['Tahun','Jumlah Korban'],
            ['2019',1179],
            ['2020',947],
            ['2021',1313],
            ['2022',1455],
            ['2023',1682],
            ['2024',468],
        ];
        Sheets::spreadsheet($sheet_id)->sheet('Chart')->update($row);
        dd('Berhasil');
    }

    // public function sheets()
    // {


    //     $sheet_url = 'https://docs.google.com/spreadsheets/d/1ehsXlQm859lUiktFZgd5h6mCsBXQDgZa3xVYhQOnHuw/edit#gid=1364826426';
    //     $sheet_id = '1ehsXlQm859lUiktFZgd5h6mCsBXQDgZa3xVYhQOnHuw';

    //     // UPDATE VALUE OF DATA
    //     $row = [
    //         ['Tahun','Jumlah Korban'],
    //         ['2019',200],
    //         ['2020',1050],
    //         ['2021',2000],
    //         ['2022',1200],
    //         ['2023',900],
    //         ['2024',1400],
    //     ];

    //     Sheets::spreadsheet($sheet_id)->sheet('Chart')->update($row);


    //     // // Presentation ID and Slide ID
    //     // $presentationId = '1iO5WZeX1g59PrL1j6mgAq9azIACnUqq9';
    //     // $slideId = 'g26e3af138ce_0_0'; // You need to know the ID of the slide containing the chart

    //     // // Make a request to retrieve the objects on the slide
    //     // $slideObjects = $this->slidesService->presentations_pages->get($presentationId, $slideId)->getObjects();

    //     // // Iterate through the objects to find the chart object
    //     // foreach ($slideObjects as $object) {
    //     //     if ($object->shape->getShapeType() === 'CHART') {
    //     //         $chartId = $object->getObjectId();
    //     //         break;
    //     //     }
    //     // }


    //     // $presentationId = '1iO5WZeX1g59PrL1j6mgAq9azIACnUqq9';
    //     // $chartId = '1364826426';

    //     //     // Create a request to refresh the Sheets chart
    //     //     $requests = [
    //     //         new Google_Service_Slides_RefreshSheetsChartRequest([
    //     //             'objectId' => $chartId
    //     //         ])
    //     //     ];

    //     //     // Execute the request
    //     //     $batchUpdateRequest = new Google_Service_Slides_BatchUpdatePresentationRequest([
    //     //         'requests' => $requests
    //     //     ]);
    //     //     $response = $this->slidesService->presentations->batchUpdate($presentationId, $batchUpdateRequest);

    //         dd('Berhasil');
    // }
}
