# Laravel + BitPay Integration (Version 2) [WIP]

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)
[![Build Status](https://img.shields.io/travis/vrajroham/laravel-bitpay/master.svg?style=for-the-badge)](https://travis-ci.org/vrajroham/laravel-bitpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/vrajroham/laravel-bitpay)
[![Total Downloads](https://img.shields.io/packagist/dt/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)

Accept Bitcoin and Bitcoin Cash for your business with your Laravel application and BitPay client.

> Recently bitpay discontinued support for old php-skd which was used by this wrapper. I'm working on V2 of this wrapper which will utilize bitpay's new php-sdk.

## Contents
- [Installation](#installation)
- [Steps to configure and pair with BitPay Server](#steps-to-configure-and-pair-with-bitPay-server)
- [Usage](#usage)
    + [Create Invoice and checkout](#create-invoice-and-checkout)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

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
    
<p align="center"><a href="https://ibb.co/s9Z5jD6"><img src="https://i.ibb.co/DfZG468/Screenshot-2019-11-03-at-7-59-55-PM.png" alt="Screenshot-2019-11-03-at-7-59-55-PM" border="0"></a></p>

- What exactly above command do?
    + Above command will create **Private and Public key**, encrypt your private key using bitpay secure storage class using your provided password. 
    + SIN (Service Identification Number) for your client will be created to uniquely identify requests from your server. 
    + By using SIN **new Token and Pairing Code** will be created for your client on bitpay server and will be shown on your console output.
    + Token will be used for all future request to bitpay and will automatically be copied to your `.env` file.
    + Based on environment you set **TEST/LIVE**, command will provide URL to approve your client and you need to copy and search Pairing Code on bitpay server & approve it.

- You are all set. :golf:

### Usage

##### Create Invoice and checkout

Let's go step by step.

- Create your internal system order and then initiate the workflow by creating bitpay invoice as below,

``` php
use Vrajroham\LaravelBitpay\LaravelBitpay;

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

- Once you get the invoice url for payment, redirect user to that particular url. Use will see something like below on browser.

<p align="center"><a href="https://ibb.co/X8JhftX"><img src="https://i.ibb.co/FV7Skz6/Screenshot-2019-11-03-at-5-31-33-PM.png" alt="Screenshot-2019-11-03-at-5-31-33-PM" border="0"></a></p>

- Next, open your bitpay wallet and make a payment. Something like below,
<p align="center"><a href="https://ibb.co/FY4G4gZ"><img src="https://i.ibb.co/WzvSvg8/IMG-3639.png" alt="IMG-3639" border="1"></a></p>

- Once payment is done, success screen will be displayed and user needs to click on **Return to Shop Name**.
<p align="center"><a href="https://ibb.co/8M21RBv"><img src="https://i.ibb.co/Jn2Dbd6/Screenshot-2019-11-03-at-5-32-05-PM.png" alt="Screenshot-2019-11-03-at-5-32-05-PM" border="0"></a></p>

- Payment done! Now you need to wait for webhook to get notification regarding status of payment.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email vaibhavraj@vrajroham.me instead of using the issue tracker.

## Credits

- [Vaibhavraj Roham](https://github.com/vrajroham)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
