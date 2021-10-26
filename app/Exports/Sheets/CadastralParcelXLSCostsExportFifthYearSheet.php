<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class CadastralParcelXLSCostsExportFifthYearSheet implements FromCollection, WithTitle
{
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
        return 'Anno 5';
    }
}
