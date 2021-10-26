<?php

namespace App\Exports\Sheets;

use App\Models\CadastralParcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CadastralParcelXLSCostsExportSecondYearSheet implements FromCollection, WithTitle
{
    private $parcel_id;

    public function __construct($parcel_id)
    {
        $this->parcel_id = $parcel_id;
    }

    public function collection()
    {
        $p = CadastralParcel::find($this->parcel_id);
        return $p->getCostsByYear(2);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Anno 2';
    }
}
