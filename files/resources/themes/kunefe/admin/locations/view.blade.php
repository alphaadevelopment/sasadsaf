{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Locations &rarr; View &rarr; {{ $location->short }}
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fa fa-globe"></i>
        <ul class="list list-unstyled">
            <li><h1>Location - {{ $location->short }}</h1></li>
            <li><small>{{ str_limit($location->long, 75) }}</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item">Locations</li>
            <li class="breadcrumb-item active">{{ $location->short }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Location Details</h3>
            </div>
            <form action="{{ route('admin.locations.view', $location->id) }}" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="pShort" class="form-label">Short Code</label>
                        <input type="text" id="pShort" name="short" class="form-control" value="{{ $location->short }}" />
                    </div>
                    <div class="form-group">
                        <label for="pLong" class="form-label">Description</label>
                        <textarea id="pLong" name="long" class="form-control" rows="4">{{ $location->long }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}
                    <button name="action" value="edit" class="btn btn-sm btn-primary pull-right">Save</button>
                    <button name="action" value="delete" class="btn btn-sm btn-danger pull-left muted muted-hover"><i class="fa fa-trash"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nodes</h3>
            </div>
            <div class="card-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>FQDN</th>
                        <th>Servers</th>
                    </tr>
                    @foreach($location->nodes as $node)
                        <tr>
                            <td><code>{{ $node->id }}</code></td>
                            <td><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></td>
                            <td><code>{{ $node->fqdn }}</code></td>
                            <td>{{ $node->servers->count() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
