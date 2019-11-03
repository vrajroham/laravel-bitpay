<?php

namespace Vrajroham\LaravelBitpay\Exceptions;

use Exception;

class InvalidConfigurationException extends Exception
{
    public static function invalidNetworkName(): self
    {
        return new static('Invalid network option provided in config. Should be livenet ot testnet only.');
    }

    public static function invalidStorageClass()
    {
        return new static('Invalid key storage class provided in config.');
    }

    public static function invalidOrEmptyPassword()
    {
        return new static('Password missing in config. Password is required to encrypt and decrypt keys on the filesystem.');
    }

    public static function invalidOrEmptyPairingCode()
    {
        return new static('Invalid or empty pairing code. To create new visit merchant dashboard on bitpay.');
    }

    public static function invalidOrEmptyPairingCodeLabel()
    {
        return new static('Invalid or empty pairing code label.');
    }

    public static function emptyToken()
    {
        return new static('BitPay token is empty. Set token in `bitpay-config` file.');
    }
}
