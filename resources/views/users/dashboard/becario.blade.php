@extends('adminlte::page')

@section('title', 'Dashboard Becario')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
  <div class="col-md-10">
    <div class="box">
      <div class="box-header">
        <h2><i class="fa fa-tasks"></i> Tareas asignadas</h2>
      </div>
      <div class="box-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Asignadasa la fecha</a></li>
          <li><a data-toggle="tab" href="#menu1">Vencidas</a></li>
        </ul>
        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
              @include('users.dashboard.partials.tables.tasks_assigned')
          </div>
          <div id="menu1" class="tab-pane fade">
              @include('users.dashboard.partials.tables.tasks_overdues')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop