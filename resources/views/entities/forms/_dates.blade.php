<section id="entry-calendar-dates" class="entry-workspace-dates flex flex-col gap-4 rounded-lg p-3" aria-labelledby="entry-dates-heading">
    <h3 id="entry-dates-heading" class="text-sm font-semibold">{{ __('entries/workspace.dates.title') }}</h3>
    @foreach ($dateRows as $dateKey => $dateRow)
        <details @if ($dateKey !== 'death' || $dateRow['filled'] || old("entry_dates.$dateKey.calendar_id")) open @endif>
            <summary class="cursor-pointer text-sm font-medium">{{ __('entities/events.types.' . $dateKey) }}</summary>
            @if (!$dateRow['editable'])
                <p class="pt-3 text-xs text-neutral-content">{{ __('entries/workspace.dates.locked') }}</p>
            @elseif ($dateCalendars->isNotEmpty())
                @php $selectedCalendar = $dateCalendars->firstWhere('id', $dateRow['calendar_id']); @endphp
                <div class="flex flex-col gap-3 pt-3" data-entry-date data-calendars="{{ $dateCalendarOptions->toJson() }}">
                    <div class="field flex flex-col gap-1">
                        <label for="entry-{{ $dateKey }}-calendar" class="text-xs font-medium">{{ __('entities.calendar') }}</label>
                        <select name="entry_dates[{{ $dateKey }}][calendar_id]" id="entry-{{ $dateKey }}-calendar" class="w-full text-sm" data-date-calendar>
                            <option value="">—</option>
                            @foreach ($dateCalendars as $dateCalendar)
                                <option value="{{ $dateCalendar->id }}" @selected($dateRow['calendar_id'] == $dateCalendar->id)>{{ $dateCalendar->entity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="field min-w-0 flex flex-col gap-1">
                            <label for="entry-{{ $dateKey }}-year" class="text-xs text-neutral-content">{{ __('calendars.fields.year') }}</label>
                            <input name="entry_dates[{{ $dateKey }}][year]" id="entry-{{ $dateKey }}-year" type="number" value="{{ $dateRow['year'] }}" class="w-full min-w-0 text-sm" data-date-year />
                        </div>
                        <div class="field min-w-0 flex flex-col gap-1">
                            <label for="entry-{{ $dateKey }}-month" class="text-xs text-neutral-content">{{ __('calendars.fields.month') }}</label>
                            <select name="entry_dates[{{ $dateKey }}][month]" id="entry-{{ $dateKey }}-month" class="w-full min-w-0 text-sm" data-date-month>
                                <option value="">—</option>
                                @foreach ($selectedCalendar?->monthList() ?? [] as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}" @selected($dateRow['month'] == $monthNumber)>{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field min-w-0 flex flex-col gap-1">
                            <label for="entry-{{ $dateKey }}-day" class="text-xs text-neutral-content">{{ __('calendars.fields.day') }}</label>
                            <input name="entry_dates[{{ $dateKey }}][day]" id="entry-{{ $dateKey }}-day" type="number" min="1" value="{{ $dateRow['day'] }}" class="w-full min-w-0 text-sm" data-date-day />
                        </div>
                    </div>
                    @if ($dateRow['existing'])
                        <div class="entry-workspace-remove-date text-xs">
                            <input id="entry-{{ $dateKey }}-remove" type="checkbox" name="entry_dates[{{ $dateKey }}][remove]" value="1" @checked(old("entry_dates.$dateKey.remove")) />
                            <label for="entry-{{ $dateKey }}-remove">{{ __('entries/workspace.dates.remove') }}</label>
                        </div>
                    @endif
                </div>
            @endif
        </details>
    @endforeach
    @if ($entityType->isCharacter())
        <p class="entry-workspace-date-hint pt-3 text-xs text-neutral-content">{{ __('entries/workspace.dates.age_hint') }}</p>
    @endif
</section>
