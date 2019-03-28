@if(isset($notifications))
    <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-bell-o"></i>
            <span class="label label-success">{{$notifications['count']}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">Tiene {{$notifications['count']}} notificación(es)</li>
            <li>
                <ul class="menu">
                    @foreach($notifications['notifications'] as $notification)
                        <li>
                            <a href="{{$notification->getLink()}}">
                                <i class="fa fa-bell"></i> <span class="text-{{ $notification->type }}">{!! $notification->message !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            <li>
            <li class="footer"><a href="{{url('notifications')}}">Ver Todas</a></li>
        </ul>
    </li>
@endif