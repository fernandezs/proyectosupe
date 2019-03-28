<?php

namespace App\Http\Controllers;

//use Baum\Extensions\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Group;
use Datatables;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\TaskRepository;
use Laracasts\Flash\Flash;
use Gate;
use Mail;
use Illuminate\Support\Collection as Collection;
use App\Traits\Notificable;

class GroupsController extends Controller
{
    use Notificable;
    //el usuario logueado
    protected $user;
    //el que llevara a cabo todas las consultas
    protected $userRepository;
    //cuando se llama al dtable se llena con el grupo correspondiente
    protected $groups;
    //el que llevara a cabo todas las consultas
    protected $groupRepository;
    protected $taskRepository;

    public function __construct(UserRepository $userRepository, GroupRepository $groupRepository, TaskRepository $taskRepository)
    {
        $this->middleware('auth');
        $this->middleware('groups')->only('create','update');
        $this->user = Auth::user();
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->taskRepository = $taskRepository;
    }
    public function setGroupsForUserAuthenticated()
    {
        if($this->user->isAdmin())
        {
            $this->groups = $this->groupRepository->getAll();
        }
        elseif($this->user->isDirector()){
            $this->groups = $this->groupRepository->getOfDirector($this->user);
        }
        else
        {
            $this->groups = $this->groupRepository->getGroupsOfUserParticipating($this->user);

        }
    }
    public function getButtons($group)
    {
        $buttons = "";
        if(Gate::allows('edit', $group))
        {
            $buttons .= '<a href="'.route('users.groups.edit', ['slug' => $group->slug]).'" data-toggle="tooltip" data-placement="top" title="Editar Grupo" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>&nbsp;';
        }
        $buttons .= '<a href="'.route('users.groups.show', ['slug' => $group->slug]).'" data-toggle="tooltip" data-placement="top" title="Ver grupo" class="btn btn-sm btn-info confirm-delete"><i class="fa fa-group"></i></a>&nbsp;';

        return $buttons;
    }
    public function datatable()
    {
        $this->setGroupsForUserAuthenticated();
        return Datatables::collection($this->groups)
            ->addColumn('action', function ($group) {
                return $this->getButtons($group);
            })->editColumn('user_id', function($data){
                return $data->user->username;
            })
            ->make(true);
    }
    public function usersGroup(Request $request, $id)
    {
        $groups =$this->groupRepository->getUsersForGroup($id);
        if($request->ajax())
        {
            return response()->json($groups);
        }
        return $groups;
    }

    public function index()
    {
        if(count($this->groupRepository->getAll()) <= 0){
            Flash::info('Crea un grupo antes!');
            return redirect('users/groups/create');
        }
        return view('users.groups.datatables');
    }

    public function create()
    {
        $investigators = $this->userRepository->cmbOfUsers('investigador');
        $scholars = $this->userRepository->cmbOfUsers('becario');
        $directors = $this->userRepository->cmbOfUsers('director');
        if($this->user->isInvestigator())
        {
            /* si el usuario logueado es investigador, este se elimina de la lista seleccionable en investigadores*/
            $investigators = $investigators->get()->filter(function($u){
                return $u->id != $this->user->id;
            });
        }
        /* sin un usuario director no se puede crear un grupo de investigacion*/
        if(count($directors) <= 0)
            {
                Flash::info('Debe haber al menos un director creado en el sistema!');
                return redirect('/users/create');
            }
            return view('users.groups.create')->with('directors', $directors)
                ->with('investigators',$investigators)
                ->with('scholars', $scholars);
    }


    public function show($slug)
    {
        $group = $this->groupRepository->getGroup($slug);
        $investigators = $this->groupRepository->getInvestigators($group);
        $scholars = $this->groupRepository->getScholars($group);
        $directors = $this->userRepository->cmbOfUsers('director');
        $tasks = $this->taskRepository->getOfGroup($group->id);
        return view('users.groups.show')->with('group', $group)
                                        ->with('directors', $directors)
                                        ->with('investigators',$investigators)
                                        ->with('scholars',$scholars)
                                        ->with('tasks', $tasks);
    }

    public function edit($slug)
    {
        $group = $this->groupRepository->getGroup($slug);
        /* solo el usuario que creo el grupo puede modificarlo, excepto que sea un administrador*/
        $this->authorize('owner', $group);
        $directors_all = $this->userRepository->cmbOfUsers('director')->get();
        $investigators_all = $this->userRepository->cmbOfUsers('investigador')->get();
        $scholars_all = $this->userRepository->cmbOfUsers('becario');
        if($this->user->isInvestigator())
        {
            /* si el usuario logueado es investigador, este se elimina de la lista seleccionable en investigadores*/
            $investigators_all = $investigators_all->filter(function($u){
                return $u->id != $this->user->id;
            });
        }
        $investigators = $this->groupRepository->getInvestigators($group);
        $scholars = $this->groupRepository->getScholars($group);
        return view('users.groups.edit')->with('group', $group)
                                        ->with('investigators',$investigators)
                                        ->with('scholars',$scholars)
                                        ->with('directors_all', $directors_all)
                                        ->with('investigators_all',$investigators_all)
                                        ->with('scholars_all',$scholars_all);
    }

    public function store(Request $request)
    {
        //$users_selected = ;
        
        $this->validate($request, [
            'name' => 'required|unique:groups|min:8',
        ]);

        $group = new Group();
        $group->name = $request->name;
        $group->owner = $this->user->id;
        //asigna un director al grupo
        if($request->has('user_id'))
        {
            $group->user_id = $request->user_id;
        }
        //es un director
        else
        {
            $group->user_id = $this->user->id;
        }
        if($group->save())
        {
            if($group->user_id != $this->user->id)
            {
                $this->sendAppNotification($group->user_id,'El usuario '.$this->user->name.' te ah asignado como director en un nuevo grupo de investigacion','info','/users/groups/'.$group->getSlug());
            }
            //si es investigador
            if($this->user->isInvestigator())
            {
                $group->users()->attach($this->user);
            }
            //une ambos arrays en una coleccion
            $users_selected= collect()->merge($request->scholars_selected)
                                      ->merge($request->investigators_selected);
            
            foreach($users_selected as $user)
            {
                $this->sendAppNotification($user,'Se te ah asignado a un nuevo grupo de investigacion','info','/users/groups/'.$group->getSlug());
                    $group->users()->attach($user);  
                $user = $this->userRepository->getUser($user);
                Mail::send('emails.new-group', ['user' => $user, 'group' => $group ], function ($m) use ($user)
                {
                    $m->from('proyectos@upe.com', 'Gestion de Proyectos UPE');
                    $m->to($user->email, $user->name)->subject('Se te ah asignado a un nuevo grupo de investigacion');
                }); 
            }
            /*
            if($request->has('investigators_selected'))
            {
                foreach($request->investigators_selected as $investigator)
                {
                    $this->sendAppNotification($investigator,'Se te ah asignado a un nuevo grupo de investigacion','info','/users/groups/'.$group->getSlug());
                    $group->users()->attach($investigator);
                }
            }
            if($request->has('scholars_selected'))
            {
                foreach($request->scholars_selected as $scholar)
                {
                    $this->sendAppNotification($scholar,'Se te ah asignado a un nuevo grupo de investigacion','info','/groups/'.$group->getSlug());
                    $group->users()->attach($scholar);
                }
            }*/
        }
        Flash::success('Grupo de usuarios creado Exitosamente!!');
        return redirect('/users/groups/create');
    }

    public function update(Request $request, $slug)
    {
        $group = $this->groupRepository->getGroup($slug);
        $investigators = $this->groupRepository->getInvestigators($group);
        $scholars = $this->groupRepository->getScholars($group);

        if($request->name != $group->name)
        {
            $this->validate($request,[
                'name' => 'min:8|unique:groups'
            ]);
        }
        if($this->user->isDirector())
        {
            $group->fill($request->only('name'));
        }
        else
        {
            if($request->user_id != $group->user_id)
            {
                $this->validate($request, [
                    'user_id' => 'required|exists:users,id'
                ]);
            }
            $group->fill($request->only('name', 'user_id'));
        }

        if($group->save())
        {
            //recorre los investigadores del grupo, si no encuentra uno lo quita de la relacion
            foreach($investigators as $i)
            {
                
                if(! in_array($i->id, $request->investigators_selected))
                {
                    if($i->id == $this->user->id)
                    {
                        //no permite que el usuario logueado sea eliminado del grupo
                    }
                    else
                    {
                        $group->users()->detach($i);
                    }

                }
            }
            //idem para los becarios
            foreach($scholars as $s)
            {
                if(! in_array($s->id, $request->scholars_selected))
                {
                    $group->users()->detach($s);
                }
            }
            if($request->has('investigators_selected'))
            {
                //recorre la respuesta del formulario, si encuentra uno que no este ya en los investigadores del grupo, lo agrega.
                foreach($request->investigators_selected as $investigator)
                {
                    if(! $investigators->contains($investigator))
                    {
                        $group->users()->attach($investigator);
                    }
                }
            }

            if($request->has('scholars_selected'))
            {
                foreach($request->scholars_selected as $scholar)
                {
                    if(! $scholars->contains($scholar))
                    {
                        $group->users()->attach($scholar);
                    }
                }
            }

        }
        Flash::info('Grupo actualizado correctamente');
        return redirect('/users/groups');
    }

    public function destroy($slug)
    {
        $group = $this->groupRepository->getGroup($slug);
        $this->authorize('owner', $group);
        $group->delete();
        Flash::error('Grupo eliminado correctamente!!');
        return redirect('/users/groups');
    }
}
