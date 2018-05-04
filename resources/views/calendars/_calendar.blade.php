@inject('renderer', 'App\Renderers\CalendarRenderer')

<div class="row form-group">
    <div class="col-md-4 text-right">
        <i class="fa fa-angle-double-left"></i> {{ $renderer->previous() }}
    </div>
    <div class="col-md-4 text-center">
        <select id="calendar-year-switcher" class="form-control">
            {!! $renderer->current() !!}
        </select>
    </div>
    <div class="col-md-2 text-left">
        {{ $renderer->next() }} <i class="fa fa-angle-double-right"></i>
    </div>
</div>

<table class="calendar table table-bordered table-striped">
    <thead>
    <tr>
        @foreach ($model->weekdays() as $weekday)
            <th>{{ $weekday }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($renderer->month() as $week => $days)
        <tr>
            @foreach ($days as $day)
                <td>
                    @if ($day['day'])
                    <h5>{{ $day['day'] }}</h5>
                    <a href="#" class="add btn btn-xs btn-default pull-right" data-date="{{ $day['date'] }}">
                        <i class="fa fa-plus"></i>
                    </a>
                    <p>
                    @if (!empty($day['events']))
                        @foreach ($day['events'] as $event)
                            <a href="{{ route($event->entity->pluralType() . '.show', $event->entity->entity_id) }}" data-toggle="tooltip" title="{{ $event->entity->tooltip() }}">{{ $event->entity->name }}</a>
                            @if ($event->is_recurring)
                                &nbsp;<i class="fa fa-refresh" data-toggle="tooltip" title="{{ trans('calendars.fields.is_recurring') }}"></i>
                            @endif
                            @if ($event->comment)
                                &nbsp;- {{ $event->comment }}
                            @endif
                            <br />
                        @endforeach
                    @endif
                    </p>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>



<!-- Modal -->
{!! Form::open(array('route' => ['calendars.event.add', $model->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}
<div class="modal fade" id="add-calendar-event" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('calendars.event.modal.title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>{{ trans('calendars.event.helpers.add') }}</p>
                        {!! Form::select2(
                            'entity_id',
                            null,
                            App\Models\Entity::class,
                            false,
                            'crud.fields.entity',
                            'search.calendar_event'
                        ) !!}
                    </div>
                    <div class="col-md-6">
                        <p>{{ trans('calendars.event.helpers.new') }}</p>
                        <div class="form-group">
                            <label>{{ trans('events.fields.name') }}</label>
                            {!! Form::text('name', null, ['placeholder' => trans('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>{{ trans('calendars.fields.comment') }}</label>
                    {!! Form::text('comment', null, ['placeholder' => trans('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>

                <div class="form-group">
                    <label>
                        {!! Form::checkbox('is_recurring') !!}
                        {{ trans('calendars.fields.is_recurring') }}
                    </label><p class="help-block">{{ trans('calendars.hints.is_recurring') }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal">{{ trans('crud.cancel') }}</a>
                <button type="submit" class="btn btn-primary" id="point-location-submit">{{ trans('crud.save') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('date', '', ['id' => 'date']) !!}
{{ csrf_field() }}
{!! Form::close() !!}