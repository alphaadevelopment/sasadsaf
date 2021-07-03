{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('server.users.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-server"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('server.users.header')</h1></li>
            <li><small>@lang('server.users.header_sub')</small></li>
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
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header with-border">
                <div class="row">
                    <div class="col-md-6">
                        <h3>@lang('server.users.list')</h3>
                    </div>
                    <div class="col-md-6">
                        @can('create-subuser', $server)
                            <div class="text-right">
                                <a href="{{ route('server.subusers.new', $server->uuidShort) }}"><button class="btn btn-primary btn-sm">@lang('server.users.add')</button></a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>@lang('strings.username')</th>
                            <th>@lang('strings.email')</th>
                            <th class="text-center">@lang('strings.2fa')</th>
                            <th class="hidden-xs">@lang('strings.created_at')</th>
                            <th></th>
                        </tr>
                        @foreach($subusers as $subuser)
                            <tr>
                                <td class="middle">{{ $subuser->user->username }}
                                <td class="middle"><code>{{ $subuser->user->email }}</code></td>
                                <td class="middle text-center">
                                    @if($subuser->user->use_totp)
                                        <i class="fa fa-lock text-green"></i>
                                    @else
                                        <i class="fa fa-unlock text-red"></i>
                                    @endif
                                </td>
                                <td class="middle hidden-xs">{{ $subuser->user->created_at }}</td>
                                <td class="text-right">
                                @can('view-subuser', $server)
                                    <a href="{{ route('server.subusers.view', ['server' => $server->uuidShort, 'subuser' => $subuser->hashid]) }}">
                                        <button class="btn btn-sm btn-warning">@lang('server.users.configure')</button>
                                    </a>
                                @endcan
                                @can('delete-subuser', $server)
                                    <a href="#/delete/{{ $subuser->hashid }}" data-action="delete" data-id="{{ $subuser->hashid }}">
                                        <button class="btn btn-sm btn-danger">@lang('strings.revoke')</button>
                                    </a>
                                @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/server.socket.js') !!}
    <script>
    $(document).ready(function () {
        $('[data-action="delete"]').click(function (event) {
            event.preventDefault();
            var self = $(this);
            Swal.fire({
                icon: 'warning',
                title: 'Delete Subuser',
                html: 'This will immediately remove this user from this server and revoke all permissions.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                showConfirmButton: true,
                confirmButtonText: 'Revoke',
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: 'DELETE',
                        url: Router.route('server.subusers.view', {
                            server: Pterodactyl.server.uuidShort,
                            subuser: self.data('id'),
                        }),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                        }
                    }).done(function () {
                        self.parent().parent().slideUp();
                        Swal.fire({
                            icon: 'success',
                            title: '',
                            html: 'Subuser was successfully deleted.'
                        });
                    }).fail(function (jqXHR) {
                        console.error(jqXHR);
                        var error = 'An error occurred while trying to process this request.';
                        if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                            error = jqXHR.responseJSON.error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Whoops!',
                            html: error
                        });
                    });
                }
            });
        });
    });
    </script>

@endsection
