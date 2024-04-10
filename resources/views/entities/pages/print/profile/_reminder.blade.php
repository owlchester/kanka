@if ($model->calendarReminder())
| {{ __('crud.fields.calendar_date') }} | {{ $model->calendarReminder()->readableDate() }} |
@endif
