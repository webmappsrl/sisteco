<?php

namespace App\Nova;

use App\Models\Municipality;
use App\Nova\Actions\CreateProjectFromParcelsAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;

class CadastralParcel extends Resource {
    public static $perPageViaRelationship = 20;
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
            Text::make(__('Codice catastale'), 'code')->sortable(),
            Text::make('Comune', function ($model) {
                if ($model->municipality) {
                    return $model->municipality->name;
                } else {
                    return '-';
                }
            }),
            Text::make('Proprietari', function ($parcel) {
                if ($parcel->owners->count() > 0) {
                    $owners = [];
                    foreach ($parcel->owners as $owner) {
                        if ($owner->last_name) {
                            $owners[] = $owner->last_name;
                        }
                    }
                    if (count($owners) > 0) {
                        return implode(',', $owners);
                    } else {
                        return '-';
                    }
                }
            }),
            Currency::make('Stima', function ($model) {
                return $model->estimated_value;
            })->currency('EUR'),
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
        return [
            (new CreateProjectFromParcelsAction())
                ->canRun(function ($request) {
                    return true;
                })
                ->onlyOnIndex(),
        ];
    }
}
