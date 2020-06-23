<?php

namespace Botble\Vendor\Http\Resources;

use Botble\Vendor\Models\Vendor;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Vendor
 */
class VendorResource extends JsonResource
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
            'id'                      => $this->id,
            'name'                    => $this->getFullName(),
            'first_name'              => $this->first_name,
            'last_name'               => $this->last_name,
            'email'                   => $this->email,
            'phone'                   => $this->phone,
            'avatar'                  => $this->avatar_url,
            'dob'                     => $this->dob,
            'gender'                  => $this->gender,
            'description'             => $this->description,
            'package'                 => new PackageResource($this->package),
            'package_id'              => $this->package_id,
            'package_start_date'      => $this->package_start_date,
            'package_end_date'        => $this->package_end_date,
            'package_available_quota' => $this->package_available_quota,
        ];
    }
}
