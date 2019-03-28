{!! Form::open(['route' => ['approveRefuse', $task->slug], 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal'])!!}
    <div class="form-group">
        <span class="col-md-1 control-label"><strong><i class="fa fa-legal"></i></strong></span>
        <div class="col-md-10">
            <div class="form-group row">
                {!! Form::label('actionLabel', 'Aprobar/Rechazar:', ['class' => 'col-md-2'])!!}
                <div class="col-md-2">
                    {!! Form::select('approve_refuse', $options, null, ['class' => 'form-control btn-block', 'id' => 'approve-refuse'])!!}
                    @if($errors->has('approve_refuse'))
                        <div class="help-block">
                            <strong class="text-red">{{ $errors->first('approve_refuse') }}</strong>
                        </div>
                    @endif
                </div>
                {!! Form::label('assign_userLabel', 'Asignar al usuario:', ['class' => 'col-md-2', 'id' => 'select-user-label'])!!}
                <div class="col-md-3">
                    {!! Form::select('user', $users->lists('username','id'), null, ['id' => 'select-user', 'class' => 'form-control', 'placeholder' => 'Seleccione'])!!}
                    @if($errors->has('user'))
                        <div class="help-block">
                            <strong class="text-red">{{ $errors->first('user') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="col-md-1">
                    {!! Form::submit('Enviar', ['class' => 'btn btn-primary'])!!}
                </div>
                <div class="col-md-1">
                    {!! link_to(URL::previous(), 'Volver', ['class' => 'btn btn-warning']) !!}
                </div>
            </div>
        </div>
    </div>
{!! Form::close()!!}