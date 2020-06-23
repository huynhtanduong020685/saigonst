<?php

namespace Botble\Vendor\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'price'              => $this->price,
            'number_of_days'     => $this->number_of_days,
            'number_of_listings' => $this->number_of_listings,
        ];
    }
}
