<?php

namespace Botble\Installer\Http\Requests;

use Botble\Support\Http\Requests\Request;

class SaveAccountRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     */
    public function rules()
    {
        return [
            'first_name'            => 'required|max:60|min:2',
            'last_name'             => 'required|max:60|min:2',
            'username'              => 'required|min:4|max:30|unique:users',
            'email'                 => 'required|max:60|min:6|email|unique:users',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
