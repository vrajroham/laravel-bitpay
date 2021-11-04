<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Currency;


trait ManageCurrencies
{
    /**
     * @param string|null $code
     *
     * @return \BitpaySDK\Model\Currency
     * @link https://bitpay.com/api/#rest-api-resources-currencies
     */
    public static function Currency(string $code = null): Currency
    {
        $currency = new Currency();
        if ($code) {
            $currency->setCode($code);
        }

        return $currency;
    }

    /**
     * Fetch the supported currencies.
     *
     * @link https://bitpay.com/api/#rest-api-resources-currencies-retrieve-the-supported-currencies
     * @return array     A list of supported BitPay Currency objects.
     */
    public static function getCurrencies(): array
    {
        return (new self())->client->getCurrencies();
    }

    //    TODO: Implement the following if/when upstream gets merged: https://github.com/bitpay/php-bitpay-client-v2/pull/67
    //    /**
    //     * Retrieve all the rates for a given cryptocurrency
    //     *
    //     * @link https://bitpay.com/api/#rest-api-resources-rates-retrieve-all-the-rates-for-a-given-cryptocurrency
    //     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
    //     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
    //     * @return \BitPaySDK\Model\Rate\Rates A Rates object populated with the currency rates for the requested baseCurrency.
    //     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
    //     */
    //    public static function getCurrencyRates(string $baseCurrency): Rates
    //    {
    //        return (new self())->client->getCurrencyRates($baseCurrency);
    //    }
    //
    //    /**
    //     * Retrieve the rate for a cryptocurrency / fiat pair
    //     *
    //     * @link https://bitpay.com/api/#rest-api-resources-rates-retrieve-the-rates-for-a-cryptocurrency-fiat-pair
    //     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
    //     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
    //     * @param string $currency The fiat currency for which you want to fetch the baseCurrency rate
    //     * @return \BitPaySDK\Model\Rate\Rate A Rate object populated with the currency rate for the requested baseCurrency.
    //     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
    //     */
    //    public static function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
    //    {
    //        return (new self())->client->getCurrencyPairRate($baseCurrency, $currency);
    //    }
}
