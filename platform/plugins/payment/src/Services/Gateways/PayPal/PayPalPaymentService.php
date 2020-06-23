<?php

namespace Botble\Payment\Services\Gateways\PayPal;

use Botble\Payment\Models\Payment;
use Botble\Payment\Services\Abstracts\PayPalPaymentAbstract;
use Botble\Payment\Services\Traits\PaymentTrait;
use Illuminate\Http\Request;

class PayPalPaymentService extends PayPalPaymentAbstract
{
    use PaymentTrait;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function makePayment(Request $request)
    {
        $currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $currency = strtoupper($currency);
        $amount = $request->input('amount');

        $queryString = '?amount=' . $amount . '&currency=' . $currency;
        $data = [
            'name'     => $request->input('name'),
            'quantity' => 1,
            'price'    => $amount,
            'sku'      => null,
            'type'     => Payment::METHOD_PAYPAL,
        ];

        $checkoutUrl = $this->setReturnUrl($request->input('return_url') . $queryString)
            ->setCurrency($currency)
            ->setItem($data)
            ->createPayment($request->input('description'));

        return $checkoutUrl;
    }

    /**
     * Use this function to perform more logic after user has made a payment
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function afterMakePayment(Request $request)
    {
        $this->storeLocalPayment([
            'amount'         => $request->input('amount'),
            'currency'       => $request->input('currency'),
            'charge_id'      => $request->input('paymentId'),
            'payment_chanel' => Payment::METHOD_PAYPAL,
        ]);

        return true;
    }
}
