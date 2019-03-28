<?php

namespace App\Repositories;

use App\Group;
use App\Project;
use App\User;
use DB;
use phpDocumentor\Reflection\DocBlock\Type\Collection;

class ProjectRepository
{
    public function getProject($slug)
    {
        return Project::findBySlugOrIdOrFail($slug);
    }
    public function getAll()
    {
        return Project::all();
    }

    public function ofDirector(User $user)
    {
        $groupsOfUser = $user->groups;
        $projects= collect();
        foreach($groupsOfUser as $item)
        {
            $group = Group::findBySlugOrIdOrFail($item->id);
            foreach($group->projects as $project)
            {
                $projects->push($project);
            }
        }
        return $projects;

    }
    public function ofUser(User $user)
    {
        return $user->projects;
    }

    public function ofUserParticipating(User $user)
    {
        $groupsOfUser = DB::table('group_user')->where('user_id', '=', $user->id)->get();
        $projects= collect();
        foreach($groupsOfUser as $item)
        {
            $group = Group::findBySlugOrIdOrFail($item->group_id);
            foreach($group->projects as $project)
            {
                $projects->push($project);
            }
        }

        return $projects;
    }
    public function getOwner(Project $project)
    {
        return $project->user;
    }
}