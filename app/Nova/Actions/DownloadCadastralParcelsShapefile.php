<?php

namespace App\Nova\Actions;

use App\Providers\CadastralParcelsShapefile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DownloadCadastralParcelsShapefile extends Action {
    use InteractsWithQueue, Queueable;

    /**
     * Define the action name
     *
     * @return string
     */
    public function name(): string {
        return 'Esporta shapefile (.zip) delle particelle catastali';
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection   $models
     *
     * @return array|string[]
     */
    public function handle(ActionFields $fields, Collection $models): array {
        $service = App::make(CadastralParcelsShapefile::class);
        $names = [];

        $cadastralParcelsIds = [];
        foreach ($models as $model) {
            $cadastralParcelsIds = array_merge($cadastralParcelsIds, $model->cadastralParcels->pluck('id')->toArray());
            $resourceClass = str_replace('Models', 'Nova', get_class($model));
            $names[] = $model->{$resourceClass::$title ?? $resourceClass::title()};
        }

        $filename = count($names) === 1
            ? 'Export ' . $names[0]
            : 'Export ' . implode(', ', $names);
        if (strlen($filename) > 50) $filename = substr($filename, 0, 47) . ' etc';

        $cadastralParcelsIds = array_unique($cadastralParcelsIds);

        $shapefilePath = $service->createShapefile($cadastralParcelsIds, $filename);

        $filename = explode('/', $shapefilePath);
        $filename = end($filename);

        return Action::download(Storage::disk('public')->url($shapefilePath), $filename);
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
