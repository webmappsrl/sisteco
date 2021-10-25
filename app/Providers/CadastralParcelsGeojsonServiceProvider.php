<?php

namespace App\Providers;

use App\Models\CadastralParcel;
use App\Models\Research;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class CadastralParcelsGeojsonServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void {
        $this->app->bind(CadastralParcelsGeojsonServiceProvider::class, function ($app) {
            return new CadastralParcelsGeojsonServiceProvider($app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void {
    }

    /**
     * Create a geojson file with the cadastral parcels included in the models collection
     *
     * @param Collection $models the collection of models
     *
     * @return string with the path of the generated geojson
     */
    public function createGeojsonFromModelsCollection(Collection $models): string {
        $names = [];

        $cadastralParcelsIds = [];
        foreach ($models as $model) {
            $cadastralParcelsIds = array_merge($cadastralParcelsIds, $model->cadastralParcels->pluck('id')->toArray());
            $resourceClass = str_replace('Models', 'Nova', get_class($model));
            $names[] = $model->{$resourceClass::$title ?? $resourceClass::title()};
        }

        $filename = count($names) === 1
            ? 'Export ' . $names[0]
            : 'Export ' . implode(', ', $names);
        if (strlen($filename) > 50) $filename = substr($filename, 0, 47) . ' etc';

        $cadastralParcelsIds = array_unique($cadastralParcelsIds);

        return $this->createGeojson($cadastralParcelsIds, $filename);
    }

    /**
     * Create a geojson with the specified cadastral parcels
     *
     * @param array $ids the ids of the cadastral parcels to include
     *
     * @return string with the path in the local storage of the generated geojson
     */
    public function createGeojson(array $ids, string $name): string {
        Storage::disk('public')->makeDirectory('exports/geojson');
        if (Storage::disk('public')->exists('exports/geojson/' . $name . '.geojson'))
            Storage::disk('public')->delete('exports/geojson/' . $name . '.geojson');

        $parcels = CadastralParcel::whereIn('cadastral_parcels.id', $ids)
            ->join('municipalities', 'cadastral_parcels.municipality_id', '=', 'municipalities.id')
            ->select([
                DB::raw('ST_AsGeojson(ST_ForcePolygonCW(geometry)) as geometry'),
                DB::raw('cadastral_parcels.code as code'),
                DB::raw('cadastral_parcels.square_meter_surface as square_meter_surface'),
                DB::raw('municipalities.name as municipality')
            ])->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($parcels as $parcel) {
            $geojson['features'][] = [
                'type' => 'Feature',
                'geometry' => json_decode($parcel->geometry, true),
                'properties' => [
                    'codice_catasto' => $parcel->code,
                    'area' => round($parcel->square_meter_surface / 10000, 4),
                    'comune' => $parcel->municipality
                ]
            ];
        }

        Storage::disk('public')
            ->put(
                'exports/geojson/' . $name . '.geojson',
                json_encode($geojson)
            );

        return 'exports/geojson/' . $name . '.geojson';
    }
}
