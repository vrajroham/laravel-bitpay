<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Model\Subscription\BillData;
use BitPaySDK\Model\Subscription\Item;
use BitPaySDK\Model\Subscription\Subscription;


trait ManageSubscriptions
{
    /**
     * Subscriptions are repeat billing agreements with specific buyers.
     * BitPay sends bill emails to buyers identified in active subscriptions according to the specified schedule.
     *
     * @link https://bitpay.com/api/#rest-api-resources-subscriptions
     * @return Subscription
     */
    public static function Subscription(): Subscription
    {
        return new Subscription();
    }

    /**
     * @param float  $price       Line item unit price for the corresponding Subscription's currency
     * @param int    $quantity    Line item number of units
     * @param string $description Line item description
     *
     * @return Item A BitPay Subscription Item
     */
    public static function SubscriptionItem(float $price = 0.0, int $quantity = 0, string $description = ""): Item
    {
        return new Item($price, $quantity, $description);
    }

    /**
     * @param string $currency ISO 4217 3-character currency code.
     *                         This is the currency associated with the items' price field.
     * @param string $email    Subscription recipient's email address
     * @param string $dueDate  Date and time at which a bill is due, ISO-8601 format yyyy-mm-ddThh:mm:ssZ (UTC).
     * @param array  $items    Array of line items
     *
     * @return BillData A BitPay Subscription's billData
     */
    public static function BillData(string $currency, string $email, string $dueDate, array $items): BillData
    {
        return new BillData($currency, $email, $dueDate, $items);
    }

    /**
     * Create a BitPay Subscription.
     *
     * @link https://bitpay.com/api/#rest-api-resources-subscriptions-create-a-subscription
     *
     * @param $subscription Subscription A Subscription object with request parameters defined.
     *
     * @return Subscription A BitPay generated Subscription object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function createSubscription(Subscription $subscription): Subscription
    {
        return (new self())->client->createSubscription($subscription);
    }

    /**
     * Retrieve a BitPay subscription by its id.
     *
     * @link https://bitpay.com/api/#rest-api-resources-subscriptions-retrieve-a-subscription
     *
     * @param $subscriptionId string The id of the subscription to retrieve.
     *
     * @return Subscription A BitPay Subscription object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getSubscription(string $subscriptionId): Subscription
    {
        return (new self())->client->getSubscription($subscriptionId);
    }

    /**
     * Retrieve a collection of BitPay subscriptions.
     *
     * @link https://bitpay.com/api/#rest-api-resources-subscriptions-retrieve-subscriptions-based-on-status
     *
     * @param $status string|null The status to filter the subscriptions.
     *
     * @return Subscription[] A list of BitPay Subscription objects.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function getSubscriptions(string $status = null): array
    {
        return (new self())->client->getSubscriptions($status);
    }

    /**
     * Update a BitPay Subscription.
     *
     * @link https://bitpay.com/api/#rest-api-resources-subscriptions-update-a-subscription
     *
     * @param $subscription   Subscription A Subscription object with the parameters to update defined.
     * @param $subscriptionId string $subscriptionIdThe Id of the Subscription to update.
     *
     * @return Subscription An updated Subscription object.
     * @throws \BitPaySDK\Exceptions\BitPayException BitPayException class
     */
    public static function updateSubscription(Subscription $subscription, string $subscriptionId): Subscription
    {
        return (new self())->client->updateSubscription($subscription, $subscriptionId);
    }
}
