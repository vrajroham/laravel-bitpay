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
        $this->assertEquals(true, LaravelBitpay::Invoice() instanceof BitPaySDKInvoice);
    }

    /** @test */
    public function isInstanceOfBuyer()
    {
        $this->assertEquals(true, LaravelBitpay::Buyer() instanceof Buyer);
    }
}
