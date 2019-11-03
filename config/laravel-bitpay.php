<?php

return [
    /*
     * This is the full path and name for the private key.
     * The default value is /tmp/laravel-bitpay.pri
     */
    'private_key' => env('BITPAY_PRIVATE_KEY_PATH', '/tmp/laravel-bitpay.pri'),

    /*
     * This is the full path and name for the public key.
     * The default value is /tmp/laravel-bitpay.pub
     */
    'public_key' => env('BITPAY_PUBLIC_KEY_PATH', '/tmp/laravel-bitpay.pub'),

    /*
     * Specifies using the Live Bitcoin network or
     * Test Bitcoin network: livenet or testnet.
     *
     * The default is livenet
     */
    'network' => env('BITPAY_NETWORK', 'livenet'),

    /*
     * The key_storage option allows you to specify a class for persisting and retrieving keys.
     *
     * By default this uses the Bitpay\Storage\EncryptedFilesystemStorage class.
     */
    'key_storage' => \BitPayKeyUtils\Storage\EncryptedFilesystemStorage::class,

    /*
     * This is the password used to encrypt and decrypt keys on the filesystem.
     */
    'key_storage_password' => env('BITPAY_KEY_STORAGE_PASSWORD', 'RandomPasswordForEncryption'),

    /*
     * BitPay Token
     */
    'token' => env('BITPAY_TOKEN', ''),
];
