<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\ValueObjects\Calendars\CalendarWidgetState $state
 */
$entity = $widget->entity;
if (empty($entity)) {
    return;
}
$calendar = $calendar ?? $entity->child;
$upcomingEvents = $state->upcomingEvents;
$previousEvents = $state->previousEvents;
$currentMoons = $state->currentMoons;
$currentWeekdayName = $state->currentWeekdayName;
$weather = $state->weather;
?>
<div class="flex flex-col gap-2">

    <div class="current-date text-center text-lg flex items-center justify-center gap-2" id="widget-date-{{ $widget->id }}">
        @can('update', $entity)
            <a href="#" class="widget-calendar-switch text-link" data-url="{{ route('dashboard.calendar.sub', [$campaign, $widget]) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" data-title="{{ __('dashboard.widgets.calendar.actions.previous') }}" role="button">
                <x-icon class="fa-regular fa-chevron-circle-left" />
                <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.previous') }}</span>
            </a>
            <span>{{ $calendar->niceDate() }}</span>

            <a href="#" class="widget-calendar-switch text-link" data-url="{{ route('dashboard.calendar.add', [$campaign, $widget]) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" data-title="{{ __('dashboard.widgets.calendar.actions.next') }}" role="button">
                <x-icon class="fa-regular fa-chevron-circle-right" />
                <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.next') }}</span>
            </a>
        @else
            {{ $calendar->niceDate() }}
        @endcan

        @if (!empty($currentMoons))
            <div class="flex gap-1 moons">
                @foreach ($currentMoons as $moon)
                    @php
                        $phaseKey = \App\Services\Calendars\MoonPhase::displayKey($moon->phase);
                        $phaseLabel = __('calendars.show.moon_' . $phaseKey, ['moon' => $moon->name]);
                        $moonTitle = $moon->isExact()
                            ? $phaseLabel
                            : trans_choice('calendars.show.moon_age', $moon->daysSincePhase, ['phase' => $phaseLabel, 'count' => $moon->daysSincePhase]);
                    @endphp
                    <x-moon-phase
                        :phase="$moon->phase"
                        :colour="$moon->colour"
                        data-id="{{ $moon->moonId }}"
                        data-toggle="tooltip"
                        data-title="{{ $moonTitle }}"
                    />
                @endforeach
            </div>
        @endif

    </div>

    @if ($currentWeekdayName)
        <div class="text-center text-muted">
            {{ $currentWeekdayName }}
        </div>
    @endif

    @if ($weather)
        <div class="col-span-2 text-center">
            <div class="weather weather-{{ $weather->weather }}" data-html="true" data-toggle="tooltip" data-title="{!! $weather->tooltip() !!}">
                <x-icon class="fa-solid fa-{{ $weather->weather }}" />
                {{ $weather->weatherName() }}
            </div>
        </div>
    @endif

    <x-grid>
        @if ($previousEvents->isNotEmpty())
            <div class="flex flex-col gap-2 @if ($upcomingEvents->isEmpty()) col-span-2 @endif">
                <div class="text-lg">
                    {{ __('dashboard.widgets.calendar.previous_events') }}
                    <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations"  class="text-link" data-toggle="tooltip" data-title="{{ __('helpers.calendar-widget.info') }}">
                        <x-icon class="question" />
                        <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                    </a>
                </div>
                <ul class="style-none p-0">
                    @foreach ($previousEvents as $reminderOccurrence)
                        @includeWhen($reminderOccurrence->reminder->remindable, 'dashboard.widgets.calendar._reminder', ['reminderOccurrence' => $reminderOccurrence])
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($upcomingEvents->isNotEmpty())
            <div class="flex flex-col gap-2 @if ($previousEvents->isEmpty()) col-span-2 @endif">
                <div class="text-lg">
                    {{ __('dashboard.widgets.calendar.upcoming_events') }}
                    <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations"  class="text-link" data-toggle="tooltip" data-title="{{ __('helpers.calendar-widget.info') }}">
                        <x-icon class="question" />
                        <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                    </a>
                </div>
                <ul class="style-none p-0">
                    @foreach ($upcomingEvents as $reminderOccurrence)
                        @includeWhen($reminderOccurrence->reminder->remindable, 'dashboard.widgets.calendar._reminder', ['reminderOccurrence' => $reminderOccurrence])

                    @endforeach
                </ul>
            </div>
        @endif
    </x-grid>
</div>
