<?php

namespace NotificationChannels\BandwidthLaravelNotificationChannel;

use BandwidthLib\BandwidthClient;
use BandwidthLib\Configuration;
use BandwidthLib\Messaging\Models\MessageRequest;
use Illuminate\Notifications\Notification;
use NotificationChannels\BandwidthLaravelNotificationChannel\Exceptions\CouldNotSendNotification;
use NotificationChannels\BandwidthLaravelNotificationChannel\BandwidthMessage;

class BandwidthChannel
{
    protected $client;
    protected $accountId;

    public function __construct(Configuration $config, string $accountId)
    {
        $this->client = new BandwidthClient($config);
        $this->accountId = $accountId;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\BandwidthLaravelNotificationChannel\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toBandwidth')) {
            throw CouldNotSendNotification::invalidNotificationMethod('toBandwidth');
        }

        $message = $notification->toBandwidth($notifiable);

        if (!$message instanceof BandwidthMessage) {
            throw CouldNotSendNotification::invalidMessageObject($message);
        }

        $messagingClient = $this->client->getMessaging()->getClient();

        $body = new MessageRequest();
        $messageArray = $message->toArray();
        $body->from = $messageArray['from'];
        $body->to = [$messageArray['to']];
        $body->text = $messageArray['text'];
        $body->applicationId = $messageArray['applicationId'];

        try {
            $response = $messagingClient->createMessage($this->accountId, $body);
            return $response;
        } catch (\Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e);
        }
    }
}
