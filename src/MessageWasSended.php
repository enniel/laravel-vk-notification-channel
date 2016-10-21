<?php

namespace NotificationChannels\Vk;

class MessageWasSended
{
    /**
     * @var array
     */
    public $response;

    /**
     * @var object
     */
    public $notifiable;

    /**
     * @param  array  $response
     * @param  object $notifiable
     *
     * @return void
     */
    public function __construct(array $response, $notifiable)
    {
        $this->response = $response;
        $this->notifiable = $notifiable;
    }
}
