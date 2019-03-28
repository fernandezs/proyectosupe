<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Group;
class GroupPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, Group $group)
    {
        return $user->id == $group->user_id or $user->role == 'admin' or $group->owner == $user->id;
    }

    public function edit(User $user, Group $group)
    {
    	return $user->isDirector() or $group->owner == $user->id or $user->isAdmin();
    }

}
