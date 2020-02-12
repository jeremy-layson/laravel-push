<?php

namespace JeremyLayson\Push\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use JeremyLayson\Push\Libraries\Messaging\Message;

class NotificationPushed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}
