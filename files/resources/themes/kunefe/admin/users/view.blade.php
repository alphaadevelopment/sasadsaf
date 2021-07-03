{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Manager User: {{ $user->username }}
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-users"></i>
        <ul class="list list-unstyled">
            <li><h1>User - {{ $user->username }}</h1></li>
            <li><small>{{ $user->name_first }} {{ $user->name_last}}</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('admin.users.view', $user->id) }}" method="post">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Identity</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <div>
                            <input readonly type="email" name="email" value="{{ $user->email }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Username</label>
                        <div>
                            <input readonly type="text" name="username" value="{{ $user->username }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Client First Name</label>
                        <div>
                            <input readonly type="text" name="name_first" value="{{ $user->name_first }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="registered" class="control-label">Client Last Name</label>
                        <div>
                            <input readonly type="text" name="name_last" value="{{ $user->name_last }}" class="form-control form-autocomplete-stop">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Default Language</label>
                        <div>
                            <select name="language" class="form-control">
                                @foreach($languages as $key => $value)
                                    <option value="{{ $key }}" @if($user->language === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted"><small>The default language to use when rendering the Panel for this user.</small></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <input type="submit" value="Update User" class="btn btn-primary btn-sm">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Password</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" style="display:none;margin-bottom:10px;" id="gen_pass"></div>
                            <div class="form-group no-margin-bottom">
                                <label for="password" class="control-label">Password <span class="field-optional"></span></label>
                                <div>
                                    <input readonly type="password" id="password" name="password" class="form-control form-autocomplete-stop">
                                    <p class="text-muted small">Leave blank to keep this user's password the same. User will not receive any notification if password is changed.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Permissions</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="root_admin" class="control-label">Administrator</label>
                                <div>
                                    <select name="root_admin" class="form-control">
                                        <option value="0">@lang('strings.no')</option>
                                        <option value="1" {{ $user->root_admin ? 'selected="selected"' : '' }}>@lang('strings.yes')</option>
                                    </select>
                                    <p class="text-muted"><small>Setting this to 'Yes' gives a user full administrative access.</small></p>
                                </div>
                                <div class="checkcard checkcard-primary">
                                    <input type="checkbox" id="pIgnoreConnectionError" value="1" name="ignore_connection_error">
                                    <label for="pIgnoreConnectionError"> Ignore exceptions raised while revoking keys.</label>
                                    <p class="text-muted small">If checked, any errors thrown while revoking keys across nodes will be ignored. You should avoid this checkcard if possible as any non-revoked keys could continue to be active for up to 24 hours after this account is changed. If you are needing to revoke account permissions immediately and are facing node issues, you should check this card and then restart any nodes that failed to be updated to clear out any stored keys.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Delete User</h3>
            </div>
            <div class="card-body">
                <p class="no-margin">There must be no servers associated with this account in order for it to be deleted.</p>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.users.view', $user->id) }}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <input id="delete" type="submit" class="btn btn-sm btn-danger pull-right" {{ $user->servers->count() < 1 ?: 'disabled' }} value="Delete User" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
