@extends('adminlte::page')
@section('content')
    <h1 class="page-header">Editar Perfil</h1>
    <div class="row">
        {!! Form::model($user, ['route' => ['profile.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
        <!-- left column -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="text-center">
                <img src="{{ $user->image }}" class="avatar img-circle img-thumbnail" alt="avatar">
                <h6>cambiar imagen de perfil...</h6>
                {!! Form::file('image', ['class' =>'text-center center-block well well-sm']) !!}
            </div>
            @if ($errors->has('image'))
                <span class="help-block">
                            <strong class="text-red control-label">{{ $errors->first('image') }}</strong>
                        </span>
            @endif
        </div>
        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            <h3>Información Personal</h3>
            <div class="form-group">
                <label class="col-md-3 control-label">Contraseña actual:</label>
                <div class="col-md-8">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                            <strong class="text-red">{{ $errors->first('password') }}</strong>
                        </span>
                @endif
            </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Usuario:</label>
                    <div class="col-lg-8">
                        {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong class="text-red control-label">{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="text-red">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                        <span></span>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection