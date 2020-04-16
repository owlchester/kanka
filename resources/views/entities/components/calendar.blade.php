<?php /** @var \App\Models\MiscModel $model */ ?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')
@if ($model->hasCalendar() && $model->calendar)
    <li class="list-group-item">
        <b><i class="ra ra-moon-sun"></i> {{ trans('crud.fields.calendar_date') }}</b>
        <p class="text-muted">
            <a href="{{ route('calendars.show', [$model->calendar, 'year' => $model->calendar_year, 'month' => $model->calendar_month]) }}">{{ $model->calendar->name }}</a>
            <span class="pull-right">{{ $dateRenderer->render($model->getDate()) }}</span>
        </p>
    </li>
@endif