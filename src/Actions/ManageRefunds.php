<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\RefundCancellationException;
use BitPaySDK\Model\Invoice\Invoice;
use BitPaySDK\Model\Invoice\Refund;


trait ManageRefunds
{

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
     * @throws BitPayException BitPayException class
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
     * @return Refund[] An array of BitPay refund object with the associated Refund object updated.
     * @throws BitPayException BitPayException class
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
     * @throws BitPayException BitPayException class
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
     * @throws RefundCancellationException RefundCancellationException class
     */
    public static function cancelRefund(string $invoiceId, Refund $refund): bool
    {
        return (new self())->client->cancelRefund($invoiceId, $refund);
    }
}
