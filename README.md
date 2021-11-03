# Laravel + BitPay Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)
[![Build Status](https://img.shields.io/travis/vrajroham/laravel-bitpay/master.svg?style=for-the-badge)](https://travis-ci.org/vrajroham/laravel-bitpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/vrajroham/laravel-bitpay)
[![Total Downloads](https://img.shields.io/packagist/dt/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)

LaravelBitpay enables you and your business to transact in Bitcoin, Bitcoin Cash and 10+ other BitPay-supported cryptocurrencies within your Laravel application.

> Requires PHP ^7.3

### Supported Resources

- [x] [Invoices](https://bitpay.com/api/#rest-api-resources-invoices)
- [ ] [Settlements](https://bitpay.com/api/#rest-api-resources-settlements)
- [ ] [Ledgers](https://bitpay.com/api/#rest-api-resources-ledgers)
- [ ] [Recipients](https://bitpay.com/api/#rest-api-resources-recipients)
- [ ] [Payouts](https://bitpay.com/api/#rest-api-resources-payouts)
- [x] [Bills](https://bitpay.com/api/#rest-api-resources-bills)
- [ ] [Subscriptions](https://bitpay.com/api/#rest-api-resources-subscriptions)
- [x] [Rates](https://bitpay.com/api/#rest-api-resources-rates)
- [ ] [Sessions](https://bitpay.com/api/#rest-api-resources-sessions)
- [x] [Currencies](https://bitpay.com/api/#rest-api-resources-currencies)

## Contents

- [Installation](#installation)
    + [Install Package](#install-package)
    + [Publish config file](#publish-config-file)
    + [Add configuration values](#add-configuration-values)
    + [Add webhook event listener](#add-webhook-event-listener)
    + [Connect to server and authenticate the client](#connect-to-server-and-authenticate-the-client)
- [Examples](#examples)
    + [Invoices](#invoices)
        + [Create Invoice and checkout (step wise)](#create-invoice-and-checkout)
        + [Retrieve an existing invoice](#retrieve-an-existing-invoice)
        + [Retrieve a list of existing invoices](#retrieve-a-list-of-existing-invoices)
        + [Refund an invoice](#refund-an-invoice)
        + [Retrieve a refund request](#retrieve-a-refund-request)
        + [Retrieve all refund requests on an invoice](#retrieve-all-refund-requests-on-an-invoice)
        + [Cancel a refund request](#cancel-a-refund-request)
    + [Bills](#bills)
        + [Create a bill](#create-a-bill)
        + [Retrieve a bill](#retrieve-a-bill)
        + [Retrieve a list of existing bills](#retrieve-a-list-of-existing-bills)
        + [Update a bill](#update-a-bill)
        + [Deliver a bill via email](#deliver-a-bill-via-email)
    + [Currencies](#currencies)
        + [Retrieve the supported currencies](#retrieve-the-supported-currencies)
    + [Rates](#rates)
        + [Retrieve the exchange rate table maintained by BitPay](#retrieve-the-exchange-rate-table-maintained-by-bitpay)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Installation

### Install package

You can install the package via composer:

```bash
composer require vrajroham/laravel-bitpay
```

### Publish config file

Publish config file with:

```bash
php artisan vendor:publish --provider="Vrajroham\LaravelBitpay\LaravelBitpayServiceProvider"
```

### Add configuration values

Add following keys to `.env` file and updated the
details ([view more about configuration](https://support.bitpay.com/hc/en-us/articles/115003001063-How-do-I-configure-the-PHP-BitPay-Client-Library-)):

```dotenv
BITPAY_PRIVATE_KEY_PATH=/tmp/bitpay.pri
BITPAY_PUBLIC_KEY_PATH=/tmp/bitpay.pub
BITPAY_NETWORK=testnet
BITPAY_KEY_STORAGE_PASSWORD=SomeRandomePasswordForKeypairEncryption
BITPAY_TOKEN=
``` 

### Add webhook event listener

By default, package is capable of handling of webhook requests. Bitpay payment status updates are completely based on
webhooks. Whenever webhook is received from server, `BitpayWebhookReceived` event is dispatched. You just need to
provide a listener for this event.

You can add your listener as below,

```php
<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vrajroham\LaravelBitpay\Events\BitpayWebhookReceived;

class ProcessBitpayWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle(BitpayWebhookReceived $event)
    {
        $orderId = $event->payload['orderId'];
        $status = $event->payload['status'];
        // Other payload properties
        // You will receive 3 webhooks for single payment with different status.
        // 1. status = paid
        // 2. status = confirmed
        // 3. status = completed
    }
}
```

Next, add listener to EventServiceProvider's `$listen` array as below,

```php
<?php

class EventServiceProvider extends ServiceProvider{
    protected $listen = [
        // Other events and listeners
        BitpayWebhookReceived::class => [
            ProcessBitpayWebhook::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
```

### Connect to server and authenticate the client

- Create keypairs and pair your client(application) with BitPay server.

    ```bash
    php artisan laravel-bitpay:createkeypair
    ```

<p align="center"><a href="https://ibb.co/s9Z5jD6"><img src="https://i.ibb.co/DfZG468/Screenshot-2019-11-03-at-7-59-55-PM.png" alt="Screenshot-2019-11-03-at-7-59-55-PM" border="0"></a></p>

- What exactly above command do?
    + Above command will create **Private and Public key**, encrypt your private key using bitpay secure storage class
      using your provided password.
    + SIN (Service Identification Number) for your client will be created to uniquely identify requests from your
      server.
    + By using SIN **new Token and Pairing Code** will be created for your client on bitpay server and will be shown on
      your console output.
    + Token will be used for all future request to bitpay and will automatically be copied to your `.env` file.
    + Based on environment you set **TEST/LIVE**, command will provide URL to approve your client, and then you need to
      copy and search Pairing Code on bitpay server & approve it.

- You are all set. :golf:

## Examples

### Invoices

Invoices are time-sensitive payment requests addressed to specific buyers. An invoice has a fixed price, typically
denominated in fiat currency. It also has an equivalent price in the supported cryptocurrencies, calculated by BitPay,
at a locked exchange rate with an expiration time of 15 minutes.

#### Create Invoice and checkout

Let's go step by step.

- Create your internal system order and then initiate the workflow by creating bitpay invoice as below,

```php
use Illuminate\Support\Facades\Redirect;
use Vrajroham\LaravelBitpay\LaravelBitpay;

public function createInvoice()
{
    // Create instance of invoice
    $invoice = LaravelBitpay::Invoice();

    // Set item details (Only 1 item)
    $invoice->setItemDesc('Photo');
    $invoice->setItemCode('sku-1');
    $invoice->setPrice(1);

    // Please make sure you provide unique orderid for each invoice
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
    $invoice->setCurrency(Currency::USD); // Always use the BitPay Currency model to prevent typos

    // Set redirect url to get back after completing the payment. GET Request
    $invoice->setRedirectURL(route('bitpay-redirect-back'));

    // Optional config. setNotificationUrl()
    // By default, package handles webhooks and dispatches BitpayWebhookReceived event as described above.
    // If you want to handle webhooks your way, you can provide url below. 
    // If handled manually, BitpayWebhookReceived event will not be dispatched.    
    $invoice->setNotificationUrl('Your custom POST route to handle webhooks');

    // Create invoice on bitpay server.
    $invoice = LaravelBitpay::createInvoice($invoice);

    // You can save invoice ID from server, for your your reference
    $invoiceId = $invoice->getId();

    $paymentUrl = $invoice->getUrl();
    // Redirect user to following URL for payment approval.
    return Redirect::to($paymentUrl);
}
```

- Once you get the invoice url for payment, redirect user to that particular url. Use will see something like below on
  browser.

<p align="center"><a href="https://ibb.co/X8JhftX"><img src="https://i.ibb.co/FV7Skz6/Screenshot-2019-11-03-at-5-31-33-PM.png" alt="Screenshot-2019-11-03-at-5-31-33-PM" border="0"></a></p>

- Next, open your bitpay wallet, scan the code and make a payment. Something like below,

<p align="center"><a href="https://ibb.co/FY4G4gZ"><img src="https://i.ibb.co/WzvSvg8/IMG-3639.png" alt="IMG-3639" border="1"></a></p>

- Once payment is done, success screen will be displayed and user needs to click on **Return to Shop Name**.

<p align="center"><a href="https://ibb.co/8M21RBv"><img src="https://i.ibb.co/Jn2Dbd6/Screenshot-2019-11-03-at-5-32-05-PM.png" alt="Screenshot-2019-11-03-at-5-32-05-PM" border="0"></a></p>

- Payment done! Now you need to wait for webhook to get notification regarding status of payment.

#### Retrieve an existing invoice

```php
$invoice = LaravelBitpay::getInvoice('invoiceId_sGsdVsgheF');
```

#### Retrieve a list of existing invoices

In this example we retrieve all MTD (Month-To-Date) invoices:

```php
$startDate = date('Y-m-d', strtotime('first day of this month'));
$endDate = date('Y-m-d');

$invoices = LaravelBitpay::getInvoices($startDate, $endDate);
```

#### Refund an invoice

The item Jane purchased was dead on arrival. Give back the lady her crypto:

```php
$invoice = LaravelBitpay::getInvoice('invoiceId_sGsdVsgheF');

$refundRequested = LaravelBitpay::createRefund($invoice, 'jane.doe@example.com', 0.016, 'ETH');

if ($refundRequested) {
    // Don't just sit there. Do something!
}
```

#### Retrieve a refund request

Let's periodically retrieve (and check the status of) Jane's refund request:

```php
$invoice = LaravelBitpay::getInvoice('invoiceId_sGsdVsgheF');

$refund = LaravelBitpay::getRefund($invoice, 'refundId_pUdhjwGjsg');
```

#### Retrieve all refund requests on an invoice

In this example we retrieve all refund requests related to Jane's invoice:

```php
$invoice = LaravelBitpay::getInvoice('invoiceId_sGsdVsgheF');

$refundRequests = LaravelBitpay::getRefunds($invoice);
```

#### Cancel a refund request

Turns out Jane didn't initially follow the instruction manual. The item works and she no longer wants a refund:

```php
$invoice = LaravelBitpay::getInvoice('invoiceId_sGsdVsgheF');

$refundRequestCancelled = LaravelBitpay::cancelRefund($invoice->getId(), 'refundId_pUdhjwGjsg');
```

### Bills

Bills are payment requests addressed to specific buyers. Bill line items have fixed prices, typically denominated in
fiat currency.

#### Create a bill

In the following example, we create a bill that's due in 10 days:

```php
// Initialize Bill
$billData = LaravelBitpay::Bill();
$billData->setNumber('bill1234-EFGH');
$billData->setCurrency(Currency::USD); // Always use the BitPay Currency model to prevent typos
$dueDate = date('Y-m-d\TH:i:s\Z', strtotime('+10 days')); // ISO-8601 formatted date
$billData->setDueDate($dueDate);
$billData->setPassProcessingFee(true); // Let the recipient shoulder BitPay's processing fee

// Prepare Bill recipient's data
$billData->setName('John Doe');
$billData->setAddress1('2630 Hegal Place');
$billData->setAddress2('Apt 42');
$billData->setCity('Alexandria');
$billData->setState('VA');
$billData->setZip(23242);
$billData->setCountry('US');
$billData->setEmail('john.doe@example.com');
$billData->setCc(['jane.doe@example.com']);
$billData->setPhone('555-123-456');

// Prepare Bill's line item(s)
$itemUno = LaravelBitpay::Item();
$itemUno->setDescription('Squid Game "Front Man" Costume');
$itemUno->setPrice(49.99);
$itemUno->setQuantity(2);

$itemDos = LaravelBitpay::Item();
$itemDos->setDescription('GOT "House Stark" Sterling Silver Pendant');
$itemDos->setPrice(35);
$itemDos->setQuantity(1);

$billData->setItems([$itemUno, $itemDos]);

// Create Bill
$bill = LaravelBitpay::createBill($billData);

// Store the Bill's BitPay ID and URL for future reference
$billId = $bill->getId();
$billPaymentUrl = $bill->getUrl();

// OR

// Redirect the recipient to BitPay's hosted Bill payment page
Redirect::to($billPaymentUrl);
```

#### Retrieve a bill

```php
$bill = LaravelBitpay::getBill('bill1234-EFGH');
```

#### Retrieve a list of existing bills

You can narrow down the retrieved list by specifying a Bill status:

```php
// Status can be "draft", "sent", "new", "paid", or "complete"
$status = 'paid';

$paidBills = LaravelBitpay::getBills($status);
```

#### Update a bill

We managed to upsell a product to our client. Let's add an extra line item to their existing Bill:

```php
$existingBill = LaravelBitpay::getBill('bill1234-EFGH');
$existingItems = $existingBill->getItems();

$billData = LaravelBitpay::Bill();

$itemTres = LaravelBitpay::Item();
$itemTres->setDescription('The Tomorrow War "White Spike" Life-Size Wax Figure');
$itemTres->setPrice(189.99);
$itemTres->setQuantity(1);

$billData->setItems(array_merge($existingItems, [$itemTres]));

// Update Bill
$updatedBill = LaravelBitpay::updateBill($billData, 'bill1234-EFGH');
```

#### Deliver a bill via email

```php
$bill = LaravelBitpay::getBill('bill1234-EFGH');

$billId = $bill->getId();
$billToken = $bill->getToken();

$billDelivery = json_decode(LaravelBitpay::deliverBill($billId, $billToken));

if (isset($billDelivery->data) && $billDelivery->data == 'Success') {
    // Bill delivered successfully. Do something about that... or not.
}
```

### Currencies

Currencies are fiat currencies supported by BitPay.

#### Retrieve the supported currencies

In this example, we retrieve the list of supported BitPay Currency objects.

```php
$supportedCurrencies = LaravelBitpay::getCurrencies();
```

### Rates

Rates are exchange rates, representing the number of fiat currency units equivalent to one BTC.

#### Retrieve the exchange rate table maintained by BitPay

```php
$rates = LaravelBitpay::getRates();

$btcToUsdRate = $rates->getRate(Currency::USD); // Always use the BitPay Currency model to prevent typos
```

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
