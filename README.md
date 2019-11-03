# Laravel + BitPay Integration (Version 2) [WIP]

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)
[![Build Status](https://img.shields.io/travis/vrajroham/laravel-bitpay/master.svg?style=for-the-badge)](https://travis-ci.org/vrajroham/laravel-bitpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/vrajroham/laravel-bitpay)
[![Total Downloads](https://img.shields.io/packagist/dt/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)

Accept Bitcoin and Bitcoin Cash for your business with your Laravel application and BitPay client.

> Recently bitpay discontinued support for old php-skd which was used by this wrapper. I'm working on V2 of this wrapper which will utilize bitpay's new php-sdk.

## Installation

You can install the package via composer:

```bash
composer require vrajroham/laravel-bitpay
```
Publish config file with:

```bash
php artisan vendor:publish --provider="Vrajroham\LaravelBitpay\LaravelBitpayServiceProvider"
```
## Steps to configure and pair with BitPay Server

- Add following keys to `.env` file and updated the details ([view more about configuration](https://support.bitpay.com/hc/en-us/articles/115003001063-How-do-I-configure-the-PHP-BitPay-Client-Library-)):

    ```dotenv
    BITPAY_PRIVATE_KEY_PATH=/tmp/bitpay.pri
    BITPAY_PUBLIC_KEY_PATH=/tmp/bitpay.pub
    BITPAY_NETWORK=testnet
    BITPAY_KEY_STORAGE_PASSWORD=SomeRandomePasswordForKeypairEncryption
    BITPAY_TOKEN=
    ``` 

- Create keypairs and pair your client(application) with BitPay server.

    ```bash
    php artisan laravel-bitpay:createkeypair
    ```
    
<p align="center"><a href="https://ibb.co/gTpZxXV"><img src="https://i.ibb.co/0MSyxWt/Screenshot-2019-11-03-at-7-01-56-PM.png" alt="Screenshot-2019-11-03-at-7-01-56-PM" border="0"></a></p>

- Done. :golf:

### Usage

##### Create Invoice and checkout

``` php
public function createInvoice()
{
    // Create instance of invoice
    $invoice = LaravelBitpay::Invoice();

    // Set item details (Only 1 item)
    $invoice->setItemDesc('Photo');
    $invoice->setItemCode('sku-1');
    $invoice->setPrice(1);
    $invoice->setOrderId(12345); // E.g. Your order number

    // Create Buyer Instance
    $buyer = LaravelBitpay::Buyer();
    $buyer->setName('Vaibhavraj Roham');
    $buyer->setEmail('test@example.me');
    $buyer->setAddress1('Kopargaon');
    $buyer->setNotify(true);

    // Add buyer to invoice
    $invoice->setBuyer($buyer);

    // Set currency
    $invoice->setCurrency('USD');

    // Set redirect url to get back after completing the payment. GET Request
    $invoice->setRedirectURL(route('bitpay-redirect-back'));

    // Webhook URL to get notifications of payment. POST request
    $invoice->setNotificationUrl(route('bitpay-webhook'));

    // Create invoice on bitpay server.
    $invoice = LaravelBitpay::createInvoice($invoice);

    // Redirect user to following URL for payment approval.
    $paymentUrl = $invoice->getUrl();
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email vaibhavraj@vrajroham.me instead of using the issue tracker.

## Credits

- [Vaibhavraj Roham](https://github.com/vrajroham)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
