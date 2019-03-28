@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    @if(Auth::user()->isInvestigator())
    	@include(Auth::user()->getDashboard());
    @endif
@stop