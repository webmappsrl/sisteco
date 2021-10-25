<?php

namespace App\Exports;

use App\Models\CadastralParcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CadastralParcelsExport implements FromCollection {
    protected $ids;

    public function __construct(array $ids) {
        $this->ids = $ids;
    }

    /**
     * Return a collection with the selected cadastral parcels
     *
     * @return Collection
     */
    public function collection(): Collection {
        $parcels = CadastralParcel::whereIn('id', $this->ids)->get();
        $collection = new Collection();

        $collection->add([
            'Codice catasto',
            'Superficie (ha)',
            'Comune',
            'Provincia',
            'Regione'
        ]);

        foreach ($parcels as $parcel) {
            $row = [
                $parcel->code,
                round($parcel->square_meter_surface / 10000, 4)
            ];

            $collection->add($row);
        }

        return $collection;
    }
}
