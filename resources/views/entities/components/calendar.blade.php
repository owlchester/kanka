<?php /** @var \App\Models\MiscModel $model */ ?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')
@if ($model->hasCalendar() && $model->calendar)
    <p>
        <b><i class="ra ra-moon-sun"></i> {{ trans('crud.fields.calendar_date') }}</b><br />

            <a href="{{ route('calendars.show', [$model->calendar, 'year' => $model->calendar_year, 'month' => $model->calendar_month]) }}">{{ $model->calendar->name }}</a>
            <span class="pull-right">{{ $dateRenderer->render($model->getDate()) }}</span>
    </p>
@endif
