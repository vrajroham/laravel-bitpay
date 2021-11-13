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
        $this->assertEquals(LaravelBitpay::Subscription() instanceof Subscription, true);
    }

    /** @test */
    public function isInstanceOfSubscriptionItem()
    {
        $this->assertEquals(LaravelBitpay::SubscriptionItem() instanceof SubscriptionItem, true);
    }

    /** @test */
    public function isInstanceOfBillData()
    {
        $this->assertEquals(LaravelBitpay::BillData(
                Currency::USD,
                'test@example.com',
                '2021-12-01T09:00:00Z',
                []) instanceof BillData, true);
    }
}
