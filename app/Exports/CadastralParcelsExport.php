<?php

namespace App\Exports;

use App\Models\CadastralParcel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadastralParcelsExport implements FromCollection, WithHeadings {
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

        foreach ($parcels as $parcel) {
            $row = [
                $parcel->code,
                round($parcel->square_meter_surface / 10000, 4),
                round($parcel->partitions['223'] / 10000, 4),
                $parcel->municipality->name
            ];

            $collection->add($row);
        }

        return $collection;
    }

    /**
     * Set the export headings
     *
     * @return array
     */
    public function headings(): array {
        return [
            'Codice catasto',
            'Superficie (ha)',
            'Superficie Olivi (ha)',
            'Comune',
            //            'Provincia',
            //            'Regione'
        ];
    }
}
