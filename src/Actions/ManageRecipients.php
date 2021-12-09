<?php

namespace Vrajroham\LaravelBitpay\Actions;

use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Exceptions\PayoutQueryException;
use BitPaySDK\Exceptions\PayoutRecipientCancellationException;
use BitPaySDK\Exceptions\PayoutRecipientCreationException;
use BitPaySDK\Exceptions\PayoutRecipientNotificationException;
use BitPaySDK\Exceptions\PayoutRecipientUpdateException;
use BitPaySDK\Model\Payout\PayoutRecipient;
use BitPaySDK\Model\Payout\PayoutRecipients;
use Vrajroham\LaravelBitpay\Constants\WebhookAutoPopulate;


/**
 * To create payout requests, merchants will first need to issue email invites using this resource.
 * This is a mandatory step to onboard customers asking for cryptocurrency payouts.
 * The recipients of the email invites will be invited to create a BitPay personal account,
 * submit a photo of a proof of ID document (Passport, driver's license, Identity card) and provide
 * the home address in order to be able to submit a cryptocurrency withdrawal address to be used for the payouts.
 *
 * @link https://bitpay.com/api/#rest-api-resources-recipients
 */
trait ManageRecipients
{

    /**
     * The Recipient resource allows a merchant to invite his clients to signup for a BitPay personal account.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-resource
     *
     * @param string|null $email           Recipient email address
     * @param string|null $label           For merchant use, pass through - could be customer name or unique reference.
     * @param string|null $notificationURL URL to which BitPay sends webhook notifications to inform the merchant about
     *                                     the status of a given recipient. HTTPS is mandatory.
     *
     * @return PayoutRecipient
     */
    public static function PayoutRecipient(
        string $email = null,
        string $label = null,
        string $notificationURL = null
    ): PayoutRecipient {
        return new PayoutRecipient($email, $label, $notificationURL);
    }

    /**
     * A PayoutRecipients object, used primarily when merchants invite their payees.
     *
     * @param PayoutRecipient[] $recipients An array of PayoutRecipient objects
     *
     * @return PayoutRecipients
     */
    public static function PayoutRecipients(array $recipients = []): PayoutRecipients
    {
        return new PayoutRecipients($recipients);
    }

    /**
     * Invite Recipient(s).
     *
     * For merchants who need to invite multiple recipients in a short period of time, make sure to send batch of
     * invites e.g. use this endpoint to invite an array [] of recipients (up to 1000 in a single API call)
     *
     * By default, a merchant can invite a maximum of 1000 distinct recipients via the business account,
     * reach out to your account manager at BitPay in order to increase this limit.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-invite-a-recipient
     *
     * @param $recipients PayoutRecipients A PayoutRecipients object with one or more PayoutRecipient included.
     *
     * @return PayoutRecipient[] A list of BitPay PayoutRecipient objects.
     * @throws PayoutRecipientCreationException BitPayException class
     */
    public static function invitePayoutRecipients(PayoutRecipients $recipients): array
    {
        $thisInstance = new self();

        try {
            foreach ($recipients->getRecipients() as $recipient) {
                if (empty($recipient['notificationURL']) &&
                    in_array(WebhookAutoPopulate::For_Recipients, $thisInstance->config['auto_populate_webhook'])) {
                    $recipient['notificationURL'] = route('laravel-bitpay.webhook.capture');
                }
            }
        } catch (\Throwable $exception) {
            // Misconfiguration or route macro not in use
        }

        return $thisInstance->client->submitPayoutRecipients($recipients);
    }

    /**
     * Retrieve a BitPay payout recipient by its ID.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-retrieve-a-recipient
     *
     * @param $recipientId string The id of the recipient to retrieve.
     *
     * @return PayoutRecipient A BitPay PayoutRecipient object.
     * @throws PayoutQueryException BitPayException class
     */
    public static function getPayoutRecipient(string $recipientId): PayoutRecipient
    {
        return (new self())->client->getPayoutRecipient($recipientId);
    }

    /**
     * Retrieve recipients by status.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-retrieve-recipients-by-status
     *
     * @param $status     string|null The recipient status you want to query on.
     * @param $limit      int|null Maximum results that the query will return (useful for paging results).
     * @param $offset     int|null Number of results to offset (ex. skip 10 will give you results starting with the 11th result).
     *
     * @return PayoutRecipient[] A list of BitPay PayoutRecipient objects.
     * @throws BitPayException BitPayException class
     */
    public static function getPayoutRecipients(string $status = null, int $limit = null, int $offset = null): array
    {
        return (new self())->client->getPayoutRecipients($status, $limit, $offset);
    }

    /**
     * Update a Recipient.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-update-a-recipient
     *
     * @param $recipientId string The ID for the recipient to be updated.
     * @param $recipient   PayoutRecipient A PayoutRecipient object with updated parameters defined.
     *
     * @return PayoutRecipient The updated PayoutRecipient object.
     * @throws PayoutRecipientUpdateException PayoutRecipientUpdateException class
     */
    public static function updatePayoutRecipient(string $recipientId, PayoutRecipient $recipient): PayoutRecipient
    {
        return (new self())->client->updatePayoutRecipient($recipientId, $recipient);
    }

    /**
     * Remove a recipient
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-remove-a-recipient
     *
     * @param $recipientId string The ID of the recipient to be removed.
     *
     * @return bool True if the recipient was successfully removed, false otherwise.
     * @throws PayoutRecipientCancellationException PayoutRecipientCancellationException class
     */
    public static function removePayoutRecipient(string $recipientId): bool
    {
        return (new self())->client->deletePayoutRecipient($recipientId);
    }

    /**
     * Request a Recipient webhook to be resent.
     *
     * @link https://bitpay.com/api/#rest-api-resources-recipients-request-a-webhook-to-be-resent
     *
     * @param  $recipientId string The id of the recipient for which you want the last webhook to be resent.
     *
     * @return bool True if the webhook has been resent for the current recipient status, false otherwise.
     * @throws PayoutRecipientNotificationException PayoutRecipientNotificationException class
     */
    public static function requestPayoutRecipientWebhook(string $recipientId): bool
    {
        return (new self())->client->requestPayoutRecipientNotification($recipientId);
    }

}
