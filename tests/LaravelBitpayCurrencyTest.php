<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Currency;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayCurrencyTest extends TestCase
{
    /** @test */
    public function isInstanceOfCurrency()
    {
        $this->assertEquals(LaravelBitpay::Currency() instanceof Currency, true);
    }
}
