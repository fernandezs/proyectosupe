<h3>Información básica</h3>
    {!! Form::label('name', 'Nombre completo') !!}
    {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
    @if ($errors->has('username'))
        <span class="help-block">
            <strong class="text-red">{{ $errors->first('username') }}</strong>
        </span>
    @endif
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null , ['class' => 'form-control']) !!}
    @if ($errors->has('email'))
        <span class="help-block">
            <strong class="text-red">{{ $errors->first('email') }}</strong>
        </span>
    @endif
    {!! Form::label('role', 'Rol de usuario:') !!}
    {!! Form::select('role', $roles, null, ['class' => 'form-control', 'placeholder' => 'Seleccione...']) !!}
    @if($errors->has('role'))
        <span class="help-block">
            <strong class="text-red">{{ $errors->first('role') }}}</strong>
        </span>
    @endif