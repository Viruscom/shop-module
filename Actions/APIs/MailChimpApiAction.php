<?php

namespace Modules\Shop\Actions\APIs;

use Exception;
use MailchimpMarketing\ApiClient;
use Modules\Shop\Entities\Settings\InternalIntegrations\InternalIntegration;

class MailChimpApiAction
{
    private static $instance;
    private        $apiKey;
    private        $apiServer;
    private        $listId;
    private        $client;

    private function __construct()
    {
        $mailChimp       = InternalIntegration::where('key', 'mailChimp')->first();
        $mailChimp       = json_decode($mailChimp->data);
        $this->apiKey    = $mailChimp->MAILCHIMP_API_KEY;
        $this->apiServer = $mailChimp->MAILCHIMP_API_SERVER;
        $this->listId    = $mailChimp->MAILCHIMP_LIST_ID;
        $this->client    = new ApiClient();

        $this->client->setConfig([
                                     'apiKey' => $this->apiKey,
                                     'server' => $this->apiServer
                                 ]);
    }

    public static function getInstance(): MailChimpApiAction
    {
        if (!self::$instance) {
            self::$instance = new MailChimpApiAction();
        }

        return self::$instance;
    }

    public function subscribeUser($email)
    {
        try {
            $response = $this->client->lists->addListMember($this->listId, [
                'email_address' => $email,
                'status'        => 'subscribed'
            ]);

            if ($response->getStatusCode() === 200) {
                return true;
            }
        } catch (Exception $e) {
            return $e;
        }

        return false;
    }

    public function unsubscribeUser($email): bool
    {
        try {
            $hashedEmail = md5(strtolower($email));
            $response    = $this->client->lists->updateListMember($this->listId, $hashedEmail, [
                'status' => 'unsubscribed'
            ]);

            if ($response->getStatusCode() === 200) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}
