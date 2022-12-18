# LaravelBitPay

![LaravelBitPay Social Image](https://banners.beyondco.de/LaravelBitPay.png?theme=light&packageManager=composer+require&packageName=vrajroham%2Flaravel-bitpay&pattern=circuitBoard&style=style_1&description=Transact+in+Bitcoin%2C+Bitcoin+Cash+and+10%2B+other+BitPay-supported+cryptocurrencies+within+your+Laravel+application.&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)
[![Build Status](https://img.shields.io/travis/vrajroham/laravel-bitpay/master.svg?style=for-the-badge)](https://travis-ci.org/vrajroham/laravel-bitpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/vrajroham/laravel-bitpay)
[![Total Downloads](https://img.shields.io/packagist/dt/vrajroham/laravel-bitpay.svg?style=for-the-badge)](https://packagist.org/packages/vrajroham/laravel-bitpay)

LaravelBitPay enables you and your business to transact in Bitcoin, Bitcoin Cash and 10+ other BitPay-supported
cryptocurrencies within your Laravel application.

> Requires PHP 7.4+

## :warning: Migration From v4 :warning:

If upgrading from v4, please follow [MIGRATION.md](./MIGRATION.md)

## Supported Resources

- :white_check_mark: [Invoices](https://bitpay.com/api/#rest-api-resources-invoices)
- :white_check_mark: [Refunds](https://bitpay.com/api/#rest-api-resources-refunds)
- :white_check_mark: [Bills](https://bitpay.com/api/#rest-api-resources-bills)
- :white_check_mark: [Subscriptions](https://bitpay.com/api/#rest-api-resources-subscriptions)
- :white_check_mark: [Settlements](https://bitpay.com/api/#rest-api-resources-settlements)
- :white_check_mark: [Ledgers](https://bitpay.com/api/#rest-api-resources-ledgers)
- :white_check_mark: [Recipients](https://bitpay.com/api/#rest-api-resources-recipients)
- :white_check_mark: [Payouts](https://bitpay.com/api/#rest-api-resources-payouts)
- :white_check_mark: [Currencies](https://bitpay.com/api/#rest-api-resources-currencies)
- :white_check_mark: [Rates](https://bitpay.com/api/#rest-api-resources-rates)

## Contents

- [Installation](#installation)
    + [Install Package](#install-package)
    + [Publish config file](#publish-config-file)
    + [Add configuration values](#add-configuration-values)
    + [Generate Key-Pair and API Token(s)](#generate-key-pair-and-api-tokens)
    + [Configure Webhooks (Optional)](#configure-webhooks-optional)
        + [1. Setup your webhook route](#1-setup-your-webhook-route)
        + [2. Setup your webhook listener](#2-setup-your-webhook-listener)
- [Examples](#examples)
    + [Invoices](#invoices)
        + [Create an invoice](#create-an-invoice)
        + [Retrieve an existing invoice](#retrieve-an-existing-invoice)
        + [Retrieve a list of existing invoices](#retrieve-a-list-of-existing-invoices)
    + [Refunds](#refunds)
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
    + [Subscriptions](#subscriptions)
        + [Create a subscription](#create-a-subscription)
        + [Retrieve a subscription](#retrieve-a-subscription)
        + [Retrieve a list of existing subscriptions](#retrieve-a-list-of-existing-subscriptions)
        + [Update a subscription](#update-a-subscription)
    + [Settlements](#settlements)
        + [Retrieve settlements](#retrieve-settlements)
        + [Retrieve a settlement](#retrieve-a-settlement)
        + [Fetch a reconciliation report](#fetch-a-reconciliation-report)
    + [Ledgers](#ledgers)
        + [Retrieve account balances](#retrieve-account-balances)
        + [Retrieve ledger entries](#retrieve-ledger-entries)
    + [Recipients](#recipients)
        + [Invite Recipients](#invite-recipients)
        + [Retrieve a recipient](#retrieve-a-recipient)
        + [Retrieve recipients by status](#retrieve-recipients-by-status)
        + [Update a recipient](#update-a-recipient)
        + [Remove a recipient](#remove-a-recipient)
        + [Request a recipient webhook to be resent](#request-a-recipient-webhook-to-be-resent)
    + [Payouts](#payouts)
        + [Create a payout](#create-a-payout)
        + [Create a payout batch](#create-a-payout-batch)
        + [Retrieve a payout](#retrieve-a-payout)
        + [Retrieve a payout batch](#retrieve-a-payout-batch)
        + [Retrieve payouts based on status](#retrieve-payouts-based-on-status)
        + [Retrieve payout batches based on status](#retrieve-payout-batches-based-on-status)
        + [Cancel a payout](#cancel-a-payout)
        + [Cancel a payout batch](#cancel-a-payout-batch)
        + [Request a payout webhook to be resent](#request-a-payout-webhook-to-be-resent)
        + [Request a payout batch webhook to be resent](#request-a-payout-batch-webhook-to-be-resent)
    + [Currencies](#currencies)
        + [Retrieve the supported currencies](#retrieve-the-supported-currencies)
    + [Rates](#rates)
        + [Retrieve the exchange rate table maintained by BitPay](#retrieve-the-exchange-rate-table-maintained-by-bitpay)
        + [Retrieve all the rates for a given cryptocurrency](#retrieve-all-the-rates-for-a-given-cryptocurrency)
        + [Retrieve the rate for a cryptocurrency / fiat pair](#retrieve-the-rate-for-a-cryptocurrency--fiat-pair)
- [Testing](#testing)
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

This will create a `laravel-bitpay.php` file inside your **config** directory.

### Add configuration values

Add the following keys to your `.env` file and update the values to match your
preferences ([read more about configuration](https://support.bitpay.com/hc/en-us/articles/115003001063-How-do-I-configure-the-PHP-BitPay-Client-Library-)):

```dotenv
BITPAY_PRIVATE_KEY_PATH=
BITPAY_NETWORK=testnet
BITPAY_KEY_STORAGE_PASSWORD=RandomPasswordForEncryption
BITPAY_ENABLE_MERCHANT=true
BITPAY_ENABLE_PAYOUT=false
BITPAY_MERCHANT_TOKEN=
BITPAY_PAYOUT_TOKEN=
``` 

### Generate Key-Pair and API Token(s)

The `laravel-bitpay:createkeypair` command generates a BitPay API Token and Pairing Code for each enabled facade:

```bash
php artisan laravel-bitpay:createkeypair
```

<center><img src="https://i.ibb.co/JvP3bQb/create-key-pair-command.png" title="Create Key-Pair Command" alt="Create Key-Pair Command"/></center>

> :information_source: By default, the command will use the (valid) existing private key located
> at `BITPAY_PRIVATE_KEY_PATH`.
> You may specify the `--fresh` or `-f` option to explicitly generate a fresh private key, from which tokens are
> derived.

After successful API Token generation, you will need to approve it by visiting the provided link.

:warning: **Note that the `payout` facade must be enabled on your BitPay merchant account before you can approve and use
the related API Token. This means you won't be able to perform actions on the [Recipients](#recipients)
and [Payouts](#payouts) resources. To enable Payouts
functionality, [Contact BitPay Support](https://bitpay.com/request-help/wizard?category=merchant).**

### Configure Webhooks (Optional)

BitPay resource status updates are completely based on webhooks (IPNs). LaravelBitPay is fully capable of automatically
handling webhook requests. Whenever a webhook is received from BitPay's server, `BitpayWebhookReceived` event is
dispatched. Take the following steps to configure your application for webhook listening:

#### 1. Setup your webhook route

Resolve the `bitPayWebhook` route macro in your desired route file (`web.php` is recommended). The macro accepts a
single, optional argument, which is the URI path at which you want to receive BitPay webhook `POST` requests. If none is
provided, it defaults to `'laravel-bitpay/webhook'`:

```php
// ... your other 'web' routes

Route::bitPayWebhook(); // https://example.com/laravel-bitpay/webhook

// OR ...

Route::bitPayWebhook('receive/webhooks/here'); // https://example.com/receive/webhooks/here
```

> :information_source: To retrieve your newly created webhook route anywhere in your application,
> use: `route('laravel-bitpay.webhook.capture')`

LaravelBitPay also offers the convenience of auto-populating your configured webhook url on applicable resources.
Specifically when:

- [Creating an Invoice](#create-an-invoice)
- [Inviting Recipients](#invite-recipients)
- Creating a [Payout](#create-a-payout)/[Payout Batch](#create-a-payout-batch)

You may enable this feature per-resource by uncommenting the respective entry within the `auto_populate_webhook` array
found in the `laravel-bitpay.php` config file.

:warning: **If a value is manually set, most likely via `$resource->setNotificationURL('https://...')` during resource
initialization, auto-population is overridden.**

#### 2. Setup your webhook listener

Start by generating an event listener:

```bash
php artisan make:listener BitPayWebhookListener --event=\Vrajroham\LaravelBitpay\Events\BitpayWebhookReceived
```

Then, implement your application-specific logic in the `handle(...)` function of the generated listener.

In the following example, we assume you have previously [created an invoice](#create-an-invoice), storing its `token`
on your internal `Order` model:

```php
/**
 * Handle the webhook event, keeping in mind that the server doesn't trust the client (us), so neither should
 * we trust the server. Well, trust, but verify.
 *
 * @param BitpayWebhookReceived $event
 * @return void
 */
public function handle(BitpayWebhookReceived $event)
{
    // Extract event payload
    $payload = $event->payload;

    // Verify that webhook is for a BitPay Invoice resource
    if (in_array($payload['event']['code'], array_keys(BitPayConstants::INVOICE_WEBHOOK_CODES))) {
        try {
            // Do not trust the webhook data. Pull the referenced Invoice from BitPay's server
            $invoice = LaravelBitpay::getInvoice($payload['data']['id']);

            // Now grab our internal Order instance for this supposed Invoice
            $order = Order::whereOrderId($invoice->getOrderId())->first();

            // Verify Invoice token, previously stored at time of creation
            // Learn more at: https://github.com/vrajroham/laravel-bitpay#create-an-invoice
            if ($invoice->getToken() !== $order->invoice_token) {
                return;
            }

            $invoice_status = $invoice->getStatus();

            // Do something about the new Invoice status
            if ($invoice_status === InvoiceStatus::Paid) {
                $order->update(['status' => $invoice_status]) && OrderStatusChanged::dispatch($order->refresh());
            }
        } catch (BitPayException $e) {
            Log::error($e);
        }
    }
}
```

Finally, map your listener to the `BitpayWebhookReceived` event inside the `$listen` array of
your `EventServiceProvider`:

```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    // ... other event-listener mappings
    BitpayWebhookReceived::class => [
        BitPayWebhookListener::class,
    ],
]
```

## Examples

### Invoices

Invoices are time-sensitive payment requests addressed to specific buyers. An invoice has a fixed price, typically
denominated in fiat currency. It also has an equivalent price in the supported cryptocurrencies, calculated by BitPay,
at a locked exchange rate with an expiration time of 15 minutes.

#### Create an invoice

In this example we assume you've already created an instance of your equivalent `Order` model, to be associated with
this Invoice (referred to as `$order`):

```php
// Create instance of Invoice
$invoice = LaravelBitpay::Invoice(449.99, Currency::USD); // Always use the BitPay Currency model to prevent typos

// Set item details (Only 1 item per Invoice)
$invoice->setItemDesc('You "Joe Goldberg" Life-Size Wax Figure');
$invoice->setItemCode('sku-1234');
$invoice->setPhysical(true); // Set to false for digital/virtual items

// Ensure you provide a unique OrderId for each Invoice
$invoice->setOrderId($order->order_id);

// Create Buyer Instance
$buyer = LaravelBitpay::Buyer();
$buyer->setName('John Doe');
$buyer->setEmail('john.doe@example.com');
$buyer->setAddress1('2630 Hegal Place');
$buyer->setAddress2('Apt 42');
$buyer->setLocality('Alexandria');
$buyer->setRegion('VA');
$buyer->setPostalCode(23242);
$buyer->setCountry('US');
$buyer->setNotify(true); // Instructs BitPay to email Buyer about their Invoice

// Attach Buyer to Invoice
$invoice->setBuyer($buyer);

// Set URL that Buyer will be redirected to after completing the payment, via GET Request
$invoice->setRedirectURL(route('your-bitpay-success-url'));
// Set URL that Buyer will be redirected to after closing the invoice or after the invoice expires, via GET Request
$invoice->setCloseURL(route('your-bitpay-cancel-url'));
$invoice->setAutoRedirect(true);

// Optional. Learn more at: https://github.com/vrajroham/laravel-bitpay#1-setup-your-webhook-route
$invoice->setNotificationUrl('https://example.com/your-custom-webhook-url');

// This is the recommended IPN format that BitPay advises for all new implementations
$invoice->setExtendedNotifications(true);

// Create invoice on BitPay's server
$invoice = LaravelBitpay::createInvoice($invoice);

$invoiceId = $invoice->getId();
$invoiceToken = $invoice->getToken();

// You should save Invoice ID and Token, for your reference
$order->update(['invoice_id' => $invoiceId, 'invoice_token' => $invoiceToken]);

// Redirect user to the Invoice's hosted URL to complete payment
$paymentUrl = $invoice->getUrl();
return Redirect::to($paymentUrl);
```

> :information_source: It is highly recommended you store the Invoice ID and Token on your internal model(s). The token
> can come in handy when verifying webhooks.

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

#### Request an Invoice webhook to be resent

```php
// True if the webhook has been resent for the current invoice status, false otherwise.
$webhookResent = LaravelBitpay::requestInvoiceWebhook('invoiceId_sGsdVsgheF');
```

### Refunds

Refund requests are full or partial refunds associated to an invoice. Fully paid invoices can be refunded via the
merchant's authorization to issue a refund, while underpaid and overpaid invoices are automatically executed by BitPay
to issue the underpayment or overpayment amount to the customer.

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
$dueDate = date(BitPayConstants::DATETIME_FORMAT, strtotime('+10 days')); // ISO-8601 formatted date
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
$itemUno = LaravelBitpay::BillItem();
$itemUno->setDescription('Squid Game "Front Man" Costume');
$itemUno->setPrice(49.99);
$itemUno->setQuantity(2);

$itemDos = LaravelBitpay::BillItem();
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
$paidBills = LaravelBitpay::getBills(BillStatus::Paid);
```

#### Update a bill

We managed to upsell a product to our client. Let's add an extra line item to their existing Bill:

```php
$existingBill = LaravelBitpay::getBill('bill1234-EFGH');
$existingItems = $existingBill->getItems();

$billData = LaravelBitpay::Bill();
$billData->setId($existingBill->getId());

$itemTres = LaravelBitpay::BillItem();
$itemTres->setDescription('The Tomorrow War "White Spike" Life-Size Wax Figure');
$itemTres->setPrice(189.99);
$itemTres->setQuantity(1);

$billData->setItems(array_merge($existingItems, [$itemTres]));

// Update Bill
$updatedBill = LaravelBitpay::updateBill($billData, $billData->getId());
```

#### Deliver a bill via email

```php
$bill = LaravelBitpay::getBill('bill1234-EFGH');

$billDelivered = LaravelBitpay::deliverBill($bill->getId(), $bill->getToken());

if ($billDelivered) {
    // Bill delivered successfully. Do something about that... or not.
}
```

### Subscriptions

Subscriptions are repeat billing agreements with specific buyers. BitPay sends bill emails to buyers identified in
active subscriptions according to the specified schedule.

#### Create a subscription

Let's create a subscription that's delivered on the 28th of each month and due on the first of the following month, at 9
AM, respectively:

```php
// Initialize Subscription
$subscriptionData = LaravelBitpay::Subscription();
$subscriptionData->setSchedule(BitPayConstants::SUBSCRIPTION_SCHEDULE_MONTHLY);

// Optional recurring bill data
$billData = [
    'number'            => 'subscription1234-ABCD',
    'name'              => 'John Doe',
    'address1'          => '2630 Hegal Place',
    'address2'          => 'Apt 42',
    'city'              => 'Alexandria',
    'state'             => 'VA',
    'zip'               => 23242,
    'country'           => 'US',
    'cc'                => ['jane.doe@example.com'],
    'phone'             => '555-123-456',
    'passProcessingFee' => true,
];

$dueDate = date(BitPayConstants::DATETIME_FORMAT, strtotime('first day of next month 9 AM'));

$billItems = array(
    LaravelBitpay::SubscriptionItem(100.00, 1, 'Web Hosting - 4 CPUs | 16GB Memory | 400GB SSD'),
    LaravelBitpay::SubscriptionItem(80.00, 1, 'Basic Website Maintenance'),
);

// Autofill optional bill data
$mapper = new JsonMapper();
$billData = $mapper->map(
    $billData,
    LaravelBitpay::BillData(
        Currency::USD, // Always use the BitPay Currency model to prevent typos
        'john.doe@example.com',
        $dueDate,
        $billItems
    )
);

$subscriptionData->setBillData($billData);

// A little wizardry to always get the 28th day of the current month (leap year safe)
$deliveryDate = strtotime('first day of this month 9 AM');
$deliveryDate = new \DateTime("@$deliveryDate");
$deliveryDate = $deliveryDate->modify('+27 days')->getTimestamp();
$deliveryDate = date(BitPayConstants::DATETIME_FORMAT, $deliveryDate);

$subscriptionData->setNextDelivery($deliveryDate);

// Create the Subscription on BitPay
$subscription = LaravelBitpay::createSubscription($subscriptionData);

// You may then store the Subscription ID for future reference
$subscriptionId = $subscription->getId();
```

#### Retrieve a subscription

```php
$subscription = LaravelBitpay::getSubscription('6gqe8y5mkc5Qx2a9zmspgx');
```

#### Retrieve a list of existing subscriptions

You can narrow down the retrieved list by specifying a Subscription status:

```php
$activeSubscriptions = LaravelBitpay::getSubscriptions(SubscriptionStatus::Active);
```

#### Update a subscription

In this example we activate a Subscription by updating its status:

```php
$subscriptionData = LaravelBitpay::Subscription();
$subscriptionData->setId('6gqe8y5mkc5Qx2a9zmspgx');
$subscriptionData->setStatus(SubscriptionStatus::Active);

$activatedSubscription = LaravelBitpay::updateSubscription($subscriptionData, $subscriptionData->getId());
```

### Settlements

Settlements are transfers of payment profits from BitPay to bank accounts and cryptocurrency wallets owned by merchants,
partners, etc.

#### Retrieve settlements

In this example we retrieve completed YTD (Year-To-Date) settlements denominated in Euros (EUR). We only need 100
records, starting from the 5th one:

```php
$startDate = date('Y-m-d', strtotime('first day of this year'));
$endDate = date('Y-m-d');

$eurSettlements = LaravelBitpay::getSettlements(
        Currency::EUR,
        $startDate,
        $endDate,
        BitPayConstants::SETTLEMENT_STATUS_COMPLETED,
        100,
        4
    );
```

#### Retrieve a settlement

```php
$settlement = LaravelBitpay::getSettlement('settlementId_uidwb3668');
```

#### Fetch a reconciliation report

A reconciliation report is a detailed report of the activity within the settlement period, in order to reconcile
incoming settlements from BitPay.

```php
$settlement = LaravelBitpay::getSettlement('settlementId_uidwb3668');

$settlementReport = LaravelBitpay::getSettlementReconciliationReport($settlement);
```

### Ledgers

Ledgers are records of money movement.

#### Retrieve account balances

```php
$accountBalances = LaravelBitpay::getLedgers();
```

#### Retrieve ledger entries

In this example we retrieve MTD (Month-To-Date) ledger entries denominated in United States Dollars (USD).

```php
$startDate = date('Y-m-d', strtotime('first day of this month'));
$endDate = date('Y-m-d');

$usdLedgerEntries = LaravelBitpay::getLedger(Currency::USD, $startDate, $endDate);
```

### Recipients

The Recipient resource allows a merchant to invite their clients to signup for a BitPay personal account.

:warning: **Your BitPay Merchant account must be authorized for Payouts functionality. To enable Payouts
functionality, [Contact BitPay Support](https://bitpay.com/request-help/wizard?category=merchant).**

#### Invite Recipients

```php
// Init individual recipients
$jane = LaravelBitpay::PayoutRecipient('jane.doe@example.com', 'Plain Jane');
$ada = LaravelBitpay::PayoutRecipient('ada@cardano.org', 'Ada Lovelace');

// Optional. Learn more at https://github.com/vrajroham/laravel-bitpay#1-setup-your-webhook-route
$ada->setNotificationUrl('https://example.com/your-custom-webhook-url');

// Batch all individual recipients
$recipients = LaravelBitpay::PayoutRecipients([$jane, $ada]);

// Submit invites
$recipientsInvited = LaravelBitpay::invitePayoutRecipients($recipients);

// Do something with the returned invitees
foreach ($recipientsInvited as $recipient) {
    $recipientId = $recipient->getId();
    $recipientToken = $recipient->getToken();
    
    // ... store Recipient ID and Token somewhere persistent

    // Perform other desired actions
    \App\Events\LookOutForAnInviteEmail::dispatch($recipient->getEmail());
}
```

> :information_source: It is highly recommended you store the Recipient ID and Token on your internal model(s). The
> token can come in handy when verifying webhooks.

#### Retrieve a recipient

```php
$recipient = LaravelBitpay::getPayoutRecipient('recipientId_adaLovelace')
```

#### Retrieve recipients by status

In this example, we retrieve 100 recipients (starting from the 50th) that have passed the good 'ole Onfido ID
verification checks:

```php
$verifiedRecipients = LaravelBitpay::getPayoutRecipients(RecipientStatus::VERIFIED, 100, 49);
```

#### Update a recipient

```php
$recipient = LaravelBitpay::getPayoutRecipient('recipientId_adaLovelace');
$recipient->setLabel('Cardano To The Moon');

$updatedRecipient = LaravelBitpay::updatePayoutRecipient($recipient->getId(), $recipient);
```

#### Remove a recipient

```php
$recipientRemoved = LaravelBitpay::removePayoutRecipient('recipientId_janeDoe');
```

#### Request a recipient webhook to be resent

```php
// True if the webhook has been resent for the current recipient status, false otherwise.
$webhookResent = LaravelBitpay::requestPayoutRecipientWebhook('recipientId_adaLovelace');
```

### Payouts

Payouts are individual (or batches of) bitcoin payments to employees, customers, partners, etc.

:warning: **Your BitPay Merchant account must be authorized for Payouts functionality. To enable Payouts
functionality, [Contact BitPay Support](https://bitpay.com/request-help/wizard?category=merchant).**

#### Create a payout

Let's assume Ada Lovelace accepted our [invitation](#invite-recipients). In this example, we schedule her an individual
payout for a 5-star rating she received from a referral:

```php
// Initialize a Payout
// Pay Ada in USD and record it on the BTC ledger
$payoutData = LaravelBitpay::Payout(50.00, Currency::USD, Currency::BTC); 

// Set Payout details
$payoutData->setRecipientId('recipientId_adaLovelace'); // From previously invited Recipient
$payoutData->setReference('1234'); // Uniquely identifies an equivalent payout entry in your system
$payoutData->setLabel('5-Star Bonus Affiliate Payment #1234 for Dec 2021');
$payoutData->setEffectiveDate('2021-12-31');

// Optional. Learn more at https://github.com/vrajroham/laravel-bitpay#1-setup-your-webhook-route
$payoutData->setNotificationURL('https://example.com/your-custom-webhook-url');

// Create Payout on BitPay's server
$payout = LaravelBitpay::createPayout($payoutData);

$payoutId = $payout->getId();
$payoutToken = $payout->getToken();

// ... store Payout ID and Token somewhere persistent
```

> :information_source: It is highly recommended you store the Payout ID and Token on your internal model(s). The token
> can come in handy when verifying webhooks.

#### Create a payout batch

Let's pay our two top-tier affiliates for all their hard work, batching both payments into a single API call, for the
efficiency of it.

```php
// Initialize a Payout Batch
$payoutBatchData = LaravelBitpay::PayoutBatch(Currency::USD); // Pay recipients in USD
$payoutBatchData->setLedgerCurrency(Currency::ETH); // Record the payout batch on the ETH ledger
$payoutBatchData->setAmount(500.00);
$payoutBatchData->setReference('Aff_Jan-Feb_2022'); // Uniquely identifies an equivalent payout batch in your system
$payoutBatchData->setLabel('Affiliate Payments for Jan-Feb 2022');
$payoutBatchData->setEffectiveDate('2022-02-28');

// Optional. Learn more at https://github.com/vrajroham/laravel-bitpay#1-setup-your-webhook-route
$payoutBatchData->setNotificationURL('https://example.com/your-custom-webhook-url');

// Define Instruction(s)
$payJane = LaravelBitpay::PayoutInstruction(
    250.00,
    RecipientReferenceMethod::RECIPIENT_ID,
    'recipientId_janeDoe'
);
$payJane->setLabel('Affiliate Payment #1234 for Jan-Feb 2022');

$payAda = LaravelBitpay::PayoutInstruction(
    250.00,
    RecipientReferenceMethod::RECIPIENT_ID,
    'recipientId_adaLovelace'
);
$payAda->setLabel('Affiliate Payment #5678 for Jan-Feb 2022');

// Attach Instruction(s) to Payout Batch
$payoutBatchData->setInstructions([$payJane, $payAda]);

// Create Payout Batch on BitPay's server
$payoutBatch = LaravelBitpay::createPayoutBatch($payoutBatchData);

$payoutBatchId = $payoutBatch->getId();
$payoutBatchToken = $payoutBatch->getToken();

// ... store Payout Batch ID and Token somewhere persistent
```

> :information_source: It is highly recommended you store the Payout Batch ID and Token on your internal model(s).
> The token can come in handy when verifying webhooks.

#### Retrieve a payout

```php
$payout = LaravelBitpay::getPayout('payoutId_jws43dbnfpg');
```

#### Retrieve a payout batch

```php
$payoutBatch = LaravelBitpay::getPayoutBatch('payoutBatchId_jws43dbnfpg');
```

#### Retrieve payouts based on status

In this example, we retrieve all completed, Year-To-Date (YTD) payouts.

```php
$startDate = date('Y-m-d', strtotime('first day of this year'));
$endDate   = date('Y-m-d');

$completedPayouts = LaravelBitpay::getPayouts($startDate, $endDate, PayoutStatus::Complete);
```

#### Retrieve payout batches based on status

In this example, we retrieve all cancelled, Year-To-Date (YTD) payout batches.

```php
$startDate = date('Y-m-d', strtotime('first day of this year'));
$endDate   = date('Y-m-d');

$cancelledPayoutBatches = LaravelBitpay::getPayoutBatches($startDate, $endDate, PayoutStatus::Cancelled);
```

#### Cancel a payout

```php
$payoutCancelled = LaravelBitpay::cancelPayout('payoutId_jws43dbnfpg');
```

#### Cancel a payout batch

```php
$payoutBatchCancelled = LaravelBitpay::cancelPayoutBatch('payoutBatchId_jws43dbnfpg');
```

#### Request a payout webhook to be resent

```php
// True if the webhook has been resent for the current payout status, false otherwise.
$webhookResent = LaravelBitpay::requestPayoutWebhook('payoutId_jws43dbnfpg');
```

#### Request a payout batch webhook to be resent

```php
// True if the webhook has been resent for the current payout batch status, false otherwise.
$webhookResent = LaravelBitpay::requestPayoutBatchWebhook('payoutBatchId_jws43dbnfpg');
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

#### Retrieve all the rates for a given cryptocurrency

```php
$ethRates = LaravelBitpay::getCurrencyRates(Currency::ETH);

$ethToUsdRate = $ethRates->getRate(Currency::USD);
```

#### Retrieve the rate for a cryptocurrency / fiat pair

```php
$dogeToUsdRate = LaravelBitpay::getCurrencyPairRate(Currrency::DOGE, Currency::USD);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email vaibhavraj@vrajroham.me or iamalexstewart@gmail.com instead of
using the issue tracker.

## Credits

- [Vaibhavraj Roham](https://github.com/vrajroham)
- [Alex Stewart](https://github.com/alexstewartja)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
