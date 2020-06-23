<?php

namespace Botble\Vendor\Http\Requests;

class PropertyRequest extends \Botble\RealEstate\Http\Requests\PropertyRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        return parent::rules() + ['image_input' => 'mimes:jpg,jpeg,png'];
    }
}
