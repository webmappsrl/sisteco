<?php

namespace App\Providers;

use App\Models\Research;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class CadastralParcelsShapefile extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void {
        $this->app->bind(CadastralParcelsShapefile::class, function ($app) {
            return new CadastralParcelsShapefile($app);
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
     * Create a shapefile with the cadastral parcels included in the researches
     *
     * @param array $ids the researches ids
     *
     * @return string with the path of the generated shapefile
     */
    public function createResearchesShapefile(array $ids): string {
        $models = Research::whereIn('id', $ids)->get();
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

        return $this->createShapefile($cadastralParcelsIds, $filename);
    }

    /**
     * Create a shapefile with the specified cadastral parcels
     *
     * @param array $ids the ids of the cadastral parcels to include
     *
     * @return string with the path in the local storage of the generated shapefile
     */
    public function createShapefile(array $ids, string $name): string {
        Storage::disk('public')->makeDirectory('exports/shape_files/zip');
        chdir(Storage::disk('public')->path('exports/shape_files'));
        if (Storage::disk('public')->exists('exports/shape_files/zip/' . $name . '.zip'))
            Storage::disk('public')->delete('exports/shape_files/zip/' . $name . '.zip');

        $query = "SELECT
                cadastral_parcels.geometry,
                cadastral_parcels.id,
                cadastral_parcels.code,
                cadastral_parcels.square_meter_surface / 1000 as ha_surface,
                municipalities.name as comune
            FROM cadastral_parcels
                INNER JOIN municipalities
                    ON cadastral_parcels.municipality_id = municipalities.id
            WHERE cadastral_parcels.id IN (" .
            implode(',', $ids) .
            ");";
        $command = 'ogr2ogr -f "ESRI Shapefile" "' .
            $name .
            '.shp" PG:"dbname=\'' .
            config('database.connections.' . config('database.default') . '.database') .
            '\' host=\'' .
            config('database.connections.' . config('database.default') . '.host') .
            '\' port=\'' .
            config('database.connections.' . config('database.default') . '.port') .
            '\' user=\'' .
            config('database.connections.' . config('database.default') . '.username') .
            '\' password=\'' .
            config('database.connections.' . config('database.default') . '.password') .
            '\'" -sql "' . $query . '"';
        exec($command);

        $command = 'zip "' . $name . '.zip" "' . $name . '."*';
        exec($command);

        $command = 'mv "' . $name . '.zip" zip/';
        exec($command);

        $command = 'rm "' . $name . '."*';
        exec($command);

        return 'exports/shape_files/zip/' . $name . '.zip';
    }
}
