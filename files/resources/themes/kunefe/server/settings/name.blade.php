{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.config.name.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-info-circle"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.config.name.header')</h1></li>
            <li><small>@lang('server.config.name.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.server_name')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
    <div class="row serverstatusupdate">
        <div class="col-md-12 mb-4">
            <form action="{{ route('server.settings.name', $server->uuidShort) }}" method="POST">
                <div class="card">
                    <div class="card-header">Server Name</div>
                    <div class="card-body">
                        <div class="form-group no-margin-bottom">
                            <div>
                                <input type="text" name="name" id="pServerName" class="form-control" value="{{ $server->name }}" />
                                <p class="pt-2 text-justify text-muted">@lang('server.config.name.details')</p>
                            </div>
                        </div>
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-md btn-primary float-right" value="Update Server Name" />
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">System Info</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-fingerprint"></i>
                            <ul class="list list-unstyled">
                                <li><h4>Server Name</h4></li>
                                <li><small>{{ $server->name }}</small></li>
                            </ul>
                        </div>
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-memory"></i>
                            <ul class="list list-unstyled">
                                <li><h4>RAM</h4></li>
                                <li><small><span data-action="memory"></span> / {{ $server->memory }} MB</small></li>
                            </ul>
                        </div>
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-hdd"></i>
                            <ul class="list list-unstyled">
                                <li><h4>HDD</h4></li>
                                <li><small><span data-action="disk"></span> / {{ $server->disk }} MB</small></li>
                            </ul>
                        </div>
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-microchip"></i>
                            <ul class="list list-unstyled">
                                <li><h4>CPU</h4></li>
                                <li><small><span data-action="cpu"></span> %</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Server Info</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-box"></i>
                            <ul class="list list-unstyled">
                                <li><h4>Packet</h4></li>
                                <li><small>{{ $server->egg->name }}</small></li>
                            </ul>
                        </div>
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="far fa-lightbulb"></i>
                            <ul class="list list-unstyled">
                                <li><h4>Status</h4></li>
                                <li><small data-action="detay_durum"></small></li>
                            </ul>
                        </div>
                        <div class="col-md-6 header-bilgi sunucu_detay">
                            <i class="fas fa-signal"></i>
                            <ul class="list list-unstyled">
                                <li><h4>Connection Address</h4></li>
                                <li><small>{{ $server->allocation->ip }}:{{ $server->allocation->port }}</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
	<script>
        (function updateSrvStatus() {
            $('.serverstatusupdate').each(function (index, data) {
                var element = $(this);
                var uuidShort = "{{ $server->uuidShort }}";

                $.ajax({
                    type: 'GET',
                    url: Router.route('index.status', { server: uuidShort }),
                    timeout: 5000,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    }
                }).done(function (data) {
                    if (typeof data.status === 'undefined') {
                        element.find('[data-action="detay_durum"]').html('Error');
                        return;
                    }
                    switch (data.status) {
                        case 0:
                            element.find('[data-action="detay_durum"]').html('Offline');
                            break;
                        case 1:
                            element.find('[data-action="detay_durum"]').html('Online');
                            break;
                        case 2:
                            element.find('[data-action="detay_durum"]').html('Starting');
                            break;
                        case 3:
                            element.find('[data-action="detay_durum"]').html('Stopping');
                            break;
                        case 20:
                            element.find('[data-action="detay_durum"]').html('Installing');
                            break;
                        case 30:
                            element.find('[data-action="detay_durum"]').html('Suspended');
                            break;
                    }
                    if (data.status > 0 && data.status < 4) {
                        var cpuMax = '{{ $server->cpu }}';
                        var currentCpu = data.proc.cpu.total;
                        if (cpuMax !== 0) {
                            currentCpu = parseFloat(((data.proc.cpu.total / cpuMax) * 100).toFixed(2).toString());
                        }
                        if (data.status !== 0) {
                            var cpuMax = {{ $server->cpu }};
                            var currentCpu = data.proc.cpu.total;
                            if (cpuMax !== 0) {
                                currentCpu = parseFloat(((data.proc.cpu.total / cpuMax) * 100).toFixed(2).toString());
                            }
                            element.find('[data-action="memory"]').html(parseInt(data.proc.memory.total / (1024 * 1024)));
                            element.find('[data-action="cpu"]').html(Math.round(currentCpu));
                            element.find('[data-action="disk"]').html(parseInt(data.proc.disk.used));
                        } else {
                            element.find('[data-action="memory"]').html('-');
                            element.find('[data-action="cpu"]').html('-');
                            element.find('[data-action="disk"]').html('-');
                        }
                    }
                }).fail(function (jqXHR) {
                    if (jqXHR.status === 504) {
                        element.find('[data-action="detay_durum"]').html('Gateway Timeout');
                    } else {
                        element.find('[data-action="detay_durum"]').html('Error');
                    }
                });
            }).promise().done(function () {
                setTimeout(updateSrvStatus, 5000);
            });
        })();

	</script>
@endsection
