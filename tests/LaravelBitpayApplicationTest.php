<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Application;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayApplicationTest extends TestCase
{
    /** @test */
    public function isInstanceOfApplication()
    {
        $this->assertEquals(LaravelBitpay::Application() instanceof Application, true);
    }
}
