<?php
/**
 * Created by PhpStorm.
 * User: Casa
 * Date: 24/04/16
 * Time: 17:28
 */

namespace App\Repositories;
use App\Group;
use App\User;
use DB;

class GroupRepository
{

    public function getAll()
    {
        return Group::all();
    }
    public function getOfDirector(User $user)
    {
        return $user->groups;
    }
    public function getGroup($slug)
    {
        return Group::findBySlug($slug);
    }

    public function getGroupById($id)
    {
        return Group::findBySlugOrId($id);
    }

    public function getUsersForGroup($id)
    {
        $group = Group::findBySlugOrIdOrFail($id);
        //obtiene los usuarios correspondientes al grupo (excepto el director)
        $users = $group->users->where('role', 'investigador');
        //se le agrega el director del grupo a la colleccion
        $users->prepend($group->user);
        return $users;
    }
    public function getUsers(Group $group)
    {
        return $group->users;
    }
    //
    public function getInvestigators(Group $group)
    {
       return $group->users->where('role', 'investigador');
    }

    public function getGroupsOfUserParticipating(User $user)
    {
        $select = DB::table('group_user')->where('user_id','=',$user->id)->get();
        $groups = collect();
        foreach($select as $item)
        {
            $group = Group::findBySlugOrIdOrFail($item->group_id);
            $groups->push($group);
        }
        return $groups;

    }
    //Group $group
    public function getScholars(Group $group)
    {
        return $group->users->where('role', 'becario');
    }


}