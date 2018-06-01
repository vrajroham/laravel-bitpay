<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\User;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayUserTest extends TestCase
{
    /** @test */
    function isInstanceOfUser()
    {
        $this->assertEquals(LaravelBitpay::User() instanceof User,true);
    }
}
