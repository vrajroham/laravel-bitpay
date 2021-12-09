<?php

namespace Vrajroham\LaravelBitpay\Tests;

use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Model\Payout\PayoutInstruction;
use BitPaySDK\Model\Payout\RecipientReferenceMethod;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelBitpay\LaravelBitpay;


class LaravelBitpayPayoutTest extends TestCase
{
    /** @test */
    public function isInstanceOfPayout()
    {
        $this->assertEquals(true, LaravelBitpay::Payout() instanceof Payout);
    }

    /** @test */
    public function isInstanceOfPayoutBatch()
    {
        $this->assertEquals(true, LaravelBitpay::PayoutBatch() instanceof PayoutBatch);
    }

    /** @test */
    public function isInstanceOfPayoutInstruction()
    {
        $this->assertEquals(true, LaravelBitpay::PayoutInstruction(
                10,
                RecipientReferenceMethod::EMAIL,
                'test@example.com'
            ) instanceof PayoutInstruction);
    }
}
