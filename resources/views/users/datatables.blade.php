@extends('adminlte::page')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title', 'Lista de usuarios')

@section('css')
    {!! Html::style('src/css/jquery.dataTables.min.css') !!}
    {!! Html::style('src/css/dataTables.jqueryui.css') !!}
@endsection
@section('content_header')
    <h2><i class="fa fa-users"></i> Usuarios registrados</h2>
    <p>Mostrando todos los usuarios registrados en el sistema</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Usuarios del sistema
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="{{route('users.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i> Crear usuario</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-condensed" id="users">
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
    {!! Html::script('app/users/users-datatables.js') !!}
@endsection