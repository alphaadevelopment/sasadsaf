{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Allocations
@endsection

@section('content-header')
<div class="col-sm-12 col-md-6">
    <div class="header-bilgi">
        <i class="fa fa-sitemap"></i>
        <ul class="list list-unstyled">
            <li><h1>{{ $node->name }}</h1></li>
            <li><small>Control allocations available for servers on this node.</small></li>
        </ul>
    </div>
</div>
<div class="col-md-6 d-none d-lg-block">
    <div class="header-liste">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Admin</a></li>
            <li class="breadcrumb-item">Nodes</li>
            <li class="breadcrumb-item active">{{ $node->name }}</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view', $node->id) }}">About</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.settings', $node->id) }}">Settings</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a>
        <a class="btn btn-md btn-info" href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocation</a>
        <a class="btn btn-md btn-primary" href="{{ route('admin.nodes.view.servers', $node->id) }}">Servers</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Existing Allocations</h3>
            </div>
            <div class="card-body table-responsive no-padding">
                <table class="table table-hover" style="margin-bottom:0;">
                    <tr>
                        <th>
                            <input type="checkbox" class="select-all-files hidden-xs" data-action="selectAll">
                        </th>
                        <th>IP Address <i class="fa fa-fw fa-minus-square" style="font-weight:normal;color:#d9534f;cursor:pointer;" data-toggle="modal" data-target="#allocationModal"></i></th>
                        <th>IP Alias</th>
                        <th>Port</th>
                        <th>Assigned To</th>
                        <th>
                            <div class="btn-group hidden-xs">
                                <button type="button" id="mass_actions" class="btn btn-sm btn-default dropdown-toggle disabled"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('server.allocations.mass_actions') <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-massactions">
                                    <li><a href="#" id="selective-deletion" data-action="selective-deletion">@lang('server.allocations.delete') <i class="fa fa-fw fa-trash-o"></i></a></li>
                                </ul>
                            </div>
                        </th>
                    </tr>
                    @foreach($node->allocations as $allocation)
                        <tr>
                            <td class="middle min-size" data-identifier="type">
                                @if(is_null($allocation->server_id))
                                <input type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                                @else
                                <input disabled="disabled" type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                                @endif
                            </td>
                            <td class="col-sm-3 middle" data-identifier="ip">{{ $allocation->ip }} <span class="input-loader"><i class="fa fa-sync-alt fa-spin fa-fw"></i></span></td>
                            <td class="col-sm-3 middle text-center">
                                <code data-action="set-alias" data-id="{{ $allocation->id }}" placeholder="none">
                                    @if(empty($allocation->ip_alias))
                                        -
                                    @else
                                        {{ $allocation->ip_alias }}
                                    @endif
                                </code>
                            </td>
                            <td class="col-sm-2 middle" data-identifier="port">{{ $allocation->port }}</td>
                            <td class="col-sm-3 middle">
                                @if(! is_null($allocation->server))
                                    <a href="{{ route('admin.servers.view', $allocation->server_id) }}">{{ $allocation->server->name }}</a>
                                @endif
                            </td>
                            <td class="col-sm-1 middle">
                                @if(is_null($allocation->server_id))
                                    <button data-action="deallocate" data-id="{{ $allocation->id }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                @else
                                    <button class="btn btn-sm disabled"><i class="fa fa-trash"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if($node->allocations->hasPages())
                <div class="card-footer text-center">
                    {{ $node->allocations->render() }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <form action="{{ route('admin.nodes.view.allocation', $node->id) }}" method="POST">
            <div class="card card-success">
                <div class="card-header with-border">
                    <h3 class="card-title">Assign New Allocations</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pAllocationIP" class="control-label">IP Address</label>
                        <div>
                            <select class="form-control" name="allocation_ip" id="pAllocationIP" multiple>
                                @foreach($allocations as $allocation)
                                    <option value="{{ $allocation->ip }}">{{ $allocation->ip }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small">Enter an IP address to assign ports to here.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pAllocationIP" class="control-label">IP Alias</label>
                        <div>
                            <input type="text" id="pAllocationAlias" class="form-control" name="allocation_alias" placeholder="alias" />
                            <p class="text-muted small">If you would like to assign a default alias to these allocations enter it here.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pAllocationPorts" class="control-label">Ports</label>
                        <div>
                            <select class="form-control" name="allocation_ports[]" id="pAllocationPorts" multiple></select>
                            <p class="text-muted small">Enter individual ports or port ranges here separated by commas or spaces.</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="allocationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Allocations for IP Block</h4>
            </div>
            <form action="{{ route('admin.nodes.view.allocation.removeBlock', $node->id) }}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" name="ip">
                                @foreach($allocations as $allocation)
                                    <option value="{{ $allocation->ip }}">{{ $allocation->ip }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{{ csrf_field() }}}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Allocations</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('[data-action="addSelection"]').on('click', function () {
        updateMassActions();
    });

    $('[data-action="selectAll"]').on('click', function () {
        $('input.select-file').not(':disabled').prop('checked', function (i, val) {
            return !val;
        });

        updateMassActions();
    });

    $('[data-action="selective-deletion"]').on('mousedown', function () {
        deleteSelected();
    });

    $('#pAllocationIP').select2({
        tags: true,
        maximumSelectionLength: 1,
        selectOnClose: true,
        tokenSeparators: [',', ' '],
    });

    $('#pAllocationPorts').select2({
        tags: true,
        selectOnClose: true,
        tokenSeparators: [',', ' '],
    });

    $('button[data-action="deallocate"]').click(function (event) {
        event.preventDefault();
        var element = $(this);
        var allocation = $(this).data('id');
        Swal.fire({
            title: '',
            html: 'Are you sure you want to delete this allocation?',
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d9534f',
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    method: 'DELETE',
                    url: Router.route('admin.nodes.view.allocation.removeSingle', { node: Pterodactyl.node.id, allocation: allocation }),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                }).done(function (data) {
                    element.parent().parent().addClass('warning').delay(100).fadeOut();
                    Swal.fire({ icon: 'success', title: 'Port Deleted!' });
                }).fail(function (jqXHR) {
                    console.error(jqXHR);
                    Swal.fire({
                        title: 'Whoops!',
                        html: jqXHR.responseJSON.error,
                        icon: 'error'
                    });
                });
            }
        });
    });

    var typingTimer;
    $('input[data-action="set-alias"]').keyup(function () {
        clearTimeout(typingTimer);
        $(this).parent().removeClass('has-error has-success');
        typingTimer = setTimeout(sendAlias, 250, $(this));
    });

    var fadeTimers = [];
    function sendAlias(element) {
        element.parent().find('.input-loader').show();
        clearTimeout(fadeTimers[element.data('id')]);
        $.ajax({
            method: 'POST',
            url: Router.route('admin.nodes.view.allocation.setAlias', { id: Pterodactyl.node.id }),
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: {
                alias: element.val(),
                allocation_id: element.data('id'),
            }
        }).done(function () {
            element.parent().addClass('has-success');
        }).fail(function (jqXHR) {
            console.error(jqXHR);
            element.parent().addClass('has-error');
        }).always(function () {
            element.parent().find('.input-loader').hide();
            fadeTimers[element.data('id')] = setTimeout(clearHighlight, 2500, element);
        });
    }

    function clearHighlight(element) {
        element.parent().removeClass('has-error has-success');
    }

    function updateMassActions() {
        if ($('input.select-file:checked').length > 0) {
            $('#mass_actions').removeClass('disabled');
        } else {
            $('#mass_actions').addClass('disabled');
        }
    }

    function deleteSelected() {
        var selectedIds = [];
        var selectedItems = [];
        var selectedItemsElements = [];

        $('input.select-file:checked').each(function () {
            var $parent = $($(this).closest('tr'));
            var id = $parent.find('[data-action="deallocate"]').data('id');
            var $ip = $parent.find('td[data-identifier="ip"]');
            var $port = $parent.find('td[data-identifier="port"]');
            var block = `${$ip.text()}:${$port.text()}`;

            selectedIds.push({
                id: id
            });
            selectedItems.push(block);
            selectedItemsElements.push($parent);
        });

        if (selectedItems.length !== 0) {
            var formattedItems = "";
            var i = 0;
            $.each(selectedItems, function (key, value) {
                formattedItems += ("<code>" + value + "</code>, ");
                i++;
                return i < 5;
            });

            formattedItems = formattedItems.slice(0, -2);
            if (selectedItems.length > 5) {
                formattedItems += ', and ' + (selectedItems.length - 5) + ' other(s)';
            }

            Swal.fire({
                icon: 'warning',
                title: '',
                html: 'Are you sure you want to delete the following allocations: ' + formattedItems + '?',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d9534f',
            }).then((result) => {
                if(result.value) {
                    $.ajax({
                        method: 'DELETE',
                        url: Router.route('admin.nodes.view.allocation.removeMultiple', {
                            node: Pterodactyl.node.id
                        }),
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        data: JSON.stringify({
                            allocations: selectedIds
                        }),
                        contentType: 'application/json',
                        processData: false
                    }).done(function () {
                        $('#file_listing input:checked').each(function () {
                            $(this).prop('checked', false);
                        });

                        $.each(selectedItemsElements, function () {
                            $(this).addClass('warning').delay(200).fadeOut();
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Allocations Deleted'
                        });
                    }).fail(function (jqXHR) {
                        console.error(jqXHR);
                        Swal.fire({
                            icon: 'error',
                            title: 'Whoops!',
                            html: 'An error occurred while attempting to delete these allocations. Please try again.',
                        });
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: '',
                html: 'Please select allocation(s) to delete.',
            });
        }
    }
    </script>
@endsection
