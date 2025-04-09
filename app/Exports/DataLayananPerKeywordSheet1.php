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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataLayananPerKeywordSheet1 implements FromCollection, WithHeadings, WithStyles, WithTitle
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

    public function title(): string
    {
        return 'Agregat';
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
            'Jabatan',
            'Nama Petugas',
            'Detail Layanan',
            'Perempuan Dewasa',
            'Anak Laki-laki',
            'Anak Perempuan',
            'Jumlah',
            'No Klien'
        ];
    }

    public static function data($request)
    {
        // mendapatkan periode 
        if ($request['tanggal'] != null) {
            $daterange = explode (" - ", $request['tanggal']); 
        }else{
            $daterange[0] = date('0000-00-00');
            $daterange[1] = date("Y-m-d");
        }
        $from = $daterange[0];
        $to = $daterange[1];
        if ($request->anda) {
            $anda = "AND a.created_by = ".Auth::user()->id; 
        } else {
            $anda = '';
        }

        if ($request->jabatan) {
            $jabatanArray = is_array($request->jabatan) ? $request->jabatan : explode(',', $request->jabatan);
            $jabatanList = "'" . implode("','", array_map('trim', $jabatanArray)) . "'";
            $jabatan = "AND c.jabatan IN ($jabatanList)"; 
        } else {
            $jabatan = '';
        }
        
        $query = DB::select("SELECT
                                c.jabatan, c.`name`, b.keyword, 
                                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) > 17 AND bb.jenis_kelamin = 'perempuan' THEN 1 ELSE 0 END) AS perempuan_dewasa,
                                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) < 18 AND bb.jenis_kelamin = 'laki-laki' THEN 1 ELSE 0 END) AS anak_laki,
                                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) < 18 AND bb.jenis_kelamin = 'perempuan' THEN 1 ELSE 0 END) AS anak_perempuan,
                                SUM(
                                    CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) > 17 AND bb.jenis_kelamin = 'perempuan' THEN 1 ELSE 0 END +
                                    CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) < 18 AND bb.jenis_kelamin = 'laki-laki' THEN 1 ELSE 0 END +
                                    CASE WHEN TIMESTAMPDIFF(YEAR, bb.tanggal_lahir, CURDATE()) < 18 AND bb.jenis_kelamin = 'perempuan' THEN 1 ELSE 0 END
                                ) AS jumlah,
                                GROUP_CONCAT(DISTINCT f.no_klien ORDER BY f.no_klien ASC SEPARATOR ', ') AS no_klien
                            FROM 
                                t_keyword a
                                LEFT JOIN m_keyword b ON a.`value` = b.id
                                LEFT JOIN users c ON c.id = a.created_by
                                LEFT JOIN tindak_lanjut d ON d.id = a.tindak_lanjut_id
                                LEFT JOIN agenda e ON e.id = d.agenda_id
                                LEFT JOIN klien f ON f.id = e.klien_id
                                LEFT JOIN kasus g ON g.id = f.kasus_id    
                            WHERE 
                                e.tanggal_mulai BETWEEN ? AND ?
                                {$anda}
                                {$jabatan}
                            GROUP BY c.id, b.keyword
                            ORDER BY c.jabatan, c.name, b.keyword;", [$from, $to]);

        return collect($query);
    }
}