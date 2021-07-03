{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.files.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.files.header')</h1></li>
            <li><small>@lang('server.files.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.file_management')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row" id="load_files">
    <div class="card card-body">
        <div class="overlay file-overlay"><i class="fa fa-refresh fa-spin"></i></div>
        <div class="card-body table-responsive no-padding">
            <div class="callout callout-info" style="margin:10px;">@lang('server.files.loading')</div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/async/async.min.js') !!}
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    {!! Theme::js('vendor/siofu/client.min.js') !!}
    @if(App::environment('production'))
        {!! Theme::js('js/frontend/files/filemanager.min.js?hash=cd7ec731dc633e23ec36144929a237d18c07d2f0') !!}
    @else
        {!! Theme::js('js/frontend/files/src/index.js') !!}
        {!! Theme::js('js/frontend/files/src/contextmenu.js') !!}
        {!! Theme::js('js/frontend/files/src/actions.js') !!}
    @endif
    {!! Theme::js('js/frontend/files/upload.js') !!}
@endsection
