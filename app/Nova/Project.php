<?php

namespace App\Nova;

use App\Nova\Actions\DownloadCadastralParcelsExcel;
use App\Nova\Actions\DownloadCadastralParcelsGeojson;
use App\Nova\Actions\DownloadCadastralParcelsShapefile;
use App\Nova\Metrics\CadastralParcelsTotalSurfaceValueMetrics;
use App\Nova\Metrics\LandUseOfCadastralParcelsPartitionMetrics;
use App\Nova\Metrics\NumberOfCadastralParcelsValueMetrics;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;

class Project extends Resource {
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Project::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string {
        return 'Progetti';
    }

    /**
     * Get the group of the resource.
     *
     * @return string
     */
    public static function group(): string {
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
    public function fields(Request $request): array {
        return [
            Text::make('Nome progetto', 'title'),
            Text::make('Descrizione', 'description')->onlyOnDetail(),
            BelongsTo::make('Autori progetto', 'creator', 'App\Nova\User')->onlyOnIndex(),
            Date::make('Data creatione', 'created_at')->onlyOnIndex(),
            Text::make('Proprietari', function (\App\Models\Project $model) {
                return '';
                //                $names = $model->owners->pluck('first_name', 'last_name')->toArray();
                //                array_walk($names, function ($value, $key) {
                //                    return "$key $value";
                //                });
                //
                //                return implode(', ', $names);
            })->onlyOnDetail(),
            Text::make('Comuni')->onlyOnDetail(),
            Currency::make('Stima (€)', function ($model) {
                return $model->estimatedValue();
            })->currency('EUR'),
            BelongsTo::make('Ricerca', 'research', 'App\Nova\Research')->onlyOnDetail(),
            BelongsTo::make('Autori progetto', 'creator', 'App\Nova\User')->onlyOnDetail(),
            BelongsToMany::make('Particelle catastali', 'cadastralParcels', 'App\Nova\CadastralParcel')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function cards(Request $request): array {
        $cards = [];

        if (isset($request->resourceId)) {
            $model = \App\Models\Project::find($request->resourceId);
            $cards = [
                (new NumberOfCadastralParcelsValueMetrics)->model($model)->onlyOnDetail(),
                (new CadastralParcelsTotalSurfaceValueMetrics)->model($model)->onlyOnDetail(),
                (new LandUseOfCadastralParcelsPartitionMetrics)->model($model)->onlyOnDetail()
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
    public function filters(Request $request): array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function lenses(Request $request): array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function actions(Request $request): array {
        return [
            new DownloadCadastralParcelsShapefile,
            new DownloadCadastralParcelsExcel,
            new DownloadCadastralParcelsGeojson
        ];
    }
}
