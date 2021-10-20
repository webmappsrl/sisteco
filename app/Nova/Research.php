<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

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
        return 'Researches';
    }

    /**
     * Get the group of the resource.
     *
     * @return string
     */
    public static function group(): string
    {
        return 'Projects';
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
                    return implode(',', $municipalities);
                } else {
                    return 'ND';
                }
            }),
            BelongsToMany::make('Cadastral parcels', 'cadastralParcels')->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function filters(Request $request)
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
    public function lenses(Request $request)
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
    public function actions(Request $request)
    {
        return [];
    }
}
