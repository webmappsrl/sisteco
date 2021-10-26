<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class LandUseOfCadastralParcelsPartitionMetrics extends Partition {
    private $model;

    /**
     * @return string
     */
    public function name(): string {
        return 'Copertura del suolo delle particelle catastali';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param NovaRequest $request
     *
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult {
        $cadastralParcels = $this->model->cadastralParcels;
        $partitions = [];

        foreach ($cadastralParcels as $parcel) {
            $landUses = $parcel->landUses;
            foreach ($landUses as $landUse) {
                if (!isset($partitions[$landUse->name]))
                    $partitions[$landUse->name] = 0;
                $partitions[$landUse->name] += $landUse->pivot->square_meter_surface;
            }
        }

        return $this->result($partitions);
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
        return 'land-use-of-cadastral-parcels';
    }

    /**
     * Set the metric reference model
     *
     * @param $model
     *
     * @return $this
     */
    public function model($model): LandUseOfCadastralParcelsPartitionMetrics {
        $this->model = $model;

        return $this;
    }
}
