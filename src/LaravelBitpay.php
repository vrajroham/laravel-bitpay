<?php

namespace Vrajroham\LaravelBitpay;

use Bitpay\AccessToken;
use Bitpay\Application;
use Bitpay\Bill;
use Bitpay\Buyer;
use Bitpay\Currency;
use Bitpay\Invoice;
use Bitpay\Item;
use Bitpay\Key;
use Bitpay\Payout;
use Bitpay\PayoutInstruction;
use Bitpay\PayoutTransaction;
use Bitpay\Point;
use Bitpay\Token;
use Bitpay\User;
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
     * @return \Bitpay\Invoice
     */
    public static function Invoice(): Invoice
    {
        return new Invoice();
    }

    /**
     * @param \Bitpay\Invoice $invoice
     *
     * @return \Bitpay\Invoice
     */
    public static function createInvoice(Invoice $invoice): Invoice
    {
        return (new self())->client->createInvoice($invoice);
    }

    /**
     * @return \Bitpay\Item
     */
    public static function Item(): Item
    {
        return new Item();
    }

    /**
     * @param null $code
     *
     * @return \Bitpay\Currency
     */
    public static function Currency($code = null): Currency
    {
        return new Currency($code);
    }

    /**
     * @return \Bitpay\Buyer
     */
    public static function Buyer(): Buyer
    {
        return new Buyer();
    }

    /**
     * @return \Bitpay\AccessToken
     */
    public static function AccessToken(): AccessToken
    {
        return new AccessToken();
    }

    /**
     * @return \Bitpay\Application
     */
    public static function Application(): Application
    {
        return new Application();
    }

    /**
     * @return \Bitpay\Bill
     */
    public static function Bill(): Bill
    {
        return new Bill();
    }

    /**
     * @param null $id
     *
     * @return \Bitpay\Key
     */
    public static function Key($id = null): Key
    {
        return new Key($id);
    }

    /**
     * @return \Bitpay\Payout
     */
    public static function Payout(): Payout
    {
        return new Payout();
    }

    /**
     * @return \Bitpay\PayoutInstruction
     */
    public static function PayoutInstruction(): PayoutInstruction
    {
        return new PayoutInstruction();
    }

    /**
     * @return \Bitpay\PayoutTransaction
     */
    public static function PayoutTransaction(): PayoutTransaction
    {
        return new PayoutTransaction();
    }

    /**
     * @param $x
     * @param $y
     *
     * @return \Bitpay\Point
     */
    public static function Point($x, $y): Point
    {
        return new Point($x,$y);
    }

    /**
     * @return \Bitpay\Token
     */
    public static function Token(): Token
    {
        return new Token();
    }

    /**
     * @return \Bitpay\User
     */
    public static function User(): User
    {
        return new User();
    }
}
