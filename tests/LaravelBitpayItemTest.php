<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Bill\Item;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;

class LaravelBitpayItemTest extends TestCase
{
    /** @test */
    public function isInstanceOfItem()
    {
        $this->assertEquals(LaravelBitpay::Item() instanceof Item, true);
    }
}
