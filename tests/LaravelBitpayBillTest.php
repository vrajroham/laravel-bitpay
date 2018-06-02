<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Bill;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayBillTest extends TestCase
{
    /** @test */
    public function isInstanceOfBill()
    {
        $this->assertEquals(LaravelBitpay::Bill() instanceof Bill, true);
    }
}
