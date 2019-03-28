<?php

namespace App\Traits;

use App\Notifications\SendAppNotification\Middleware\SetTheUserId;
use App\Notifications\SendAppNotification\SendAppNotificationCommand;
use App\Notifications\SendAppNotification\Handler\SendAppNotificationCommandHandler;

trait Notificable
{
    use DispatchesCommands;

    /**
     * @param object $user
     * @param $message
     * @param string $type
     * @param $link must be resolvable by url() helper
     */
    public function sendAppNotification($user, $message, $type = "info", $link = null)
    {
        $this->execute(SendAppNotificationCommand::class, SendAppNotificationCommandHandler::class, [
            'user' => $user,
            'type' => $type,
            'message' => $message,
            'link' => $link
        ], [
            SetTheUserId::class
        ]);
    }
}
