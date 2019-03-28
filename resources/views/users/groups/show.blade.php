@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/jquery.dataTables.min.css') !!}
    {!! Html::style('src/css/dataTables.jqueryui.css') !!}
@endsection
@section('title', 'Grupo de investigacion')

@section('content_header')
    <h2><i class="fa fa-group"></i>{{ $group->name }}</h2>
    <p>Informacion del grupo de investigacion</p>

@endsection
@section('content')
    <div class="row">
        <div class="col-md-offset-1">
            <ul class="list-inline">
            <li><strong><span class="fa fa-user"> </span>Director: </strong><span>{{ $group->user->username }}</span></li>
            <li><strong><span class="fa fa-group"></span> Nombre del Equipo: </strong> {{ $group->name }}</li>
            <li><strong>Participantes en el grupo: </strong><span>{{ count($group->users )}}</span></li>
            <li><strong>Cantidad de tareas: </strong><span>{{ count($tasks)}}</span></li>
        </ul>
        <br>
        </div>
    </div>
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                        <div class="col-md-4">
        <h4><i class="fa fa-group"></i> Usuarios del grupo:</h4>
        <hr>
            <table class="table table-striped table-bordered" id="users">
                <thead>
                    <tr>
                        <td>Usuario</td>
                        <td>Rol</td>
                    </tr>
                </thead>
                <tbody>
                @foreach( $group->users as $user )
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-8">
        <h4><i class="fa fa-tasks"></i> Tareas</h4>
        <hr>
            <table class="table table-striped table-bordered" id="tasks">
                <thead>
                    <tr>
                        <td>Titulo</td>
                        <td>Fecha limite</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                @foreach( $tasks as $task )
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->end_date->format('d/m/Y') }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <a href="{{ route('tasks.show', ['slug' => $task->slug])}}" data-toggle="tooltip" data-placement="top" title="Revisar tarea" class="btn btn-sm btn-info"><i class="fa fa-file"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>
    {!! link_to(URL::previous(), 'Volver', ['class' => 'btn btn-warning']) !!}
@endsection
@section('js')
    {!! Html::script('src/js/chosen.jquery.js') !!}
    {!! Html::script('src/js/jquery.dataTables.min.js') !!}
    {!! Html::script('app/users/groups/group-show.js')!!}
@endsection