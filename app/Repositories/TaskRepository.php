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
use App\Task;
use App\Repositories\ProjectRepository;
use Carbon\Carbon;
use Auth;
class TaskRepository
{
    public function getAll()
    {
        return Task::all();
    }

    public function getTask($slug)
    {
        return Task::findBySlug($slug);
    }
    public function getOfDirector(User $user)
    {
        $repo = new ProjectRepository();
        $projects = $repo->ofDirector($user);
        $tasks = collect();
        foreach($projects as $project)
        {
            foreach($project->tasks as $task)
            {
                $tasks->push($task);
            }
        }
        return $tasks;

    }

    public function getOfGroup($id)
    {
        $group = Group::find($id);
        $tasks = collect();
        foreach ($group->projects as $project) {
            foreach ($project->tasks as $task) {
                $tasks->push($task);
            }
        }
        return $tasks;
    }

    public function getOfInvestigator(User $user)
    {
        $repo = new ProjectRepository();
        $projects = $repo->ofUserParticipating($user);
        $tasks = collect();
        foreach($projects as $project)
        {
            foreach($project->tasks as $task)
            {
                $tasks->push($task);
            }
        }
        return $tasks;
    }
    public function getTasks(User $user)
    {
        return $user->tasks;
    }

    // eq  => 'igual'
    // ne  => 'no es igual'
    // gt  => 'es mayor'
    // gte => 'es mayor o igual'
    // lt  => 'es menor'
    // lte => 'es menor o igual'
    public function getTasksAssigned(User $user)
    {
        //fecha de inicio menor o igual a la que tiene asignada a la fecha y que no este finalizada
        return $user->tasks->filter(function($task){
            return ($task->start_date->lte(Carbon::now()) and $task->end_date->gte(Carbon::now()) and $task->status != 'Finalizado');
        })->sortByDesc('end_date');
    }
        //tareas vencidas que no fueron respondidas antes de su fecha de finalizacion
    public function getTasksOverdues(User $user)
    {
        return $user->tasks->filter(function($task){
            return ($task->end_date->lt(Carbon::now()) and $task->status != 'Finalizado' );
                
        })->sortByDesc('end_date');
    }

    public function getTasksAnswers(User $user)
    {
        return $this->getOfInvestigator($user)->filter(function($task){
            return $task->user_id != Auth::user()->id;
        })->sortByDesc('end_date');
    }
}