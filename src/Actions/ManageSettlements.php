<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Settlement\Settlement;


/**
 * Settlements are transfers of payment profits from BitPay to bank accounts and cryptocurrency wallets owned by
 * merchants, partners, etc. This endpoint exposes reports detailing these settlements.
 *
 * @link https://bitpay.com/api/#rest-api-resources-settlements-resource
 */
trait ManageSettlements
{

    /**
     * Retrieve settlements.
     *
     * @link https://bitpay.com/api/#rest-api-resources-settlements-retrieve-settlements
     *
     * @param string      $currency  The three digit currency string for the ledger to retrieve.
     * @param string      $startDate The start of the date window to query for settlements. Format YYYY-MM-DD
     * @param string      $endDate   The end of the date window to query for settlements. Format YYYY-MM-DD
     * @param string|null $status    The settlement status you want to query on.
     *                               Can be `new`, `processing`, `rejected` or `completed`.
     * @param int|null    $limit     Maximum results that the query will return (useful for paging results).
     * @param int|null    $offset    Number of results to offset
     *                               (ex. skip 10 will give you results starting with the 11th result)
     *
     * @return Settlement[] A list of BitPay Settlement objects.
     * @throws BitPayException BitPayException class
     */
    public static function getSettlements(
        string $currency,
        string $startDate,
        string $endDate,
        string $status = null,
        int    $limit = null,
        int    $offset = null
    ): array {
        return (new self())->client->getSettlements($currency, $startDate, $endDate, $status, $limit, $offset);
    }

    /**
     * Retrieve a settlement.
     *
     * @link https://bitpay.com/api/#rest-api-resources-settlements-retrieve-settlements
     *
     * @param $settlementId string Settlement Id.
     *
     * @return Settlement A BitPay Settlement object.
     * @throws BitPayException BitPayException class
     */
    public static function getSettlement(string $settlementId): Settlement
    {
        return (new self())->client->getSettlement($settlementId);
    }

    /**
     * Fetch a reconciliation report. Allows merchant to retrieve a detailed report of the activity within
     * the settlement period, in order to reconcile incoming settlements from BitPay.
     *
     * @link https://bitpay.com/api/#rest-api-resources-settlements-fetch-a-reconciliation-report
     *
     * @param $settlement Settlement to generate report for.
     *
     * @return Settlement A detailed BitPay Settlement object.
     * @throws BitPayException BitPayException class
     */
    public static function getSettlementReconciliationReport(Settlement $settlement): Settlement
    {
        return (new self())->client->getSettlementReconciliationReport($settlement);
    }
}
