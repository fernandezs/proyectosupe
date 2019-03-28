@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini')

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                @if(Auth::guest())
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ url(config('adminlte.login_url', 'auth/login')) }}">
                                <i class="fa fa-fw fa-sign-in"></i> Ingresar
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
                <div class="navbar-custom-menu">
                    @if(Auth::user())

                    <ul class="nav navbar-nav">
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
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset(Auth::user()->getAvatarImageUrl())}}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{Auth::user()->username}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{asset(Auth::user()->getAvatarImageUrl())}}" class="img-circle" alt="User Image">
                                    <p>
                                        {{Auth::user()->username}}
                                    </p>

                                </li>
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-xs-12 text-center">
                                            <a href="{{url('profile')}}">Mi Perfil</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{url('profile')}}" class="btn btn-default btn-flat">Editar Perfil</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{url('logout')}}" class="btn btn-default btn-flat">Salida Segura</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                @if(Auth::user())
                <ul class="sidebar-menu">
                    @if(Auth::user()->role == 'admin')
                        @each('adminlte::partials.menu-item', config('adminlte.menu', []), 'item')
                    @elseif(Auth::user()->role == 'director')
                        @each('adminlte::partials.menu-item', config('directorlte.menu', []), 'item')
                    @elseif(Auth::user()->role == 'investigador')
                        @each('adminlte::partials.menu-item', config('investigadorlte.menu', []), 'item')
                    @elseif(Auth::user()->role == 'becario')
                        @each('adminlte::partials.menu-item', config('becariolte.menu', []), 'item')
                    @endif

                </ul>
                @endif
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">
                @include('flash::message')
                @yield('content')


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/app.min.js') }}"></script>
    @yield('js')
@stop
