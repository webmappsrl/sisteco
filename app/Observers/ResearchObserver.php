<?php

namespace App\Observers;

use App\Models\Research;

class ResearchObserver
{
    public function creating(Research $research)
    {
        $research->filters = Research::getFiltersStringFromElasticQuery($research->elastic_query);
    }

    public function updating(Research $research)
    {
        $research->filters = Research::getFiltersStringFromElasticQuery($research->elastic_query);
    }

}
