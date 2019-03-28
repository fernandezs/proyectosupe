@extends('adminlte::page')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Lista de tareas')

@section('css')
    {!! Html::style('src/css/jquery.dataTables.min.css') !!}
    {!! Html::style('src/css/dataTables.jqueryui.css') !!}
@endsection
@section('content_header')
    <h2><i class="fa fa-tasks"></i> Tareas</h2>
    <p>Admintración de tareas del sistema, como investigador se te asignaran tareas y tambien deberas corregir las de los usuarios.</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Tareas pendientes
                    </h3>
                    @if(!Auth::user()->isScholar())
                    <div class="box-tools pull-right">
                        <a href="{{route('tasks.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Crear tarea</a>
                    </div>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-hover table-condensed" id="tasks">
                        <thead>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {!! Html::script('src/js/jquery.dataTables.min.js') !!}
    {!! Html::script('app/tasks/tasks-datatables.js') !!}
@endsection