<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice as BitPaySDKInvoice;
use BitPaySDK\Model\Invoice\Refund;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayInvoiceTest extends TestCase
{
    /** @test */
    public function isInstanceOfInvoice()
    {
        $this->assertEquals(LaravelBitpay::Invoice() instanceof BitPaySDKInvoice, true);
    }

    /** @test */
    public function isInstanceOfBuyer()
    {
        $this->assertEquals(LaravelBitpay::Buyer() instanceof Buyer, true);
    }

    /** @test */
    public function isInstanceOfRefund()
    {
        $this->assertEquals(LaravelBitpay::Refund() instanceof Refund, true);
    }
}
