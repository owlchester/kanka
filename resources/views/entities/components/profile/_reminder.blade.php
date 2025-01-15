@if ($child->calendarReminder())
    <div class="element profile-date">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('calendars.show', [$campaign, $entity->calendarDate->calendar_id, 'year' => $child->calendarReminder()->year, 'month' => $child->calendarReminder()->month]) }}">
            {{ $child->calendarReminder()->readableDate() }}
        </a>
    </div>
@endif
