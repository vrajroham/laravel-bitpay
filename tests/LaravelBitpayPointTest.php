<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Point;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayPointTest extends TestCase
{
    /** @test */
    public function isInstanceOfPoint()
    {
        $this->assertEquals(LaravelBitpay::Point(1, 2) instanceof Point, true);
    }
}
