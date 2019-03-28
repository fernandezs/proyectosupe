@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('content_header')
    <h2><i class="fa fa-bell"></i> Notificaciones</h2>
    <p>Estas son las últimas notificaciones enviadas por el sistema</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Mostrando página
                    </h3>
                </div>
                <ul class="list-group">
                    @foreach($notifications['notifications'] as $notification)
                        <li class="list-group-item">
                            <a href="{{$notification->getLink()}}">
                                <div class="row">
                                    <div class="col-md-1 text-center">
                                        @if(empty($notification->readed_at))
                                            <span class="label label-default">Nueva</span>
                                        @endif
                                    </div>
                                    <div class="col-md-8 text-{{$notification->type}}">
                                        <i class="fa fa-{{$notification->getIconByType()}} notification-icon"></i>
                                        {!! $notification->message !!}<br />
                                        @if(!empty($notification->readed_at))
                                            <small class="text-muted">Leído : {{$notification->readed_at->format('d/m/Y h:i A')}}</small>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="pull-right">
                                            <small class="text-muted">Recibído:<br />{{$notification->created_at->format('d/m/Y h:i A')}}</small><br />
                                            <span class="label label-{{$notification->type}}">{{ucwords($notification->getTimeAgo())}}</span><br />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
            </div>
        </div>
    </div>
    <div class="text-center">

    </div>
@endsection
