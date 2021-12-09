<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Bill\Bill;
use BitPaySDK\Model\Bill\Item;


/**
 * Bills are payment requests addressed to specific buyers.
 * Bill line items have fixed prices, typically denominated in fiat currency.
 *
 * @link https://bitpay.com/api/#rest-api-resources-bills-resource
 */
trait ManageBills
{
    /**
     * Get BitPay Bill instance.
     *
     * @param string|null $number   A bill number for tracking purposes.
     * @param string|null $currency The three digit currency code used to compute the bill's crypto amount.
     * @param string|null $email    The email address of the receiver for this bill.
     * @param Item[]|null $items    The list of BillItems to add to this bill.
     *
     * @return Bill
     */
    public static function Bill(
        string $number = null,
        string $currency = null,
        string $email = null,
        array  $items = null): Bill
    {
        return new Bill($number, $currency, $email, $items);
    }

    /**
     * Get BitPay Bill Item instance.
     *
     * @return Item  A BitPay Bill Item
     */
    public static function BillItem(): Item
    {
        return new Item();
    }

    /**
     * Create a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-create-a-bill
     *
     * @param $bill Bill A Bill object with request parameters defined.
     *
     * @return Bill A BitPay generated Bill object.
     * @throws BitPayException BitPayException class
     */
    public static function createBill(Bill $bill): Bill
    {
        return (new self())->client->createBill($bill);
    }

    /**
     * Retrieve a BitPay bill by its id.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-retrieve-a-bill
     *
     * @param $billId      string The id of the bill to retrieve.
     *
     * @return Bill A BitPay Bill object.
     * @throws BitPayException BitPayException class
     */
    public static function getBill(string $billId): Bill
    {
        return (new self())->client->getBill($billId);
    }

    /**
     * Retrieve a collection of BitPay bills.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-retrieve-bills-by-status
     *
     * @param $status string|null The status to filter the bills.
     *
     * @return Bill[] A list of BitPay Bill objects.
     * @throws BitPayException BitPayException class
     */
    public static function getBills(string $status = null): array
    {
        return (new self())->client->getBills($status);
    }

    /**
     * Update a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-update-a-bill
     *
     * @param $bill   Bill A Bill object with the parameters to update defined.
     * @param $billId string The ID of the Bill to update.
     *
     * @return Bill An updated Bill object.
     * @throws BitPayException BitPayException class
     */
    public static function updateBill(Bill $bill, string $billId): Bill
    {
        return (new self())->client->updateBill($bill, $billId);
    }

    /**
     * Deliver a BitPay Bill.
     *
     * @link https://bitpay.com/api/#rest-api-resources-bills-deliver-a-bill-via-email
     *
     * @param $billId      string The id of the requested bill.
     * @param $billToken   string The token of the requested bill.
     *
     * @return bool True if the bill has been delivered, false otherwise.
     * @throws BitPayException BitPayException class
     */
    public static function deliverBill(string $billId, string $billToken): bool
    {
        return strtolower((new self())->client->deliverBill($billId, $billToken)) === "success";
    }
}
