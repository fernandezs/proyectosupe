<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Project;
use App\Repositories\ProjectRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Laracasts\Flash\Flash;
use Datatables;
use Carbon\Carbon;
use Gate;
use Lanz\Commentable\Comment;
use App\Traits\Notificable;
use Mail;

class TasksController extends Controller
{
    use Notificable;
    protected $task;
    protected $tasks;
    protected $user;
    protected $groups;
    protected $projects;
    protected $projectRepository;
    protected $groupRepository;
    protected $taskRepository;
    protected $userRepository;
    public function __construct(TaskRepository $taskRepository,
                                GroupRepository $groupRepository,
                                ProjectRepository $projectRepository,
                                UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('tasks')->only('create','edit','update','store');
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->user = Auth::user();
    }
    public function setProjectsForUserAuthenticated()
    {
        switch ($this->user->role) {
            case 'admin':
                $this->projects = $this->projectRepository->getAll();
                break;
            case 'director':
                $this->projects = $this->projectRepository->ofDirector($this->user);
                break;
            default:
                $this->projects = $this->projectRepository->ofUserParticipating($this->user);
                break;
        }
    }

    public function getButtons($task)
    {
        $buttons = "";
        if(Gate::allows('edit-task', $task))
        {
            $buttons .= '<a href="'.route('tasks.edit', ['slug' => $task->slug]).'" data-toggle="tooltip" data-placement="top" title="Editar tarea" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>&nbsp;';
        }
        $buttons .= '<a href="'.route('tasks.show', ['slug' => $task->slug]).'" data-toggle="tooltip" data-placement="top" title="Revisar tarea" class="btn btn-sm btn-info"><i class="fa fa-file"></i></a>&nbsp;';
        return $buttons;
    }

    public function rules($task)
    {
        $rules = [
            'title' => 'required|min:10|max:60',
            'description' => 'required',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => isset($task) ? 'required|date_format:d/m/Y|after:created_at' :  'required|date_format:d/m/Y|after:today',
            'end_date' => 'required|date_format:d/m/Y|after:start_date',

        ];
        return $rules;
    }
    
    public function messages()
    {
        return [
            'title.required' => 'Debes asignar un titulo',
            'title.min'=> 'El titulo debe tener almenos 10 caracteres.',
            'title.max'  => 'El titulo debe tener un maximo de 60 caracteres.',
            'description.required'  => 'Debes asignar una descripcion',
            'project_id.required' => 'Debes seleccionar un proyecto',
            'project_id.exists' => 'El proyecto seleccionado no existe en la base de datos',
            'user_id.required' => 'Debes asignar a un usuario',
            'user_id.exists' => 'El usuario seleccionado no existe en la base de datos',
            'start_date.required' => 'Debes seleccionar una fecha de inicio',
            'start_date.after' => 'La fecha de inicio no puede ser superior a la fecha limite de una tarea',
            'end_date.required' => 'Debes seleccionar una fecha de limite para esta tarea',
            'end_date.after' => 'La fecha de limite no puede ser superior a la fecha de inicio de la tarea'
        ];
    }

    public function buildDatatable($tasks)
    {
        return Datatables::collection($tasks)
            ->addColumn('action', function ($task) {
                return $this->getButtons($task);
            })->editColumn('user_id', function($data){
                return $this->user == $data->user ? '<strong class="text-danger">'.$data->user->username.'</strong>': $data->user->username;
            })->editColumn('end_date', function($data){
                return $data->end_date->format('d/m/Y');
            })->editColumn('project_id', function($data){
                return $data->project->title;
            })
            ->make(true);
    }
    public function datatable()
    {
        //setea las tareas del usuario autenticado
        $this->setTasksForUserAuthenticated();
        return $this->buildDatatable($this->tasks);     
    }

    public function tasksOfProject(Project $project)
    {
        $tasks = $project->tasks;
        return $this->buildDatatable($tasks);
    }
    public function index()
    {
        return view('tasks.datatables');
    }

    public function tasksOfProjectView()
    {
        return view('tasks.tasksOfProjectDatatable');
    }

    public function setTasksForUserAuthenticated()
    {
        switch ($this->user->role) {
            case 'admin':
                $this->tasks = $this->taskRepository->getAll();
                break;
            case 'director':
                $this->tasks = $this->taskRepository->getOfDirector($this->user);
                break;
            case 'investigador':
                $this->tasks = $this->taskRepository->getOfInvestigator($this->user);
                break;
            default:
                $this->tasks = $this->taskRepository->getTasks($this->user);
                break;  
        }
    }


    public function create()
    {
        $this->setProjectsForUserAuthenticated();
        return view('tasks.create')->with('projects', $this->projects);
    }


    public function store(Request $request)
    {
        
        $this->validate($request, $this->rules(null), $this->messages());
        $task = new Task($request->except('filter','_token'));
        $task->save();
        
        $user = $task->user;
        $message = "Se te ah asignado a una tarea";
        $link = 'tasks/'.$task->getSlug(); 
        $this->sendAppNotification($user->id,$message,'info',$link);
        Mail::send('emails.reminder', ['task' => $task ], function ($m) use ($user, $message) {
            $m->to($user->email, $user->username)->subject($message);
        });
        Flash::success('Tarea creada correctamente');
        return redirect('tasks');
    }


    public function show($slug)
    {
        $task = $this->taskRepository->getTask($slug);
        
        //selecciona los usuarios asignados al proyecto, excepto a los usuarios directores
        $users = $task->project->group->users->filter( function($u){
            return !$u->isDirector();
        });
        $options = [
                        '0' => 'Seleccione',
                        '1' => 'Aprobar',
                        '2' => 'Rechazar',
                        '3' => 'Asignar a otro usuario'];

        return view('tasks.show')->with('task', $task)->with('users', $users)->with('options', $options);
    }

    public function edit($slug)
    {
        $this->setProjectsForUserAuthenticated();
        $this->task = $this->taskRepository->getTask($slug);
        return view('tasks.edit')->with('projects', $this->projects)
                                 ->with('task', $this->task);

    }

    public function alerts()
    {
        $tasks = Task::where('status', '<>', 'Finalizado')->whereBetween('end_date', [Carbon::now(),new Carbon('next week') ])->get();
        dd($tasks);
        return $tasks;
    }
    public function update(Request $request, $slug)
    {
        $task = $this->taskRepository->getTask($slug);
        $current_user = $task->user;
        $this->validate($request, $this->rules($task));
        $task->fill($request->except('_token, filter, created_at, user'));
        if($task->save())
        {
            Flash::info('Tarea editada correctamente!');
        }
            
        return redirect()->route('tasks.edit', [$task->slug]);
        
    }


    public function destroy($slug)
    {
        $task = $this->taskRepository->getTask($slug);
        $task->delete();
        Flash::error('Tarea eliminada correctamente!!');
        return redirect('/tasks');
    }

    public function insertComment(Request $request, $slug)
    {

        $task = $this->taskRepository->getTask($slug);
        $investigators = $this->groupRepository->getInvestigators($task->project->group);
        $comment = new Comment;
        $comment->user_id = $this->user->id;
        $comment->body = $request->body;
        if($task->comments()->save($comment))
        {
            $task->status = "Esperando confirmacion";
            $task->save();
            
            $message = "Han respondido a tu tarea!";
            $link = 'tasks/'.$task->getSlug(); 

            foreach ($investigators as $user) {    
                $this->sendAppNotification($user->id, $message,'info', $link);
                Mail::send('emails.answer', ['user' => $user, 'task' => $task ], function ($m) use ($user, $message) {
                    $m->to($user->email, $user->username)->subject($message);
                });     
            } 
            
            Flash::success('Se ah enviado tu respuesta!');
        }
        return redirect()->route('tasks.show', [$task->slug]);
    }
    public function replyComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $newComment = new Comment;
        $newComment->user_id = $this->user->id;
        $newComment->body = $request->body;
        $newComment->save();
        $newComment->makeChildOf($comment);

        $user = ($comment->user == $this->user) ? $newComment->user : $comment->user; 
        $message = "Han respondido a tu tarea!";
        $task = $this->taskRepository->getTask($request->task);
        $link = 'tasks/'.$task->getSlug(); 
        

        $this->sendAppNotification($user->id, $message,'info', $link);
        Mail::send('emails.answer', ['user' => $user, 'task' => $task ], function ($m) use ($user, $message) {
            $m->to($user->email, $user->username)->subject($message);
        });
        
        Flash::info('Tu respuesta fue enviada!!');
        return redirect()->back();
    }

    public function approveRefuseTask(Request $request, $slug)
    {   
        $task = $this->taskRepository->getTask($slug);
        $user = $task->user;
        $link = 'tasks/'.$task->getSlug(); 
        switch ($request->approve_refuse) {
            case 0:
                Flash::error('Debes seleccionar una opcion!');
                return redirect()->back();
                break;
            case 1:
                $task->status = 'Finalizado';
                $status = 'Finalizada';
                $message = "Se ah aprobado tu tarea!"; 
                $task->save();
                Flash::success('Se ah aprobado la tarea, felicitaciones!');
                break;
            case 2:
                $task->status = 'Rechazado';
                $status = 'Rechazada';
                $message = "Se ah rechazado tu tarea!";
                $task->save();
                Flash::info('Se ah rechazado la tarea!');
                break;
            case 3:
                
                if($request->has('user')){
                    $this->validate($request, [ 'user' => 'required|exists:users,id'
                        ]);
                    //se valida que exista el usuario, luego se le informa al usuario desplazado que ah sigo
                    //desplazado de su tarea
                    $message= "Se ah asignado tu tarea a otro usuario!";
                    $this->sendAppNotification($user->id, $message,'info',$link);
                    //se obtiene el usuario que sera el reemplazo
                    $user = $this->userRepository->getUser($request->user);
                    $task->user_id = $user->id;
                    $task->status = "Sin responder";
                    $status = 'assigned';
                    $message = "Has sido asignado a una tarea";
                    $this->sendAppNotification($user->id, $message,'info',$link);
                    Mail::send('emails.approve_refuse', ['task' => $task, 'status' => $status ], function ($m) use ($user, $message) {
                    $m->to($user->email, $user->username)->subject($message);
                    });
                    $task->save();
                    Flash::info('Se ah asignado la tarea a otro usuario');
                    return redirect()->route('tasks.show', [$task->slug]);
                }
                break;      
        }
        $this->sendAppNotification($user->id,$message,'info',$link);
                Mail::send('emails.approve_refuse', ['task' => $task, 'status' => $status ], function ($m) use ($user, $message) {
                    $m->to($user->email, $user->username)->subject($message);
                });
        return redirect()->route('tasks.show', [$task->slug]);

    }
}
