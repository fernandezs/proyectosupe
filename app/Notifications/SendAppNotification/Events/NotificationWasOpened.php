<?php

namespace App\Notifications\SendAppNotification\Events;

use App\Events\Event;
use App\Notifications\SendAppNotification\Notification;

class NotificationWasOpened extends Event
{
    /**
     * @var Notification
     */
    public $notification;

    /**
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
}
