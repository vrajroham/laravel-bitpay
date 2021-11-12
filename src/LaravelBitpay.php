<?php

namespace Vrajroham\LaravelBitpay;

use BitPaySDK\Exceptions\BitPayException;
use Vrajroham\LaravelBitpay\Actions\ManageBills;
use Vrajroham\LaravelBitpay\Actions\ManageCurrencies;
use Vrajroham\LaravelBitpay\Actions\ManageExchangeRates;
use Vrajroham\LaravelBitpay\Actions\ManageInvoices;
use Vrajroham\LaravelBitpay\Actions\ManageSubscriptions;
use Vrajroham\LaravelBitpay\Traits\MakesHttpRequests;


class LaravelBitpay
{
    use MakesHttpRequests;
    use ManageBills;
    use ManageCurrencies;
    use ManageExchangeRates;
    use ManageInvoices;
    use ManageSubscriptions;


    protected $client;
    private   $config;

    /**
     * Setup client while creating the instance.
     *
     * @throws Exceptions\InvalidConfigurationException
     * @throws BitPayException
     */
    public function __construct()
    {
        $this->setupClient();
    }
}
