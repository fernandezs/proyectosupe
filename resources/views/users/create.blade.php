@extends('adminlte::page')
@section('title', 'Crear Usuario')

@section('content_header')
    <h2><i class="fa fa-user"></i> Crear usuario</h2>
    <p>Agregue toda la información solicitada para crear el usuario</p>
@endsection
@section('content')
        {!! Form::open(['route' => 'users.store']) !!}
        <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    @include('users.user-form')
                    {!! Form::label('password', 'Contraseña') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                    @if($errors->has('password'))
                        <span class="help-block">
                            <strong class="text-red">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-user-plus"></i> Crear</button>
        </div>
        </div>
    {!! Form::close() !!}
@endsection
