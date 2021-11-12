<?php

namespace Vrajroham\LaravelBitpay\Constants;

class BitPayConstants
{
    public const DATETIME_FORMAT = 'Y-m-d\TH:i:s\Z';

    // Bill Statuses
    public const BILL_STATUS_DRAFT = 'draft';
    public const BILL_STATUS_SENT = 'sent';
    public const BILL_STATUS_NEW = 'new';
    public const BILL_STATUS_PAID = 'paid';
    public const BILL_STATUS_COMPLETE = 'complete';

    // Subscription Statuses
    public const SUBSCRIPTION_STATUS_DRAFT = 'draft';
    public const SUBSCRIPTION_STATUS_ACTIVE = 'active';
    public const SUBSCRIPTION_STATUS_CANCELLED = 'cancelled';

    // Subscription Schedules
    public const SUBSCRIPTION_SCHEDULE_WEEKLY = 'weekly';
    public const SUBSCRIPTION_SCHEDULE_MONTHLY = 'monthly';
    public const SUBSCRIPTION_SCHEDULE_QUARTERLY = 'quarterly';
    public const SUBSCRIPTION_SCHEDULE_YEARLY = 'yearly';
}
