<?php

use Botble\RealEstate\Facades\CurrencyFacade;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Botble\RealEstate\Models\Currency;

if (!function_exists('format_price')) {
    /**
     * @param $price
     * @param Currency|null $currency
     * @param bool $withoutCurrency
     * @param bool $useSymbol
     * @return string
     */
    function format_price($price, $currency = null, $withoutCurrency = false, $useSymbol = false)
    {
        if ($currency != null && !($currency instanceof Currency)) {
            $currency = app(CurrencyInterface::class)->getFirstBy(['currencies.id' => $currency]);
        }

        if (!$currency) {
            return human_price_text($price, $currency);
        }

        if ($useSymbol && !$currency->symbol) {
            $currency->symbol = '$';
        }

        if ($useSymbol && $currency->is_prefix_symbol) {
            return human_price_text($currency->symbol . $price, $currency);
        }

        if ($withoutCurrency) {
            return human_price_text($price, $currency);
        }

        return human_price_text($price, $currency, ($useSymbol ? $currency->symbol : $currency->title));
    }
}

if (!function_exists('human_price_text')) {
    /**
     * @param $price
     * @param $currency
     * @param string $priceUnit
     * @return string
     */
    function human_price_text($price, $currency, $priceUnit = '')
    {
        $numberAfterDot = ($currency instanceof Currency) ? $currency->decimals : 0;

        if ($price >= 1000000 && $price < 1000000000) {
            $price = round($price / 1000000, 2);
            $numberAfterDot = 2;
            $priceUnit = __('million') . ' '. $priceUnit;
        }

        if ($price >= 1000000000) {
            $price = round($price / 1000000000, 2);
            $numberAfterDot = 2;
            $priceUnit =  __('billion') . ' '. $priceUnit;
        }

        if (is_numeric($price)) {
            $price = preg_replace('/[^0-9,.]/s', '', $price);
        }

        $price = number_format($price, $numberAfterDot, '.', ',');

        return $price . ' ' . $priceUnit;
    }
}

if (!function_exists('cms_currency')) {
    /**
     * @return \Botble\RealEstate\Supports\CurrencySupport
     */
    function cms_currency()
    {
        return CurrencyFacade::getFacadeRoot();
    }
}

if (!function_exists('get_all_currencies')) {
    /**
     * @return \Illuminate\Support\Collection
     */
    function get_all_currencies()
    {
        return app(CurrencyInterface::class)->getAllCurrencies();
    }
}

if (!function_exists('get_application_currency')) {
    /**
     * @return \Botble\RealEstate\Models\Currency|null
     */
    function get_application_currency()
    {
        return cms_currency()->getApplicationCurrency();
    }
}

if (!function_exists('get_application_currency_id')) {
    /**
     * @return int|null
     */
    function get_application_currency_id()
    {
        $currency = cms_currency()->getApplicationCurrency();
        return $currency ? $currency->id : null;
    }
}
