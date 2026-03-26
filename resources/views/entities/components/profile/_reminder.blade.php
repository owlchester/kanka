@if ($entity->calendarReminder())
    <div class="element profile-date">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('calendars.show', [$campaign, $entity->calendarDate->calendar_id, 'year' => $entity->calendarReminder()->year, 'month' => $entity->calendarReminder()->month]) }}" class="text-link" @if ($entity->calendarReminder()->hasEra()) data-toggle="tooltip" data-title="{{ $entity->calendarReminder()->readableRawDate() }}" @endif>
            {{ $entity->calendarReminder()->readableDate() }}
        </a>
    </div>
@endif
