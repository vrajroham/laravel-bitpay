<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Invoice\Refund;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;


class LaravelBitpayRefundTest extends TestCase
{
    /** @test */
    public function isInstanceOfRefund()
    {
        $this->assertEquals(true, LaravelBitpay::Refund() instanceof Refund);
    }
}
