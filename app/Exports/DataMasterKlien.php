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

class DataMasterKlien implements FromCollection, WithHeadings, WithStyles
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
            'Progres Terakhir',
            'No Klien',
            'Tanggal Pelaporan',
            'Rujukan',
            'Media Pengaduan',
            'Sumber Informasi',
            'Tanggal Kejadian',
            'Ringkasan',
            'Alamat TKP',
            'Provinsi TKP',
            'Kota TKP',
            'Kecamatan TKP',
            'Kelurahan TKP',
            'Kategori Lokasi',
            'Nama Lengkap Klien',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Jenis Kelain',
            'Alamat Domisili',
            'Provinsi Domisili',
            'Kota Domisili',
            'Kecamatan Domisili',
            'Kelurahan Domisili',
            'Alamat KTP',
            'Provinsi KTP',
            'Kota KTP',
            'Kecamatan KTP',
            'Kelurahan KTP',
            'Agama',
            'No Tlp',
            'Pendidikan',
            'Status Pendidikan',
            'Pekerjaan',
            'Status Kawin',
            'Kategori Kasus',
            'Jenis Kekerasan',
            'Bentuk Kekerasn',
            'Disabilitas',
            'Jenis Terminasi',
            'Penerima Pengaduan',
            'Manajer Kasus',
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
            $basis_tanggal = 'b.'.$request['basisTanggal'];
        } else {
            $basis_tanggal = 'a.'.$request['basisTanggal'];
        }

        // filter basis wilayah & wilayah
        if ($request['wilayah'] != 'default') {
            if ($request['basisWilayah'] == 'tkp') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'a.kotkab_id' : 'a.provinsi_id';
                $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
            } elseif ($request['basisWilayah'] == 'ktp') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'b.kotkab_id_ktp' : 'b.provinsi_id_ktp';
                $wilayah_value = $request['wilayah'] != 'luar' ? $request['wilayah'] : env('id_provinsi');
            } elseif ($request['basisWilayah'] == 'domisili') {
                $basis_wilayah = $request['wilayah'] != 'luar' ? 'b.kotkab_id' : 'b.provinsi_id';
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
            $no_regis = 'AND b.no_klien IS NOT NULL';
        }else{
            $no_regis = '';
        }

        // filter arsip
        if ($request['arsip'] == '0') {
            $arsip = 'AND b.arsip = 0';
        }else{
            $arsip = '';
        }

        // filter basis perhitungan usia klien
        if ($request['penghitunganUsia'] == 'lapor') {
            $penguarang = 'a.tanggal_pelaporan';
        } elseif ($request['penghitunganUsia'] == 'kejadian') {
            $penguarang = 'a.tanggal_kejadian';
        } elseif ($request['penghitunganUsia'] == 'input') {
            $penguarang = 'a.created_at';
        } else {
            $penguarang = 'CURDATE()';
        }

        // filter kategori klien
        if ($request['kategoriKlien'] == 'dewasa_perempuan') {
            $kategori_klien = "AND (b.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, b.tanggal_lahir, ".$penguarang.") >= 18)";
        } elseif ($request['kategoriKlien'] == 'anak_perempuan'){
            $kategori_klien = "AND (b.jenis_kelamin = 'perempuan'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, b.tanggal_lahir, ".$penguarang.") <= 17)";
        } elseif ($request['kategoriKlien'] == 'anak_laki') {
            $kategori_klien = "AND (b.jenis_kelamin = 'laki-laki'";
            $kategori_klien .= " AND TIMESTAMPDIFF(YEAR, b.tanggal_lahir, ".$penguarang.") <= 17)";
        }else{
            $kategori_klien = '';
        }

        $query = DB::select("SELECT
                b.status AS progres_terakhir, b.no_klien, a.tanggal_pelaporan, a.sumber_rujukan, a.media_pengaduan,
                a.sumber_informasi, a.tanggal_kejadian, a.ringkasan, a.alamat AS alamat_TKP, e.name AS provinsi_TKP, 
                f.name AS kota_TKP, g.name AS kecamatan_TKP, h.name AS kelurahan_TKP, a.kategori_lokasi, b.nama, b.nik,
                b.tempat_lahir, b.tanggal_lahir, TIMESTAMPDIFF(YEAR, b.tanggal_lahir, CURDATE()) AS usia, b.jenis_kelamin, 
                b.alamat AS alamat_domisili, i.name AS provinsi_Domisili, j.name AS kota_Domisili, 
                k.name AS kecamatan_Domisili, l.name AS kelurahan_Domisili, b.alamat_ktp AS alamat_KTP, 
                m.name AS provinsi_KTP, n.name AS kota_KTP, o.name AS kecamatan_KTP, p.name AS kelurahan_KTP,
                b.agama, b.no_telp, b.pendidikan, b.status_pendidikan, b.pekerjaan, b.status_kawin, y.kategori_kasus, x.jenis_kekerasan, 
                w.bentuk_kekerasan, v.disabilitas, r.jenis_terminasi, z.penerima_pengaduan, t.manajer_kasus, s.supervisor_kasus
                FROM
                kasus a
                LEFT JOIN klien b ON a.id = b.kasus_id
                LEFT JOIN 
                petugas c ON b.id = c.klien_id
                LEFT JOIN 
                users d ON d.id = c.user_id
                LEFT JOIN 
                indonesia_provinces e ON e.code = a.provinsi_id
                LEFT JOIN 
                indonesia_cities f ON f.code = a.kotkab_id
                LEFT JOIN 
                indonesia_districts g ON g.code = a.kecamatan_id
                LEFT JOIN 
                indonesia_villages h ON h.code = a.kelurahan_id
                LEFT JOIN 
                indonesia_provinces i ON i.code = b.provinsi_id
                LEFT JOIN 
                indonesia_cities j ON j.code = b.kotkab_id
                LEFT JOIN 
                indonesia_districts k ON k.code = b.kecamatan_id
                LEFT JOIN 
                indonesia_villages l ON l.code = b.kelurahan_id
                LEFT JOIN 
                indonesia_provinces m ON m.code = b.provinsi_id_ktp
                LEFT JOIN 
                indonesia_cities n ON n.code = b.kotkab_id_ktp
                LEFT JOIN 
                indonesia_districts o ON o.code = b.kecamatan_id_ktp
                LEFT JOIN 
                indonesia_villages p ON p.code = b.kelurahan_id_ktp
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS kategori_kasus FROM t_kategori_kasus a LEFT JOIN 
                m_kategori_kasus b ON a.value = b.kode GROUP BY a.klien_id) y ON y.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS jenis_kekerasan FROM t_jenis_kekerasan a LEFT JOIN 
                m_jenis_kekerasan b ON a.value = b.kode GROUP BY a.klien_id) x ON x.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(b.nama) AS bentuk_kekerasan FROM t_bentuk_kekerasan a LEFT JOIN 
                m_bentuk_kekerasan b ON a.value = b.kode GROUP BY a.klien_id) w ON w.klien_id = b.id
                LEFT JOIN 
                (SELECT klien_id, GROUP_CONCAT(value) AS disabilitas FROM t_tipe_disabilitas GROUP BY klien_id) 
                v ON v.klien_id = b.id
                LEFT JOIN 
                (SELECT klien_id, GROUP_CONCAT(value) AS pasal FROM t_pasal GROUP BY klien_id) 
                u ON u.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(DISTINCT ' ', b.name) AS penerima_pengaduan FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE a.active = 1 AND b.jabatan = 'Penerima Pengaduan' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id) 
                z ON z.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(DISTINCT ' ', b.name) AS manajer_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE a.active = 1 AND b.jabatan = 'Manajer Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id) 
                t ON t.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(DISTINCT ' ', b.name) AS supervisor_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE a.active = 1 AND b.jabatan = 'Supervisor Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id) 
                s ON s.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(DISTINCT ' ', a.jenis_terminasi) AS jenis_terminasi FROM terminasi a LEFT JOIN klien b ON a.klien_id = b.id WHERE a.deleted_at IS NULL and a.validated_by IS NOT NULL GROUP BY a.klien_id) 
                r ON r.klien_id = b.id
                WHERE 
                a.deleted_at IS NULL AND
                b.deleted_at IS NULL AND 
                ".$basis_tanggal." BETWEEN '".$from."' AND '".$to."'
                ".$wilayah."
                ".$no_regis."
                ".$arsip."
                ".$kategori_klien."
                GROUP BY 
                b.id
                ORDER BY CAST(SUBSTRING_INDEX(b.no_klien, '/', 1) AS UNSIGNED);");

        return collect($query);
    }
}