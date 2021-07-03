{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.config.sftp.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.config.sftp.header')</h1></li>
            <li><small>@lang('server.config.sftp.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.sftp_settings')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">@lang('server.config.sftp.details')</h3>
            </div>
            <div class="card-body">
                <div class="row ailgn-items-center">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="control-label">@lang('server.config.sftp.conn_addr')</label>
                            <div>
                                <input type="text" class="form-control" readonly value="sftp://{{ $node->fqdn }}:{{ $node->daemonSFTP }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">@lang('strings.username')</label>
                            <div>
                                <input type="text" class="form-control" readonly value="{{ auth()->user()->username }}.{{ $server->uuidShort }}" />
                            </div>
                        </div>
                        <p class="alert bg-info">@lang('server.config.sftp.warning')</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="{{ route('index') }}/themes/kunefe/img/sftp.png" width="100%" class="img img-fluid" />
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
@endsection
