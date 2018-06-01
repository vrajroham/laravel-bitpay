<?php

namespace Vrajroham\LaravelBitpay;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelBitpayFacade
 *
 * @package Vrajroham\LaravelBitpay
 */
class LaravelBitpayFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-bitpay';
    }
}
