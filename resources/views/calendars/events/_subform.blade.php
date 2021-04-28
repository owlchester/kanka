
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
            {!! Form::select('month', isset($calendar) ? $calendar->monthList() : [], (!empty($month) ? $month : null), ['class' => 'form-control']) !!}
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
            <label>{{ __('calendars.fields.length') }}
            <i class="fa fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('calendars.hints.event_length') }}"></i>
            </label>
            {!! Form::number('length', (empty($entityEvent) ? 1 : null), ['placeholder' => __('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1]) !!}

            <p class="help-block hidden-md hidden-lg">{{ __('calendars.hints.event_length') }}</p>

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('calendars.fields.colour') }}</label><br />
            {!! Form::text('colour', (!empty($entityEvent) ? null : '#cccccc'), ['class' => 'form-control spectrum', 'maxlength' => 7] ) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>
                {{ __('calendars.fields.is_recurring') }}
            </label>
            {!! Form::select('recurring_periodicity', (isset($calendar) ? $calendar->recurringOptions() : null), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6" style="@if (!isset($entityEvent) || !$entityEvent->is_recurring) display:none @endif" id="add_event_recurring_until">
        <div class="form-group">
            <label>{{ __('calendars.fields.recurring_until') }}</label>
            {!! Form::text('recurring_until', null, ['placeholder' => __('calendars.placeholders.recurring_until'), 'class' => 'form-control', 'maxlength' => 12]) !!}
        </div>
    </div>
</div>

@include('cruds.fields.visibility', ['model' => isset($entityEvent) ? $entityEvent : null])

@if (!empty($entity) && $entity->typeId() == config('entities.ids.character'))
    <div class="form-group">
        <label>{{ __('entities/events.fields.type') }}</label>
        {!! Form::select('type_id', [null => '', 2 => __('entities/events.types.birth'), 3 =>  __('entities/events.types.death')], (isset($entityEvent) ? $entityEvent->type_id : null), ['class' => 'form-control']) !!}
        <p class="help-block">{!! __('entities/events.helpers.characters', ['more' => link_to_route('helpers.age', __('crud.actions.find_out_more'), null, ['target' => '_blank'])]) !!}</p>
    </div>
@endif
