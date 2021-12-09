# LaravelBitPay Migration Guide

This guide will serve as a single source of truth, regarding breaking changes and necessary actions one must take when
upgrading to major versions.

## From v4 to v5

### Configuration

- Ensure `BITPAY_*` values inside your `.env` follows the updated naming conventions outlined
  here: https://github.com/vrajroham/laravel-bitpay#add-configuration-values. Specifically:
    + Removed:
        - `BITPAY_PUBLIC_KEY_PATH`
    + Changed:
        - `BITPAY_TOKEN` renamed to `BITPAY_MERCHANT_TOKEN`
    + Added:
        - `BITPAY_ENABLE_MERCHANT`
        - `BITPAY_ENABLE_PAYOUT`
        - `BITPAY_PAYOUT_TOKEN`


- Ensure the contents of your `laravel-bitpay.php` config file is on par with the updated one found
  here: https://github.com/vrajroham/laravel-bitpay/blob/master/config/laravel-bitpay.php

### API Tokens

LaravelBitPay now supports the `payout` facade, along with generating a Payout API Token, which allows you to interact
with [Recipients](https://bitpay.com/api/#rest-api-resources-recipients)
and [Payouts](https://bitpay.com/api/#rest-api-resources-payouts) resources.

It's as easy as setting `BITPAY_ENABLE_PAYOUT` to `true` inside your `.env` file then
following: https://github.com/vrajroham/laravel-bitpay#generate-key-pair-and-api-tokens.

### Webhooks

Webhooks are now an optional feature. Your event listener should work the same, but to configure your webhook URL
(notificationURL) please refer here: https://github.com/vrajroham/laravel-bitpay#configure-webhooks-optional.

### Constants

+ Removed:
  - `BitPayConstants::BILL_STATUS_*` in favor of core `BillStatus::*`
  - `BitPayConstants::SUBSCRIPTION_STATUS_*` in favor of core `SubscriptionStatus::*`
+ Added:
  - `BitPayConstants::INVOICE_EXCEPTION_*`
  - `BitPayConstants::INVOICE_WEBHOOK_CODES`
  - `BitPayConstants::RECIPIENT_WEBHOOK_CODES`
  - `BitPayConstants::PAYOUT_WEBHOOK_CODES`
