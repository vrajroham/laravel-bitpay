<?php

namespace Vrajroham\LaravelBitpay;

use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;
use BitPaySDK\Model\Currency;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;
use BitPaySDK\Model\Rate\Rates;
use Vrajroham\LaravelBitpay\Traits\LaravelBitpayTrait;

class LaravelBitpay
{
    use LaravelBitpayTrait;

    public $client;
    public $config;

    /**
     * LaravelBitpay constructor.
     */
    public function __construct()
    {
        $this->authenticate();
    }

    /**
     * @link https://bitpay.com/api/#rest-api-resources-invoices-resource
     * @return \BitPaySDK\Model\Invoice\Invoice
     */
    public static function Invoice(): Invoice
    {
        return new Invoice();
    }

    /**
     * @return \BitPaySDK\Model\Invoice\Buyer
     */
    public static function Buyer(): Buyer
    {
        return new Buyer();
    }

    /**
     * Create a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-create-an-invoice
     * @param $invoice \BitPaySDK\Model\Invoice\Invoice An Invoice object with request parameters defined.
     * @return \BitPaySDK\Model\Invoice\Invoice $invoice A BitPay generated Invoice object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function createInvoice(Invoice $invoice): Invoice
    {
        if ('' == $invoice->getNotificationURL()) {
            $invoice->setNotificationURL(route('laravel-bitpay.webhook.capture'));
        }

        return (new self())->client->createInvoice($invoice);
    }

    /**
     * Retrieve a BitPay invoice by its id.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-retrieve-an-invoice
     * @param $invoiceId string The id of the invoice to retrieve.
     * @return \BitPaySDK\Model\Invoice\Invoice A BitPay Invoice object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getInvoice(string $invoiceId): Invoice
    {
        return (new self())->client->getInvoice($invoiceId);
    }

    /**
     * Retrieve a collection of BitPay invoices.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-retrieve-invoices-filtered-by-query
     * @param $dateStart string The start of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $dateEnd   string The end of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $status    string|null The invoice status you want to query on.
     * @param $orderId   string|null The optional order id specified at time of invoice creation.
     * @param $limit     int|null Maximum results that the query will return (useful for paging results).
     * @param $offset    int|null Number of results to offset (ex. skip 10 will give you results starting with the 11th
     *                   result).
     * @return array     A list of BitPay Invoice objects.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getInvoices(
        string $dateStart,
        string $dateEnd,
        string $status = null,
        string $orderId = null,
        int    $limit = null,
        int    $offset = null
    ): array
    {
        return (new self())->client->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * @return \BitPaySDK\Model\Invoice\Refund
     */
    public static function Refund(): Refund
    {
        return new Refund();
    }

    /**
     * Create a BitPay refund.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-refund-an-invoice
     * @param $invoice          \BitPaySDK\Model\Invoice\Invoice A BitPay invoice object for which a refund request should be made.  Must have
     *                          been obtained using the merchant facade.
     * @param $refundEmail      string The email of the buyer to which the refund email will be sent
     * @param $amount           float The amount of money to refund. If zero then a request for 100% of the invoice
     *                          value is created.
     * @param $currency         string The three digit currency code specifying the exchange rate to use when
     *                          calculating the refund bitcoin amount. If this value is "BTC" then no exchange rate
     *                          calculation is performed.
     * @return bool True if the refund was successfully created, false otherwise.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function createRefund(
        Invoice $invoice,
        string  $refundEmail,
        float   $amount,
        string  $currency
    ): bool
    {
        return (new self())->client->createRefund($invoice, $refundEmail, $amount, $currency);
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-retrieve-all-refund-requests-on-an-invoice
     * @param $invoice  \BitPaySDK\Model\Invoice\Invoice The BitPay invoice having the associated refunds.
     * @return array An array of BitPay refund object with the associated Refund object updated.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getRefunds(Invoice $invoice): array
    {
        return (new self())->client->getRefunds($invoice);
    }

    /**
     * Retrieve a previously made refund request on a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-retrieve-a-refund-request
     * @param $invoice  \BitPaySDK\Model\Invoice\Invoice The BitPay invoice having the associated refund.
     * @param $refundId string The refund id for the refund to be updated with new status.
     * @return Refund A BitPay refund object with the associated Refund object updated.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getRefund(Invoice $invoice, string $refundId): Refund
    {
        return (new self())->client->getRefund($invoice, $refundId);
    }

    /**
     * Cancel a previously submitted refund request on a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-cancel-a-refund-request
     * @param $invoiceId string The refund id for the refund to be canceled.
     * @param $refund    \BitPaySDK\Model\Invoice\Refund The BitPay invoice having the associated refund to be canceled.
     *                   Must have been obtained using the merchant facade.
     * @return bool True if the refund was successfully canceled, false otherwise.
     * @throws \BitPaySDK\Exceptions\RefundCancellationException RefundCancellationException class
     */
    public static function cancelRefund(string $invoiceId, Refund $refund): bool
    {
        return (new self())->client->cancelRefund($invoiceId, $refund);
    }

    /**
     * Bills are payment requests addressed to specific buyers.
     * Bill line items have fixed prices, typically denominated in fiat currency.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-resource
     * @return \BitPaySDK\Model\Bill\Bill
     */
    public static function Bill(): Bill
    {
        return new Bill();
    }

    /**
     * @return \BitPaySDK\Model\Bill\Item
     */
    public static function Item(): Item
    {
        return new Item();
    }

    /**
     * Create a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-create-a-bill
     * @param $bill \BitPaySDK\Model\Bill\Bill A Bill object with request parameters defined.
     * @return \BitPaySDK\Model\Bill\Bill A BitPay generated Bill object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function createBill(Bill $bill): Bill
    {
        return (new self())->client->createBill($bill);
    }

    /**
     * Retrieve a BitPay bill by its id.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-retrieve-a-bill
     * @param $billId      string The id of the bill to retrieve.
     * @return \BitPaySDK\Model\Bill\Bill A BitPay Bill object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getBill(string $billId): Bill
    {
        return (new self())->client->getBill($billId);
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-retrieve-bills-by-status
     * @param $status string|null The status to filter the bills.
     * @return array A list of BitPay Bill objects.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getBills(string $status = null): array
    {
        return (new self())->client->getBills($status);
    }

    /**
     * Update a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-update-a-bill
     * @param $bill   \BitPaySDK\Model\Bill\Bill A Bill object with the parameters to update defined.
     * @param $billId string The Id of the Bill to update.
     * @return \BitPaySDK\Model\Bill\Bill An updated Bill object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function updateBill(Bill $bill, string $billId): Bill
    {
        return (new self())->client->updateBill($bill, $billId);
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-deliver-a-bill-via-email
     * @param $billId      string The id of the requested bill.
     * @param $billToken   string The token of the requested bill.
     * @return string A response status returned from the API.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function deliverBill(string $billId, string $billToken): string
    {
        return (new self())->client->deliverBill($billId, $billToken);
    }

    /**
     * @param string|null $code
     *
     * @return \BitpaySDK\Model\Currency
     * @link https://bitpay.com/api/#rest-api-resources-currencies
     */
    public static function Currency(string $code = null): Currency
    {
        $currency = new Currency();
        if ($code) {
            $currency->setCode($code);
        }
        return $currency;
    }

    /**
     * Fetch the supported currencies.
     *
     * @link https://bitpay.com/api/#rest-api-resources-currencies-retrieve-the-supported-currencies
     * @return array     A list of supported BitPay Currency objects.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getCurrencies(): array
    {
        return (new self())->client->getCurrencies();
    }

    /**
     * Retrieve the exchange rate table maintained by BitPay.
     *
     * @link https://bitpay.com/bitcoin-exchange-rates
     * @return \BitPaySDK\Model\Rate\Rates A Rates object populated with the BitPay exchange rate table.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getRates(): Rates
    {
        return (new self())->client->getRates();
    }

//    TODO: Implement the following if/when upstream gets merged: https://github.com/bitpay/php-bitpay-client-v2/pull/67
//    /**
//     * Retrieve all the rates for a given cryptocurrency
//     *
//     * @link https://bitpay.com/api/#rest-api-resources-rates-retrieve-all-the-rates-for-a-given-cryptocurrency
//     * @param string $baseCurrency The cryptocurrency for which you want to fetch the rates.
//     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
//     * @return \BitPaySDK\Model\Rate\Rates A Rates object populated with the currency rates for the requested baseCurrency.
//     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
//     */
//    public static function getCurrencyRates(string $baseCurrency): Rates
//    {
//        return (new self())->client->getCurrencyRates($baseCurrency);
//    }
//
//    /**
//     * Retrieve the rate for a cryptocurrency / fiat pair
//     *
//     * @link https://bitpay.com/api/#rest-api-resources-rates-retrieve-the-rates-for-a-cryptocurrency-fiat-pair
//     * @param string $baseCurrency The cryptocurrency for which you want to fetch the fiat-equivalent rate.
//     *                             Current supported values are BTC, BCH, ETH, XRP, DOGE and LTC
//     * @param string $currency The fiat currency for which you want to fetch the baseCurrency rate
//     * @return \BitPaySDK\Model\Rate\Rate A Rate object populated with the currency rate for the requested baseCurrency.
//     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
//     */
//    public static function getCurrencyPairRate(string $baseCurrency, string $currency): Rate
//    {
//        return (new self())->client->getCurrencyPairRate($baseCurrency, $currency);
//    }
}
