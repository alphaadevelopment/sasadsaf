{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}

<div class="col-md-3">
    <div class="card p-2">
        <div class="filemanager-list">
            <a href="/server/{{ $server->uuidShort }}/files/add/@if($directory['header'] !== '')?dir={{ $directory['header'] }}@endif">
                <label class="btn btn-block btn-success btn-icon">
                    New File <i class="fas fa-file-alt"></i>
                </label>
            </a>
            <label class="btn btn-block btn-success btn-icon" data-action="add-folder">
                New Folder <i class="far fa-folder-open"></i>
            </label>
            <label class="btn btn-block btn-primary btn-icon">
                Upload <i class="fas fa-fw fa-upload"></i><input type="file" id="files_touch_target" class="hidden">
            </label>
            <div class="btn-group btn-block hidden-xs" style="margin-top:0px">
                <button type="button" id="mass_actions" class="btn btn-block btn-default dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @lang('server.files.mass_actions') <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-massactions">
                    <li><a href="#" id="selective-deletion" class="dropdown-item" data-action="selective-deletion"><i class="fa fa-fw fa-trash"></i> @lang('server.files.delete')</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="card p-0">
        <div class="card-header">
            <h3 class="card-title">/home/container{{ $directory['header'] }}</h3>
        </div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover" id="file_listing" data-current-dir="{{ rtrim($directory['header'], '/') . '/' }}">
                <thead>
                    <tr>
                        <th class="middle min-size">
                            <input type="checkbox" class="select-all-files hidden-xs" data-action="selectAll"><i class="fa fa-refresh muted muted-hover use-pointer" data-action="reload-files" style="font-size:14px;"></i>
                        </th>
                        <th>@lang('server.files.file_name')</th>
                        <th class="hidden-xs">@lang('server.files.size')</th>
                        <th class="hidden-xs">@lang('server.files.last_modified')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="append_files_to">
                    @if (isset($directory['first']) && $directory['first'] === true)
                        <tr data-type="disabled">
                            <td class="middle min-size"><i class="fa fa-folder" style="margin-left: 10px;"></i></td>
                            <td><a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr;</a></td>
                            <td class="hidden-xs"></td>
                            <td class="hidden-xs"></td>
                            <td></td>
                        </tr>
                    @endif
                    @if (isset($directory['show']) && $directory['show'] === true)
                        <tr data-type="disabled">
                            <td class="middle min-size"><i class="fa fa-folder" style="margin-left: 10px;"></i></td>
                            <td data-name="{{ rawurlencode($directory['link']) }}">
                                <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr; {{ $directory['link_show'] }}</a>
                            </td>
                            <td class="hidden-xs"></td>
                            <td class="hidden-xs"></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach ($folders as $folder)
                        <tr data-type="folder">
                            <td class="middle min-size" data-identifier="type">
                                <input type="checkbox" class="select-folder hidden-xs" data-action="addSelection"><i class="fa fa-folder" style="margin-left: 10px;"></i>
                            </td>
                            <td data-identifier="name" data-name="{{ rawurlencode($folder['entry']) }}" data-path="@if($folder['directory'] !== ''){{ rawurlencode($folder['directory']) }}@endif/">
                                <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">{{ $folder['entry'] }}</a>
                            </td>
                            <td data-identifier="size" class="hidden-xs">{{ $folder['size'] }}</td>
                            <td data-identifier="modified" class="hidden-xs">
                                <?php $carbon = Carbon::createFromTimestamp($folder['date'])->timezone(config('app.timezone')); ?>
                                @if($carbon->diffInMinutes(Carbon::now()) > 60)
                                    {{ $carbon->format('m/d/y H:i:s') }}
                                @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
                                    <em>@lang('server.files.seconds_ago')</em>
                                @else
                                    {{ $carbon->diffForHumans() }}
                                @endif
                            </td>
                            <td class="min-size">
                                <button class="btn btn-xxs btn-default disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px;"><i class="fa fa-ellipsis-h disable-menu-hide"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($files as $file)
                        <tr data-type="file" data-mime="{{ $file['mime'] }}">
                            <td class="middle min-size" data-identifier="type"><input type="checkbox" class="select-file hidden-xs" data-action="addSelection">
                                {{--  oh boy --}}
                                @if(in_array($file['mime'], [
                                    'application/x-7z-compressed',
                                    'application/zip',
                                    'application/x-compressed-zip',
                                    'application/x-tar',
                                    'application/x-gzip',
                                    'application/x-bzip',
                                    'application/x-bzip2',
                                    'application/java-archive'
                                ]))
                                    <i class="fas fa-file-archive-o" style="margin-left: 2px;"></i>
                                @elseif(in_array($file['mime'], [
                                    'application/json',
                                    'application/javascript',
                                    'application/xml',
                                    'application/xhtml+xml',
                                    'text/xml',
                                    'text/css',
                                    'text/html',
                                    'text/x-perl',
                                    'text/x-shellscript'
                                ]))
                                    <i class="fas fa-file-code" style="margin-left: 2px;"></i>
                                @elseif(starts_with($file['mime'], 'image'))
                                    <i class="fas fa-file-image" style="margin-left: 2px;"></i>
                                @elseif(starts_with($file['mime'], 'video'))
                                    <i class="fas fa-file-video" style="margin-left: 2px;"></i>
                                @elseif(starts_with($file['mime'], 'video'))
                                    <i class="fas fa-file-audio" style="margin-left: 2px;"></i>
                                @elseif(starts_with($file['mime'], 'application/vnd.ms-powerpoint'))
                                    <i class="fas fa-file-powerpoint" style="margin-left: 2px;"></i>
                                @elseif(in_array($file['mime'], [
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                                    'application/msword'
                                ]) || starts_with($file['mime'], 'application/vnd.ms-word'))
                                    <i class="far fa-file-word-o" style="margin-left: 2px;"></i>
                                @elseif(in_array($file['mime'], [
                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                                ]) || starts_with($file['mime'], 'application/vnd.ms-excel'))
                                    <i class="far fa-file-excel-o" style="margin-left: 2px;"></i>
                                @elseif($file['mime'] === 'application/pdf')
                                    <i class="far fa-file-pdf-o" style="margin-left: 2px;"></i>
                                @else
                                    <i class="far fa-file-text-o" style="margin-left: 2px;"></i>
                                @endif
                            </td>
                            <td data-identifier="name" data-name="{{ rawurlencode($file['entry']) }}" data-path="@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}@endif/">
                                @if(in_array($file['mime'], $editableMime))
                                    @can('edit-files', $server)
                                        <a href="/server/{{ $server->uuidShort }}/files/edit/@if($file['directory'] !== ''){{ $file['directory'] }}/@endif{{ $file['entry'] }}" class="edit_file">{{ $file['entry'] }}</a>
                                    @else
                                        {{ $file['entry'] }}
                                    @endcan
                                @else
                                    {{ $file['entry'] }}
                                @endif
                            </td>
                            <td data-identifier="size" class="hidden-xs">{{ $file['size'] }}</td>
                            <td data-identifier="modified" class="hidden-xs">
                                <?php $carbon = Carbon::createFromTimestamp($file['date'])->timezone(config('app.timezone')); ?>
                                @if($carbon->diffInMinutes(Carbon::now()) > 60)
                                    {{ $carbon->format('m/d/y H:i:s') }}
                                @elseif($carbon->diffInSeconds(Carbon::now()) < 5 || $carbon->isFuture())
                                    <em>@lang('server.files.seconds_ago')</em>
                                @else
                                    {{ $carbon->diffForHumans() }}
                                @endif
                            </td>
                            <td class="min-size">
                                <button class="btn btn-xxs btn-default disable-menu-hide" data-action="toggleMenu" style="padding:2px 6px 0px;"><i class="fa fa-ellipsis-h disable-menu-hide"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-body mt-3">
        <p class="text-muted">@lang('server.files.path', ['path' => '<code>/home/container</code>', 'size' => '<code>' . $node->upload_size . ' MB</code>'])</p>
    </div>
</div>