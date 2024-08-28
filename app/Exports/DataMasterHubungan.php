<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataMasterHubungan implements FromCollection, WithHeadings, WithStyles
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function lorem_ipsum()
    {
        $a = 'lorem ipsum';
        $b = 'dolor sit amet';
        $jumlah = $a.' '.$b;
        echo $jumlah;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap Terlapor',
            'Nama Lengkap Klien',
            'No Klien',
            'Tanggal Pelaporan',
            'Hubungan (Terlapor Siapanya Klien)',
            'Supervisor Kasus',
        ];
    }

    public static function data($request)
    {
        // mendapatkan periode 
        if ($request['tanggal'] != null) {
            $daterange = explode (" - ", $request['tanggal']); 
        }else{
            $daterange[0] = date("Y").'-01-01';
            $daterange[1] = date("Y-m-d");
        }
        $from = $daterange[0];
        $to = $daterange[1];

        if ($request['basisTanggal'] == 'tanggal_approve') {
            $basis_tanggal = 'c.'.$request['basisTanggal'];
        } else {
            $basis_tanggal = 'b.'.$request['basisTanggal'];
        }

        // filter basis wilayah & wilayah
        if ($request['wilayah'] != 'default') {
            if ($request['basisWilayah'] == 'tkp') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id';
                $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
            } elseif ($request['basisWilayah'] == 'ktp') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'c.kotkab_id_ktp' : 'c.provinsi_id_ktp';
                $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
            } elseif ($request['basisWilayah'] == 'domisili') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'c.kotkab_id' : 'c.provinsi_id';
                $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
            } elseif ($request['basisWilayah'] == 'satpel') {
                $basis_wilayah = 's.kotkab_id';
                $wilayah_value = $request['wilayah'];
            }
            $wilayah = 'AND '.$basis_wilayah.' = "'.$wilayah_value.'"';
        } else { 
            $wilayah = '';
        }

        // filter kasus ada no regis
        if ($request['regis'] != '0') {
            $no_regis = 'AND c.no_klien IS NOT NULL';
        }else{
            $no_regis = '';
        }

        // filter arsip
        if ($request['arsip'] == '0') {
            $arsip = 'AND c.arsip = 0';
        }else{
            $arsip = '';
        }

        // filter basis perhitungan usia klien
        if ($request['penghitunganUsia'] == 'lapor') {
            $penguarang = 'b.tanggal_pelaporan';
        } elseif ($request['penghitunganUsia'] == 'kejadian') {
            $penguarang = 'b.tanggal_kejadian';
        } elseif ($request['penghitunganUsia'] == 'input') {
            $penguarang = 'b.created_at';
        } else {
            $penguarang = 'CURDATE()';
        }

        // filter kategori klien
        if ($request['kategoriKlien'] == 'dewasa_perempuan') {
            $kategori_klien = "AND (c.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, c.tanggal_lahir, ".$penguarang.") >= 18)";
        } elseif ($request['kategoriKlien'] == 'anak_perempuan'){
            $kategori_klien = "AND (c.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, c.tanggal_lahir, ".$penguarang.") <= 17)";
        } elseif ($request['kategoriKlien'] == 'anak_laki') {
            $kategori_klien = "AND (c.jenis_kelamin = 'laki-laki'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, c.tanggal_lahir, ".$penguarang.") <= 17)";
        }else{
            $kategori_klien = '';
        }

        $query = DB::select("
                            SELECT 
                            a.nik, a.nama AS nama_terlapor, c.nama AS nama_klien, c.no_klien, b.tanggal_pelaporan, d.value AS hubungan_terlapor_siapanya_korban, s.supervisor_kasus
                            FROM 
                            terlapor a LEFT JOIN kasus b ON a.kasus_id = b.id 
                            LEFT JOIN 
                            klien c ON c.kasus_id = b.id
                            LEFT JOIN 
                            r_hubungan_terlapor_klien d ON c.id = d.klien_id
                            LEFT JOIN 
                            (SELECT a.klien_id, GROUP_CONCAT(' ', b.name) AS supervisor_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Supervisor Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id)
                            s ON s.klien_id = c.id
                            WHERE 
                            b.deleted_at IS NULL AND 
                            c.deleted_at IS NULL AND
                            ".$basis_tanggal." BETWEEN '".$from."' AND '".$to."'
                            ".$wilayah."
                            ".$no_regis."
                            ".$arsip."
                            ".$kategori_klien."
                            ORDER BY a.id"
                        );

        return collect($query);
    }
}