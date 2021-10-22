<?php

namespace App\Nova\Metrics;

use App\Models\Project;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ProjectLandUsePartitionMetrics extends Partition {
    public function name(): string {
        return 'Copertura del suolo coinvolta nei progetti';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request) {
        return $this->count($request, Project::class, 'title');
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor() {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey() {
        return 'project-land-use-partition-metrics';
    }
}
