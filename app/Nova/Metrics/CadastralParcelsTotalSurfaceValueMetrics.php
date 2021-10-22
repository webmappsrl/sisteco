<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class CadastralParcelsTotalSurfaceValueMetrics extends Value {
    private $model;

    public function name(): string {
        return 'Superficie totale delle particelle catastali';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult {
        $totalSurface = array_sum($this->model->cadastralParcels->pluck('square_meter_surface')->toArray());

        return $this->result(round($totalSurface / 10000, 4))->suffix('ha');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array {
        return [];
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
    public function uriKey(): string {
        return 'cadastral-parcels-total-surface';
    }

    /**
     * Set the metric reference model
     *
     * @param $model
     *
     * @return $this
     */
    public function model($model): CadastralParcelsTotalSurfaceValueMetrics {
        $this->model = $model;

        return $this;
    }
}
