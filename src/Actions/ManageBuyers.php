<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Invoice\Buyer;

trait ManageBuyers
{
    /**
     * @return Buyer
     */
    public static function Buyer(): Buyer
    {
        return new Buyer();
    }
}