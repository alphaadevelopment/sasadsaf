{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('base.api.index.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-user"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('base.api.index.header')</h1></li>
            <li><small>@lang('base.api.index.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item active">@lang('navigation.account.api_access')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Credentials List <a href="{{ route('account.api.new') }}" class="btn btn-sm btn-primary float-right">Create New</a></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tr>
                            <th>Key</th>
                            <th>Memo</th>
                            <th>Last Used</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        @foreach($keys as $key)
                            <tr>
                                <td>
                                    <code class="toggle-display" style="cursor:pointer" data-toggle="tooltip" data-placement="right" title="Click to Reveal">
                                        <i class="fa fa-key"></i> &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                                    </code>
                                    <code class="d-none" data-attr="api-key">
                                        {{ $key->identifier }}{{ decrypt($key->token) }}
                                    </code>
                                </td>
                                <td>{{ $key->memo }}</td>
                                <td>
                                    @if(!is_null($key->last_used_at))
                                        @datetimeHuman($key->last_used_at)
                                        @else
                                        &mdash;
                                    @endif
                                </td>
                                <td>@datetimeHuman($key->created_at)</td>
                                <td>
                                    <a href="#" data-action="revoke-key" data-attr="{{ $key->identifier }}">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('.toggle-display').on('click', function () {
            $(this).parent().find('code[data-attr="api-key"]').removeClass('d-none');
            $(this).hide();
        });

        $('[data-action="revoke-key"]').click(function (event) {
            var self = $(this);
            event.preventDefault();
            swal.fire({
                icon: 'error',
                title: 'Revoke API Key',
                html: 'Once this API key is revoked any applications currently using it will stop working.',
                showCancelButton: true,
                allowOutsideClick: true,
                confirmButtonText: 'Revoke',
                confirmButtonColor: '#d9534f'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        method: 'DELETE',
                        url: Router.route('account.api.revoke', { identifier: self.data('attr') }),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).done(function (data) {
                        swal.fire({
                            icon: 'success',
                            title: '',
                            html: 'API Key has been revoked.'
                        });
                        self.parent().parent().slideUp();
                    }).fail(function (jqXHR) {
                        console.error(jqXHR);
                        swal.fire({
                            icon: 'error',
                            title: 'Whoops!',
                            html: 'An error occurred while attempting to revoke this key.'
                        });
                    });
                }
            });
        });
    });
    </script>
@endsection