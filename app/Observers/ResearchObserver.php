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
        $this->updateFiltersAndParcels($research);
    }

    public function updating(Research $research)
    {
        $this->updateFiltersAndParcels($research);
    }

    private function updateFiltersAndParcels(Research $research)
    {
        $research->filters = Research::getFiltersStringFromElasticQuery($research->elastic_query);

        // UPDATE PARCELS from string (elastic query)
        $elastic = app(ElasticServiceProvider::class);
        $parcels = Research::getCadastralParcelFromElasticResult($elastic->query($research->elastic_query));
        if (count($parcels) > 0) {
            foreach ($parcels as $parcel) {
                $parcel_obj = CadastralParcel::where('code', $parcel)->first();
                if (!is_null($parcel_obj)) {
                    $research->cadastralParcels()->attach($parcel_obj->id);
                }
            }
        }
    }

}
