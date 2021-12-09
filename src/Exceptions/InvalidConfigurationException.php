<?php

namespace Vrajroham\LaravelBitpay\Exceptions;

use Exception;

class InvalidConfigurationException extends Exception
{
    public static function invalidNetworkName(): self
    {
        return new static('Invalid network option provided in config. Should be livenet or testnet only.');
    }

    public static function invalidStorageClass()
    {
        return new static('Invalid key storage class provided in config.');
    }

    public static function invalidOrEmptyPassword()
    {
        return new static('Password missing in config. Password is required to encrypt and decrypt keys on the filesystem.');
    }

    public static function emptyMerchantToken()
    {
        return new static('BitPay merchant token is empty. Set BITPAY_MERCHANT_TOKEN in your .env file.');
    }

    public static function emptyPayoutToken()
    {
        return new static('BitPay payout token is empty. Set BITPAY_PAYOUT_TOKEN in your .env file.');
    }
}
