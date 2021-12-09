<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Subscription\BillData;
use BitPaySDK\Model\Subscription\Subscription;
use BitPaySDK\Model\Subscription\Item as SubscriptionItem;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;


class LaravelBitpaySubscriptionTest extends TestCase
{
    /** @test */
    public function isInstanceOfSubscription()
    {
        $this->assertEquals(true, LaravelBitpay::Subscription() instanceof Subscription);
    }

    /** @test */
    public function isInstanceOfSubscriptionItem()
    {
        $this->assertEquals(true, LaravelBitpay::SubscriptionItem() instanceof SubscriptionItem);
    }

    /** @test */
    public function isInstanceOfBillData()
    {
        $this->assertEquals(true, LaravelBitpay::BillData(
                Currency::USD,
                'test@example.com',
                '2021-12-01T09:00:00Z',
                []) instanceof BillData);
    }
}
