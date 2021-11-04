<?php

namespace Vrajroham\LaravelBitpay;

use BitPaySDK\Exceptions\BitPayException;
use Vrajroham\LaravelBitpay\Actions\ManageBills;
use Vrajroham\LaravelBitpay\Actions\ManageBuyers;
use Vrajroham\LaravelBitpay\Actions\ManageCurrencies;
use Vrajroham\LaravelBitpay\Actions\ManageInvoices;
use Vrajroham\LaravelBitpay\Actions\ManageItems;
use Vrajroham\LaravelBitpay\Actions\ManageRefunds;
use Vrajroham\LaravelBitpay\Tests\ManageExchangeRates;
use Vrajroham\LaravelBitpay\Traits\MakesHttpRequests;


class LaravelBitpay
{
    use MakesHttpRequests;
    use ManageInvoices;
    use ManageBuyers;
    use ManageItems;
    use ManageBills;
    use ManageCurrencies;
    use ManageExchangeRates;
    use ManageRefunds;

    protected $client;
    private $config;

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
