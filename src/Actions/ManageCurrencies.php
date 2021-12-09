<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
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
     * @throws BitPayException BitPayException class
     */
    public static function getCurrencies(): array
    {
        return (new self())->client->getCurrencies();
    }
}
