@extends('adminlte::page')
@section('content_header')
    <h2><i class="fa fa-user"></i> Informacion usuario: {{ $user->name }}</h2>
    <p>Aqui se muestra toda la informacion del usuario, proyectos y/o tareas asignadas</p>
@endsection
@section('content')
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Informacion basica</h3>
                    <ul>
                        <li>Nombre: {{ $user->username }}</li>
                        <li>Email : {{ $user->email }}</li>
                    </ul>

                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
        <div class="box-footer">
            
        </div>
    </div>

@endsection