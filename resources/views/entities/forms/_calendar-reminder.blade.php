@if ($workspaceCalendarLocked)
    <input type="hidden" name="calendar_id" value="{{ $workspaceCalendarReminder?->calendar_id }}" />
    <input type="hidden" name="calendar_skip" value="1" />
@elseif ($dateCalendars->isNotEmpty())
    @php
        $reminder = $workspaceCalendarReminder;
        $calendar = $dateCalendars->firstWhere('id', old('calendar_id', $reminder?->calendar_id));
        $options = $dateCalendarOptions;
        $periodicity = old('calendar_recurring_periodicity', $reminder?->is_recurring ? $reminder->recurring_periodicity : null);
    @endphp
    <section class="entry-workspace-dates flex flex-col gap-4 rounded-lg p-3" aria-labelledby="entry-calendar-reminder-heading" data-entry-date data-calendars="{{ $options->toJson() }}">
        <h3 id="entry-calendar-reminder-heading" class="text-sm font-semibold">{{ __('crud.fields.calendar_date') }}</h3>
        <div class="field flex flex-col gap-1">
            <label for="entry-calendar-reminder-calendar" class="text-xs font-medium">{{ __('entities.calendar') }}</label>
            <select name="calendar_id" id="entry-calendar-reminder-calendar" class="w-full text-sm" data-date-calendar>
                <option value="">—</option>
                @foreach ($dateCalendars as $dateCalendar)
                    <option value="{{ $dateCalendar->id }}" @selected(old('calendar_id', $reminder?->calendar_id) == $dateCalendar->id)>{{ $dateCalendar->entity->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-2 md:grid-cols-3">
            <div class="field flex flex-col gap-1"><label for="entry-calendar-year" class="text-xs text-neutral-content">{{ __('calendars.fields.year') }}</label><input id="entry-calendar-year" name="calendar_year" type="number" value="{{ old('calendar_year', $reminder?->year) }}" class="w-full text-sm" data-date-year /></div>
            <div class="field flex flex-col gap-1"><label for="entry-calendar-month" class="text-xs text-neutral-content">{{ __('calendars.fields.month') }}</label><select id="entry-calendar-month" name="calendar_month" class="w-full text-sm" data-date-month><option value="">—</option>@foreach ($calendar?->monthList() ?? [] as $number => $name)<option value="{{ $number }}" @selected(old('calendar_month', $reminder?->month) == $number)>{{ $name }}</option>@endforeach</select></div>
            <div class="field flex flex-col gap-1"><label for="entry-calendar-day" class="text-xs text-neutral-content">{{ __('calendars.fields.day') }}</label><input id="entry-calendar-day" name="calendar_day" type="number" min="1" value="{{ old('calendar_day', $reminder?->day) }}" class="w-full text-sm" data-date-day /></div>
            <div class="field flex flex-col gap-1"><label for="entry-calendar-length" class="text-xs text-neutral-content">{{ __('calendars.fields.length') }}</label><input id="entry-calendar-length" name="calendar_length" type="number" min="1" value="{{ old('calendar_length', $reminder?->length ?? 1) }}" class="w-full text-sm" /></div>
            <div class="field flex flex-col gap-1"><label for="entry-calendar-colour" class="text-xs text-neutral-content">{{ __('crud.fields.colour') }}</label><input id="entry-calendar-colour" name="calendar_colour" type="text" maxlength="7" value="{{ old('calendar_colour', $reminder?->colour ?? '#cccccc') }}" class="w-full text-sm spectrum" /></div>
            <div class="field flex flex-col gap-1"><label for="entry-calendar-periodicity" class="text-xs text-neutral-content">{{ __('calendars.fields.is_recurring') }}</label><select id="entry-calendar-periodicity" name="calendar_recurring_periodicity" class="w-full text-sm" data-date-recurrence>
                @foreach ($calendar ? app(\App\Services\Calendars\RecurrenceOptionsService::class)->forSelect($calendar) : [] as $value => $label)
                    @if (is_array($label))
                        <optgroup label="{{ $value }}">@foreach ($label as $phaseValue => $phaseLabel)<option value="{{ $phaseValue }}" @selected($periodicity == $phaseValue)>{{ $phaseLabel }}</option>@endforeach</optgroup>
                    @else
                        <option value="{{ $value }}" @selected($periodicity == $value)>{{ $label }}</option>
                    @endif
                @endforeach
            </select></div>
        </div>
        <input type="hidden" name="calendar_recurrence_from_periodicity" value="1" />
    </section>
@endif
