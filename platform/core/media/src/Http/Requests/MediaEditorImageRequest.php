<?php

namespace Botble\Media\Http\Requests;

use Botble\Support\Http\Requests\Request;

class MediaEditorImageRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'upload' => 'required|mimes:' . config('core.media.media.allowed_mime_types'),
        ];
    }

}
