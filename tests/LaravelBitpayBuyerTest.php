<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Invoice\Buyer;
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
