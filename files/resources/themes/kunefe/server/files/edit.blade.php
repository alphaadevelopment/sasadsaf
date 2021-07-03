{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.files.edit.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.files.edit.header')</h1></li>
            <li><small>@lang('server.files.edit.header_sub')</small></li>
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header inline-flex">
                <h3 class="card-title">{{ $file }}</h3>
            </div>
            <input type="hidden" name="file" value="{{ $file }}" />
            <textarea id="editorSetContent" class="hidden">{{ $contents }}</textarea>
            <div class="overlay" id="editorLoadingOverlay"><i class="fa fa-refresh fa-spin"></i></div>
            <div class="card-body" style="height:500px;" id="editor"></div>
            <div class="card-footer with-border">
                <button class="btn btn-md btn-primary" id="save_file"><i class="fa fa-fw fa-save"></i> &nbsp;@lang('server.files.edit.save')</button>
                <a href="/server/{{ $server->uuidShort }}/files#{{ rawurlencode($directory) }}" class="pull-right"><button class="btn btn-default btn-md">@lang('server.files.edit.return')</button></a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    {!! Theme::js('vendor/ace/ace.js') !!}
    {!! Theme::js('vendor/ace/ext-modelist.js') !!}
    {!! Theme::js('vendor/ace/ext-whitespace.js') !!}
    {!! Theme::js('js/frontend/files/editor.js') !!}
    <script>
        $(document).ready(function () {
            Editor.setValue($('#editorSetContent').val(), -1);
            Editor.getSession().setUndoManager(new ace.UndoManager());
            $('#editorLoadingOverlay').hide();
        });
    </script>
@endsection
