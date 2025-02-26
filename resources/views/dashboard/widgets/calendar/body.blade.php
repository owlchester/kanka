@inject ('reminderService', 'App\Services\Calendars\ReminderService')
<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 * @var \App\Models\EntityEvent $reminder
 * @var \App\Models\EntityEvent $event
 * @var \App\Services\Calendars\ReminderService $reminderService
 */
$entity = $widget->entity;
if (empty($entity)) {
    return;
}
$calendar = $calendar ?? $entity->child;

$upcomingEvents = $reminderService->calendar($calendar)->upcoming();
$previousEvents = $reminderService->past();
//$previousEvents = new \Illuminate\Support\Collection();

// Get the current day's weather effect.
$weather = $calendar->calendarWeather()
    ->year($calendar->currentYear())
    ->month($calendar->currentMonth())
    ->where('day', $calendar->currentDay())
    ->first();


?>
<x-grid>
<div class="col-span-2 current-date text-center text-xl flex items-center justify-center gap-2" id="widget-date-{{ $widget->id }}">
    @can('update', $entity)
        <a href="#" class="widget-calendar-switch" data-url="{{ route('dashboard.calendar.sub', [$campaign, $widget]) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" data-title="{{ __('dashboard.widgets.calendar.actions.previous') }}" role="button">
            <x-icon class="fa-solid fa-chevron-circle-left" />
            <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.previous') }}</span>
        </a>
        <span>{{ $calendar->niceDate() }}</span>

        <a href="#" class="widget-calendar-switch" data-url="{{ route('dashboard.calendar.add', [$campaign, $widget]) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" data-title="{{ __('dashboard.widgets.calendar.actions.next') }}" role="button">
            <x-icon class="fa-solid fa-chevron-circle-right" />
            <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.next') }}</span>
        </a>
    @else
        {{ $calendar->niceDate() }}
    @endcan

</div>

@if ($weather)
    <div class="col-span-2 text-center">
        <div class="weather weather-{{ $weather->weather }}" data-html="true" data-toggle="tooltip" data-title="{!! $weather->tooltip() !!}">
            <x-icon class="fa-solid fa-{{ $weather->weather }}" />
            {{ $weather->weatherName() }}
        </div>
    </div>
@endif

    @if ($previousEvents->isNotEmpty())
        <div class="flex flex-col gap-2 @if ($upcomingEvents->isEmpty()) col-span-2 @endif">
            <div class="text-lg">
                {{ __('dashboard.widgets.calendar.previous_events') }}
                <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations" target="_blank" data-toggle="tooltip" data-title="{{ __('helpers.calendar-widget.info') }}">
                    <x-icon class="question" />
                    <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                </a>
            </div>
            <ul class="style-none p-0">
                @foreach ($previousEvents->take(5) as $reminder)
                    @includeWhen($reminder->entity, 'dashboard.widgets.calendar._reminder')
                @endforeach
            </ul>
        </div>
    @endif

    @if ($upcomingEvents->isNotEmpty())
        <div class="flex flex-col gap-2 @if ($previousEvents->isEmpty()) col-span-2 @endif">
            <div class="text-lg">
                {{ __('dashboard.widgets.calendar.upcoming_events') }}
                <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations" target="_blank" data-toggle="tooltip" data-title="{{ __('helpers.calendar-widget.info') }}">
                    <x-icon class="question" />
                    <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                </a>
            </div>
            <ul class="style-none p-0">
                @foreach ($upcomingEvents->take(5) as $reminder)
                    @includeWhen($reminder->entity, 'dashboard.widgets.calendar._reminder', ['future' => true])

                @endforeach
            </ul>
        </div>
    @endif
</x-grid>
