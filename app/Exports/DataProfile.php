<?php

namespace App\Exports;

use App\Http\Controllers\MonitoringController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataProfile implements FromCollection, WithHeadings, WithStyles
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
            'Tahun',
            'Jumlah'
        ];
    }

    public static function data($request)
    {
        // initial init
        // basis tanggal dan periode tanggal tergantung inputan
        $request->merge(['pengelompokan' => 'perbulan']);
        $request->merge(['basis_wilayah' => 'default']);
        $request->merge(['wilayah' => 'default']);
        $request->merge(['penghitungan_usia' => 'lapor']);
        $request->merge(['regis' => 1]);
        $request->merge(['arsip' => 0]);
        $request->merge(['rekaptotal' => null]);
        // $data = [];

        // $monitoringController = new MonitoringController(); // Create an instance
        // $data = $monitoringController->jumlah_korban($request);
        $data = [];
        

        return $data;
    }
}