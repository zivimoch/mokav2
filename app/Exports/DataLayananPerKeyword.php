<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataLayananPerKeyword implements WithMultipleSheets
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        // 1 file 2 sheet
        if ($this->request->breakdown) {
            return [
                'Breakdown' => new DataLayananPerKeywordSheet2(DataLayananPerKeywordSheet2::data($this->request))
            ];
        } else {
            return [
                'Agregat' => new DataLayananPerKeywordSheet1(DataLayananPerKeywordSheet1::data($this->request)),
            ];
        }
    }
}
