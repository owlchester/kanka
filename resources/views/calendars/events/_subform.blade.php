<?php /** @var \App\Models\EntityEvent $entityEvent */?>
<x-grid type="3/3">
    <div class="field-year">
        <label>{{ __('calendars.fields.year') }}</label>
        {!! Form::number('year', (!empty($year) ? $year : null), ['class' => 'form-control']) !!}
    </div>

    <div class="field-month">
        <label>{{ __('calendars.fields.month') }}</label>
        {!! Form::select('month', isset($calendar) ? $calendar->monthList() : [], (!empty($month) ? $month : null), ['class' => 'form-control']) !!}
    </div>

    <div class="field-day">
        <label>{{ __('calendars.fields.day') }}</label>
        {!! Form::number('day', (!empty($day) ? $day : null), ['class' => 'form-control']) !!}
    </div>
</x-grid>
<x-grid>
    <div class="field-comment col-span-2">
        <label>{{ __('calendars.fields.comment') }}</label>
        {!! Form::text('comment', null, ['placeholder' => __('calendars.placeholders.comment'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>
    <div class="field-length">
        <label>
            {{ __('calendars.fields.length') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ __('calendars.hints.event_length') }}"></i>
        </label>
        {!! Form::number('length', (empty($entityEvent) ? 1 : null), ['placeholder' => __('calendars.placeholders.length'), 'class' => 'form-control', 'maxlength' => 1, 'data-url' => route('calendars.event-length', [$campaign, 'calendar' => 0])]) !!}

        <p class="help-block md:hidden">{{ __('calendars.hints.event_length') }}</p>
        <p class="length-warning hidden text-red">
            {!!  __('calendars.warnings.event_length', ['documentation' => link_to('https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation'), ['target' => '_blank'], null, false)])!!}
        </p>

    </div>

    <div class="field-colour">
        <label>{{ __('calendars.fields.colour') }}</label><br />
@php
$fieldOptions = [
'class' => 'form-control spectrum', 'maxlength' => 7
];
if (isset($colourAppendTo) && request()->ajax()) {
$fieldOptions['data-append-to'] = $colourAppendTo;
}
@endphp
        {!! Form::text('colour', (!empty($entityEvent) ? null : '#cccccc'), $fieldOptions ) !!}
    </div>

    <div class="field-recurring">
        <label>
            {{ __('calendars.fields.is_recurring') }}
        </label>
        {!! Form::select('recurring_periodicity', (isset($calendar) ? $calendar->recurringOptions() : []), (isset($entityEvent) && $entityEvent->is_recurring ? $entityEvent->recurring_periodicity : ''), ['class' => 'form-control reminder-periodicity']) !!}
    </div>
    <div class="field-recurring-until">
        <div style="@if (!isset($entityEvent) || !$entityEvent->is_recurring) display:none @endif" id="add_event_recurring_until">
            <label>{{ __('calendars.fields.recurring_until') }}</label>
            {!! Form::text('recurring_until', null, ['placeholder' => __('calendars.placeholders.recurring_until'), 'class' => 'form-control', 'maxlength' => 12]) !!}
        </div>
    </div>
    @include('cruds.fields.visibility_id', ['model' => $entityEvent ?? null])
    @if (!empty($entity) && $entity->isCharacter())
        <div class="field-type">
            <label>{{ __('entities/events.fields.type') }}</label>
            {!! Form::select('type_id', [null => '', 2 => __('entities/events.types.birth'), 3 =>  __('entities/events.types.death')], (isset($entityEvent) ? $entityEvent->type_id : null), ['class' => 'form-control']) !!}
            <p class="help-block">{!! __('entities/events.helpers.characters', ['more' => link_to('https://docs.kanka.io/en/latest/advanced/age.html', __('crud.actions.find_out_more'), null, ['target' => '_blank'])]) !!}</p>
        </div>
    @endif
    @if (!empty($entity) && in_array($entity->typeId(), [config('entities.ids.location'), config('entities.ids.family'), config('entities.ids.organisation')]))
        <div class="field-type">
            <label>{{ __('entities/events.fields.type') }}</label>
            {!! Form::select('type_id', [null => '', 5 => __('entities/events.types.founded')], (isset($entityEvent) ? $entityEvent->type_id : null), ['class' => 'form-control']) !!}
            <p class="help-block">{!! __('entities/events.helpers.founding', ['type' => '<code>' . __('entities/events.types.founded') . '</code>']) !!}</p>
        </div>
    @endif
</x-grid>


