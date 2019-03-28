<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

use Datatables;
use Laracasts\Flash\Flash;
use Validator;
use App\Repositories\UserRepository;

class UsersController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin')->except('assign');
        $this->userRepository = $userRepository;
    }

    public function rules()
    {
        return [
            'username' => 'min:6|max:20|required',
            'email' => 'email|unique:users|required',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,director,investigador,becario'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es requerido',
            'username.min' => 'El nombre de usuario debe tener minimo 6',
            'username.max' => 'el nombre de usuario debe tener como maximo 20 caracteres',
            'email.required'  => 'El campo email es requerido',
            'password.required' => 'Debes agregar una constraseña',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres',
            'role.required' => 'Debes asignarle un rol'
        ];
    }

    public function index()
    {
        return view('users.datatables');
    }
    public function datatables()
    {
        return Datatables::collection(User::all())
                                    ->addColumn('action', function ($user) {
                                            return $this->getButtons($user);
                                    })->make(true);
    }
    public function roles()
    {
        return [
            'admin' => 'Administrador',
            'director'=> 'Director',
            'investigador' => 'Investigador',
            'becario' => 'Becario'];
    }



    public function create()
    {
        return view('users.create')->with('roles', $this->roles());
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if($request->ajax())
        {
            return response()->json($user);
        }
        return view('users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user', $user)
            ->with('roles', $this->roles());
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($request->email != $user->email)
        {
            $this->validate($request, [
                'email' => 'required|unique:users|email']);
        }
        if($request->name != $user->name)
        {
            $this->validate($request, [
                'name' => 'required|min:6'
            ]);
        }
        $user->fill($request->all());
        $user->save();
        Flash::info('Usuario actualizado correctamente!');
        return redirect()->to('/users');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();
        Flash::success('Usuario creado correctamente');
        return redirect()->to('/users/create');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Flash::info('Usuario eliminado correctamente!!');
        return redirect('/users');
    }

    public function getButtons($user)
    {
        $buttons = "";
        $buttons .= '<a href="'.route('users.edit', ['id' => $user->id]).'" data-toggle="tooltip" data-placement="top" title="Editar usuario" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>&nbsp;';
        $buttons .= '<a href="'.route('users.show', ['id' => $user->id]).'" data-toggle="tooltip" data-placement="top" title="Revisar usuario" class="btn btn-sm btn-info"><i class="fa fa-user"></i></a>&nbsp;';

        return $buttons;
    }
}