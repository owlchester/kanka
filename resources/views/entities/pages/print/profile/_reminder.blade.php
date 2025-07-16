@if ($entity->calendarReminder())
| {{ __('crud.fields.calendar_date') }} | {{ $entity->calendarReminder()->readableDate() }} |
@endif
