<div class="col-lg-6 ">
    <div class="box">
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('titleLabel', 'Titulo:')!!}
                {!! Form::text('title', null, ['class' => 'form-control','required', 'placeholder' => 'Titulo de la tarea'])!!}
                @if($errors->has('title'))
                    <div class="help-block">
                        <strong class="text-red">{{ $errors->first('title') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('descriptionLabel', 'Descripcion:')!!}
                {!! Form::textarea('description', null, ['class' => 'form-control','required'])!!}
                @if($errors->has('description'))
                    <div class="help-block">
                        <strong class="text-red">{{ $errors->first('description') }}</strong>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('start', 'Fecha de inicio:')!!}
                        <div class="input-group date">
                            {!! Form::text('start_date', (isset($task) ? $task->start_date->format('d/m/Y') :  \Carbon\Carbon::today()->format('d/m/Y')), ['class' => 'form-control','required', 'id' => 'start_date']) !!}
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                        @if($errors->has('start_date'))
                            <div class="help-block">
                                <strong class="text-red">{{ $errors->first('start_date') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('end', 'Fecha Limite:')!!}
                        <div class="input-group date">
                            {!! Form::text('end_date',(isset($task) ? $task->end_date->format('d/m/Y') :  \Carbon\Carbon::tomorrow()->format('d/m/Y')), ['class' => 'form-control','required', 'id' => 'end_date', 'data-provide' => 'datepicker']) !!}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>

                        @if($errors->has('end_date'))
                            <div class="help-block">
                                <strong class="text-red">{{ $errors->first('end_date') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
