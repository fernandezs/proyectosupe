<div class="col-md-4">
    <div class="form-group">
        {!! Form::label('user_id', 'Asignar al usuario:')!!}
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-user"></span></span>
            {!! Form::select('user_id', [], old('project->user_id'), ['class' => 'form-control', 'placeholder' => 'Seleccione..'] ) !!}
            @if($errors->has('user_id'))
                <div class="help-block">
                    <strong class="text-red">{{ $errors->first('user_id') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
    {!! Form::label('filter', 'Filtrar:')!!}
        <div class="input-group">
            <span class="input-group-addon"><span class="fa fa-filter"></span></span>
                {!! Form::select('filter', ['investigador' => 'INVESTIGADOR', 'director' => 'DIRECTOR'], [], ['class' => 'form-control', 'placeholder' => 'Seleccione..'] ) !!}                       
        </div>
    </div>
</div>
