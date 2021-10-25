<?php

namespace App\Nova\Actions;

use App\Providers\CadastralParcelsGeojsonServiceProvider;
use App\Providers\CadastralParcelsShapefileServiceProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class DownloadCadastralParcelsGeojson extends Action {
    use InteractsWithQueue, Queueable;

    /**
     * Define the action name
     *
     * @return string
     */
    public function name(): string {
        return 'Esporta geojson (.geojson) delle particelle catastali';
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
        $service = App::make(CadastralParcelsGeojsonServiceProvider::class);
        $geojsonPath = $service->createGeojsonFromModelsCollection($models);

        $filename = explode('/', $geojsonPath);
        $filename = end($filename);

        return Action::download(Storage::disk('public')->url($geojsonPath), $filename);
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
