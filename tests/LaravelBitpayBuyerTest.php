<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Buyer;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayBuyerTest extends TestCase
{
    /** @test */
    public function isInstanceOfBuyer()
    {
        $this->assertEquals(LaravelBitpay::Buyer() instanceof Buyer, true);
    }
}
