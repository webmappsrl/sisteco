<?php

namespace App\Observers;

use App\Models\CadastralParcel;
use App\Models\Research;
use App\Providers\ElasticServiceProvider;
use Illuminate\Support\Facades\Log;

class ResearchObserver
{

    public function created(Research $research)
    {
        $this->setParcels($research);
        $this->setSurface($research);
    }

    public function updating(Research $research)
    {
        $this->setParcels($research);
        $this->setSurface($research);
    }

    private function setParcels(Research $research)
    {

        // UPDATE PARCELS from string (elastic query)
        $elastic = app(ElasticServiceProvider::class);
        $parcels = Research::getCadastralParcelFromElasticResult($elastic->query($research->elastic_query));
        if (count($parcels) > 0) {
            $research->cadastralParcels()->detach();
            foreach ($parcels as $parcel) {
                $parcel_obj = CadastralParcel::where('code', $parcel)->first();
                if (!is_null($parcel_obj)) {
                    $research->cadastralParcels()->attach($parcel_obj->id);
                }
            }
        }
    }

    private function setSurface(Research $research)
    {
        Log::info('Observer - setSurface');
        if (!is_null($research->elastic_query)) {
            $elastic = app(ElasticServiceProvider::class);
            $surface = Research::getPartitionTotalSurfaceFromElasticResult($elastic->query($research->elastic_query));
            Log::info('Surface (m**2) =' . $surface);
            $research->square_meter_surface = $surface;
            Log::info("Surface on object: {$research->square_meter_surface}");
        }
    }

}
