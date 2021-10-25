<?php

namespace App\Nova\Actions;

use App\Exports\CadastralParcelsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Facades\Excel;

class DownloadCadastralParcelsExcel extends Action {
    use InteractsWithQueue, Queueable;

    /**
     * Define the action name
     *
     * @return string
     */
    public function name(): string {
        return 'Esporta excel (.xlsx) delle particelle catastali';
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection   $models
     *
     * @return array
     */
    public function handle(ActionFields $fields, Collection $models): array {
        $ids = [];
        $names = [];
        foreach ($models as $model) {
            $ids = array_merge($ids, $model->cadastralParcels->pluck('id')->toArray());
            $resourceClass = str_replace('Models', 'Nova', get_class($model));
            $names[] = $model->{$resourceClass::$title ?? $resourceClass::title()};
        }

        $ids = array_unique($ids);
        $filename = count($names) === 1
            ? 'Export ' . $names[0]
            : 'Export ' . implode(', ', $names);

        $publicPath = "exports/excel/$filename.xlsx";
        Excel::store(new CadastralParcelsExport($ids), $publicPath, 'public');

        return Action::download(Storage::disk('public')->url($publicPath), "$filename.xlsx");
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(): array {
        return [];
    }
}
