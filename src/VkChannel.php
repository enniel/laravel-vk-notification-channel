<?php

namespace NotificationChannels\Vk;

use NotificationChannels\Vk\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Event;
use ATehnix\VkClient\Client;

class VkChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\VK\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toVkontakte($notifiable);
        if (is_string($message)) {
            $message = VKMessage::create($message);
        }
        if ($message->recipientNotGiven()) {
            if (! $to = $notifiable->routeNotificationFor('vkontakte')) {
                throw CouldNotSendNotification::missingRecipient();
            }
            $message->to($to);
        }
        if ($message->tokenNotGiven()) {
            throw CouldNotSendNotification::missingToken();
        }
        if ($message->contentNotGiven()) {
            throw CouldNotSendNotification::missingContent();
        }
        $response = (new Client())->request('messages.send', $message->toArray(), $message->getToken());

        Event::fire(new MessageWasSended($response, $notifiable));
    }
}
