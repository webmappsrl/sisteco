<?php

namespace App\Exports\Sheets;

use App\Models\CadastralParcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CadastralParcelXLSCostsExportResumeSheet implements FromCollection, WithTitle
{
    private $parcel_id;

    public function __construct($parcel_id)
    {
        $this->parcel_id = $parcel_id;
    }

    public function collection()
    {
        $parcel = CadastralParcel::find($this->parcel_id);
        $c = new Collection();
        $row = ['Codice Particella', $parcel->code];
        $c->add($row);
        $row = ['Proprietari', '?'];
        $c->add($row);
        $row = ['Data Elaborazione', date('d/m/Y')];
        $c->add($row);
        $c->merge($parcel->getGlobalCosts());
        return $parcel->getGlobalCosts();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Riassuntivo';
    }
}
