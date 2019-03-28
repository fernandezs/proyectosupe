<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Laracasts\Flash\Flash;
use Hash;
use File;

class ProfileController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('web');
        $this->user = Auth::user();
    }

    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'Ya existe un usuario con ese nombre',
            'username.min' => 'El nombre de usuario debe tener entre 6 y 20 caracteres',
            'email.required'  => 'El email es requerido',
            'password.required' => 'El campo password es requerido'
        ];
    }

    public function show(User $user)
    {
        return view('users.profile.show')->with('user', $user);
    }

    public function edit()
    {
        return view('users.profile.edit')->with('user', $this->user);
    }
    public function update(Request $request)
    {
        $user = $this->user;
        $this->validate($request, ['password' => 'required']);
        if($request->password != Hash::check($request->password, $user->password))
        {
            Flash::error('La contraseña que ingresaste no coincide con nuestros registros!');
            return redirect('profile');
        }
        else
        {
            if($request->username != $user->username)
            {
                $this->validate($request, ['username' => 'required|unique:users|min:6'], $this->messages());
                $user->username = $request->username;
            }
            if($request->email != $user->email)
            {
                $this->validate($request, ['email' => 'required|unique:users|email|min:6']);
                $user->email = $request->email;
            }
            if($request->hasFile('image'))
            {
                $this->validate($request, [
                    'image' => 'required|image|mimes:jpeg,bmp,png,jpg|max:1024*1014*1'
                ]);
                $name = str_random(30);
                //Storage::put('profiles/'.$name,file_get_contents($request->file('image')->getRealPath()));
                //si existe un archivo previamente lo borra
                File::delete($user->image);
                $request->file('image')->move('profiles', $name);
                $user->image = 'profiles/'.$name;
            }
            $user->save();
            Flash::info('Datos actualizados correctamente!');
            return redirect('profile');
        }

        

    }
    public function editPassword()
    {
        return view('users.profile.change_password');
    }
    public function changePassword(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'password' => 'required|min:6',
            'password_new' => 'required|min:6|confirmed'
        ]);
        if($request->password != Hash::check($request->password, $user->password))
        {
            Flash::error('La contraseña que ingresaste no coincide con nuestros registros!');
            return redirect('profile/change-password');
        }
        else
        {
            $user->password = bcrypt($request->password_new);
            $user->save();
            Flash::success('Contraseña actualizada correctamente!');
            return redirect('profile/change-password');
        }
    }
}
