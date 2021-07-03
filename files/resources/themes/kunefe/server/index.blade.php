{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    {{ trans('server.index.title', [ 'name' => $server->name]) }}
@endsection

@section('scripts')
    @parent
    {!! Theme::css('css/terminal.css') !!}
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-terminal"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.index.header')</h1></li>
            <li><small>@lang('server.index.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.console')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col mb-5">
        <div class="card">
            <div class="card-header alert bg-primary"><h1><span id="server_status_icon"></span><i class="fas fa-angle-right fa-xs ml-2"></i> {{ $server->name }}</h1></div>
            <div class="card-body position-relative">
                <div id="terminal" style="width:100%;"></div>
                <div id="terminal_input" class="form-group no-margin">
                    <div class="input-group">
                        <div class="input-group-addon terminal_input--prompt">send-command:</div>
                        <input type="text" class="form-control terminal_input--input">
                    </div>
                </div>
                <div id="terminalNotify" class="terminal-notify hidden">
                    <a class="text-black" href="{{ route('server.console', $server->uuidShort) }}" id="console-popout"><i class="fas fa-expand"></i></a>
                </div>
            </div>
            <div class="card-footer mt-3 bg-primary text-center">
                @can('power-start', $server)<button class="btn btn-success m-2 disabled" data-attr="power" data-action="start">Start</button>@endcan
                @can('power-restart', $server)<button class="btn btn-primary m-2 disabled" data-attr="power" data-action="restart">Restart</button>@endcan
                @can('power-stop', $server)<button class="btn btn-danger m-2 disabled" data-attr="power" data-action="stop">Stop</button>@endcan
                @can('power-kill', $server)<button class="btn btn-danger m-2 disabled" id="zorlaDurdur" data-attr="power" data-action="zorla_durdur">Force Stop</button>@endcan
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Resource Usage</h3>
            </div>
            <div class="card-body">
                <canvas id="chart_kaynak_kullanimi" style="max-height:600px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/ansi/ansi_up.js') !!}
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/mousewheel/jquery.mousewheel-min.js') !!}
    {!! Theme::js('js/frontend/console.js') !!}
    {!! Theme::js('vendor/chartjs/chart.min.js') !!}
    {!! Theme::js('vendor/jquery/date-format.min.js') !!}
    @if($server->nest->name === 'Minecraft' && $server->nest->author === 'support@pterodactyl.io')
        {!! Theme::js('js/plugins/minecraft/eula.js') !!}
    @endif

    <script>
        @can('power-kill', $server)
            var cbText = '<a data-attr="power" data-action="kill" style="color:#fff">I am sure.</a>';
        @endcan
        $('#zorlaDurdur').on('click', function (event) {
            if ($(this).hasClass('disabled')) {
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure you want to stop by force?',
                html: 'The forced stop shuts down the server instantly. Running tasks (such as saving player information) does not terminate properly when the server is shut down. Forced stopping can cause data loss on the server.',
                showCancelButton: true,
                focusConfirm: false,
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10c45b',
                cancelButtonColor: '#d33',
                confirmButtonText: cbText
            }).then((result) => {
                if (result.value) {
                    Socket.emit('set status', 'kill');
                }
            });
        });
    </script>
@endsection