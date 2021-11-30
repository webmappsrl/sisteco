<?php

namespace App\Nova;

use App\Nova\Actions\DownloadCadastralParcelsCsv;
use App\Nova\Actions\DownloadCadastralParcelsExcel;
use App\Nova\Actions\DownloadCadastralParcelsGeojson;
use App\Nova\Actions\DownloadCadastralParcelsShapefile;
use App\Nova\Metrics\CadastralParcelsTotalPartitionSurfaceValueMetrics;
use App\Nova\Metrics\CadastralParcelsTotalSurfaceValueMetrics;
use App\Nova\Metrics\LandUseOfCadastralParcelsPartitionMetrics;
use App\Nova\Metrics\NumberOfCadastralParcelsValueMetrics;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Research extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Research::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Ricerche';
    }

    /**
     * Get the group of the resource.
     *
     * @return string
     */
    public static function group(): string
    {
        return 'Progetti';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            Text::make('Titolo', 'title'),
            Textarea::make('Descrizione', 'description')->hideFromIndex()->alwaysShow(),
            Textarea::make('Elastic Query', 'elastic_query')->hideFromIndex(),
            Text::make('Filtri attivi', function ($model) {
                return \App\Models\Research::getFiltersStringFromElasticQuery($model->elastic_query);
            })->showOnIndex()->showOnDetail()->hideWhenCreating()->hideWhenUpdating(),
            Number::make('Numero di particelle catastali', function ($model) {
                return count($model->cadastralParcels);
            }),
            Text::make('Comuni', function ($model) {
                if ($model->cadastralParcels->count() > 0) {
                    $municipalities = [];
                    foreach ($model->cadastralParcels as $parcel) {
                        if ($parcel->municipality) {
                            $municipalities[] = $parcel->municipality->name;
                        }
                    }
                    $municipalities = array_unique($municipalities);

                    return implode(', ', $municipalities);
                } else {
                    return 'ND';
                }
            }),
            BelongsToMany::make('Particelle catastali', 'cadastralParcels', 'App\Nova\CadastralParcel')->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function cards(Request $request): array
    {
        $cards = [];

        if (isset($request->resourceId)) {
            $model = \App\Models\Research::find($request->resourceId);
            $cards = [
                (new NumberOfCadastralParcelsValueMetrics)->model($model)->onlyOnDetail(),
                (new CadastralParcelsTotalSurfaceValueMetrics)->model($model)->onlyOnDetail(),
                (new CadastralParcelsTotalPartitionSurfaceValueMetrics())->model($model)->onlyOnDetail(),
                // (new LandUseOfCadastralParcelsPartitionMetrics)->model($model)->onlyOnDetail()
            ];
        }

        return $cards;
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            new DownloadCadastralParcelsShapefile,
            new DownloadCadastralParcelsExcel,
            new DownloadCadastralParcelsGeojson,
            new DownloadCadastralParcelsCsv
        ];
    }
}
