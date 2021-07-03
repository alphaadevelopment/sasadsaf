@extends('layouts.master')

@section('title')
    @lang('base.index.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('base.index.header')</h1></li>
            <li><small>@lang('base.index.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item active">@lang('strings.servers')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @if(count($servers) < 1)
        <div class="col-md-12">
            <div class="card text-center mb-4">
                <div class="card-body">
                    <a class="btn btn-danger btn-block">There is no service in your account.</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card sunucu-satin-al text-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                            <a class="btn bg-gradient-blue btn-block" href="#!" target="_blank">Game Server Packet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{ $servers }}
    @foreach($servers as $server)
        @php
            $sunucu_turu = "-"; $sunucu_bg = ""; $sunucu_bg_class = "bg-gradient-red";

            if($server->nest_id === 1 && $server->egg_id === 1) {$sunucu_turu = "Bungeecord";}
            else if($server->nest_id === 1 && $server->egg_id === 2) {$sunucu_turu = "Forge";}
            else if($server->nest_id === 1 && $server->egg_id === 3) {$sunucu_turu = "Paper";}
            else if($server->nest_id === 1 && $server->egg_id === 4) {$sunucu_turu = "Sponge";}
            else if($server->nest_id === 1 && $server->egg_id === 5) {$sunucu_turu = "Vanilla";}

            if($server->nest_id === 1) {$sunucu_bg_class = "bg-game-minecraft";}
            if($server->nest_id === 5) {$sunucu_turu = "Discordjs"; $sunucu_bg_class = "bg-gradient-purple";}
        @endphp
        <div class="col-md-6">
            <div class="card sunucu sunucu-guncelleme mb-4" data-server="{{ $server->uuidShort }}">
                <a href="{{ route('server.index', $server->uuidShort) }}">
                    <div class="card-header {{ $sunucu_bg_class }} text-center" @if($sunucu_bg !== '') style="background: url('{{ $sunucu_bg }}') !important;" @endif>
                        <div class="sunucu-bg">
                            <h1>{{ $server->name }}</h1>
                            @if($server->node->maintenance_mode)
                                <span class="badge badge-warning">@lang('strings.under_maintenance')</span>
                            @else
                                <div class="durum" data-action="status"><span class="badge bg-gradient-dark"><i class="fa fa-refresh fa-fw fa-spin"></i></span></div>
                            @endif
                            <div class="durum badge bg-gradient-success">{{ $server->getRelation('allocation')->alias }}:{{ $server->getRelation('allocation')->port }}</div>
                        </div>
                    </div>
                </a>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <ul class="liste-ozellik">
                                <li><span>UUID:</span><data>{{ $server->uuidShort }}</data></li>
                                <li><span>Node:</span><data>{{ $server->getRelation('node')->name }}</data></li>
                                <li><span>Packet:</span><data>{{ $sunucu_turu }}</data></li>
                            </ul>
                            
                        </div>
                        <div class="col-md-6">
                            <ul class="liste-ozellik">
                                <li><span>Ram:</span><data data-action="memory">--</data> / {{ $server->memory === 0 ? '∞' : $server->memory }} MB</li>
                                <li><span>CPU:</span><data data-action="cpu" data-cpumax="{{ $server->cpu }}">--</data> %</li>
                                <li><span>HDD:</span><data data-action="disk">--</data> / {{ $server->disk === 0 ? '∞' : $server->disk }} MB </li>
                            </ul>
                        </div>
                        <div class="row col">
                            <div class="col-md-6 mb-2">
                                <a class="btn btn-primary btn-md btn-block" href="{{ route('server.index', $server->uuidShort) }}">Management Panel</a>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-default btn-md btn-block" href="{{ route('server.console', $server->uuidShort) }}" id="console-popout">Server Console</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#console-popout').on('click', function (event) {
            event.preventDefault();
            window.open($(this).attr('href'), 'Keyubu Konsol', 'width=800,height=400');
        });
    </script>
    {!! Theme::js('js/frontend/serverlist.js') !!}
@endsection
