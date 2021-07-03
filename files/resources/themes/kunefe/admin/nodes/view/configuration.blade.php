{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Configuration
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fa fa-sitemap"></i>
        <ul class="list list-unstyled">
            <li><h1>{{ $node->name }}</h1></li>
            <li><small>Your daemon configuration file.</small></li>
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
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view', $node->id) }}">About</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.settings', $node->id) }}">Settings</a>
        <a class="btn btn-md btn-info" href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocation</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.servers', $node->id) }}">Servers</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Configuration File</h3>
            </div>
            <div class="card-body">
                <pre class="no-margin">{{ $node->getConfigurationAsJson(true) }}</pre>
            </div>
            <div class="card-footer">
                <p class="no-margin">This file should be placed in your daemon's <code>config</code> directory in a file called <code>core.json</code>.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Auto-Deploy</h3>
            </div>
            <div class="card-body">
                <p class="text-muted small">To simplify the configuration of nodes it is possible to fetch the config from the panel. A token is required for this process. The button below will generate a token and provide you with the commands necessary for automatic configuration of the node. <em>Tokens are only valid for 5 minutes.</em></p>
            </div>
            <div class="card-footer">
                <button type="button" id="configTokenBtn" class="btn btn-sm btn-default" style="width:100%;">Generate Token</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#configTokenBtn').on('click', function (event) {
        $.getJSON('{{ route('admin.nodes.view.configuration.token', $node->id) }}').done(function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Token created.',
                html: 'Your token will expire <strong>in 5 minutes.</strong><br /><br />' +
                      '<p>To auto-configure your node run the following command:<br /><small><pre>npm run configure -- --panel-url {{ config('app.url') }} --token ' + data.token + '</pre></small></p>'
            })
        }).fail(function () {
            Swal.fire({
                title: 'Error',
                html: 'Something went wrong creating your token.',
                icon: 'error'
            });
        });
    });
    </script>
@endsection
