{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.users.new.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.users.new.header')</h1></li>
            <li><small>@lang('server.users.new.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></li>
            <li class="breadcrumb-item active">@lang('navigation.server.subusers')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<?php $oldInput = array_flip(is_array(old('permissions')) ? old('permissions') : []) ?>
<form action="{{ route('server.subusers.new', $server->uuidShort) }}" method="POST">
    <div class="row">
        <div class="col mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">@lang('server.users.new.email')</label>
                        <div class="input-group">
                            {!! csrf_field() !!}
                            <input type="email" class="form-control px-3" name="email" value="{{ old('email') }}" required />
                            <input type="submit" name="submit" value="@lang('server.users.add')" class="btn btn-md btn-inputgroup text-white ml-2 input-group-append" />
                        </div>
                        <p class="text-muted small mt-2">@lang('server.users.new.email_help')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-inline-flex">
                    @foreach($permissions as $block => $perms)
                        @if ($loop->iteration === 1 || $loop->iteration === 4)
                            <div class="col-md-6">
                        @endif
                            <div class="mb-3">
                                <a class="btn btn-block btn-lg bg-cardheader text-left collapsed" data-toggle="collapse" href="#{{ $block }}" role="button" aria-expanded="false" aria-controls="{{ $block }}">
                                    @lang('server.users.new.' . $block . '_header')
                                </a>
                                <div class="collapse" id="{{ $block }}">
                                    <div class="card card-body bg-cardheader">
                                        @foreach($perms as $permission => $daemon)
                                            <div class="form-group">
                                                <div class="form-check no-margin-bottom">
                                                    <input id="{{ $permission }}" class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission }}"/>
                                                    <label for="{{ $permission }}" class="strong">
                                                        @lang('server.users.new.' . str_replace('-', '_', $permission) . '.title')
                                                    </label>
                                                </div>
                                                <p class="text-muted small">@lang('server.users.new.' . str_replace('-', '_', $permission) . '.description')</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @if ($loop->iteration === 3 || $loop->iteration > 5)
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="card-footer">
                    <a id="selectAllcheckboxes" class="btn btn-md btn-primary">@lang('strings.select_all')</a>
                    <a id="unselectAllcheckboxes" class="btn btn-md btn-primary">@lang('strings.select_none')</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectAllcheckboxes').on('click', function () {
                $('input[type=checkbox]').prop('checked', true);
            });
            $('#unselectAllcheckboxes').on('click', function () {
                $('input[type=checkbox]').prop('checked', false);
            });
        })
    </script>
@endsection
