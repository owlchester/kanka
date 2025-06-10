<?php /** @var \App\Models\MiscModel $model */ ?>
@if ($entity->hasCalendar() && $model->calendar)
    <p>
        <b>
            <x-icon entity="calendar" />
            {{ __('crud.fields.calendar_date') }}
        </b><br />
        <a href="{{ route('calendars.show', [$campaign, $model->calendar, 'year' => $model->calendar_year, 'month' => $model->calendar_month]) }}">{{ $model->calendar->name }}</a>
        <x-date :date="$child->entity->getDate()" />
    </p>
@endif
