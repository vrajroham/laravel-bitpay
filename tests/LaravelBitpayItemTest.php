<?php

namespace Vrajroham\LaravelBitpay\Tests;

use Bitpay\Item;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayItemTest extends TestCase
{
    /** @test */
    function isInstanceOfItem()
    {
        $this->assertEquals(LaravelBitpay::Item() instanceof Item,true);
    }
}
