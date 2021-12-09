<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Ledger\Ledger;
use BitPaySDK\Model\Ledger\LedgerEntry;


/**
 * Ledgers are records of money movement.
 *
 * @link https://bitpay.com/api/#rest-api-resources-ledgers
 */
trait ManageLedgers
{

    /**
     * Retrieve account balances.
     *
     * @link https://bitpay.com/api/#rest-api-resources-ledgers-retrieve-account-balances
     *
     * @return Ledger[] A list of Ledger objects populated with the currency and current balance of each one.
     * @throws BitPayException BitPayException class
     */
    public static function getLedgers(): array
    {
        return (new self())->client->getLedgers();
    }

    /**
     * Retrieve ledger entries.
     *
     * @link https://bitpay.com/api/#rest-api-resources-ledgers-retrieve-ledger-entries
     *
     * @param $currency  string ISO 4217 3-character currency code for the ledger to retrieve.
     * @param $startDate string The start date for fetching ledger entries. Format YYYY-MM-DD
     * @param $endDate   string The end date for fetching ledger entries. Format YYYY-MM-DD
     *
     * @return LedgerEntry[] A list of LedgerEntry objects that match the provided filters.
     * @throws BitPayException BitPayException class
     */
    public static function getLedger(string $currency, string $startDate, string $endDate): array
    {
        return (new self())->client->getLedger($currency, $startDate, $endDate);
    }

}
