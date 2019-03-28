@extends('adminlte::page')
@section('title', 'Editar tarea')
@section('content_header')
    <h1>Editar tarea: <strong>{{ $task->title }}</strong>   </h1>
@endsection
@section('content')
    <div class="row">
        {!! Form::model($task,['route' => ['tasks.update', $task->slug], 'method' => 'PUT']) !!}
        @include('tasks.tasks-form')
        @include('tasks.task-form-select-user-for-project')
    </div>
@endsection
@section('js')
    {!! Html::script('src/js/bootstrap-datepicker.js') !!}
    {!! Html::script('src/js/bootstrap-datepicker.es.min.js') !!}
    {!! Html::script('app/tasks/task-edit.js') !!}
@endsection