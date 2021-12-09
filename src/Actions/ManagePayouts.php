<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\PayoutBatchCancellationException;
use BitPaySDK\Exceptions\PayoutBatchCreationException;
use BitPaySDK\Exceptions\PayoutBatchNotificationException;
use BitPaySDK\Exceptions\PayoutBatchQueryException;
use BitPaySDK\Exceptions\PayoutCancellationException;
use BitPaySDK\Exceptions\PayoutCreationException;
use BitPaySDK\Exceptions\PayoutNotificationException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Model\Payout\Payout;
use BitPaySDK\Model\Payout\PayoutBatch;
use BitPaySDK\Model\Payout\PayoutInstruction;
use Vrajroham\LaravelBitpay\Constants\WebhookAutoPopulate;


/**
 * Payouts are batches of bitcoin payments to employees, customers, partners, etc.
 *
 * @link https://bitpay.com/api/#rest-api-resources-payouts
 */
trait ManagePayouts
{
    /**
     * Get BitPay Payout instance.
     *
     *
     * @param float|null  $amount         The total amount of the payout in fiat currency. This amount must equal the
     *                                    sum of the instruction's amounts
     * @param string|null $currency       Currency code set for the payout amount (ISO 4217 3-character currency code).
     *                                    Supported currency codes for payouts are EUR, USD, GBP, CAD, NZD, AUD, ZAR
     * @param string|null $ledgerCurrency Ledger currency code set for the payout request (ISO 4217 3-character
     *                                    currency code), it indicates on which ledger the payout request will be
     *                                    recorded. If not provided in the request, this parameter will be set by
     *                                    default to the active ledger currency on your account, e.g. your settlement
     *                                    currency.
     *
     * @return Payout
     */
    public static function Payout(float $amount = null, string $currency = null, string $ledgerCurrency = null): Payout
    {
        return new Payout($amount, $currency, $ledgerCurrency);
    }

    /**
     * Get BitPay PayoutBatch instance.
     *
     *
     * @param string|null $currency       Currency code set for the batch amount (ISO 4217 3-character currency code).
     *                                    Supported currency codes for payout batches are EUR, USD, GBP, CAD, NZD, AUD,
     *                                    ZAR
     * @param array|null  $instructions   An array containing the detailed payout instruction objects.
     *                                    This array can contain a maximum of 200 instructions.
     * @param string|null $ledgerCurrency Ledger currency code set for the payout request (ISO 4217 3-character
     *                                    currency code), it indicates on which ledger the payout request will be
     *                                    recorded. If not provided in the request, this parameter will be set by
     *                                    default to the active ledger currency on your account, e.g. your settlement
     *                                    currency.
     *
     * @return PayoutBatch
     */
    public static function PayoutBatch(string $currency = null, array $instructions = null, string $ledgerCurrency = null): PayoutBatch
    {
        return new PayoutBatch($currency, $instructions, $ledgerCurrency);
    }

    /**
     * Get BitPay PayoutInstruction instance.
     *
     * @param $amount      float BTC amount.
     * @param $method      int Method used to target the recipient.
     * @param $methodValue string value for the chosen target method.
     *
     * @throws PayoutBatchCreationException BitPayException class
     * @return PayoutInstruction
     */
    public static function PayoutInstruction(float $amount, int $method, string $methodValue): PayoutInstruction
    {
        return new PayoutInstruction($amount, $method, $methodValue);
    }

    /**
     * Create a payout.
     *
     * @param Payout $payout A Payout object with request parameters defined.
     *
     * @return Payout A BitPay generated Payout object.
     * @throws PayoutCreationException PayoutCreationException class
     */
    public static function createPayout(Payout $payout): Payout
    {
        $thisInstance = new self();

        try {
            if (empty($payout->getNotificationURL()) &&
                in_array(WebhookAutoPopulate::For_Payouts, $thisInstance->config['auto_populate_webhook'])) {
                $payout->setNotificationURL(route('laravel-bitpay.webhook.capture'));
            }
        } catch (\Throwable $exception) {
            // Misconfiguration or route macro not in use
        }

        return $thisInstance->client->submitPayout($payout);
    }

    /**
     * Retrieve a payout
     *
     * @param string $payoutId The id of the payout to retrieve.
     *
     * @return Payout A BitPay Payout object.
     * @throws PayoutQueryException PayoutQueryException class
     */
    public static function getPayout(string $payoutId): Payout
    {
        return (new self)->client->getPayout($payoutId);
    }

    /**
     * Retrieve payouts based on status
     *
     * @param string|null $startDate The start date to filter the Payouts.
     * @param string|null $endDate   The end date to filter the Payout.
     * @param string|null $status    The payout status you want to query on
     * @param string|null $reference The optional reference specified at payout request creation.
     * @param int|null    $limit     Maximum results that the query will return (useful for paging results).
     * @param int|null    $offset    number of results to offset (ex. skip 10 will give you results starting
     *                               with the 11th result).
     *
     * @return Payout[] A list of BitPay Payout objects.
     * @throws PayoutQueryException PayoutQueryException class
     */
    public static function getPayouts(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
        string $reference = null,
        int    $limit = null,
        int    $offset = null): array
    {
        return (new self())->client->getPayouts(
            $startDate,
            $endDate,
            $status,
            $reference,
            $limit,
            $offset
        );
    }

    /**
     * Cancel a payout
     *
     * @param string $payoutId The id of the payout to cancel.
     *
     * @return bool True if payout was canceled successfully, false otherwise.
     * @throws PayoutCancellationException PayoutCancellationException class
     */
    public static function cancelPayout(string $payoutId): bool
    {
        return (new self())->client->cancelPayout($payoutId);
    }

    /**
     * Request a Payout webhook to be resent.
     *
     * @param  $payoutId string The id of the payout for which you want the last webhook to be resent.
     *
     * @return bool True if the webhook has been resent for the current payout status, false otherwise.
     * @throws PayoutNotificationException PayoutNotificationException class
     */
    public static function requestPayoutWebhook(string $payoutId): bool
    {
        return (new self())->client->requestPayoutNotification($payoutId);
    }

    /**
     * Create a payout batch
     *
     * @link https://bitpay.com/api/#rest-api-resources-payouts-create-a-payout-batch
     *
     * @param PayoutBatch $payoutBatch A PayoutBatch object with request parameters defined.
     *
     * @return PayoutBatch A BitPay generated PayoutBatch object.
     * @throws PayoutBatchCreationException PayoutBatchCreationException class
     */
    public static function createPayoutBatch(PayoutBatch $payoutBatch): PayoutBatch
    {
        $thisInstance = new self();

        try {
            if (empty($payoutBatch->getNotificationURL()) &&
                in_array(WebhookAutoPopulate::For_Payouts, $thisInstance->config['auto_populate_webhook'])) {
                $payoutBatch->setNotificationURL(route('laravel-bitpay.webhook.capture'));
            }
        } catch (\Throwable $exception) {
            // Misconfiguration or route macro not in use
        }

        return $thisInstance->client->submitPayoutBatch($payoutBatch);
    }

    /**
     * Retrieve a payout batch
     *
     * @link https://bitpay.com/api/#rest-api-resources-payouts-retrieve-a-payout-batch
     *
     * @param string $payoutBatchId The id of the payout batch to retrieve.
     *
     * @return PayoutBatch A BitPay PayoutBatch object.
     * @throws PayoutBatchQueryException PayoutBatchQueryException class
     */
    public static function getPayoutBatch(string $payoutBatchId): PayoutBatch
    {
        return (new self)->client->getPayoutBatch($payoutBatchId);
    }

    /**
     * Retrieve payout batches based on status
     *
     * @link https://bitpay.com/api/#rest-api-resources-payouts-retrieve-payout-batches-based-on-status
     *
     * @param string|null $startDate The start date to filter the PayoutBatch Batches.
     * @param string|null $endDate   The end date to filter the PayoutBatch Batches.
     * @param string|null $status    The payout status you want to query on
     * @param int|null    $limit     Maximum results that the query will return (useful for paging results).
     * @param int|null    $offset    number of results to offset (ex. skip 10 will give you results starting
     *                               with the 11th result).
     *
     * @return PayoutBatch[] A list of BitPay PayoutBatch objects.
     * @throws PayoutBatchQueryException PayoutBatchQueryException class
     */
    public static function getPayoutBatches(
        string $startDate = null,
        string $endDate = null,
        string $status = null,
        int    $limit = null,
        int    $offset = null): array
    {
        return (new self())->client->getPayoutBatches(
            $startDate,
            $endDate,
            $status,
            $limit,
            $offset
        );
    }

    /**
     * Cancel a payout batch
     *
     * @link https://bitpay.com/api/#rest-api-resources-payouts-cancel-a-payout-batch
     *
     * @param string $payoutBatchId The id of the payout batch to cancel.
     *
     * @return bool True if payout batch was canceled successfully, false otherwise.
     * @throws PayoutBatchCancellationException PayoutBatchCancellationException class
     */
    public static function cancelPayoutBatch(string $payoutBatchId): bool
    {
        return (new self())->client->cancelPayoutBatch($payoutBatchId);
    }

    /**
     * Request a PayoutBatch webhook to be resent.
     *
     * @param  $payoutBatchId string The id of the payout batch for which you want the last webhook to be resent.
     *
     * @return bool True if the webhook has been resent for the current payout batch status, false otherwise.
     * @throws PayoutBatchNotificationException PayoutBatchNotificationException class
     */
    public static function requestPayoutBatchWebhook(string $payoutBatchId): bool
    {
        return (new self())->client->requestPayoutBatchNotification($payoutBatchId);
    }

}
