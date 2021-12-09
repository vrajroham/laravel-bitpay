<?php

namespace Vrajroham\LaravelBitpay\Constants;

interface BitPayConstants
{
    // TODO: Deprecate 'Invoice Exceptions', 'Subscription Schedules' and 'Settlement Statuses' after upstream merge & update (^6.0): https://github.com/bitpay/php-bitpay-client-v2/pull/69

    const DATETIME_FORMAT = 'Y-m-d\TH:i:s\Z';

    // Invoice Exceptions
    const INVOICE_EXCEPTION_PAIDOVER    = 'paidOver';
    const INVOICE_EXCEPTION_PAIDPARTIAL = 'paidPartial';

    // Subscription Schedules
    const SUBSCRIPTION_SCHEDULE_WEEKLY    = 'weekly';
    const SUBSCRIPTION_SCHEDULE_MONTHLY   = 'monthly';
    const SUBSCRIPTION_SCHEDULE_QUARTERLY = 'quarterly';
    const SUBSCRIPTION_SCHEDULE_YEARLY    = 'yearly';

    // Settlement Statuses
    const SETTLEMENT_STATUS_NEW        = 'new';
    const SETTLEMENT_STATUS_PROCESSING = 'processing';
    const SETTLEMENT_STATUS_REJECTED   = 'rejected';
    const SETTLEMENT_STATUS_COMPLETED  = 'completed';

    // Invoice Webhook Codes
    const INVOICE_WEBHOOK_CODES = [
        1003 => 'invoice_paidInFull',
        1004 => 'invoice_expired',
        1005 => 'invoice_confirmed',
        1006 => 'invoice_completed',
        1012 => 'invoice_manuallyNotified',
        1013 => 'invoice_failedToConfirm',
        1016 => 'invoice_refundComplete',
    ];

    // Recipient Webhook Codes
    const RECIPIENT_WEBHOOK_CODES = [
        4001 => 'recipient_invited',
        4002 => 'recipient_unverified',
        4003 => 'recipient_verified',
        4004 => 'recipient_active',
        4005 => 'recipient_paused',
        4006 => 'recipient_removed',
    ];

    // Payout Webhook Codes
    const PAYOUT_WEBHOOK_CODES = [
        2001 => 'payoutRequest_funded',
        2002 => 'payoutRequest_completed',
        2003 => 'payoutRequest_cancelled',
    ];
}
