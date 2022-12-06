@if ($model->calendarReminder())
    <div class="element profile-date">
        <div class="title">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('calendars.show', [$model->calendar_id, 'year' => $model->calendarReminder()->year, 'month' => $model->calendarReminder()->month]) }}">
            {{ $model->getDate() }}
        </a>
    </div>
@endif
