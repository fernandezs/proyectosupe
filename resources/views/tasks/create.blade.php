@extends('adminlte::page')
@section('styles')
    {!! Html::style('src/css/bootstrap-datepicker.css') !!}
    {!! Html::style('src/css/bootstrap-datepicker.standalone.css') !!}
@section('content_header')
    <h1>Crear una nueva Tarea</h1>
@endsection
@section('content')
    <div class="row">
        {!! Form::open(['route' => ['tasks.store'], 'method' => 'POST']) !!}
        @include('tasks.tasks-form')
        @include('tasks.task-form-select-user-for-project')
        {!! Form::close() !!}
    </div>
@endsection
@section('js')
    {!! Html::script('src/js/bootstrap-datepicker.js') !!}
    {!! Html::script('src/js/bootstrap-datepicker.es.min.js') !!}
    {!! Html::script('app/tasks/task-create.js') !!}
@endsection
