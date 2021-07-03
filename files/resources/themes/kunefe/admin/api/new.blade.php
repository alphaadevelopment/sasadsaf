@extends('layouts.admin')

@section('title')
    Application API
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fas fa-robot"></i>
        <ul class="list list-unstyled">
            <li><h1>Application API</h1></li>
            <li><small>Create a new application API key.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Application API</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.api.new') }}">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="memoField">Description <span class="field-required"></span></label>
                            <input id="memoField" type="text" name="memo" class="form-control">
                        </div>
                        <p class="small text-muted">Once you have assigned permissions and created this set of credentials you will be unable to come back and edit it. If you need to make changes down the road you will need to create a new set of credentials.</p>
                    </div>
                    <div class="card-footer">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn-sm pull-right">Create Credentials</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Select Permissions</h3>
                    </div>
                    <div class="card-body table-responsive no-padding">
                        <table class="table table-hover">
                            @foreach($resources as $resource)
                                <tr>
                                    <td class="col-sm-3 strong">{{ str_replace('_', ' ', title_case($resource)) }}</td>
                                    <td class="col-sm-3 radio radio-primary text-center">
                                        <input type="radio" id="r_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['r'] }}">
                                        <label for="r_{{ $resource }}">Read</label>
                                    </td>
                                    <td class="col-sm-3 radio radio-primary text-center">
                                        <input type="radio" id="rw_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['rw'] }}">
                                        <label for="rw_{{ $resource }}">Read &amp; Write</label>
                                    </td>
                                    <td class="col-sm-3 radio text-center">
                                        <input type="radio" id="n_{{ $resource }}" name="r_{{ $resource }}" value="{{ $permissions['n'] }}" checked>
                                        <label for="n_{{ $resource }}">None</label>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    </script>
@endsection
