<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ProjectRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;
use Datatables;
use Auth;
use Laracasts\Flash\Flash;
use App\Traits\Notificable;
use Mail;
use Gate;
class ProjectsController extends Controller
{
    use Notificable;
    protected $user;
    protected $group;
    protected $projects;
    protected $projectRepository;
    protected $groupRepository;
    protected $userRepository;
    public function __construct(ProjectRepository $projectRepository,
                                GroupRepository $groupRepository,
                                UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('projects')->only('create','edit','update');
        $this->middleware('assigns')->only('assignShow', 'assign');
        $this->user = Auth::user();
        $this->projectRepository = $projectRepository;
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }
    public function setProjectsForUserAuthenticated()
    {
        switch ($this->user->role) {
            case 'director':
                $this->projects = $this->projectRepository->ofDirector($this->user);
            case 'admin':
                $this->projects = $this->projectRepository->getAll();
                break;
            default:
                $this->projects = $this->projectRepository->ofUserParticipating($this->user);
                break;
        }
    }
    public function getButtons($project)
    {
        $buttons = "";
        if(Gate::allows('edit-project', $project))
        {
            $buttons .= '<a href="'.route('projects.edit', ['slug' => $project->slug]).'" data-toggle="tooltip" data-placement="top" title="Editar proyecto" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>&nbsp;';
        }  
        $buttons .= '<a href="'.route('projects.show', ['slug' => $project->slug]).'" data-toggle="tooltip" data-placement="top" title="Revisar Proyecto" class="btn btn-sm btn-info"><i class="fa fa-folder-open"></i></a>&nbsp;';
        return $buttons;
    }
    public function datatable()
    {
        $this->setProjectsForUserAuthenticated();

        return Datatables::collection($this->projects)
            ->addColumn('action', function ($project) {
                return $this->getButtons($project);
            })->editColumn('user_id', function($data){
                return $data->user->username;
            })->editColumn('group_id', function($data){
                return $data->group->name;
            })->make(true);

    }

    public function usersProject(Request $request, $id)
    {
        $project = $this->projectRepository->getProject($id);
        $users = $this->groupRepository->getUsers($project->group);
        //si es investiador se elimina de la lista seleccionable
        
        if($users->contains($this->user))
        {
           $users= $users->except($this->user->id);
        }
        if($request->ajax())
        {
            return response()->json($users);
        }
        return $users;
    }
    public function rules()
    {
        return [
            'title' => 'required|min:10|max:200',
            'keyword' => array('required','regex:/[a-z0-9][a-z0-9]/','min:6'),
            'description' => 'required|min:10',
            'group_id' => 'required|exists:groups,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Debes asignar un titulo',
            'keyword.regex' => 'La palabra clave debe ser una cadena sin espacios!',
            'description.required'  => 'Debes asignar una descripcion',
            'group_id.required' => 'Debes seleccionar un grupo de investigacion',
            'group_id.exists' => 'El grupo seleccionado no existe en la base de datos',
            'keyword.required' => 'Debes asignar una palabra clave para el proyecto'
        ];
    }

    public function setGroupsOfUserAuthenticated()
    {
        switch ($this->user->role) {
            case 'admin':
                $this->group = $this->groupRepository->getAll();
                break;
            case 'director':
                $this->group =$this->groupRepository->getOfDirector($this->user);
                break;
            default:
                $this->group = $this->groupRepository->getGroupsOfUserParticipating($this->user);
                break;
        }
        
    }
    public function index()
    {
        return view('projects.index');
    }

    public function create()
    {
        $this->setGroupsOfUserAuthenticated();
        if($this->group->count() == 0)
        {
            Flash::info('Debes crear un grupo de investigacion antes!');
            return redirect()->to('users/groups/create');
        }
        return view('projects.create')->with('groups', $this->group);
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->messages());
        $project = new Project($request->only('title', 'keyword', 'description', 'group_id'));
        /* cuando no es director*/
        if ($request->has('user_id')) {
            $project->user_id = $request->user_id;
        } else {
            /* es director */
            $project->user_id = $this->user->id;
        }
        if ($project->save()) {
            foreach($project->group->users as $user)
            {
                if($user->id != $this->user->id)
                {
                    $this->sendAppNotification($user->id,'Se te ah asignado un nuevo proyecto','info','projects/'.$project->getSlug());

                    Mail::send('emails.new-project', ['user' => $user,'project' => $project ], function ($m) use ($user) 
                    {
                        $m->to($user->email, $user->name)->subject('Se te ah asignado a un nuevo proyecto');
                    });
                }
            }
            if($project->group->user->id != $this->user->id)
            {
                $user = $project->group->user;
                
                Mail::send('emails.new-project', ['user' => $user,'project' => $project ], function ($m) use ($user) 
                    {
                        $m->to($user->email, $user->name)->subject('Se te ah asignado a un nuevo proyecto');
                    });
                $this->sendAppNotification($project->group->user->id,'Se te ah asignado un nuevo proyecto','info','projects/'.$project->getSlug());
            }
            Flash::success('Proyecto creado correctamente!');
            return redirect('projects');
        }
        else{
            Flash::error('Se produjo un error desconocido!');
            return redirect('projects');
        }
    }

    public function show($slug)
    {
        $this->project = $this->projectRepository->getProject($slug);
        return view('projects.show')->with('project', $this->project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $project = $this->projectRepository->getProject($slug);
        //verifica que el usuario tenga permisos para editar, declarado en providers\AuthServiceProvider
        $this->authorize('edit-project', $project);
        
        $this->setGroupsOfUserAuthenticated();

        return view('projects.edit')->with('project', $project)
                                    ->with('groups',$this->group);


    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules());
        $project = $this->projectRepository->getProject($id);
        $project->fill($request->only('title','keyword','group_id', 'description'));
        if($request->has('user_id'))
        {
            $project->user_id = $request->user_id;
        }
        $project->save();
        Flash::info('Proyecto actualizado correctamente!!');
        return redirect('/projects');
    }

    public function assignShow($slug, $id)
    {
        $user = $this->userRepository->getUser($id);
        $project = $this->projectRepository->getProject($slug);
        $roles = [ 'becario' => 'Becario', 'investigador' => 'Investigador'];
        return view('users.assign')->with('user', $user)
                                   ->with('project', $project)
                                   ->with('roles', $roles);
    }

    public function assign(Request $request, $id)
    {
        $project = $this->projectRepository->getProject($request->slug);
        $user = $this->userRepository->getUser($id);
        $user->role = $request->role;
        $user->save();
        $message = "Se te ah asignado como investigador en un proyecto!";
        $link = 'projects/'.$project->getSlug(); 
        $this->sendAppNotification($user->id,$message,'info',$link);
        Mail::send('emails.assigned_to_investigator', ['project' => $project, 'user' => $user ], function ($m) use ($user,$message) {
                    $m->to($user->email, $user->username)->subject($message);
                });
        Flash::success('Usuario asignado correctamente!!');
        return redirect()->route('users.assignShow', [$project->slug, $user->id]);
    }

    public function destroy($slug)
    {
        $project = $this->projectRepository->getProject($slug);
        $project->delete();
        Flash::error('Proyecto eliminado correctamente!!');
        return redirect('/projects');
    }
}
