{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Delete
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>{{ $server->name }}</h1></li>
            <li><small>Delete this server from the panel.</small></li>
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
        <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view', $server->id) }}">About</a>
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">Safely Delete Server</h3>
            </div>
            <div class="card-body">
                <p>This action will attempt to delete the server from both the panel and daemon. If either one reports an error the action will be cancelled.</p>
                <p class="text-danger small">Deleting a server is an irreversible action. <strong>All server data</strong> (including files and users) will be removed from the system.</p>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-danger">Safely Delete This Server</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header with-border">
                <h3 class="card-title">Force Delete Server</h3>
            </div>
            <div class="card-body">
                <p>This action will attempt to delete the server from both the panel and daemon. If the daemon does not respond, or reports an error the deletion will continue.</p>
                <p class="text-danger small">Deleting a server is an irreversible action. <strong>All server data</strong> (including files and users) will be removed from the system. This method may leave dangling files on your daemon if it reports an error.</p>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button type="submit" class="btn btn-danger">Forcibly Delete This Server</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('form[data-action="delete"]').submit(function (event) {
        event.preventDefault();
        Swal.fire({
            title: '',
            icon: 'warning',
            html: 'Are you sure that you want to delete this server? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }).then((result) => {
            if(result.value) {
                event.target.submit();
            }
        });
    });
    </script>
@endsection
