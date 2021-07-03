{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.error')

@section('title')
    @lang('base.errors.maintenance.header')
@endsection

@section('content-header')
@endsection

@section('content')
<div class="box box-danger">
    <div class="box-body text-center">
        <h1 class="text-red" style="font-size: 3em !important;font-weight: 100 !important;">@lang('base.errors.maintenance.title')</h1>
        <p class="text-muted">@lang('base.errors.maintenance.desc')</p>
    </div>
    <div class="box-footer with-border">
        <a href="{{ URL::previous() }}"><button class="btn btn-danger">&larr; @lang('base.errors.return')</button></a>
        <a href="/"><button class="btn btn-default">@lang('base.errors.home')</button></a>
    </div>
</div>
@endsection
