<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use Mail;
use Carbon\Carbon;

class MailAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia alertas a usuarios que tengan tareas cercanas a su fecha de finalizacion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = Task::where('status', '<>', 'Finalizado')->whereBetween('end_date', [Carbon::now(),new Carbon('next week') ])->get();
        foreach ($tasks as $task) {
            $user = $task->user;
            Mail::send('emails.alerts', ['user' => $user,'task' => $task ], function ($m) use ($user) {
                $m->from('proyectos@upe.com', 'Gestion de Proyectos UPE');
                $m->to($user->email, $user->name)->subject('Tienes una tarea cercana a su fecha de finalizacion!');
            });
        }
        
    }
}
