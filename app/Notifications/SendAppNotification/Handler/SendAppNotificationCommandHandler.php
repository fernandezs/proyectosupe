<?php

namespace App\Notifications\SendAppNotification\Handler;

use App\Notifications\SendAppNotification\Notification;
use App\Notifications\SendAppNotification\Events\NotificationWasSent;

class SendAppNotificationCommandHandler
{
    public function handle($command)
    {
        $notification = Notification::create((array) $command);
        event(new NotificationWasSent($notification));
        return $notification;
    }
}
