@extends('adminlte::page')
@section('content')
    <h1 class="page-header">Cambiar contraseña</h1>
    <div class="row">
        {!! Form::open(['route' => ['profile.changePassword'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">

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
                <label class="col-md-3 control-label">Nueva contraseña:</label>
                <div class="col-md-8">
                    {!! Form::password('password_new', ['class' => 'form-control']) !!}
                </div>
                @if ($errors->has('password_new'))
                    <span class="help-block">
                            <strong class="text-red">{{ $errors->first('password_new') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Confirmar contraseña:</label>
                <div class="col-md-8">
                    {!! Form::password('password_new_confirmation', ['class' => 'form-control']) !!}
                </div>
                @if ($errors->has('password_new_confirmation'))
                    <span class="help-block">
                            <strong class="text-red">{{ $errors->first('password_new_confirmation') }}</strong>
                        </span>
                @endif
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