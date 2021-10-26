<?php

namespace App\Nova\Actions;

use App\Exports\CadastralParcelXLSCostsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Facades\Excel;

class CadastralParcelDownloadXLSCosts extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'XLS';

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        foreach ($models as $model) {
            $filename = 'SISTECO_' . date('Ymd') . '_dettaglio_interventi_' . $model->code . '.xlsx';
            $publicPath = "exports/excel/$filename";
            Excel::store(new CadastralParcelXLSCostsExport($model->id), $publicPath, 'public');
            return Action::download(Storage::disk('public')->url($publicPath), "$filename");
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
