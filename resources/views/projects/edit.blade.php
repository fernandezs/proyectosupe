@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/chosen.css') !!}
@endsection
@section('title', 'Editar Proyhecto de investigacion')

@section('content_header')
    <h2><i class="fa fa-group"></i> Crear Proyecto de investigacion</h2>
    <p>Agregue toda la información solicitada para crear el proyecto</p>
@endsection
@section('content')
    <div class="row">
        {!! Form::model($project, ['route' => ['projects.update', $project->slug ], 'method' => 'PUT'])!!}
        @include('projects.partials.form')
    </div>
@endsection
@section('js')
    {!! Html::script('app/projects/project-edit.js') !!}
@endsection