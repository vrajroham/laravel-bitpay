<?php

namespace Vrajroham\LaravelBitpay;

use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use Vrajroham\LaravelBitpay\Traits\LaravelBitpayTrait;

class LaravelBitpay
{
    use LaravelBitpayTrait;
    public $client;
    public $config;

    /**
     * LaravelBitpay constructor.
     */
    public function __construct()
    {
        $this->authenticate();
    }

    /**
     * @return \BitPaySDK\Model\Invoice\Invoice
     */
    public static function Invoice(): Invoice
    {
        return new Invoice();
    }

    /**
     * @param \BitPaySDK\Model\Invoice\Invoice $invoice
     *
     * @return \BitPaySDK\Model\Invoice\Invoice
     */
    public static function createInvoice(Invoice $invoice): Invoice
    {
        if ('' == $invoice->getNotificationURL()) {
            $invoice->setNotificationURL(route('laravel-bitpay.webhook.capture'));
        }

        return (new self())->client->createInvoice($invoice);
    }

    /**
     * @return \BitPaySDK\Model\Bill\Item
     */
    public static function Item(): Item
    {
        return new Item();
    }

    /**
     * @return \BitPaySDK\Model\Invoice\Buyer
     */
    public static function Buyer(): Buyer
    {
        return new Buyer();
    }

    /**
     * @param null $code
     *
     * @return \Bitpay\Model\Currency
     */
    public static function Currency($code = null): Currency
    {
        return new Currency($code);
    }
}
