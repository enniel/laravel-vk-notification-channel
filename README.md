# Vkontakte notification channel for Laravel 5.3

This package makes it easy to send notifications using [vk.com](https://vk.com/) with Laravel 5.3.

## Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Testing](#testing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:

``` bash
composer require enniel/laravel-vk-notification-channel
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Vk\VkChannel;
use NotificationChannels\Vk\VkMessage;
use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification
{
    public function via($notifiable)
    {
        return [VkChannel::class];
    }

    public function toVkontakte($notifiable)
    {
        return (new VkMessage())
            ->message('message text')
            ->token('some_token');
    }
}
```


In order for your notice to know who to send messages, you must add `routeNotificationForVkontakte` method to your notification model that returns data in array like ['user_id', 1].

### Available message methods

- `user()`: User ID (by default — current user). Takes a parameter `user_id`.
- `random()`: Unique identifier to avoid resending the message. Takes a parameter `random_id`.
- `peer()`: Destination ID. Takes a parameter `peer_id`.
- `domain()`: User's short address (for example, `illarionov`). Takes a parameter `domain_id`.
- `chat()`: ID of conversation the message will relate to. Takes a parameter `chat_id`.
- `users()`: IDs of message recipients (if new conversation shall be started). Takes a parameter `user_ids`.
- `message()`: The identity of the sender. Takes a parameter `message`.
- `lat()`: Geographical latitude of a check-in, in degrees (from -90 to 90). Takes a parameter `lat`.
- `long()`: Geographical longitude of a check-in, in degrees (from -180 to 180). Takes a parameter `long`.
- `attachment()`: List of objects attached to the message. Takes a parameter `attachment`.
- `forwarded()`: IDs of forwarded messages. Takes a parameter `forward_messages`.
- `sticker()`: Sticker id. Takes a parameter `sticker_id`.
- `notification()`: `1` or `true` if the message is a notification (for community messages). Takes a parameter `notification`.
- `token()`: Access token. Passes a parameter `access_token`. For more information see [Authorization](https://github.com/atehnix/vk-client#authorization) and [Getting a Token](https://vk.com/dev/access_token).
- `to()`: Recipient. Takes an array like ['user_id', 1], where the first value corresponds to one of them: peer_id, user_id, domain, chat_id or user_ids.

For more information about parameters see [messages.send](https://vk.com/dev/messages.send).

## Testing

``` bash
$ composer test
```

## Credits

- [Evgeni Razumov](https://github.com/enniel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
