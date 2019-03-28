@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/chosen.css') !!}
@endsection
@section('title', 'Crear Grupo de investigacion')

@section('content_header')
    <h2><i class="fa fa-group"></i> Crear Grupo de investigacion</h2>
    <p>Agregue toda la información solicitada para crear el grupo</p>
@endsection
@section('content')
<div class="box">
    <div class="box box-body">
        {!! Form::open(['route' => 'users.groups.store', 'method' => 'POST'])!!}
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre:')!!}
                    {!! Form::text('name', null, ['class' => 'form-control'])!!}
                    @if($errors->has('name'))
                        <div class="help-block">
                            <strong class="text-red">{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
                <!-- Solo se muestra si el usuario logueado no es director, ya que si lo es se asigna el mismo -->
                @if(! Auth::user()->isDirector())
                    <div class="form-group">
                        {!! Form::label('lider', 'Seleccione un Director:')!!}
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-user"></span></span>
                            {!! Form::select('user_id', $directors->lists('username', 'id'), [], ['class' => 'form-control'] ) !!}
                            @if($errors->has('user_id'))
                                <div class="help-block">
                                    <strong class="text-red">{{ $errors->first('username') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="page-header">
                    <h3>Investigadores</h3>
                </div>
                <div class="form-group">
                    {!! Form::label('investigators', 'Seleccione los investigadores:')!!}
                    {!! Form::select('investigators_selected[]', $investigators->lists('username','id'), array(), ['class' => 'form-control select-investigators', 'multiple' =>'true'] ) !!}
                </div>
            </div>
            <div class="col-md-6">
                <!-- Becarios -->
                <div class="page-header">
                    <h3>Becarios</h3>
                </div>
                <div class="form-group">
                    {!! Form::label('scholar', 'Seleccione los becarios:')!!}
                    {!! Form::select('scholars_selected[]', $scholars->lists('username','id'), array(), ['class' => 'form-control select-scholars', 'multiple' =>'true'] ) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box box-footer">
        <div class="form-group">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary'])!!}
            {!! link_to(URL::previous(), 'Cancelar', ['class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('js')
    {!! Html::script('src/js/chosen.jquery.js') !!}
    {!! Html::script('app/users/groups/select-chosen.js') !!}
@endsection