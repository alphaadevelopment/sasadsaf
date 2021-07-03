{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    List Packs
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>Packs</h1></li>
            <li><small>All service packs available on the system.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Packs</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form action="{{ route('admin.packs') }}" method="GET">
                            <input type="text" name="query" class="form-control pull-right" value="{{ request()->input('query') }}" placeholder="Search Packs">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <div class="text-right">
                            <a class="btn btn-md btn-primary" href="{{ route('admin.packs.new') }}">Create New</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Pack Name</th>
                            <th>Version</th>
                            <th>Description</th>
                            <th>Egg</th>
                            <th class="text-center">Servers</th>
                        </tr>
                        @foreach ($packs as $pack)
                            <tr>
                                <td class="middle" data-toggle="tooltip" data-placement="right" title="{{ $pack->uuid }}"><code>{{ $pack->id }}</code></td>
                                <td class="middle"><a href="{{ route('admin.packs.view', $pack->id) }}">{{ $pack->name }}</a></td>
                                <td class="middle"><code>{{ $pack->version }}</code></td>
                                <td class="col-md-6">{{ str_limit($pack->description, 150) }}</td>
                                <td class="middle"><a href="{{ route('admin.nests.egg.view', $pack->egg->id) }}">{{ $pack->egg->name }}</a></td>
                                <td class="middle text-center">{{ $pack->servers_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($packs->hasPages())
                <div class="card-footer with-border">
                    <div class="col-md-12 text-center">{!! $packs->appends(['query' => Request::input('query')])->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
