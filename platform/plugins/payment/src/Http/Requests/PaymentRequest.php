<?php

namespace Botble\Payment\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PaymentRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'amount'         => 'required|numeric',
            'payment_method' => 'required',
        ];

        $extras = [];
        switch ($this->input('payment_method')) {
            case 'stripe':
                $extras = [
                    'number' => 'required|integer|min:6',
                    'cvc'    => 'required|integer|min:3|max:3',
                    'month'  => 'required|integer|min:2|max:2',
                    'year'   => 'required|integer|min:2|max:2',
                    'amount' => 'required|numeric|min:1',
                ];
                break;
            case 'paypal':
                $extras = [];
                break;
            case 'cod':
                $extras = [];
                break;
            case 'bank_transfer':
                $extras = [];
                break;
        }
        return array_merge($rules, $extras);
    }
}
