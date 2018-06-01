<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Payout;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayPayoutTest extends TestCase
{
    /** @test */
    function isInstanceOfPayout()
    {
        $this->assertEquals(LaravelBitpay::Payout() instanceof Payout,true);
    }
}
