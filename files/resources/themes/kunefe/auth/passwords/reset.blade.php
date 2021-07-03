{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
    Reset Password
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
<div class="card bg-secondary border-0">
  <div class="card-body px-lg-5 py-lg-5">
    <div class="text-center text-muted mb-4"><b>Reset Password</b></div>
    <form role="form" id="resetForm" action="{{ route('auth.reset.post') }}" method="POST">
      <div class="form-group mb-3">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required autofocus placeholder="@lang('strings.email')">
        </div>
      </div>
      <div class="form-group mb-3">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>
          </div>
          <input type="password" name="password" class="form-control" id="password" required placeholder="@lang('strings.password')">
        </div>
        <p class="small">@lang('auth.password_requirements')</p>
      </div>
      <div class="form-group mb-3">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>
          </div>
          <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required placeholder="@lang('strings.confirm_password')">
        </div>
      </div>
      <div class="text-center">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}" />
        <button type="submit" class="btn btn-primary my-4 g-recaptcha" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.reset_password')</button>
        <a href="{{ route('auth.login') }}"><button type="button" class="btn btn-primary my-4"><i class="fa fa-user-circle"></i></button></a>
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
            document.getElementById("resetForm").submit();
        }
        </script>
     @endif
@endsection
