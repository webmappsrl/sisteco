<?php

namespace App\Nova;

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
        return 'Projects';
    }

    /**
     * Get the group of the resource.
     *
     * @return string
     */
    public static function group(): string {
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
    public function fields(Request $request): array {
        return [
            Text::make('Project name', 'title'),
            Text::make('Description', 'description')->onlyOnDetail(),
            BelongsTo::make('Project author', 'creator', 'App\Nova\User')->onlyOnIndex(),
            Date::make('Creation date', 'created_at')->onlyOnIndex(),
            Text::make('Owners', function (\App\Models\Project $model) {
                $names = $model->owners->pluck('first_name', 'last_name')->toArray();
                array_walk($names, function ($value, $key) {
                    return "$key $value";
                });

                return implode(', ', $names);
            })->onlyOnDetail(),
            Text::make('Municipalities')->onlyOnDetail(),
            Currency::make('Estimate (€)', function ($model) {
                return $model->estimatedValue();
            })->currency('EUR'),
            BelongsTo::make('Research', 'research', 'App\Nova\Research')->onlyOnDetail(),
            BelongsTo::make('Project author', 'creator', 'App\Nova\User')->onlyOnDetail(),
            BelongsToMany::make('Cadastral parcels', 'cadastralParcels')->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     *
     * @return array
     */
    public function cards(Request $request) {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function filters(Request $request) {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function lenses(Request $request) {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function actions(Request $request) {
        return [];
    }
}
