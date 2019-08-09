<?php
$calendars = \App\Models\Calendar::get();
$onlyOneCalendar = count($calendars) == 1;
?>
{{ csrf_field() }}

<div id="entity-calendar-modal-form">
    <div class="form-group">
        <div class="form-group entity-calendar-selector">
            {!! Form::select2(
                'calendar_id',
                ($onlyOneCalendar ? $calendar->first() : null),
                App\Models\Calendar::class,
                false
            ) !!}
        </div>
    </div>
</div>

<div class="entity-calendar-subform" style="{{ $onlyOneCalendar ? '' : 'display: none;' }}">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('calendars.fields.current_year') }}</label>
                {!! Form::number('year', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('calendars.fields.current_month') }}</label>
                {!! Form::select('month', [], null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ trans('calendars.fields.current_day') }}</label>
                {!! Form::number('day', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ trans('calendars.fields.comment') }}</label>
                {!! Form::text('comment', null, ['placeholder' => trans('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 191]) !!}
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
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('calendars.fields.length') }}</label>
                {!! Form::number('length', (empty($entityEvent) ? 1 : null), ['placeholder' => trans('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('calendars.fields.colour') }}</label>
                {!! Form::select('colour', trans('calendars.colours'), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="entity-calendar-loading" style="display: none">
        <p class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </p>
    </div>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', ['calendar' => 0]) }}">