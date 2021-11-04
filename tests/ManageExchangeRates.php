<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Rate\Rates;


trait ManageExchangeRates
{
    /**
     * Retrieve the exchange rate table maintained by BitPay.
     *
     * @link https://bitpay.com/bitcoin-exchange-rates
     * @return Rates A Rates object populated with the BitPay exchange rate table.
     */
    public static function getRates(): Rates
    {
        return (new self())->client->getRates();
    }
}
