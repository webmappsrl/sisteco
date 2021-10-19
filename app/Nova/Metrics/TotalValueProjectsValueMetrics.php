<?php

namespace App\Nova\Metrics;

use App\Models\Project;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class TotalValueProjectsValueMetrics extends Value {
    public function name(): string {
        return 'Valore complessivo Progetti';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult {
        $projects = Project::all()->map(function ($value) {
            return $value->estimatedValue();
        })->toArray();

        return $this->result(array_sum($projects))
            ->format("0[.]00")
            ->currency('€');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array {
        return [
            //            30 => __('30 Days'),
            //            60 => __('60 Days'),
            //            365 => __('365 Days'),
            //            'TODAY' => __('Today'),
            //            'MTD' => __('Month To Date'),
            //            'QTD' => __('Quarter To Date'),
            //            'YTD' => __('Year To Date'),
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
        return 'total-value-projects-value-metrics';
    }
}
