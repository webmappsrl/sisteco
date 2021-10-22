<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class NumberOfCadastralParcels extends Value {
    private $model;

    public function name(): string {
        return 'Numero di particelle catastali';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request) {
        return $this->result(count($this->model->cadastralParcels));
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
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey() {
        return 'number-of-cadastral-parcels';
    }

    /**
     * Set the metric model
     *
     * @param $model
     *
     * @return $this
     */
    public function model($model): NumberOfCadastralParcels {
        $this->model = $model;

        return $this;
    }
}
