<?php

namespace NotificationChannels\Vk;

class VkMessage
{
    /**
     * @var array Params payload.
     */
    protected $payload = [];

    /**
     * @var array Recipient [key, value]
     */
    protected $recipient = [];

    /**
     * @var string Access Token
     */
    protected $token;

    /**
     * Message constructor.
     *
     * @param string $message
     * @param string $token
     */
    public function __construct($message = null, $token = null)
    {
        $this->message($message);
        $this->token($token);
    }

    /**
     * @param string $message
     *
     * @return static
     */
    public static function create($message = null)
    {
        return new static($message);
    }

    /**
     * Recipient.
     *
     * @return $this
     */
    public function to($recipient)
    {
        $this->recipient = $recipient;
        if ($this->recipientIsValid()) {
            list($key, $value) = $recipient;
            $this->payload[$key] = $value;
        }

        return $this;
    }

    /**
     * The text of the message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function message($message)
    {
        $this->payload['message'] = $message;

        return $this;
    }

    /**
     * User ID (by default — current user).
     *
     * @param int $user
     *
     * @return $this
     */
    public function user($user)
    {
        $this->payload['user_id'] = (int) $user;

        return $this;
    }

    /**
     * Unique identifier to avoid resending the message.
     *
     * @param int $random
     *
     * @return $this
     */
    public function random($random)
    {
        $this->payload['random_id'] = (int) $random;

        return $this;
    }

    /**
     * Destination ID.
     *
     * @param int $peer
     *
     * @return $this
     */
    public function peer($peer)
    {
        $this->payload['peer_id'] = (int) $peer;

        return $this;
    }

    /**
     * User's short address (for example, illarionov).
     *
     * @param string $domain
     *
     * @return $this
     */
    public function domain($domain)
    {
        $this->payload['domain'] = (string) $domain;

        return $this;
    }

    /**
     * ID of conversation the message will relate to.
     *
     * @param int $chat
     *
     * @return $this
     */
    public function chat($chat)
    {
        $this->payload['chat_id'] = (int) abs($chat);

        return $this;
    }

    /**
     * IDs of message recipients (if new conversation shall be started).
     *
     * @param mixed $users
     *
     * @return $this
     */
    public function users($users)
    {
        if (is_array($users)) {
            $users = implode(',', $users);
        }

        $this->payload['user_ids'] = $users;

        return $this;
    }

    /**
     * Geographical latitude of a check-in, in degrees (from -90 to 90).
     *
     * @param string $lat
     *
     * @return $this
     */
    public function lat($lat)
    {
        $this->payload['lat'] = $lat;

        return $this;
    }

    /**
     * Geographical longitude of a check-in, in degrees (from -180 to 180).
     *
     * @param string $long
     *
     * @return $this
     */
    public function long($long)
    {
        $this->payload['long'] = $long;

        return $this;
    }

    /**
     * List of objects attached to the message.
     *
     * @param mixed $attachment
     *
     * @return $this
     */
    public function attachment($attachment)
    {
        if (is_array($attachment)) {
            $attachment = implode(',', $attachment);
        }

        $this->payload['attachment'] = $attachment;

        return $this;
    }

    /**
     * Forwarded messages.
     *
     * @param mixed $forwarded
     *
     * @return $this
     */
    public function forwarded($forwarded)
    {
        if (is_array($forwarded)) {
            $forwarded = implode(',', $forwarded);
        }

        $this->payload['forward_messages'] = $forwarded;

        return $this;
    }

    /**
     * Sticker id.
     *
     * @param int $sticker
     *
     * @return $this
     */
    public function sticker($sticker)
    {
        $this->payload['sticker_id'] = (int) abs($sticker);

        return $this;
    }

    /**
     * If the message is a notification (for community messages).
     *
     * @param bool $notification
     *
     * @return $this
     */
    public function notification($notification)
    {
        $this->payload['notification'] = (int) $notification;

        return $this;
    }

    /**
     * Access Token.
     *
     * @param string $token
     *
     * @return $this
     */
    public function token($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get Access Token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Determine if recipient is not given.
     *
     * @return bool
     */
    public function recipientNotGiven()
    {
        if (! $this->recipientIsValid()) {
            return true;
        }
        list($key) = $this->recipient;

        return ! (array_key_exists($key, $this->payload) && $this->payload[$key]);
    }

    /**
     * Determine if token is not given.
     *
     * @return bool
     */
    public function tokenNotGiven()
    {
        return ! $this->token;
    }

    /**
     * Determine if message content is not given.
     *
     * @return bool
     */
    public function contentNotGiven()
    {
        $keys = [
            'message',
            'stiker_id',
            'attachment',
        ];
        foreach ($keys as $key) {
            if (array_key_exists($key, $this->payload) && $this->payload[$key]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns params payload.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }

    /**
     * Validate recipient.
     *
     * @return bool
     */
    protected function recipientIsValid()
    {
        $keys = [
            'domain',
            'user_id',
            'chat_id',
            'peer_id',
            'user_ids',
        ];
        $key = null;
        $value = null;
        if (is_array($this->recipient) && count($this->recipient) > 1) {
            list($key, $value) = $this->recipient;
        }

        return $key && $value;
    }
}
