<?php

namespace Botble\Payment\Http\Requests;

use Botble\Support\Http\Requests\Request;

class AfterMakePaymentRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'    => 'required|numeric',
            'currency'  => 'required',
            'paymentId' => 'required|min:6',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();

        $messages['paymentId.required'] = __('You\'ve canceled the payment!');

        return $messages;
    }
}
