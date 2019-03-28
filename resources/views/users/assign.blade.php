@extends('adminlte::page')
@section('content_header')
    <h2><i class="fa fa-user"></i> Informacion usuario: {{ $user->name }}</h2>
    <p>Puedes asignar a un usuario como investigador/becario en un proyecto</p>
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
                        <li>Rol actual: {{$user->role}}</li>
                    </ul>

                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="col-md-6">
                {!! Form::open(['route' => ['users.assign', $user->id], 'method' => 'POST']) !!}
                    <div class="form-group">
                        {!! Form::select('role', $roles, null, ['class' => 'form-control', 'placeholder' => 'Seleccione...']) !!}
                    </div>
                    {!! Form::hidden('slug', $project->slug) !!}
                    {!! Form::submit('Enviar', ['class' => 'btn btn-primary'])!!}
                    {!! link_to(URL::previous(), 'Cancelar', ['class' => 'btn btn-default']) !!}
                    <div class="pull-right">
                        {!! link_to_route('projects.show', $title = "Volver al proyecto", $parameters = [$project->getSlug()], $attributes = ['class' => 'btn btn-info', 'pull-left']) !!}
                    </div>
                 {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection