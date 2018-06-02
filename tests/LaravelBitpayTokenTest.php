<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Token;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayTokenTest extends TestCase
{
    /** @test */
    public function isInstanceOfToken()
    {
        $this->assertEquals(LaravelBitpay::Token() instanceof Token, true);
    }
}
