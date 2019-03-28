@extends('adminlte::page')
@section('css')
    {!! Html::style('src/css/chosen.css') !!}
@endsection
@section('title', 'Editar Grupo')
@section('content_header')
    <h2><i class="fa fa-group"></i> Estas modificando el grupo: {{ $group->name }}</h2>
    <p>Aqui puedes modificar toda la informacion del grupo y sus participantes</p>
@endsection
@section('content')

    <div class="box">
        <div class="box box-body">
            {!! Form::model($group,['route' => ['users.groups.update', $group->slug], 'method' => 'PUT'])!!}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre:')!!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control'])!!}
                        @if($errors->has('name'))
                            <div class="help-block">
                                <strong class="text-red">{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                    @if(! Auth::user()->isDirector())
                        <div class="form-group">
                            {!! Form::label('director', 'Seleccione un Director:')!!}
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                {!! Form::select('user_id', $directors_all->lists('username','id'), $group->user_id, ['class' => 'form-control'] ) !!}
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
                        {!! Form::select('investigators_selected[]', $investigators_all->lists('username', 'id'), $investigators->lists('id')->all(), ['class' => 'form-control select-investigators', 'multiple' =>'true'] ) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Becarios -->
                    <div class="page-header">
                        <h3>Becarios</h3>
                    </div>
                    <div class="form-group">
                        {!! Form::label('scholar', 'Seleccione los becarios:')!!}
                        {!! Form::select('scholars_selected[]', $scholars_all->lists('username','id'), $scholars->lists('id')->all(), ['class' => 'form-control select-scholars', 'multiple' =>'true'] ) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-footer">
            <div class="form-group col-md-6">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary'])!!}
                {!! link_to(URL::previous(), 'Cancelar', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
                @include('users.groups.destroy')
            </div>
            
        </div>
    </div>
@endsection
@section('js')
    {!! Html::script('src/js/chosen.jquery.js') !!}
    {!! Html::script('app/users/groups/select-chosen.js') !!}
@endsection