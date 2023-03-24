<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CadastralParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'municipality' => $this->municipality->name,
            'estimated_value' => $this->estimated_value,
            'average_slope' => $this->average_slope,
            'meter_min_distance_road' => $this->meter_min_distance_road,
            'meter_min_distance_path' => $this->meter_min_distance_path,
            'square_meter_surface' => $this->square_meter_surface,
            'slope' => $this->slope,
            'way' => $this->way,
            'catalog_estimate' => $this->catalog_estimate,
            'geometry' => $this->geometry,
        ];
    }
}
