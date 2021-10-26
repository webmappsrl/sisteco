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
    public function sheets(): array
    {
        return [
            new CadastralParcelXLSCostsExportResumeSheet(),
            new CadastralParcelXLSCostsExportFirstYearSheet(),
            new CadastralParcelXLSCostsExportSecondYearSheet(),
            new CadastralParcelXLSCostsExportThirdYearSheet(),
            new CadastralParcelXLSCostsExportFourthYearSheet(),
            new CadastralParcelXLSCostsExportFifthYearSheet(),
        ];
    }
}
