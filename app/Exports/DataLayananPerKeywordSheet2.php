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

class DataLayananPerKeywordSheet2 implements FromCollection, WithHeadings, WithStyles, WithTitle
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
        return 'Breakdown';
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
            'Nama Klien',
            'No Regis',
            'Detail Layanan',
            'Kategori',
            'Id Agenda',
            'Judul Kegiatan',
            'Tanggal Mulai',
            'Jam Mulai',
            'Jam Selesai',
            'Lokasi Kegiatan',
            'Deskripsi Proses',
            'Deskripsi Hasil',
            'Rencana Tindak Lanjut'
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
        $query = DB::select("SELECT
                            c.jabatan, c.`name`, f.nama, f.no_klien, b.keyword, b.jenis_agenda, e.id, e.judul_kegiatan, e.tanggal_mulai, e.jam_mulai, d.jam_selesai, d.lokasi, e.keterangan AS deskripsi_proses, d.catatan AS deskripsi_hasil, d.rtl
                            FROM 
                                t_keyword a
                                LEFT JOIN m_keyword b ON a.`value` = b.id
                                LEFT JOIN users c ON c.id = a.created_by
                                LEFT JOIN tindak_lanjut d ON d.id = a.tindak_lanjut_id
                                LEFT JOIN agenda e ON e.id = d.agenda_id
                                LEFT JOIN klien f ON f.id = e.klien_id
                            WHERE 
                                e.tanggal_mulai BETWEEN '".$from."' AND '".$to."'
                                ".$anda."
                            ORDER BY c.jabatan, c.name, e.id;");

        return collect($query);
    }
}