<?php

namespace NotificationChannels\Vk\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when recipient is missing.
     *
     * @return static
     */
    public static function missingRecipient()
    {
        return new static('Notification was not sent. You should specify peer_id, user_id, domain, chat_id or user_ids param.');
    }

    /**
     * Thrown when token is missing.
     *
     * @return static
     */
    public static function missingToken()
    {
        return new static('Notification was not sent. You should specify access_token.');
    }

    /**
     * Thrown when content is missing.
     *
     * @return static
     */
    public static function missingContent()
    {
        return new static('Notification was not sent. You should specify message, stiker_id or attachment param.');
    }
}
