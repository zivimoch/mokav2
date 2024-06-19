<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataMasterKasus implements FromCollection
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

    public static function data_klien($request)
    {
        $query = DB::select("SELECT
                b.status AS progres_terakhir, b.no_klien, a.tanggal_pelaporan, a.media_pengaduan,
                a.sumber_informasi, a.tanggal_kejadian, a.ringkasan, a.alamat AS alamat_TKP, e.name AS provinsi_TKP, 
                f.name AS kota_TKP, g.name AS kecamatan_TKP, h.name AS kelurahan_TKP, a.kategori_lokasi, b.nama, b.nik,
                b.tempat_lahir, b.tanggal_lahir, TIMESTAMPDIFF(YEAR, b.tanggal_lahir, CURDATE()) AS usia, b.jenis_kelamin, 
                b.alamat AS alamat_domisili, i.name AS provinsi_Domisili, j.name AS kota_Domisili, 
                k.name AS kecamatan_Domisili, l.name AS kelurahan_Domisili, b.alamat_ktp AS alamat_KTP, 
                m.name AS provinsi_KTP, n.name AS kota_KTP, o.name AS kecamatan_KTP, p.name AS kelurahan_KTP,
                b.agama, b.no_telp, b.pendidikan, b.status_pendidikan, b.pekerjaan, b.status_kawin, y.kategori_kasus, x.jenis_kekerasan, 
                w.bentuk_kekerasan, v.disabilitas, z.name AS penerima_pengaduan, t.manajer_kasus, s.supervisor_kasus
                FROM
                kasus a
                LEFT JOIN klien b ON a.id = b.kasus_id
                LEFT JOIN 
                petugas c ON b.id = c.klien_id
                LEFT JOIN 
                users d ON d.id = c.user_id
                LEFT JOIN 
                (
                SELECT `name`, `id`
                FROM users
                WHERE jabatan = 'Penerima Pengaduan ') z ON z.id = a.created_by
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
                (SELECT a.klien_id, GROUP_CONCAT(' ', b.name) AS manajer_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Manajer Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id) 
                t ON t.klien_id = b.id
                LEFT JOIN 
                (SELECT a.klien_id, GROUP_CONCAT(' ', b.name) AS supervisor_kasus FROM petugas a LEFT JOIN users b ON a.user_id = b.id WHERE b.jabatan = 'Supervisor Kasus' AND a.deleted_at IS NULL AND b.deleted_at IS NULL GROUP BY a.klien_id) 
                s ON s.klien_id = b.id
                WHERE 
                a.deleted_at IS NULL AND
                b.deleted_at IS NULL AND 
                b.arsip = 0 
                GROUP BY 
                b.id");

        return collect($query);
    }
}