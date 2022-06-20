<?php

namespace Vrajroham\LaravelBitpay;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelBitpayFacade.
 */
class LaravelBitpayFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LaravelBitpay::class;
    }
}
