<?php

namespace App\Notifications\SendAppNotification\Middleware;

use League\Tactician\Middleware;

class SetTheUserId implements Middleware
{
    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $command->user_id = $command->user;
        if (is_object($command->user)) {
            $command->user_id = $command->user->id;
        }
        return $next($command);
    }
}
