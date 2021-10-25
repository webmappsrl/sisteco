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
     * Download a shapefile with the cadastral parcels included in the researches
     *
     * @param array $ids the researches ids
     */
    public function downloadResearchesShapefile(array $ids) {
        Log::info($ids);
        $shapefileUri = $this->createFromResearches($ids);
        Log::info($shapefileUri);
    }

    /**
     * Create a shapefile with the cadastral parcels included in the research
     *
     * @param array $ids the researches ids
     *
     * @return string with the path in the local storage of the generated shapefile
     */
    public function createFromResearches(array $ids): string {
        $models = Research::whereIn('id', $ids)->get();
        $name = 'test';
        $ids = [];
        foreach ($models as $model) {
            array_merge($ids, $model->cadastralParcels->pluck('id')->toArray());
        }

        $ids = array_unique($ids);
        //        Storage::disk('public')->makeDirectory('shape_files/zip');
        //        chdir(Storage::disk('public')->path('shape_files'));
        //        if (Storage::disk('public')->exists('shape_files/zip/' . $name . '.zip'))
        //            Storage::disk('public')->delete('shape_files/zip/' . $name . '.zip');
        //
        //        $command = 'ogr2ogr -f "ESRI Shapefile" ' .
        //            $name .
        //            '.shp PG:"dbname=\'' .
        //            config('database.connections.' . config('database.default') . '.database') .
        //            '\' host=\'' .
        //            config('database.connections.' . config('database.default') . '.host') .
        //            '\' port=\'' .
        //            config('database.connections.' . config('database.default') . '.port') .
        //            '\' user=\'' .
        //            config('database.connections.' . config('database.default') . '.username') .
        //            '\' password=\'' .
        //            config('database.connections.' . config('database.default') . '.password') .
        //            '\'" -sql "SELECT geometry, id, name FROM cadastral_parcels WHERE id IN (' .
        //            implode(',', $ids) .
        //            ');"';
        //        exec($command);
        //
        //        $command = 'zip ' . $name . '.zip ' . $name . '.*';
        //        exec($command);
        //
        //        $command = 'mv ' . $name . '.zip zip/';
        //        exec($command);
        //
        //        $command = 'rm ' . $name . '.*';
        //        exec($command);

        return 'shape_files/zip/' . $name . '.zip';
    }
}
