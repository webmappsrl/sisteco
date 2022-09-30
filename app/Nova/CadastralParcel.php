<?php

namespace App\Nova;

use App\Nova\Actions\CadastralParcelDownloadXLSCosts;
use App\Nova\Actions\CreateProjectFromParcelsAction;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Wm\MapMultiPolygonNova3\MapMultiPolygonNova3;

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
        return 'Particelle catastali';
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
                return round($model->estimated_value, 2);
            }),
            Text::make('Pendenza media (º)', 'average_slope', function (string $slope) {
                return str_replace('.', ',', round($slope, 2));
            })->onlyOnDetail(),
            Text::make('Classe Pendenza','slope')->onlyOnDetail(),
            Text::make('Distanza minima sentiero (m)', 'meter_min_distance_path', function (string $distance) {
                return intval($distance) . ' m';
            })->onlyOnDetail(),
            Text::make('Distanza minima strada (m)', 'meter_min_distance_road', function (string $distance) {
                return intval($distance) . ' m';
            })->onlyOnDetail(),
            Text::make('Classe Trasporto','way')->onlyOnDetail(),
            Text::make('Area (ettari)', 'square_meter_surface', function (string $surface) {
                return str_replace('.', ',', round($surface / 10000, 4)) . ' ha';
            })->sortable(),
            Text::make('Dettaglio Stima',function(){
                if(empty($this->estimate_detail)) {
                    return 'ND';
                }
                $o="<table>";

                $o.="<tr>";
                $o.="<th>ID</th>";
                $o.="<th>Code</th>";
                $o.="<th>Action</th>";
                $o.="<th>UCS</th>";
                $o.="<th>Unit Price</th>";
                $o.="<th>Surface</th>";
                $o.="<th>Price</th>";
                $o.="</tr>";

                foreach(json_decode($this->estimate_detail) as $id=>$item) {
                    $o.="<tr>";
                    $o.="<td>$id</td>";
                    $o.="<td>{$item[0]}</td>";
                    $o.="<td>{$item[1]}</td>";
                    $o.="<td>{$item[2]}</td>";
                    $o.="<td>{$item[3]}</td>";
                    $o.="<td>{$item[4]}</td>";
                    $o.="<td>{$item[5]}</td>";
                    $o.="</tr>";    
                }

                $o.="</table>";
                return $o;
            }
            )->asHtml()->onlyOnDetail(),
            MapMultiPolygonNova3::make('geometry')->withMeta([
                'center' => ['42.795977075', '10.326813853'],
                'attribution' => '<a href="https://webmapp.it/">Webmapp</a> contributors',
            ]),
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
            (new CadastralParcelDownloadXLSCosts())
                ->canRun(function ($request) {
                    return true;
                })
                ->onlyOnTableRow()
                ->withoutConfirmation(),
        ];
    }
}
