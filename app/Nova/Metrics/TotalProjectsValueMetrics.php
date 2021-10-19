<?php

namespace App\Nova\Metrics;

use App\Models\Project;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class TotalProjectsValueMetrics extends Value {
    public function name(): string {
        return 'Totale Progetti';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult {
        return $this->result(Project::count());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array {
        return [
            //            'ALL' => __('All time'),
        ];
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
        return 'total-projects-value-metrics';
    }
}
