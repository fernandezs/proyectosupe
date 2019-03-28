<div class="col-lg-6">
    <div class="box">
        <div class="box-body">
            <div class="col-lg-12">
                {{-- Select project--}}
                <div class="form-group">
                    {!! Form::label('projects','Seleccione un proyecto:') !!}
                    <div class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-folder-open"></span>
                </span>
                        {!! Form::select('project_id', $projects->lists('title','id'), null, ['class' => 'form-control', 'id' => 'project_id','required', 'placeholder' => 'Seleccione..']) !!}
                    </div>
                    @if($errors->has('project_id'))
                        <div class="help-block">
                            <strong class="text-red">{{ $errors->first('project_id') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <!-- SELECTS INVESTIGADORES Y BECARIOS -->
            <div class="col-lg-7">
                <div class="form-group">
                    {!! Form::label('group', 'Asignar a:') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-user"></span>
                        </span>
                        {!! Form::select('user_id', [], null, ['class' => 'form-control','required', 'id' => 'user_id', 'placeholder' => 'Seleccione...']) !!}
                    </div>
                    @if($errors->has('user_id'))
                        <div class="help-block">
                            <strong class="text-red">{{ $errors->first('user_id') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    {!! Form::label('director', 'Filtrar por tipo de Usuario:')!!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-filter"></span>
                        </span>
                        {!!Form::select('filter', ['investigador' => 'INVESTIGADOR', 'becario' => 'BECARIO'], null, ['class' => 'form-control', 'id' => 'filter', 'placeholder' => 'Seleccione un filtro']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary', 'pull-right']) !!}
            {!! link_to_route('tasks.index', $title= 'Cancelar', $parameters = [],$attributes = ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}
            @if (Route::currentRouteName() == 'tasks.edit')
                {!! Form::text('created_at', $task->created_at, ['hidden', 'id' => 'created_at']) !!}
                {!! Form::text('user', $task->user_id, ['hidden', 'id' => 'user']) !!}
                @include('tasks.destroy')
            @endif
        </div>
    </div>
</div>