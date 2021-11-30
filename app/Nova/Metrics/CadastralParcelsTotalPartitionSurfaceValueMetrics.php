<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class CadastralParcelsTotalPartitionSurfaceValueMetrics extends Value
{
    private $model;

    public function name(): string
    {
        return 'Superficie totale delle partizioni di particelle coinvolte nella ricerca';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {

        return $this->result(round($this->model->square_meter_surface / 10000, 4))
            ->format("0[.]0000")
            ->suffix('ha')
            ->withoutSuffixInflection();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'cadastral-parcels-total-partition-surface-value-metrics';
    }

    /**
     * Set the metric reference model
     *
     * @param $model
     *
     * @return $this
     */
    public function model($model): CadastralParcelsTotalPartitionSurfaceValueMetrics
    {
        $this->model = $model;

        return $this;
    }

}
