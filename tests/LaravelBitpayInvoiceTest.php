<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Invoice;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayInvoiceTest extends TestCase
{
    /** @test */
    public function isInstanceOfInvoice()
    {
        $this->assertEquals(LaravelBitpay::Invoice() instanceof Invoice, true);
    }
}
