@if ($model->calendarReminder())
| {{ __('crud.fields.calendar_date') }} | <a href="{{ route('calendars.show', [$campaign, $model->entity->calendarDate->calendar_id, 'year' => $model->calendarReminder()->year, 'month' => $model->calendarReminder()->month]) }}">{{ $model->calendarReminder()->readableDate() }}</a> |
@endif
