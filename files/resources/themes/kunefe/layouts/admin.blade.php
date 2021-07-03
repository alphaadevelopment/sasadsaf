<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">

    @include('layouts.scripts')
    @section('scripts')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        {!! Theme::css('vendor/select2/select2.min.css') !!}
        {!! Theme::css('js/plugins/nucleo/css/nucleo.css') !!}
        {!! Theme::css('js/plugins/@fortawesome/fontawesome-free/css/all.min.css') !!}
        @if(Route::currentRouteName() === 'admin.mods' || Route::currentRouteName() === 'admin.mods.delete' || Route::currentRouteName() === 'admin.mods.edit'
            || Route::currentRouteName() === 'admin.mods.create'  || Route::currentRouteName() === 'admin.mods.update')
          {!! Theme::css('vendor/sweetalert/sweetalertold.min.css') !!}
        @else
          {!! Theme::css('vendor/sweetalert/sweetalert.min.css') !!}
        @endif
        {!! Theme::css('css/dashboard.css') !!}
        {!! Theme::css('css/custom.css') !!}
        {!! Theme::css('css/custom-admin.css') !!}
        {!! Theme::css('vendor/animate/animate.min.css') !!}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show
 </head>
 <body class="bg-body">
  <div class="main-content">
    <nav class="navbar navbar-top navbar-expand-md bg-primary" id="navbar-main">
      <div class="container-fluid">
        <a class="h4 mb-0 text-white text-uppercase d-lg-inline-block" href="{{ route('index') }}/admin">
          {{ config('app.name', 'Pterodactyl') }}
        </a>
        <ul class="navbar-nav align-items-center d-md-flex">
          <li class="nav-item"><a href="{{ route('index') }}" class="nav-link" title="Exit Admin Control Panel"><i class="fa fa-server"></i></a></li>
          <li class="nav-item"><a id="cikisyap" href="#" class="nav-link" title="@lang('strings.logout')"><i class="fas fa-sign-out-alt"></i></a></li>
          <li class="nav-item">
            <a class="nav-link pr-0" href="{{ route('account')}}">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img title="{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}" src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=200">
                </span>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">
                <aside id="sidenav-main" class="navbar navbar-dark navbar-vertical fixed-left navbar-expand-md bg-secondary pt-7">
                    <section class="sidebar">
                        <h6 class="navbar-heading text-muted">BASIC ADMINISTRATION</h6>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() !== 'admin.index' ?: 'active' }}" href="{{ route('admin.index') }}">
                                    <i class="fa fa-home"></i> <span>Overview</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() !== 'admin.statistics' ?: 'active' }}" href="{{ route('admin.statistics') }}">
                                    <i class="fas fa-tachometer-alt"></i> <span>Statistics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.settings') ?: 'active' }}" href="{{ route('admin.settings')}}">
                                    <i class="fa fa-wrench"></i> <span>Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.api') ?: 'active' }}" href="{{ route('admin.api.index')}}">
                                    <i class="fa fa-gamepad"></i> <span>Application API</span>
                                </a>
                            </li>
                        </ul>
                        <h6 class="navbar-heading text-muted mt-3">MANAGEMENT</h6>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.databases') ?: 'active' }}" href="{{ route('admin.databases') }}">
                                    <i class="fa fa-database"></i> <span>Databases</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.locations') ?: 'active' }}" href="{{ route('admin.locations') }}">
                                    <i class="fa fa-globe"></i> <span>Locations</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}" href="{{ route('admin.nodes') }}">
                                    <i class="fa fa-sitemap"></i> <span>Nodes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.servers') ?: 'active' }}" href="{{ route('admin.servers') }}">
                                    <i class="fa fa-server"></i> <span>Servers</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'admin.users') ?: 'active' }}" href="{{ route('admin.users') }}">
                                    <i class="fa fa-users"></i> <span>Users</span>
                                </a>
                            </li>
                        </ul>
                        <h6 class="navbar-heading text-muted mt-3">SERVICE MANAGEMENT</h6>
                        <ul class="navbar-nav">
                            <li class="nav-item {{ ! starts_with(Route::currentRouteName(), 'admin.nests') ?: 'active' }}">
                                <a class="nav-link" href="{{ route('admin.nests') }}">
                                    <i class="fa fa-th-large"></i> <span>Nests</span>
                                </a>
                            </li>
                            <li class="nav-item {{ ! starts_with(Route::currentRouteName(), 'admin.packs') ?: 'active' }}">
                                <a class="nav-link" href="{{ route('admin.packs') }}">
                                    <i class="fa fa-archive"></i> <span>Packs</span>
                                </a>
                            </li>
                        </ul>
                    </section>
                </aside>
            </div>
            <div class="col-md-8 centermain">
                <div class="header mb-5 pt-8">
                <div class="container">
                    <div class="header-body">
                        <div class="row align-items-center">
                            @yield('content-header')
                        </div>
                    </div>
                </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @lang('base.validation_error')<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {!! $message !!}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @yield('content')

                    <footer class="container footer footer-fixed">
                        <div class="row">
                            <div class="col-xl-3">
                            <div class="copyright text-muted">
                                &copy; {{ date('Y') }} <a href="{{ route('index') }}" class="font-weight-bold ml-1" target="_blank">{{ config('app.name', 'Pterodactyl') }}</a>
                            </div>
                            </div>
                            <div class="col-xl-9">
                            <ul class="nav nav-footer float-right">
                                <li class="nav-item">
                                <a href="#!" class="nav-link" target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                <a href="#!" class="nav-link" target="_blank">Privacy Policy</a>
                                </li>
                                <li class="nav-item">
                                <a href="#!" class="nav-link" target="_blank">Service Agreement</a>
                                </li>
                                <li class="nav-item">
                                <a href="#!" class="nav-link" target="_blank">Contact</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
  </div>

    @section('footer-scripts')
        {!! Theme::js('js/keyboard.polyfill.js') !!}
        <script>keyboardeventKeyPolyfill.polyfill();</script>

        {!! Theme::js('js/laroute.js') !!}
        {!! Theme::js('js/plugins/jquery/dist/jquery.min.js') !!}
        @if(Route::currentRouteName() === 'admin.mods' || Route::currentRouteName() === 'admin.mods.delete' || Route::currentRouteName() === 'admin.mods.edit'
            || Route::currentRouteName() === 'admin.mods.create'  || Route::currentRouteName() === 'admin.mods.update')
          {!! Theme::js('vendor/sweetalert/sweetalertold.min.js') !!}
        @else
          {!! Theme::js('vendor/sweetalert/sweetalert.min.js') !!}
        @endif
        {!! Theme::js('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') !!}
        {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js') !!}
        {!! Theme::js('js/dashboard.min.js') !!}
        {!! Theme::js('vendor/socketio/socket.io.v203.min.js') !!}
        {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js') !!}
        {!! Theme::js('vendor/select2/select2.full.min.js') !!}
        {!! Theme::js('js/admin/functions.js') !!}
        {!! Theme::js('js/autocomplete.js') !!}

        @if(Auth::user()->root_admin)
            <script>
                $('#cikisyap').on('click', function (event) {
                    var that = this;
                    Swal.fire({
                        title: 'Do you want to sign out?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#10c45b',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<a href="{{ route('auth.logout')}}" style="color:#fff">Yes, I do.</a>'
                    });
                });
            </script>
        @endif

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            })
        </script>
    @show
</body>
</html>