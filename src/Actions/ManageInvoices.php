<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;


trait ManageInvoices
{
    /**
     * Get BitPay Invoice instance.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-resource
     * @return Invoice
     */
    public static function Invoice(): Invoice
    {
        return new Invoice();
    }

    /**
     * @return Buyer
     */
    public static function Buyer(): Buyer
    {
        return new Buyer();
    }

    /**
     * Create a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-create-an-invoice
     *
     * @param $invoice Invoice An Invoice object with request parameters defined.
     *
     * @return Invoice $invoice A BitPay generated Invoice object.
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
     *
     * @param $invoiceId string The id of the invoice to retrieve.
     *
     * @return Invoice A BitPay Invoice object.
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
     *
     * @param $dateStart string The start of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $dateEnd   string The end of the date window to query for invoices. Format YYYY-MM-DD.
     * @param $status    string|null The invoice status you want to query on.
     * @param $orderId   string|null The optional order id specified at time of invoice creation.
     * @param $limit     int|null Maximum results that the query will return (useful for paging results).
     * @param $offset    int|null Number of results to offset (ex. skip 10 will give you results starting with the 11th result).
     *
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
    ): array {
        return (new self())->client->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }

    /**
     * Get BitPay refund instance.
     *
     * @return Refund
     */
    public static function Refund(): Refund
    {
        return new Refund();
    }

    /**
     * Create a BitPay refund.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-refund-an-invoice
     *
     * @param $invoice          Invoice A BitPay invoice object for which a refund request should be made.  Must have
     *                          been obtained using the merchant facade.
     * @param $refundEmail      string The email of the buyer to which the refund email will be sent
     * @param $amount           float The amount of money to refund. If zero then a request for 100% of the invoice
     *                          value is created.
     * @param $currency         string The three digit currency code specifying the exchange rate to use when
     *                          calculating the refund bitcoin amount. If this value is "BTC" then no exchange rate
     *                          calculation is performed.
     *
     * @return bool True if the refund was successfully created, false otherwise.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function createRefund(
        Invoice $invoice,
        string  $refundEmail,
        float   $amount,
        string  $currency
    ): bool {
        return (new self())->client->createRefund($invoice, $refundEmail, $amount, $currency);
    }

    /**
     * Retrieve all refund requests on a BitPay invoice.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-retrieve-all-refund-requests-on-an-invoice
     *
     * @param $invoice  Invoice The BitPay invoice having the associated refunds.
     *
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
     *
     * @param $invoice  Invoice The BitPay invoice having the associated refund.
     * @param $refundId string The refund id for the refund to be updated with new status.
     *
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
     *
     * @param $invoiceId string The refund id for the refund to be canceled.
     * @param $refund    Refund The BitPay invoice having the associated refund to be canceled.
     *                   Must have been obtained using the merchant facade.
     *
     * @return bool True if the refund was successfully canceled, false otherwise.
     * @throws \BitPaySDK\Exceptions\RefundCancellationException RefundCancellationException class
     */
    public static function cancelRefund(string $invoiceId, Refund $refund): bool
    {
        return (new self())->client->cancelRefund($invoiceId, $refund);
    }
}
