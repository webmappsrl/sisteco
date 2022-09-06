<?php

namespace App\Imports;

use App\Models\Price;
use Maatwebsite\Excel\Concerns\ToModel;

class PricesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }
        
        return new Price([
            'code' => $row[0],
            'action' => $row[1],
            'ucs' => $row[2],
            'slope' => $row[3],
            'way' => $row[4],
            'price' => preg_replace('|,|','',$row[5]),
            'type' => $row[6],
            'description' => !empty($row[7])?$row[7]:'ND',
        ]);
    }
}
