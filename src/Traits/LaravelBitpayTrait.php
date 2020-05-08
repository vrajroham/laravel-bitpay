<?php

namespace Vrajroham\LaravelBitpay\Traits;

use BitPaySDK\Client as BitpayClient;
use BitPaySDK\Env;
use BitPaySDK\Tokens;
use Vrajroham\LaravelBitpay\Exceptions\InvalidConfigurationException;

trait LaravelBitpayTrait
{
    public function authenticate()
    {
        $this->validateAndLoadConfig();

        $this->client = BitpayClient::create()->withData(
            'testnet' == $this->config['network'] ? Env::Test : Env::Prod,
            $this->config['private_key'],
            new Tokens(
                $this->config['token'] //merchant
            ),
            $this->config['key_storage_password'] //used to decrypt your private key, if encrypted
        );
    }

    public function validateAndLoadConfig()
    {
        $config = config('laravel-bitpay');

        if ('livenet' != $config['network'] && 'testnet' != $config['network']) {
            throw InvalidConfigurationException::invalidNetworkName();
        }

        if (!class_exists($config['key_storage'])) {
            throw InvalidConfigurationException::invalidStorageClass();
        }

        if ('' === trim($config['key_storage_password'])) {
            throw InvalidConfigurationException::invalidOrEmptyPassword();
        }

        if ('' === trim($config['token'])) {
            throw InvalidConfigurationException::emptyToken();
        }

        $this->config = $config;
    }
}
