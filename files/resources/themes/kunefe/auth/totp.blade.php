{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
    2-FA Verification
@endsection

@section('scripts')
    @parent
    <style>
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection

@section('content')
<div class="card bg-secondary border-0">
  <div class="card-body px-lg-5 py-lg-5">
    <div class="text-center text-muted mb-4"><b>2-FA Verification</b></div>
    <form role="form" id="totpForm" action="{{ route('auth.totp') }}" method="POST">
      <div class="form-group mb-3">
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-shield"></i></span>
          </div>
          <input type="number" name="2fa_token" class="form-control" required placeholder="@lang('strings.2fa_token')" autofocus>
        </div>
      </div>
      <div class="text-center">
        {!! csrf_field() !!}
        <input type="hidden" name="verify_token" value="{{ $verify_key }}" />
        <button type="submit" class="btn btn-primary my-4">@lang('strings.submit')</button>
      </div>
    </form>
  </div>
</div>
@endsection
