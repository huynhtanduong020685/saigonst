<?php

use Botble\Payment\Supports\StripeHelper;

if (!function_exists('convert_stripe_amount_from_api')) {
    /**
     * @param $amount
     * @param $currency
     * @return float|int
     */
    function convert_stripe_amount_from_api($amount, $currency)
    {
        return $amount / StripeHelper::getStripeCurrencyMultiplier($currency);
    }
}
