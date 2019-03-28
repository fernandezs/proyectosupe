@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/chosen.css') !!}
    {!! Html::style('src/css/jquery.dataTables.min.css') !!}
    {!! Html::style('src/css/dataTables.jqueryui.css') !!}
@endsection
@section('title', 'Proyecto de investigacion')

@section('content_header')
    <h2><i class="fa fa-folder-open"></i>{{ $project->title }}</h2>
    <p>{{ $project->description }}</p>
    {!! Form::text('project_id', $project->id, ['hidden', 'id' => 'project_id'])!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-offset-1">
            <ul class="list-inline">
            <li><strong><span class="fa fa-user"> </span>Director: </strong><span>{{ $project->group->user->username }}</span></li>
            <li><strong><span class="fa fa-group"></span> Pertenece al Equipo: </strong> {{ $project->group->name }}</li>
            <li><strong>Participantes en el grupo: </strong><span>{{ count($project->group->users )}}</span></li>
            <li><strong>Cantidad de tareas: </strong><span>{{ count($project->tasks)}}</span></li>
        </ul>
        <br>
        </div>
    </div>
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                        <div class="col-md-5">
        <h4><i class="fa fa-group"></i> Usuarios del proyecto:</h4>
        <hr>
            <table class="table table-striped table-bordered" id="users">
                <thead>
                    <tr>
                        <td>Usuario</td>
                        <td>Rol</td>
                        @can('assign-role', $project)
                            <td>Asignar rol</td>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                @foreach( $project->group->users as $user )
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        @can('assign-role', $project)
                            @if($user->isScholar())
                                <td>
                                <a href='/users/assign/{{$project->slug}}/{{$user->id}}')}} data-toggle="tooltip" data-placement="top" title="Asignar rol" class="btn btn-sm btn-info"><i class="fa fa-user"></i></a>
                                </td>
                            @endif
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-7">
        <h4><i class="fa fa-tasks"></i> Tareas</h4>
        <hr>
            <table class="table table-striped table-bordered" id="tasks">
                <thead>
                    <tr>
                        <td>Titulo</td>
                        <td>Fecha limite</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                @foreach( $project->tasks as $task )
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->end_date->format('d/m/Y') }}</td>
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
    {!! Html::script('app/projects/project-show.js')!!}
@endsection