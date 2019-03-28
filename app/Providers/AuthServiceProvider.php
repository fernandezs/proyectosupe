<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Group;
use App\Policies\GroupPolicy;   
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Group::class => GroupPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        $gate->define('edit-task', function($user, $task){
            return $user->id != $task->user_id;
        });
        $gate->define('owner-task', function($user, $task){
            return $task->user_id == $user->id;
        });
        $gate->define('approve-task', function($user, $task){
            return !$user->isScholar();
        });
        $gate->define('answer-task',function($user, $task){
            return $task->status != 'Finalizado' and $task->end_date->gt(Carbon::now());
        });
        $gate->define('assign-role', function($user, $project){
            return $user->role == 'director' or $user->role == 'admin';
        });
        $gate->define('edit-project', function($user, $project){
            return $user->role == 'admin' or $user->id == $project->user_id or $user->role == 'director';
        });

    }
}
