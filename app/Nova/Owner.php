<?php

namespace App\Nova;

use App\Nova\Metrics\CadastralParcelsTotalSurfaceValueMetrics;
use App\Nova\Metrics\LandUseOfCadastralParcelsPartitionMetrics;
use App\Nova\Metrics\NumberOfCadastralParcelsValueMetrics;
use Illuminate\Http\Request;
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
        return 'Proprietari';
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
            Text::make('Nome', 'first_name')
                ->onlyOnIndex(),
            Text::make('Cognome', 'last_name')
                ->onlyOnIndex(),
            Text::make('Email', 'email')
                ->onlyOnIndex(),
            Text::make('Telefono', 'phone')
                ->onlyOnIndex(),
            Text::make('Codice fiscale', 'fiscal_code')
                ->onlyOnIndex(),
            Panel::make('Dati anagrafici', [
                Text::make('Nome', 'first_name')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Cognome', 'last_name')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Email', 'email')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Codice fiscale', 'fiscal_code')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Partita IVA', 'vat_number')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Indirizzo', function (\App\Models\Owner $model) {
                    return $model["addr:street"] . " " .
                        $model["addr:housenumber"] . ", " .
                        $model["addr:city"] . " " .
                        $model["addr:postcode"] . " (" .
                        strtoupper($model["addr:province"]) . "), " .
                        $model["addr:locality"];
                })
                    ->onlyOnDetail(),
                Text::make('Telefono', 'phone')
                    ->required()
                    ->hideFromIndex(),
                Text::make('Nome azienda', 'business_name')
                    ->onlyOnForms(),
                Text::make('Via', 'addr:street')
                    ->onlyOnForms(),
                Text::make('Numero civico', 'addr:housenumber')
                    ->onlyOnForms(),
                Text::make('Città', 'addr:city')
                    ->onlyOnForms(),
                Text::make('Codice postale', 'addr:postcode')
                    ->onlyOnForms(),
                Text::make('Provincia', 'addr:province')
                    ->onlyOnForms(),
                Text::make('Località', 'addr:locality')
                    ->onlyOnForms()
            ]),
            BelongsToMany::make('Particelle catastali', 'cadastralParcels', 'App\Nova\CadastralParcel')
                ->onlyOnDetail()
                ->searchable(),
            //            BelongsToMany::make('Progetti', 'projects', 'App\Nova\Project')
            //                ->onlyOnDetail()
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
            $model = \App\Models\Owner::find($request->resourceId);
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
