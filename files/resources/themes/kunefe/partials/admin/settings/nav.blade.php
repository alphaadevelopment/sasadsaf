@include('partials/admin.settings.notice')

@section('settings::nav')
    @yield('settings::notice')
    <div class="row mb-4">
        <div class="col-md-12">
            <a class="btn btn-md btn-primary" href="{{ route('admin.settings') }}">General</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.settings.mail') }}">Mail</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.settings.advanced') }}">Advanced</a>
        </div>
    </div>
@endsection
