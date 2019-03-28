@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/chosen.css') !!}
@endsection
@section('title', 'Crear Proyecto de investigacion')

@section('content_header')
    <h2><i class="fa fa-group"></i> Crear Proyecto de investigacion</h2>
    <p>Agregue toda la información solicitada para crear el proyecto</p>
@endsection
@section('content')
    <div class="row">
        {!! Form::open(['route' => 'projects.store', 'method' => 'POST'])!!}
        @include('projects.partials.form')
        {!! Form::close() !!}
    </div>
@endsection
@section('js')
    {!! Html::script('app/projects/project-create.js') !!}
@endsection