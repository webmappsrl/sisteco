<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CadastralParcelXLSCostsExport implements FromCollection
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $c = new Collection();
        $c->add([1, 2, 3]);
        $c->add([1, 2, 3]);
        return $c;
    }
}
