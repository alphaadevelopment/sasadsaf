{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Administration
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fa fa-home"></i>
        <ul class="list list-unstyled">
            <li><h1>System Information</h1></li>
            <li><small>General system information.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Overview</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title">System Information</h3>
            </div>
            <div class="card-body">
                @if ($version->isLatestPanel())
                    Panel version <code>{{ config('app.version') }}</code>. Your panel is up to date!
                @else
                    Your panel is <strong>not up-to-date!</strong> The latest version is <a href="https://github.com/Pterodactyl/Panel/releases/v{{ $version->getPanel() }}" target="_blank"><code>{{ $version->getPanel() }}</code></a> and you are currently running version <code>{{ config('app.version') }}</code>.
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2 text-center">
        <a href="{{ $version->getDiscord() }}"><button class="btn btn-warning btn-block"><i class="far fa-life-ring"></i> Get Help <small>(via Discord)</small></button></a>
    </div>
    <div class="col-md-6 mb-2 text-center">
        <a href="https://discord.me/smtsupport"><button class="btn btn-warning btn-block"><i class="far fa-life-ring"></i> Kuenfe Theme Discord</button></a>
    </div>
    <div class="col-md-6 mb-2 text-center">
        <a href="https://docs.pterodactyl.io"><button class="btn btn-primary btn-block"><i class="fa fa-fw fa-link"></i> Documentation</button></a>
    </div>
    <div class="col-md-6 mb-2 text-center">
        <a href="https://github.com/Pterodactyl/Panel"><button class="btn btn-primary btn-block"><i class="fab fa-github"></i> Github</button></a>
    </div>
    <div class="col-md-6 mb-2 text-center">
        <a href="https://donorcard.org/pterodactyl"><button class="btn btn-success btn-block"><i class="fas fa-donate"></i> Support the Project</button></a>
    </div>
    <div class="col-md-6 mb-2 text-center">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick" />
            <input type="hidden" name="hosted_button_id" value="YKFKUQ98AYEMS" />
            <button name="submit" class="btn btn-success btn-block"><i class="fas fa-donate"></i> Support the Theme</button>
        </form>
    </div>
</div>
@endsection
