<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ConsultRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function rules()
    {
        return [
            'name'    => 'required',
            'email'   => 'required|email',
            'content' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => trans('plugins/real-estate::consult.name.required'),
            'email.required'   => trans('plugins/real-estate::consult.email.required'),
            'email.email'      => trans('plugins/real-estate::consult.email.email'),
            'content.required' => trans('plugins/real-estate::consult.content.required'),
        ];
    }
}
