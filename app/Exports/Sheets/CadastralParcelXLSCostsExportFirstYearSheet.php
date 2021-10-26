<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CadastralParcelXLSCostsExportFirstYearSheet implements FromCollection, WithTitle
{
    private $parcel_id;

    public function __construct($parcel_id)
    {
        $this->parcel_id = $parcel_id;
    }

    public function collection()
    {
        $c = new Collection();
        $c->add([1, 2, 3]);
        $c->add([1, 2, 3]);
        return $c;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Anno 1';
    }
}
