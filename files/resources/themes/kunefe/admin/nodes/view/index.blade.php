{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fa fa-sitemap"></i>
        <ul class="list list-unstyled">
            <li><h1>{{ $node->name }}</h1></li>
            <li><small>A quick overview of your node.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item">Nodes</li>
            <li class="breadcrumb-item active">{{ $node->name }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a class="btn btn-md btn-info" href="{{ route('admin.nodes.view', $node->id) }}">About</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.settings', $node->id) }}">Settings</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocation</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.servers', $node->id) }}">Servers</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Information</h3>
                    </div>
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <td>Daemon Version</td>
                                <td><code data-attr="info-version"><i class="fas fa-sync-alt fa-fw fa-spin"></i></code> (Latest: <code>{{ $version->getDaemon() }}</code>)</td>
                            </tr>
                            <tr>
                                <td>System Information</td>
                                <td data-attr="info-system"><i class="fas fa-sync-alt fa-fw fa-spin"></i></td>
                            </tr>
                            <tr>
                                <td>Total CPU Cores</td>
                                <td data-attr="info-cpus"><i class="fas fa-sync-alt fa-fw fa-spin"></i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Delete Node</h3>
                    </div>
                    <div class="card-body">
                        <p class="no-margin">Deleting a node is a irreversible action and will immediately remove this node from the panel. There must be no servers associated with this node in order to continue.</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('admin.nodes.view.delete', $node->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="submit" class="btn btn-danger btn-sm pull-right" {{ ($node->servers_count < 1) ?: 'disabled' }}>Yes, Delete This Node</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-primary">
            <div class="card-header with-border">
                <h3 class="card-title">Description</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($node->maintenance_mode)
                    <div class="col-sm-12">
                        <div class="alert bg-orange">
                            <span class="alert-icon"><i class="ion ion-wrench"></i></span>
                            <div class="alert-content" style="padding: 23px 10px 0;">
                                <span class="alert-text">This node is under</span>
                                <span class="alert-number">Maintenance</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="alert bg-{{ $stats['disk']['css'] }}">
                            <span><i class="ion ion-ios-folder"></i> Disk Space Allocated <span class="float-right">{{ $stats['disk']['value'] }} / {{ $stats['disk']['max'] }} Mb</span></span>
                            <div class="progress mt-2">
                                <div class="progress-bar" style="width: {{ $stats['disk']['percent'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="alert bg-{{ $stats['memory']['css'] }}">
                            <span><i class="ion ion-ios-barcode"></i> Memory Allocated <span class="float-right">{{ $stats['memory']['value'] }} / {{ $stats['memory']['max'] }} Mb</span></span>
                            <div class="progress mt-2">
                                <div class="progress-bar" style="width: {{ $stats['memory']['percent'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="alert bg-gray">
                            <span><i class="ion ion-social-buffer"></i> Total Servers <span class="float-right">{{ $node->servers_count }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    (function getInformation() {
        $.ajax({
            method: 'GET',
            url: '{{ $node->scheme }}://{{ $node->fqdn }}:{{ $node->daemonListen }}/v1',
            timeout: 5000,
            headers: {
                'X-Access-Token': '{{ $node->daemonSecret }}'
            },
        }).done(function (data) {
            $('[data-attr="info-version"]').html(data.version);
            $('[data-attr="info-system"]').html(data.system.type + '(' + data.system.arch + ') <code>' + data.system.release + '</code>');
            $('[data-attr="info-cpus"]').html(data.system.cpus);
        }).fail(function (jqXHR) {

        }).always(function() {
            setTimeout(getInformation, 10000);
        });
    })();
    </script>
@endsection