@if ($entity->calendarReminder())
    <div class="element profile-date">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.calendar_date') }}</div>
        <a href="{{ route('entities.show', [$campaign, $entity->calendarDate->calendar->entity, 'year' => $entity->calendarReminder()->year, 'month' => $entity->calendarReminder()->month]) }}" class="text-link">
            {{ $entity->calendarReminder()->readableDate() }}
        </a>
    </div>
@endif
