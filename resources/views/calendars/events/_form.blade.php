{{ csrf_field() }}
@if (empty($entityEvent))
    <div class="row" id="calendar-event-first">
        <div class="col-md-6">
            <span class="calendar-event-action" id="calendar-action-existing">
                <i class="ra ra-eyeball"></i> {{ __('calendars.event.actions.existing') }}
            </span>
        </div>
        <div class="col-md-6">
            <span class="calendar-event-action" id="calendar-action-new">
                <i class="far fa-calendar"></i> {{ __('calendars.event.actions.new') }}
            </span>
        </div>
    </div>
@else
    @include('cruds.fields.entity', ['entity' => $entityEvent->entity])
@endif

<div id="calendar-event-subform" style="{{ empty($entityEvent) ? 'display:none' : null }}">
    @if (empty($entityEvent))
        <div class="row">
            <div class="col-md-8 calendar-existing-event-field">
                {!! Form::select2(
                    'entity_id',
                    null,
                    App\Models\Entity::class,
                    false,
                    'crud.fields.entity',
                    'search.entities-with-reminders'
                ) !!}
            </div>
            <div class="col-md-8 calendar-new-event-field">
                <div class="form-group">
                    <label>{{ __('events.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => __('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
            </div>
            <div class="col-md-4">
            <span class="pull-right">
                <label></label>
                <a href="#" id="calendar-event-switch" class="pull-right">
                    {{ __('calendars.event.actions.switch') }}
                </a>
            </span>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ __('calendars.fields.current_year') }}</label>
                {!! Form::number('year', (!empty($year) ? $year : null), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ __('calendars.fields.current_month') }}</label>
                {!! Form::select('month', $calendar->monthList(), (!empty($month) ? $month : null), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>{{ __('calendars.fields.current_day') }}</label>
                {!! Form::number('day', (!empty($day) ? $day : null), ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('calendars.fields.comment') }}</label>
                {!! Form::text('comment', null, ['placeholder' => __('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('calendars.fields.length') }}</label>
                {!! Form::number('length', (empty($entityEvent) ? 1 : null), ['placeholder' => __('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('calendars.fields.colour') }}</label>
                {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <label>
        {!! Form::checkbox('is_recurring') !!}
        {{ __('calendars.fields.is_recurring') }}
    </label>
</div>
<div class="row" style="@if (!isset($entityEvent) || !$entityEvent->is_recurring) display:none @endif" id="add_event_recurring_until">
    <div class="col-md-6">
        <div class="form-group" >
            <label>{{ __('calendars.fields.recurring_periodicity') }}</label>
            {!! Form::select('recurring_periodicity', __('calendars.options.events.recurring_periodicity'), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" >
            <label>{{ __('calendars.fields.recurring_until') }}</label>
            {!! Form::text('recurring_until', null, ['placeholder' => __('calendars.placeholders.recurring_until'), 'class' => 'form-control', 'maxlength' => 12]) !!}
        </div>
    </div>
    <div class="col-md-12">
        <p class="help-block">{{ __('calendars.hints.is_recurring') }}</p>
    </div>
</div>