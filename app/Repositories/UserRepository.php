<?php
/**
 * Created by PhpStorm.
 * User: Casa
 * Date: 24/04/16
 * Time: 16:53
 */

namespace App\Repositories;

use DB;
use App\User;
use App\Group;
class UserRepository
{
	public function getUser($id)
	{
		$user = User::find($id);
		return $user;
	}
	public function cmbOfUsers($role)
	{
		return User::where('role', $role);
	}
	public function getAll()

	{
	    return User::where('role', '<>', 'admin')->get()->lists('username', 'id');
    }
    public function all()
    {
    	return User::all();
    }

	public function getUsersForGroup($id)
	{
		$group = Group::findBySlugOrIdOrFail($id);
		$users = $group->users;
		return $users;
	}


}