<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Invoice\Invoice;

trait ManageInvoices
{
    /**
     * Get Bitpay Invoice instance.
     *
     * @link https://bitpay.com/api/#rest-api-resources-invoices-resource
     * @return Invoice
     */
    public static function Invoice(): Invoice
    {
        return new Invoice();
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
    ): array
    {
        return (new self())->client->getInvoices($dateStart, $dateEnd, $status, $orderId, $limit, $offset);
    }
}
