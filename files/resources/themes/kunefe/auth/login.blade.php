{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="card bg-transparent pb-2">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            @lang('auth.auth_error')<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="callout callout-{{ $type }} alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! $message !!}
        </div>
    @endforeach
@endforeach
<div class="card bg-secondary border-0">
  <div class="card-body px-lg-5 py-lg-5">
    <div class="text-center text-muted mb-4"><b>Login</b></div>
    <form role="form" id="loginForm" action="{{ route('auth.login') }}" method="POST">
      <div class="form-group mb-3">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
          </div>
          <input type="text" name="user" class="form-control" value="{{ old('user') }}" required placeholder="@lang('strings.user_identifier')" autofocus>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
          </div>
          <input type="password" name="password" class="form-control" required placeholder="@lang('strings.password')">
        </div>
      </div>
      <div class="text-center">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-primary my-4 g-recaptcha" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.sign_in')</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
    @parent
    @if(config('recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function onSubmit(token) {
            document.getElementById("loginForm").submit();
        }
        </script>
     @endif
@endsection
