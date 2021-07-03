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
            <li><small>Control access credentials for managing this Panel via the API.</small></li>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Credentials List</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.api.new') }}">Create New</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive no-padding">
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
                                <td><code>{{ $key->identifier }}{{ decrypt($key->token) }}</code></td>
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
                                        <i class="fa fa-trash text-danger"></i>
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
            $('[data-action="revoke-key"]').click(function (event) {
                var self = $(this);
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Revoke API Key',
                    html: 'Once this API key is revoked any applications currently using it will stop working.',
                    showCancelButton: true,
                    allowOutsideClick: true,
                    confirmButtonText: 'Revoke',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#d9534f'
                }).then((request) => {
                    if (request.value) {
                        $.ajax({
                            method: 'DELETE',
                            url: Router.route('admin.api.delete', { identifier: self.data('attr') }),
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).done(function () {
                            Swal.fire({
                                icon: 'success',
                                title: '',
                                html: 'API Key has been revoked.'
                            });
                            self.parent().parent().slideUp();
                        }).fail(function (jqXHR) {
                            console.error(jqXHR);
                            Swal.fire({
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
