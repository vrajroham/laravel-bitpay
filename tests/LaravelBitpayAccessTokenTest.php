<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\AccessToken;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayAccessTokenTest extends TestCase
{
    /** @test */
    function isInstanceOfAccessToken()
    {
        $this->assertEquals(LaravelBitpay::AccessToken() instanceof AccessToken,true);
    }
}
