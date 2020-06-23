<?php

namespace Botble\Payment\Services\Gateways\Stripe;

use Botble\Payment\Models\Payment;
use Botble\Payment\Services\Abstracts\StripePaymentAbstract;
use Botble\Payment\Services\Traits\PaymentTrait;
use Botble\Payment\Supports\StripeHelper;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripePaymentService extends StripePaymentAbstract
{
    use PaymentTrait;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function makePayment(Request $request)
    {
        $this->amount = $request->input('amount');
        $this->currency = $request->input('currency', config('plugins.payment.payment.currency'));
        $this->currency = strtoupper($this->currency);
        $description = $request->input('description');

        Stripe::setApiKey(setting('payment_stripe_secret'));
        Stripe::setClientId(setting('payment_stripe_client_id'));
        $charge = Charge::create([
            'amount'      => $this->amount * StripeHelper::getStripeCurrencyMultiplier($this->currency),
            'currency'    => $this->currency,
            'source'      => $this->token,
            'description' => $description,
        ]);

        $this->chargeId = $charge['id'];

        return $this->chargeId;
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
            'amount'         => $this->amount,
            'currency'       => $this->currency,
            'charge_id'      => $this->chargeId,
            'payment_chanel' => Payment::METHOD_STRIPE,
        ]);

        return true;
    }
}
