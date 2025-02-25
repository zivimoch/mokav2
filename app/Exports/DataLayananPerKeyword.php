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
        return [
            'Agregat' => new DataLayananPerKeywordSheet1(DataLayananPerKeywordSheet1::data($this->request)),
            'Breakdown' => new DataLayananPerKeywordSheet2(DataLayananPerKeywordSheet2::data($this->request))
        ];
    }
}
