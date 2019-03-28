<?php

namespace App\Notifications\SendAppNotification;


class SendAppNotificationCommand
{

    public $user;

    public $type;

    public $message;

    public $link;

    /**
     * @param $user
     * @param $type
     * @param $message
     * @param $link
     */
    public function __construct($user, $type, $message, $link = null)
    {
        $this->user = $user;
        $this->type = $type;
        $this->message = $message;
        $this->link = $link;
    }
}
