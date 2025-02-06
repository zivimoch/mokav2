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

class DataDAK implements FromCollection, WithHeadings, WithStyles
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
            'Jenis Kelamin',
            'Usia',
            'Timestamp',
            'Nama Lengkap Tenaga Ahli/Petugas Layanan/Petugas',
            'Jenis Pekerjaan Tenaga Ahli/Petugas Layanan/jabatan lainnya',
            'Bulan Layanan',
            'Waktu Layanan',
            'Tanggal Layanan',
            'Nomor Registrasi Klien',
            'Jenis Kekerasan',
            'Jenis Layanan',
            'Jenis Pendampingan/Penjangkauan',
            'Nomor surat tugas P2TP2A',
            'Tanggal surat tugas P2TP2A',
            'Kasus Wilayah',
            'Instansi',
            'Email Address',
            'STATUS (SUDAH DIAJUKAN)'
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

        // filter basis wilayah & wilayah
        // if ($request['wilayah'] != 'default') {
        //     if ($request['basisWilayah'] == 'tkp') {
        //         $basis_wilayah = $request['wilayah'] != 'luar' ? 'h.kotkab_id' : 'b.provinsi_id';
        //         $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
        //     } elseif ($request['basisWilayah'] == 'ktp') {
        //         $basis_wilayah = $request['wilayah'] != 'luar' ? 'c.kotkab_id_ktp' : 'c.provinsi_id_ktp';
        //         $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
        //     } elseif ($request['basisWilayah'] == 'domisili') {
        //         $basis_wilayah = $request['wilayah'] != 'luar' ? 'c.kotkab_id' : 'c.provinsi_id';
        //         $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
        //     } elseif ($request['basisWilayah'] == 'satpel') {
        //         $basis_wilayah = 's.kotkab_id';
        //         $wilayah_value = $request['wilayah'];
        //     }
        //     $wilayah = 'AND '.$basis_wilayah.' = "'.$wilayah_value.'"';
        // } else { 
        //     $wilayah = '';
        // }

        // filter kasus ada no regis
        if ($request['regis'] != '0') {
            $no_regis = 'AND f.no_klien IS NOT NULL';
        }else{
            $no_regis = '';
        }

        // filter arsip
        if ($request['arsip'] == '0') {
            $arsip = 'AND f.arsip = 0';
        }else{
            $arsip = '';
        }

        // filter basis perhitungan usia klien
        if ($request['penghitunganUsia'] == 'lapor') {
            $penguarang = 'h.tanggal_pelaporan';
        } elseif ($request['penghitunganUsia'] == 'kejadian') {
            $penguarang = 'h.tanggal_kejadian';
        } elseif ($request['penghitunganUsia'] == 'input') {
            $penguarang = 'h.created_at';
        } else {
            $penguarang = 'CURDATE()';
        }

        // filter kategori klien
        if ($request['kategoriKlien'] == 'dewasa_perempuan') {
            $kategori_klien = "AND (f.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, f.tanggal_lahir, ".$penguarang.") >= 18)";
        } elseif ($request['kategoriKlien'] == 'anak_perempuan'){
            $kategori_klien = "AND (f.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, f.tanggal_lahir, ".$penguarang.") <= 17)";
        } elseif ($request['kategoriKlien'] == 'anak_laki') {
            $kategori_klien = "AND (f.jenis_kelamin = 'laki-laki'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, f.tanggal_lahir, ".$penguarang.") <= 17)";
        }else{
            $kategori_klien = '';
        }

        $layanan = '4,22,25,26,27,28,30,32,33,34,35,36,42,52,57,58,59,59,
                    60,61,62,63,64,65,66,67,68,69,70,71,86,86,112,114';
        $pendampingan = '4,22,25,26,27,30,32,33,34,36,42,57,58,59,59,
                            60,61,62,63,64,65,66,67,68,69,70,71,86,86,112,114';

        $query = DB::select("
                            SELECT
                            f.jenis_kelamin,
                            COALESCE(TIMESTAMPDIFF(YEAR, f.tanggal_lahir, ".$penguarang."), '0') AS usia,
                            CONCAT(d.tanggal_mulai, ' ', d.jam_mulai) AS `timestamp`, 
                            e.`name` AS nama_petugas,
                            e.jabatan,
                            MONTHNAME(d.tanggal_mulai) AS bulan,
                            d.jam_mulai AS waktu_layanan,
                            d.tanggal_mulai AS tanggal_layanan,
                            f.no_klien AS nomor_registrasi_klien,
                            GROUP_CONCAT(' ',j.nama) AS jenis_kekerasan,
                            -- id hanya pendampingan saja, else penjangkauan (ubah where in nya juga)
                            (if (a.`value` IN (".$pendampingan."),
                            'pendampingan', 'penjangkauan')) AS jenis_layanan,
                            b.keyword AS layanan,
                            CONCAT('') AS nomor_surat_tugas,
                            CONCAT('') AS tanggal_surat_tugas,
                            g.wilayah AS kasus_wilayah,
                            CONCAT('P2TP2A DKI Jakarta') AS instansi,
                            e.email,
                            CONCAT('') AS status_sudah_diajukan
                            FROM 
                            t_keyword a LEFT JOIN m_keyword b ON a.`value` = b.id
                            LEFT JOIN tindak_lanjut c ON c.id = a.tindak_lanjut_id
                            LEFT JOIN agenda d ON d.id = c.agenda_id
                            LEFT JOIN users e ON e.id = a.created_by
                            LEFT JOIN klien f ON f.id = d.klien_id
                            LEFT JOIN kasus h ON h.id = f.kasus_id
                            LEFT JOIN t_jenis_kekerasan i ON i.klien_id = f.id
                            LEFT JOIN m_jenis_kekerasan j ON j.kode = i.`value`
                            LEFT JOIN 
                            (
                            SELECT
                            a.klien_id, b.name, c.name AS wilayah
                            FROM 
                            petugas a LEFT JOIN users b ON a.user_id = b.id 
                            LEFT JOIN indonesia_cities c ON c.code = b.kotkab_id
                            WHERE b.jabatan = 'Supervisor Kasus'
                            AND a.`active` = 1
                            ) g ON g.klien_id = f.id
                            WHERE 
                            d.tanggal_mulai BETWEEN '".$from."' AND '".$to."'
                            AND 
                            a.`value` IN (".$layanan.")
                            ".$kategori_klien."
                            ".$arsip."
                            ".$no_regis."
                            AND 
                            c.deleted_at IS NULL AND d.deleted_at IS NULL
                            GROUP BY a.id 
                            "
                        );

        return collect($query);
    }
}