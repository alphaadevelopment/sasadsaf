<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/favicons/manifest.json">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">

    @section('scripts')
        {!! Theme::css('js/plugins/nucleo/css/nucleo.css') !!}
        {!! Theme::css('js/plugins/@fortawesome/fontawesome-free/css/all.min.css') !!}
        {!! Theme::css('css/dashboard.css') !!}
        {!! Theme::css('css/custom.css') !!}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    @show
</head>

<body class="bg-giris">
  <div class="main-content">
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="{{ route('index') }}">
          {{ config('app.name', 'Pterodactyl') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="{{ route('index') }}">{{ config('app.name', 'Pterodactyl') }}</a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              @if(!Auth::user())
                <a class="nav-link nav-link-icon" href="{{ route('index') }}" target="_blank">
                  <i class="ni ni-single-02"></i><span class="nav-link-inner--text">Management Panel</span>
                </a>
              @endif
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="#!">
                <i class="fab fa-discord"></i></i><span class="nav-link-inner--text" target="_blank">Discord</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="header py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
        </div>
      </div>
    </div>
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10">
            <div class="card bg-secondary border-0">
                <div class="card-body px-lg-5 py-lg-5 text-center">
                    @yield('content')
                </div>
            </div>
        </div>
      </div>
    </div>
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

  @section('footer-scripts')
    {!! Theme::js('js/plugins/jquery/dist/jquery.min.js') !!}
    {!! Theme::js('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') !!}
    {!! Theme::js('js/dashboard.min.js') !!}
  @show
</body>
</html>
