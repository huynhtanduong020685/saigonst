<?php

namespace Botble\Payment\Services\Traits;

use Auth;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Illuminate\Support\Arr;

trait PaymentTrait
{

    /**
     * Store payment on local
     *
     * @param array $args
     * @return mixed
     */
    public function storeLocalPayment(array $args = [])
    {
        $data = array_merge([
            'user_id' => Auth::check() ? Auth::user()->id : 0,
        ], $args);

        $paymentChanel = Arr::get($data, 'payment_chanel', 'stripe');

        app(PaymentInterface::class)->create([
            'user_id'        => Arr::get($data, 'user_id'),
            'amount'         => $data['amount'],
            'currency'       => $data['currency'],
            'charge_id'      => $data['charge_id'],
            'payment_chanel' => $paymentChanel,
        ]);
    }
}
