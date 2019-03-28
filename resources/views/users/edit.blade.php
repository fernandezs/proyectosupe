@extends('adminlte::page')
@section('content_header')
    <h2><i class="fa fa-edit"></i> Editar usuario {{ $user->name }}</h2>
    <p>Agregue toda la información solicitada para modificar el usuario</p>
@endsection

@section('content')
    {!! Form::model($user,['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    @include('users.user-form')
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-6">
                {!! Form::submit('Actualizar usuario', ['class' => 'btn btn-info']) !!}
                {!! Form::close() !!}
                @include('users.destroy')
            </div>
            </div>
        </div>
    </div>
    
@endsection
