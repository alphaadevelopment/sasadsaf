{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>{{ $server->name }}</h1></li>
            <li><small>{{ str_limit($server->description) }}</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item">Servers</li>
            <li class="breadcrumb-item active">{{ $server->name }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a class="btn btn-md btn-info" href="{{ route('admin.servers.view', $server->id) }}">About</a>
        @if($server->installed === 1)
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.details', $server->id) }}">Details</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.build', $server->id) }}">Build Configuration</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.startup', $server->id) }}">Startup</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.database', $server->id) }}">Database</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.manage', $server->id) }}">Manage</a>
        @endif
        <a class="btn btn-md btn-danger" href="{{ route('admin.servers.view.delete', $server->id) }}">Delete</a>
        <a class="btn btn-md btn-success" href="{{ route('server.index', $server->uuidShort) }}"><i class="fas fa-external-link-alt"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Information</h3>
                    </div>
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <td>Internal Identifier</td>
                                <td><code>{{ $server->id }}</code></td>
                            </tr>
                            <tr>
                                <td>External Identifier</td>
                                @if(is_null($server->external_id))
                                    <td><span class="label label-default">Not Set</span></td>
                                @else
                                    <td><code>{{ $server->external_id }}</code></td>
                                @endif
                            </tr>
                            <tr>
                                <td>UUID / Docker Container ID</td>
                                <td><code>{{ $server->uuid }}</code></td>
                            </tr>
                            <tr>
                                <td>Service</td>
                                <td>
                                    <a href="{{ route('admin.nests.view', $server->nest_id) }}">{{ $server->nest->name }}</a> ::
                                    <a href="{{ route('admin.nests.egg.view', $server->egg_id) }}">{{ $server->egg->name }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $server->name }}</td>
                            </tr>
                            <tr>
                                <td>Memory</td>
                                <td><code>{{ $server->memory }} MB</code> / <code data-toggle="tooltip" data-placement="top" title="Swap Space">{{ $server->swap }} MB</code></td>
                            </tr>
                            <tr>
                                <td>Disk Space</td>
                                <td><code>{{ $server->disk }}MB</code></td>
                            </tr>
                            <tr>
                                <td>Block IO Weight</td>
                                <td><code>{{ $server->io }}</code></td>
                            </tr>
                            <tr>
                                <td>CPU Limit</td>
                                <td><code>{{ $server->cpu }}%</code></td>
                            </tr>
                            <tr>
                                <td>Default Connection/td>
                                <td><code>{{ $server->allocation->ip }}:{{ $server->allocation->port }}</code></td>
                            </tr>
                            <tr>
                                <td>Connection Alias</td>
                                <td>
                                    @if($server->allocation->alias !== $server->allocation->ip)
                                        <code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code>
                                    @else
                                        <span class="label label-default">No Alias Assigned</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        @if($server->suspended)
            <div class="card text-center bg-warning mb-4"><h3 class="m-3">Suspended</h3></div>
        @endif
        @if($server->installed !== 1)
            <div class="card text-center mb-4 bg-primary {{ (! $server->installed) ? 'bg-success' : 'bg-danger' }}">
                <h3 class="m-3">{{ (! $server->installed) ? 'Installing' : 'Install Failed' }}</h3>
            </div>
        @endif    
        <div class="card card-stats mb-4 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Server Node</h5>
                        <span class="h2 font-weight-bold mb-0">{{ str_limit($server->node->name, 16) }}</span>
                    </div>
                    <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap"><a href="{{ route('admin.nodes.view', $server->node->id) }}" class="small-card-footer">More info</a></span>
                </p>
            </div>
        </div>
        <div class="card card-stats mb-4 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Server Owner</h5>
                        <span class="h2 font-weight-bold mb-0">{{ str_limit($server->user->username, 16) }}</span>
                    </div>
                    <div class="col-auto">
                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-user"></i>
                    </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap"><a href="{{ route('admin.users.view', $server->user->id) }}" class="small-card-footer">More info</a></span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
