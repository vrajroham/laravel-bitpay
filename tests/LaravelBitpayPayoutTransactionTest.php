<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\PayoutTransaction;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayPayoutTransactionTest extends TestCase
{
    /** @test */
    function isInstanceOfPayoutTransaction()
    {
        $this->assertEquals(LaravelBitpay::PayoutTransaction() instanceof PayoutTransaction,true);
    }
}
