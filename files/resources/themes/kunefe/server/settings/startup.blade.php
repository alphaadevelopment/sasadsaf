{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.config.startup.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.config.startup.header')</h1></li>
            <li><small>@lang('server.config.startup.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.startup_parameters')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('server.config.startup.command')</h3>
            </div>
            <div class="card-body">
                <div class="form-group no-margin-bottom">
                    <input type="text" class="form-control" readonly value="{{ $startup }}" />
                </div>
            </div>
        </div>
    </div>
</div>
    @can('edit-startup', $server)
        <form action="{{ route('server.settings.startup', $server->uuidShort) }}" method="POST">
            <div class="row">
                @foreach($variables as $v)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $v->name }}</h3>
                            </div>
                            <div class="card-body">
                                <input
                                    @if($v->user_editable)
                                        name="environment[{{ $v->env_variable }}]"
                                    @else
                                        readonly
                                    @endif
                                class="form-control" type="text" value="{{ old('environment.' . $v->env_variable, $server_values[$v->env_variable]) }}" />
                                <p class="small text-muted">{{ $v->description }}</p>
                                <p class="no-margin">
                                    @if($v->required && $v->user_editable )
                                        <span class="label label-danger">@lang('strings.required')</span>
                                    @elseif(! $v->required && $v->user_editable)
                                        <span class="label label-default">@lang('strings.optional')</span>
                                    @endif
                                    @if(! $v->user_editable)
                                        <span class="label label-warning">@lang('strings.read_only')</span>
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer">
                                <p class="no-margin text-muted small"><strong>@lang('server.config.startup.startup_regex'):</strong> <code>{{ $v->rules }}</code></p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {!! csrf_field() !!}
                            {!! method_field('PATCH') !!}
                            <input type="submit" class="btn btn-primary btn-md float-right" value="@lang('server.config.startup.update')" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endcan
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
@endsection
