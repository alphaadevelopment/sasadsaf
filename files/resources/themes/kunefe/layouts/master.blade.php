@php
  $sidebar = "false";
@endphp

<!DOCTYPE html>
<html lang="en">
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
        {!! Theme::css('js/plugins/nucleo/css/nucleo.css') !!}
        {!! Theme::css('js/plugins/@fortawesome/fontawesome-free/css/all.min.css') !!}
        @if(Route::currentRouteName() === 'server.files.index' || Route::currentRouteName() === 'server.mods' || Route::currentRouteName() === 'server.mods.install' || Route::currentRouteName() === 'server.mods.uninstall')
          {!! Theme::css('vendor/sweetalert/sweetalertold.min.css') !!}
        @endif
        {!! Theme::css('css/dashboard.css') !!}
        {!! Theme::css('css/custom.css') !!}
        {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
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
      <div class="@if($sidebar === 'true') container-fluid @else container @endif">
        <a class="h4 mb-0 text-white text-uppercase d-lg-inline-block" href="{{ route('index') }}">
          {{ config('app.name', 'Pterodactyl') }}
        </a>
        <ul class="navbar-nav align-items-center d-md-flex">
          @if(Auth::user()->root_admin)
            <li class="nav-item"><a href="{{ route('admin.index') }}" title="@lang('strings.admin_cp')" class="nav-link"><i class="fas fa-cogs"></i></a></li>
          @endif
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
    @if($sidebar !== "true")
      <div class="navbar-alt bg-secondary">
        <div class="container">
          <ul class="list-unstyled d-flex align-items-center">
            @if(starts_with(Route::currentRouteName(), 'index') || starts_with(Route::currentRouteName(), 'account') || starts_with(Route::currentRouteName(), 'api'))
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'index' ?: 'active' }}" href="{{ route('index') }}" >
                @lang('navigation.home')</a>
              </li>
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'account' ?: 'active' }}" href="{{ route('account') }}" >
                @lang('navigation.account.my_account')</a>
              </li>
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'account.security' ?: 'active' }}" href="{{ route('account.security') }}" >
                @lang('navigation.account.security_controls')</a>
              </li>
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'account.api' ?: 'active' }} {{ Route::currentRouteName() !== 'account.api.new' ?: 'active' }}" href="{{ route('account.api') }}" >
                @lang('navigation.account.api_access')</a>
              </li>
            @endif
            @if(isset($server->name) && isset($node->name))
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'index' ?: 'active' }}" href="{{ route('index') }}" >
                @lang('navigation.home')</a>
              </li>
              <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'server.index' || Route::currentRouteName() === 'server.settings.name' || Route::currentRouteName() === 'server.settings.sftp') active @endif" href="{{ route('server.index', $server->uuidShort) }}" >
                System</a>
              </li>
              <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'server.files.index' || Route::currentRouteName() === 'server.subusers' || Route::currentRouteName() === 'server.databases.index') active @endif" href="{{ route('server.files.index', $server->uuidShort) }}" >
                Management</a>
              </li>
              <li class="nav-item"><a class="nav-link @if(Route::currentRouteName() === 'server.settings.startup' || Route::currentRouteName() === 'server.settings.allocation' || Route::currentRouteName() === 'server.schedules') active @endif" href="{{ route('server.settings.startup', $server->uuidShort) }}" >
                @lang('navigation.server.configuration')</a>
              </li>
            @endif
          </ul>
        </div>
      </div>
      @if(Route::currentRouteName() === 'server.index' || Route::currentRouteName() === 'server.settings.name' || Route::currentRouteName() === 'server.settings.sftp')
        <div class="navbar-alt-secenek">
          <div class="container">
            <ul class="list-unstyled d-flex align-items-center">
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.index' ?: 'active' }}" href="{{ route('server.index', $server->uuidShort) }}" >
                @lang('navigation.server.console')</a>
              </li>
              @can('view-name', $server)
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.settings.name' ?: 'active' }}" href="{{ route('server.settings.name', $server->uuidShort) }}" >
                @lang('navigation.server.server_name')</a>
              </li>
              @endcan
              @can('access-sftp', $server)
              <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.settings.sftp' ?: 'active' }}" href="{{ route('server.settings.sftp', $server->uuidShort) }}" >
                @lang('navigation.server.sftp_settings')</a>
              </li>
              @endcan
            </ul>
          </div>
        </div>
      @endif
      @if(Route::currentRouteName() === 'server.files.index' || Route::currentRouteName() === 'server.files.add' || Route::currentRouteName() === 'server.files.edit' || Route::currentRouteName() === 'server.subusers' || Route::currentRouteName() === 'server.subusers.view' || Route::currentRouteName() === 'server.subusers.new' || Route::currentRouteName() === 'server.databases.index')
        <div class="navbar-alt-secenek">
          <div class="container">
            <ul class="list-unstyled d-flex align-items-center">
              @can('list-files', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.files.index')) active @endif" href="{{ route('server.files.index', $server->uuidShort) }}" >
                @lang('navigation.server.file_management')</a>
              </li>
              @endcan
              @can('list-databases', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.databases.index')) active @endif" href="{{ route('server.databases.index', $server->uuidShort) }}" >
                @lang('navigation.server.databases')</a>
              </li>
              @endcan
              @can('list-subusers', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.subusers')) active @endif" href="{{ route('server.subusers', $server->uuidShort) }}" >
                @lang('navigation.server.subusers')</a>
              </li>
              @endcan
            </ul>
          </div>
        </div>
      @endif
      @if(Route::currentRouteName() === 'server.settings.startup' || Route::currentRouteName() === 'server.settings.allocation' || Route::currentRouteName() === 'server.schedules' || Route::currentRouteName() === 'server.schedules.new' || Route::currentRouteName() === 'server.schedules.view')
        <div class="navbar-alt-secenek">
          <div class="container">
            <ul class="list-unstyled d-flex align-items-center">
              @can('view-startup', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.settings.startup')) active @endif" href="{{ route('server.settings.startup', $server->uuidShort) }}" >
                @lang('navigation.server.startup_parameters')</a>
              </li>
              @endcan
              @can('view-allocations', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.settings.allocation')) active @endif" href="{{ route('server.settings.allocation', $server->uuidShort) }}" >
                @lang('navigation.server.port_allocations')</a>
              </li>
              @endcan
              @can('list-schedules', $server)
              <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.schedules')) active @endif" href="{{ route('server.schedules', $server->uuidShort) }}" >
                @lang('navigation.server.schedules')</a>
              </li>
              @endcan
            </ul>
          </div>
        </div>
      @endif
    @else
      <div class="col-md-1">
        <aside id="sidenav-main" class="navbar navbar-dark navbar-vertical fixed-left navbar-expand-md bg-secondary pt-7">
          <section class="sidebar">
            <h6 class="navbar-heading text-muted">Account Management</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() !== 'account' ?: 'active' }}" href="{{ route('account') }}">
                        <i class="fa fa-user"></i> <span>@lang('navigation.account.my_account')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() !== 'account.security' ?: 'active' }}" href="{{ route('account.security') }}">
                        <i class="fas fa-lock"></i> <span>@lang('navigation.account.security_controls')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ! starts_with(Route::currentRouteName(), 'account.api') ?: 'active' }} {{ Route::currentRouteName() !== 'account.api.new' ?: 'active' }}" href="{{ route('account.api')}}">
                        <i class="fa fa-code"></i> <span>@lang('navigation.account.api_access')</span>
                    </a>
                </li>
            </ul>
            @if(Route::currentRouteName() === 'server.index' || Route::currentRouteName() === 'server.settings.name' || Route::currentRouteName() === 'server.settings.sftp' || Route::currentRouteName() === 'server.files.index'
                || Route::currentRouteName() === 'server.files.add' || Route::currentRouteName() === 'server.files.edit' || Route::currentRouteName() === 'server.subusers' || Route::currentRouteName() === 'server.subusers.view'
                || Route::currentRouteName() === 'server.subusers.new' || Route::currentRouteName() === 'server.databases.index' || Route::currentRouteName() === 'server.settings.startup' || Route::currentRouteName() === 'server.settings.allocation'
                || Route::currentRouteName() === 'server.schedules' || Route::currentRouteName() === 'server.schedules.new' || Route::currentRouteName() === 'server.schedules.view')
            <h6 class="navbar-heading text-muted mt-3">Server Management</h6>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.index' ?: 'active' }}" href="{{ route('server.index', $server->uuidShort) }}">
                  <i class="fa fa-server"></i> <span>@lang('navigation.server.console')</span></a>
                </li>
                @can('list-files', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.files.index')) active @endif" href="{{ route('server.files.index', $server->uuidShort) }}" >
                    <i class="fa fa-folder"></i> @lang('navigation.server.file_management')</a>
                  </li>
                @endcan
                @can('list-databases', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.databases.index')) active @endif" href="{{ route('server.databases.index', $server->uuidShort) }}" >
                    <i class="fa fa-database"></i> @lang('navigation.server.databases')</a>
                  </li>
                @endcan
                @can('list-subusers', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.subusers')) active @endif" href="{{ route('server.subusers', $server->uuidShort) }}" >
                    <i class="fa fa-users"></i> @lang('navigation.server.subusers')</a>
                  </li>
                @endcan
                @can('list-schedules', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.schedules')) active @endif" href="{{ route('server.schedules', $server->uuidShort) }}" >
                    <i class="fa fa-clock"></i> @lang('navigation.server.schedules')</a>
                  </li>
                @endcan
                @can('view-name', $server)
                  <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.settings.name' ?: 'active' }}" href="{{ route('server.settings.name', $server->uuidShort) }}">
                    <i class="fas fa-info-circle"></i> <span>@lang('navigation.server.server_name')</span></a>
                  </li>
                @endcan
                @can('access-sftp', $server)
                  <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() !== 'server.settings.sftp' ?: 'active' }}" href="{{ route('server.settings.sftp', $server->uuidShort) }}">
                    <i class="fas fa-file-import"></i> <span>@lang('navigation.server.sftp_settings')</span></a>
                  </li>
                @endcan
                @can('view-startup', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.settings.startup')) active @endif" href="{{ route('server.settings.startup', $server->uuidShort) }}" >
                    <i class="fa fa-play"></i> @lang('navigation.server.startup_parameters')</a>
                  </li>
                @endcan
                @can('view-allocations', $server)
                  <li class="nav-item"><a class="nav-link @if(starts_with(Route::currentRouteName(), 'server.settings.allocation')) active @endif" href="{{ route('server.settings.allocation', $server->uuidShort) }}" >
                    <i class="fas fa-map-marker"></i> @lang('navigation.server.port_allocations')</a>
                  </li>
                @endcan
            </ul>
            @endif
          </section>
        </aside>
      </div>
    @endif
    @if($sidebar === "true") <div class="col-md-8 centermain"> @endif
    <div class="header @if($sidebar === 'true') mb-5 pt-8 @else my-5 @endif ">
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
    @if($sidebar === "true") </div> @endif
  </div>

    @section('footer-scripts')
        {!! Theme::js('js/keyboard.polyfill.js?t={cache-version}') !!}
        <script>keyboardeventKeyPolyfill.polyfill();</script>

        {!! Theme::js('js/laroute.js?t={cache-version}') !!}
        {!! Theme::js('js/plugins/jquery/dist/jquery.min.js') !!}
        @if(Route::currentRouteName() === 'server.files.index' || Route::currentRouteName() === 'server.mods' || Route::currentRouteName() === 'server.mods.install' || Route::currentRouteName() === 'server.mods.uninstall')
          {!! Theme::js('vendor/sweetalert/sweetalertold.min.js') !!}
        @else
          {!! Theme::js('vendor/sweetalert/sweetalert.min.js') !!}
        @endif
        {!! Theme::js('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') !!}
        {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
        {!! Theme::js('js/dashboard.min.js') !!}
        {!! Theme::js('vendor/socketio/socket.io.v203.min.js?t={cache-version}') !!}
        {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
        {!! Theme::js('js/autocomplete.js?t={cache-version}') !!}

        <script>
            $('#cikisyap').on('click', function (event) {
                var that = this;
                Swal.fire({
                    title: 'Do you want to sign out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10c45b',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<a href="{{ route('auth.logout')}}" style="color:#fff">Yes, I do.</a>'
                });
            });
        </script>
    @show
</body>
</html>