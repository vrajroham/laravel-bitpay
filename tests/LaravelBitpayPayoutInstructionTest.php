<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\PayoutInstruction;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayPayoutInstructionTest extends TestCase
{
    /** @test */
    function isInstanceOfPayoutInstruction()
    {
        $this->assertEquals(LaravelBitpay::PayoutInstruction() instanceof PayoutInstruction,true);
    }
}
