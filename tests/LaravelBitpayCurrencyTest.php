<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Currency;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayCurrencyTest extends TestCase
{
    /** @test */
    public function isInstanceOfCurrency()
    {
        $this->assertEquals(true, LaravelBitpay::Currency() instanceof Currency);
    }
}
