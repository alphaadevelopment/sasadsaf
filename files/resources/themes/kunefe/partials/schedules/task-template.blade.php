@section('tasks::chain-template')
<div class="task-list-item" data-target="task-clone">
    <div class="row">
        <div class="form-group col-md-2">
            <label class="control-label">@lang('server.schedule.task.time')</label>
            <div>
                <select name="tasks[time_value][]" class="form-control">
                    @foreach(range(0, 59) as $number)
                        <option value="{{ $number }}">{{ $number }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-md-2">
            <label class="control-label">Zaman</label>
            <div>
                <select name="tasks[time_interval][]" class="form-control">
                    <option value="s">@lang('strings.seconds')</option>
                    <option value="m">@lang('strings.minutes')</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-3">
            <label class="control-label">@lang('server.schedule.task.action')</label>
            <div>
                <select name="tasks[action][]" class="form-control">
                    <option value="command">@lang('server.schedule.actions.command')</option>
                    <option value="power">@lang('server.schedule.actions.power')</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-5">
            <label class="control-label">@lang('server.schedule.task.payload')</label>
            <div data-attribute="remove-task-element">
                <input type="text" name="tasks[payload][]" class="form-control mr-2">
                <div class="input-group-btn d-none">
                    <button type="button" class="btn btn-danger" data-action="remove-task"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@show
