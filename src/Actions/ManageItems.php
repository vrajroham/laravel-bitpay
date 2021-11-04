<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Bill\Item;


trait ManageItems
{
    /**
     * @return Item
     */
    public static function Item(): Item
    {
        return new Item();
    }
}
