@if ($model->calendarReminder())
    <div class="element profile-date">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('calendars.show', [$campaign, $model->entity->calendarDate->calendar_id, 'year' => $model->calendarReminder()->year, 'month' => $model->calendarReminder()->month]) }}">
            {{ $model->calendarReminder()->readableDate() }}
        </a>
    </div>
@endif
