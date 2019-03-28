<?php

namespace App\Policies;

use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class TaskPolicy
{
    use HandlesAuthorization;

    public function owner(Task $task,User $user)
    {
        return $user->isAdmin() or $user->isDirector();
    }

    


}
