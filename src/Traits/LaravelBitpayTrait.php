<?php

namespace Vrajroham\LaravelBitpay\Traits;

use Bitpay\Client\Adapter\CurlAdapter;
use Bitpay\Client\Client as BitpayClient;
use Bitpay\Network\Livenet;
use Bitpay\Network\Testnet;
use Bitpay\Token;
use Vrajroham\LaravelBitpay\Exceptions\InvalidConfigurationException;

trait LaravelBitpayTrait
{
    public function authenticate()
    {
        $this->validateAndLoadConfig();

        if (in_array('__construct', get_class_methods($this->config['key_storage']))) {
            $storageEngine = new $this->config['key_storage']($this->config['key_storage_password']);
        } else {
            $storageEngine = new $this->config['key_storage']();
        }

        $privateKey = $storageEngine->load($this->config['private_key']);
        $publicKey = $storageEngine->load($this->config['public_key']);

        $this->client = new BitpayClient();

        if ('testnet' == $this->config['network']) {
            $network = new Testnet();
        } elseif ('livenet' == $this->config['network']) {
            $network = new Livenet();
        } else {
            $network = new $this->config['network']();
        }

        $adapter = new CurlAdapter();

        $this->client->setPrivateKey($privateKey);
        $this->client->setPublicKey($publicKey);
        $this->client->setNetwork($network);
        $this->client->setAdapter($adapter);

        $token = new Token();
        $token->setToken($this->config['token']);
        $this->client->setToken($token);
    }

    public function validateAndLoadConfig()
    {
        $config = config('laravel-bitpay');

        if ('livenet' != $config['network'] and 'testnet' != $config['network']) {
            throw InvalidConfigurationException::invalidNetworkName();
        }

        if (!class_exists($config['key_storage'])) {
            throw InvalidConfigurationException::invalidStorageClass();
        }

        if ('' === trim($config['key_storage_password'])) {
            throw InvalidConfigurationException::invaidOrEmptyPassword();
        }

        if ('' === trim($config['token'])) {
            throw InvalidConfigurationException::emptyToken();
        }

        $this->config = $config;
    }
}
