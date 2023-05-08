<?php /** @var \App\Models\MiscModel $model */ ?>
@if ($model->hasCalendar() && $model->calendar)
    <p>
        <b>
            <x-icon class="ra ra-moon-sun"></x-icon>
            {{ __('crud.fields.calendar_date') }}
        </b><br />
        <a href="{{ route('calendars.show', [$model->calendar, 'year' => $model->calendar_year, 'month' => $model->calendar_month]) }}">{{ $model->calendar->name }}</a>
        <span class="pull-right">{{ \App\Facades\UserDate::format($model->getDate()) }}</span>
    </p>
@endif
