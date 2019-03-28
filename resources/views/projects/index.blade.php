@extends('adminlte::page')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Lista de proyectos')

@section('css')
    {!! Html::style('src/css/jquery.dataTables.min.css') !!}
    {!! Html::style('src/css/dataTables.jqueryui.css') !!}
@endsection
@section('content_header')
    <h2><i class="fa fa-folder-open"></i> Proyectos creados</h2>
    <p>Mostrando todos los proyectos registrados en el sistema</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Mis Proyectos
                    </h3>
                    @if(!Auth::user()->isScholar())
                    <div class="box-tools pull-right">
                        <a href="{{route('projects.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Crear proyecto</a>
                    </div>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-hover table-condensed" id="projects">
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
    {!! Html::script('app/projects/projects-datatables.js') !!}
@endsection