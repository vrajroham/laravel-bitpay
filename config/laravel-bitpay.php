<?php

$pkPath = 'app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'bitpay'  . DIRECTORY_SEPARATOR . 'laravel-bitpay.pk';

return [
    /*
     * This is the full path and name for the private key.
     * The default value is `storage/app/private/bitpay/laravel-bitpay.pk`
     */
    'private_key'             => env('BITPAY_PRIVATE_KEY_PATH') ?: storage_path($pkPath),

    /*
     * Specifies using the Live Bitcoin network or
     * Test Bitcoin network: livenet or testnet.
     *
     * The default is livenet
     */
    'network'                 => env('BITPAY_NETWORK', 'livenet'),

    /*
     * The key_storage option allows you to specify a class for persisting and retrieving keys.
     *
     * By default this uses the Bitpay\Storage\EncryptedFilesystemStorage class.
     */
    'key_storage'             => \BitPayKeyUtils\Storage\EncryptedFilesystemStorage::class,

    /*
     * This is the password used to encrypt and decrypt keys on the filesystem.
     */
    'key_storage_password'    => env('BITPAY_KEY_STORAGE_PASSWORD', 'RandomPasswordForEncryption'),

    /*
     * Generate/Enable use of BitPay token for 'merchant' facade?
     *
     * Default: true
     */
    'merchant_facade_enabled' => env('BITPAY_ENABLE_MERCHANT', true),

    /*
     * Generate/Enable use of BitPay token for 'payout' facade?
     *
     * Default: false
     */
    'payout_facade_enabled'   => env('BITPAY_ENABLE_PAYOUT', false),

    /*
     * BitPay Merchant Token
     *
     * Default: null
     */
    'merchant_token'          => env('BITPAY_MERCHANT_TOKEN'),

    /*
     * BitPay Payout Token
     *
     * Default: null
     */
    'payout_token'            => env('BITPAY_PAYOUT_TOKEN'),

    /*
     * Indicates if configured webhook (notificationURL) should automatically be set on:
     * - Invoices
     * - Recipients
     * - Payouts/PayoutBatches
     *
     * This feature is overridden when a value is manually set on a respective resource
     * before submitting it to the BitPay API.
     *
     * Uncomment an entry to enable its auto-population.
     */
    'auto_populate_webhook'   => [
//        \Vrajroham\LaravelBitpay\Constants\WebhookAutoPopulate::For_Invoices,
//        \Vrajroham\LaravelBitpay\Constants\WebhookAutoPopulate::For_Recipients,
//        \Vrajroham\LaravelBitpay\Constants\WebhookAutoPopulate::For_Payouts,
    ],
];
