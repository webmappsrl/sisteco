<?php

namespace App\Exports;

use App\Exports\Sheets\CadastralParcelXLSCostsExportFifthYearSheet;
use App\Exports\Sheets\CadastralParcelXLSCostsExportFirstYearSheet;
use App\Exports\Sheets\CadastralParcelXLSCostsExportFourthYearSheet;
use App\Exports\Sheets\CadastralParcelXLSCostsExportResumeSheet;
use App\Exports\Sheets\CadastralParcelXLSCostsExportSecondYearSheet;
use App\Exports\Sheets\CadastralParcelXLSCostsExportThirdYearSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CadastralParcelXLSCostsExport implements WithMultipleSheets
{
    private $parcel_id;

    public function __construct($parcel_id)
    {
        $this->parcel_id = $parcel_id;
    }

    public function sheets(): array
    {
        return [
            new CadastralParcelXLSCostsExportResumeSheet($this->parcel_id),
            new CadastralParcelXLSCostsExportFirstYearSheet($this->parcel_id),
            new CadastralParcelXLSCostsExportSecondYearSheet($this->parcel_id),
            new CadastralParcelXLSCostsExportThirdYearSheet($this->parcel_id),
            new CadastralParcelXLSCostsExportFourthYearSheet($this->parcel_id),
            new CadastralParcelXLSCostsExportFifthYearSheet($this->parcel_id),
        ];
    }
}
