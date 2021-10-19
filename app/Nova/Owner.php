<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;

/**
 * @property string $first_name
 * @property string $last_name
 */
class Owner extends Resource {
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Owner::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string {
        return 'Owners';
    }

    /**
     * Get the group of the resource.
     *
     * @return string
     */
    public static function group(): string {
        return 'CRM';
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     *
     * @return string
     */
    public function title(): string {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name',
        'last_name',
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
            Text::make('Name', 'first_name')->onlyOnIndex(),
            Text::make('Surname', 'last_name')->onlyOnIndex(),
            Text::make('Email', 'email')->onlyOnIndex(),
            Text::make('Phone', 'phone')->onlyOnIndex(),
            Text::make('Fiscal code', 'fiscal_code')->onlyOnIndex(),
            Panel::make('Personal details', [
                Text::make('Name', 'first_name')->onlyOnDetail(),
                Text::make('Surname', 'last_name')->onlyOnDetail(),
                Text::make('Email', 'email')->onlyOnDetail(),
                Text::make('Fiscal code', 'fiscal_code')->onlyOnDetail(),
                Text::make('Vat number', 'vat_number')->onlyOnDetail(),
                Text::make('Address', function (\App\Models\Owner $model) {
                    return $model["addr:street"] . " " .
                        $model["addr:housenumber"] . ", " .
                        $model["addr:city"] . " " .
                        $model["addr:postcode"] . " (" .
                        strtoupper($model["addr:province"]) . "), " .
                        $model["addr:locality"];
                })->onlyOnDetail(),
                Text::make('Phone', 'phone')->onlyOnDetail(),
            ]),
            BelongsToMany::make('Cadastral parcels', 'cadastralParcels')->onlyOnDetail(),
            BelongsToMany::make('Projects', 'projects')->onlyOnDetail()
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
