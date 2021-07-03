{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.master')

@section('title')
    @lang('base.security.header')
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-shield-alt"></i>
        <ul class="list list-unstyled">
            <li><h1>@lang('base.security.header')</h1></li>
            <li><small>@lang('base.security.header_sub')</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('strings.home')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('index') }}">@lang('navigation.account.my_account')</a></li>
            <li class="breadcrumb-item active">@lang('navigation.account.security_controls')</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(Auth::user()->use_totp)
                        <i class="fas fa-circle text-success" title="Aktif"></i>
                    @else
                        <i class="fas fa-circle text-danger" title="Devre dışı"></i>
                    @endif
                    @lang('base.security.2fa_header') 
                </h3>
            </div>
            @if(Auth::user()->use_totp)
            <form action="{{ route('account.security.totp') }}" method="post">
                <div class="card-body">
                    <p>@lang('base.security.2fa_enabled')</p>
                    <div class="form-group">
                        <label for="new_password_again" class="control-label">@lang('strings.2fa_token')</label>
                        <div>
                            <input type="text" class="form-control" name="token" />
                            <p class="text-muted small">@lang('base.security.2fa_token_help')</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm">@lang('base.security.disable_2fa')</button>
                </div>
            </form>
            @else
            <form action="{{ route('account.security.totp') }}" method="post" id="do_2fa">
                <div class="card-body">
                    @lang('base.security.2fa_disabled')
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm">@lang('base.security.enable_2fa')</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">@lang('base.security.sessions')</h3>
            </div>
            @if(!is_null($sessions))
                <div class="card-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>@lang('strings.id')</th>
                                <th>User</th>
                                <th>IP</th>
                                <th>@lang('strings.last_activity')</th>
                                <th></th>
                            </tr>
                            @foreach($sessions as $session)
                                @php
                                    $username = DB::table('users')->where('id', $session->user_id)->value('username');
                                @endphp
                                <tr>
                                    <td><code>{{ substr($session->id, 0, 6) }}</code></td>
                                    <td>{{ $username }}</td>
                                    <td>{{ $session->ip_address }}</td>
                                    <td>{{ Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('account.security.revoke', $session->id) }}">
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> @lang('strings.revoke')</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body">
                    <p class="text-muted">@lang('base.security.session_mgmt_disabled')</p>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="open2fa" tabindex="-1" role="dialog" aria-labelledby="open2fa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="#" method="post" id="2fa_token_verify">
                <div class="py-3 text-center">
                    <h4 class="modal-title">@lang('base.security.2fa_qr')</h4>
                </div>
                <div class="modal-body" id="modal_insert_content">
                    <div class="row">
                        <div class="col-md-12" id="notice_card_2fa" style="display:none;"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span id="hide_img_load"><i class="fa fa-spinner fa-spin"></i> QR Kod Yükleniyor...</span><img src="" id="qr_image_insert" style="display:none;"/>
                        </div>
                        <div class="col-md-12 text-center py-3">
                            <div class="alert alert-info">@lang('base.security.2fa_checkpoint_help')</div>
                            <div class="form-group">
                                <label class="control-label" for="2fa_token">@lang('strings.2fa_token')</label>
                                {!! csrf_field() !!}
                                <input class="form-control" type="text" name="2fa_token" id="2fa_token" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-md" id="submit_action">@lang('strings.submit')</button>
                            <button type="button" class="btn btn-default btn-md" data-dismiss="modal" id="close_reload">@lang('strings.close')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/2fa-modal.js') !!}
@endsection
