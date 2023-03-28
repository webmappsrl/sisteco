<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CatalogAreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $res = DB::select(DB::raw("SELECT ST_asgeojson('$this->geometry') as geom;"));
        $geom = json_decode($res[0]->geom,true);
        return [
            'id' => $this->id,
            'catalog_id' => $this->catalog_id,
            'catalog_type_id' => $this->catalog_type_id,
            'geometry' => $geom,
        ];
    }
}
