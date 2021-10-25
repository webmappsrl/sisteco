<?php

namespace App\Nova\Actions;

use App\Http\Controllers\CadastralParcelController;
use App\Providers\CadastralParcelsShapefile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
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
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models) {
        $service = App::make(CadastralParcelsShapefile::class);
        $response = $service->downloadResearchesShapefile($models->pluck('id')->toArray());
        Log::info($response);

        // TODO: check for response status
        return Action::message('File downloaded successfully');
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
