@inject('renderer', 'App\Renderers\CalendarRenderer')
{{ $renderer->setCalendar($model) }}

{!! Form::open(['route' => ['calendars.show', $model], 'method' => 'GET']) !!}
<div class="calendar-toolbar">
    <div class="pull-left">
        <div class="btn-group">
            <a href="{{ $renderer->previous() }}" class="btn btn-default btn-corner-left">
                <i class="fa fa-angle-left"></i> {{ $renderer->previous(true) }}
            </a>
            <a href="{{ $renderer->next() }}" class="btn btn-default btn-corner-right">
                {{ $renderer->next(true) }} <i class="fa fa-angle-right"></i>
            </a>
        </div>
        {{ $renderer->todayButton() }}
    </div>
    <div class="pull-right">
        <div class="btn-group">
            <a href="{{ route('calendars.show', [$model, 'layout' => 'year', 'year' => $renderer->currentYear()]) }}" class="btn btn-default btn-corner-left"<?=($renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ trans('calendars.layouts.year') }}</a>
            <a href="{{ route('calendars.show', [$model, 'year' => $renderer->currentYear()]) }}" class="btn btn-default btn-corner-right"<?=(!$renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ trans('calendars.layouts.month') }}</a>
        </div>
    </div>
    <div class="calendar-center">
        <h2>{!! $renderer->current() !!}</h2>
        {!! Form::text('year', null, ['class' => 'form-input form-input-sm', 'id' => 'calendar-year-switcher-field', 'style' => 'display:none']) !!}
    </div>
</div>
@if ($renderer->isYearlyLayout())
    <input type="hidden" name="layout" value="yearly">
@else
    {!! Form::hidden('month', $renderer->currentMonthId()) !!}
@endif
{!! Form::close() !!}

<table class="calendar table table-bordered table-striped">
    <thead>
    <tr>
        @foreach ($model->weekdays() as $weekday)
            <th>{{ $weekday }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @if ($renderer->isYearlyLayout())
        <tr>
        @foreach ($renderer->weeks() as $key => $day)
            @if($key % count($model->weekdays()) == 0)
                </tr><tr>
            @endif
            @include('calendars._day', ['showMonth' => true])
        @endforeach
        </tr>
    @else
        @foreach ($renderer->month() as $week => $days)
            <tr>
            @foreach ($days as $day)
                @include('calendars._day')
            @endforeach
            </tr>
        @endforeach
    @endif
    </tbody>
</table>



<!-- Modal -->
{!! Form::open(['route' => ['calendars.event.add', $model->id], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
<div class="modal fade export-hidden" id="add-calendar-event" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('calendars.event.modal.title') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="calendar-event-first">
                    <div class="col-md-6">
                        <span class="calendar-event-action" id="calendar-action-existing">
                            <i class="ra ra-eyeball"></i> {{ __('calendars.event.actions.existing') }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <span class="calendar-event-action" id="calendar-action-new">
                            <i class="fa fa-calendar-o"></i> {{ __('calendars.event.actions.new') }}
                        </span>
                    </div>
                </div>
                <div id="calendar-event-subform" style="display: none">
                    <div class="row">
                        <div class="col-md-8 calendar-existing-event-field">
                            {!! Form::select2(
                                'entity_id',
                                null,
                                App\Models\Entity::class,
                                false,
                                'crud.fields.entity',
                                'search.calendar_event'
                            ) !!}
                        </div>
                        <div class="col-md-8 calendar-new-event-field">
                            <div class="form-group">
                                <label>{{ trans('events.fields.name') }}</label>
                                {!! Form::text('name', null, ['placeholder' => trans('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <span class="pull-right">
                                <label></label>
                                <a href="#" id="calendar-event-switch" class="pull-right">
                                    {{ trans('calendars.event.actions.switch') }}
                                </a>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('calendars.fields.comment') }}</label>
                                {!! Form::text('comment', null, ['placeholder' => trans('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    {!! Form::checkbox('is_recurring') !!}
                                    {{ trans('calendars.fields.is_recurring') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group" style="display:none" id="add_event_recurring_until">
                                <label>{{ trans('calendars.fields.recurring_until') }}</label>
                                {!! Form::text('recurring_until', null, ['placeholder' => trans('calendars.placeholders.recurring_until'), 'class' => 'form-control', 'maxlength' => 12]) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="help-block">{{ trans('calendars.hints.is_recurring') }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('calendars.fields.length') }}</label>
                                {!! Form::number('length', 1, ['placeholder' => trans('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1]) !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal">{{ trans('crud.cancel') }}</a>
                <button type="submit" class="btn btn-primary" id="calendar-event-submit" disabled="disabled">{{ trans('crud.save') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('date', '', ['id' => 'date']) !!}
@if($renderer->isYearlyLayout())
    <input type="hidden" name="layout" value="year">
@endif
{{ csrf_field() }}
{!! Form::close() !!}