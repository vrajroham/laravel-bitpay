<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Invoice\Invoice as BitPaySDKInvoice;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayInvoiceTest extends TestCase
{
    /** @test */
    public function isInstanceOfInvoice()
    {
        $this->assertEquals(LaravelBitpay::Invoice() instanceof BitPaySDKInvoice, true);
    }
}
