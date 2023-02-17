@if ($model->calendarReminder())
    <div class="element profile-date">
        <div class="title">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('calendars.show', ['campaign' => $campaign->id, 'calendar' => $model->calendar_id, 'year' => $model->calendarReminder()->year, 'month' => $model->calendarReminder()->month]) }}">
            {{ $model->calendarReminder()->readableDate() }}
        </a>
    </div>
@endif
