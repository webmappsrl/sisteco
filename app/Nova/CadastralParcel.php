<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class CadastralParcel extends Resource {
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CadastralParcel::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string {
        return 'Cadastral parcels';
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
     * @var string
     */
    public static $title = 'code';
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
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
            Text::make(__('Cadastral code'), 'code')->sortable(),
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
