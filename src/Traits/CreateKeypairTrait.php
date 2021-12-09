<?php

namespace Vrajroham\LaravelBitpay\Traits;

use Vrajroham\LaravelBitpay\Exceptions\InvalidConfigurationException;


trait CreateKeypairTrait
{
    public function validateAndLoadConfig()
    {
        $config = config('laravel-bitpay');

        if ('livenet' !== $config['network'] && 'testnet' !== $config['network']) {
            throw InvalidConfigurationException::invalidNetworkName();
        }

        if (! class_exists($config['key_storage'])) {
            throw InvalidConfigurationException::invalidStorageClass();
        }

        if ('' === trim($config['key_storage_password'])) {
            throw InvalidConfigurationException::invalidOrEmptyPassword();
        }

        $this->config = $config;
    }

    protected function getEnabledFacades(): array
    {
        $facades = [];

        if (! empty($this->config['merchant_facade_enabled']) && $this->config['merchant_facade_enabled']) {
            $facades[] = 'merchant';
        }

        if (! empty($this->config['payout_facade_enabled']) && $this->config['payout_facade_enabled']) {
            $facades[] = 'payout';
        }

        return $facades;
    }

    /**
     *
     * @param string $facade One of 'merchant' or 'payout'
     *
     * @throws \Exception
     */
    private function getEnvReplacementString(string $facade): string
    {
        if ($facade === 'merchant') {
            return "BITPAY_MERCHANT_TOKEN";
        } elseif ($facade === 'payout') {
            return "BITPAY_PAYOUT_TOKEN";
        }

        throw new \Exception("'$facade' is not a valid BitPay facade!", 1);
    }

    /**
     * Write facade-specific token to .env
     * Update it if it exists, otherwise add it below existing BITPAY_* entries.
     * Finally, and very unlikely, if it doesn't exist nor does any other BITPAY_* entries, write it to the end
     * of the .env
     *
     * @param string $facade One of 'merchant' or 'payout'
     *
     * @throws \Exception
     */
    protected function writeNewEnvironmentFileWith(string $facade)
    {
        $replString      = $this->getEnvReplacementString($facade) . '=' . $this->token;
        $envFilePath     = $this->laravel->environmentFilePath();
        $envFileContents = file_get_contents($envFilePath);

        if (strpos($envFileContents, $this->getEnvReplacementString($facade)) !== false) {
            file_put_contents($envFilePath, preg_replace(
                    $this->keyReplacementPattern($facade),
                    $replString,
                    $envFileContents)
            );
        } else {
            $envLines = file($envFilePath, FILE_IGNORE_NEW_LINES);
            $offset   = null;

            foreach ($envLines as $line) {
                if (strpos($line, "BITPAY_") === 0) {
                    $offset = array_search($line, $envLines);
                }
            }

            // Highly unlikely, but place token at end of .env if no other BITPAY_* entries exist
            if ($offset === null) {
                $offset     = count($envLines) - 1;
                $replString = "\n" . $replString;
            }

            array_splice($envLines, $offset + 1, 0, $replString);
            file_put_contents($envFilePath, implode("\n", $envLines));
        }
    }

    /**
     *
     * @param string $facade One of 'merchant' or 'payout'
     *
     * @throws \Exception
     */
    protected function keyReplacementPattern(string $facade): string
    {
        if ($facade === 'merchant') {
            $token = $this->laravel['config']['laravel-bitpay.merchant_token'];
        } elseif ($facade === 'payout') {
            $token = $this->laravel['config']['laravel-bitpay.payout_token'];
        } else {
            throw new \Exception("'$facade' is not a valid BitPay facade!", 1);
        }

        $replString = $this->getEnvReplacementString($facade);
        $escaped    = preg_quote('=' . $token, '/');

        return "/^" . $replString . "{$escaped}/m";
    }
}
