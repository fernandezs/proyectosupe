<div class="col-lg-12">
    <div class="box">
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                {!! Form::label('title', 'Titulo:')!!}
                {!! Form::text('title', null, ['class' => 'form-control'])!!}
                @if($errors->has('title'))
                    <div class="help-block">
                        <strong class="text-red">{{ $errors->first('title') }}</strong>
                    </div>
                @endif
                </div>
                <div class="form-group">
                {!! Form::label('keyword', 'Palabra clave:')!!}
                {!! Form::text('keyword', null, ['class' => 'form-control'])!!}
                @if($errors->has('keyword'))
                    <div class="help-block">
                        <strong class="text-red">{{ $errors->first('keyword') }}</strong>
                    </div>
                @endif
                </div>
                <div class="form-group">
                    {!! Form::label('group', 'Seleccione un grupo de investigacion:')!!}
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-group"></span></span>
                        {!! Form::select('group_id', $groups->lists('name', 'id'), old('project->group_id'), ['class' => 'form-control', 'placeholder' => 'Seleccione..', 'id' => 'group_id'] ) !!}
                        @if($errors->has('group_id'))
                            <div class="help-block">
                                <strong class="text-red">{{ $errors->first('group') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            <div class="form-group">
                {!! Form::label('description', 'Descripcion:')!!}
                {!! Form::textarea('description', null, ['class' => 'form-control'])!!}
                @if($errors->has('description'))
                    <div class="help-block">
                        <strong class="text-red">{{ $errors->first('description') }}</strong>
                    </div>
                @endif
            </div>
            </div>
            @if(Auth::user()->isAdmin())
                @include('projects.partials.select-users-form')
            @endif
        </div>
        <div class="box-footer">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary'])!!}
                    {!! link_to(URL::previous(), 'Cancelar', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
                    @if (Route::currentRouteName() == 'projects.edit')
                        @include('projects.destroy')
                    @endif
            </div>
            </div>
        </div>
    </div>

</div>