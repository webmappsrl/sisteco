<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * 
     *    {
      "first_name": "Gian Paolo",
      "last_name": "Adami",
      "email": "ND",
      "business_name": "ND",
      "vat_number": "ND",
      "fiscal_code": "DMAGPL31M04G702Z",
      "phone": "ND",
      "addr:street": "ND",
      "addr:housenumber": "ND",
      "addr:city": "ND",
      "addr:postcode": "ND",
      "addr:province": "ND",
      "addr:locality": "ND"
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'business_name' => $this->business_name,
            'vat_number' => $this->vat_number,
            'fiscal_code' => $this->fiscal_code,
            'phone' => $this->phone,
            'addr:street' => $this->{'addr:street'},
            'addr:housenumber' => $this->{'addr:housenumber'},
            'addr:city' => $this->{'addr:city'},
            'addr:postcode' => $this->{'addr:postcode'},
            'addr:province' => $this->{'addr:province'},
            'addr:locality' => $this->{'addr:locality'},
            'cadastral_parcels' => $this->cadastralParcels()->pluck('cadastral_parcel_id')->toArray(),
        ];
    }
}
