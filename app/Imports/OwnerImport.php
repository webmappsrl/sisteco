<?php

namespace App\Imports;

use App\Models\Owner;
use Maatwebsite\Excel\Concerns\ToModel;

class OwnerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Owner([
            'first_name ' => $row[0],
            'last_name' => $row[1],
            'email' => $row[2],
        ]);
    }
}
