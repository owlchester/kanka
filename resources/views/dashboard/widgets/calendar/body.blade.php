<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 * @var \App\Models\EntityEvent $reminder
 */
$entity = $widget->entity;
if (empty($entity)) {
    return;
}
$calendar = $entity->child;

$upcomingEvents = $calendar->upcomingReminders();
$previousEvents = $calendar->pastReminders();
//$previousEvents = new \Illuminate\Support\Collection();

// Get the current day's weather effect.
// Todo: make it a relation that can be queried "with"?
$weather = $calendar->calendarWeather()
    ->year($calendar->currentYear())
    ->month($calendar->currentMonth())
    ->where('day', $calendar->currentDay())
    ->first();


/** @var \App\Models\EntityEvent $event */
?>
<div class="current-date text-center text-2xl flex items-center justify-center gap-2" id="widget-date-{{ $widget->id }}">
    @can('update', $calendar)
        <a href="#" class="widget-calendar-switch" data-url="{{ route('dashboard.calendar.sub', $widget) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" title="{{ __('dashboard.widgets.calendar.actions.previous') }}" role="button">
            <i class="fa-solid fa-chevron-circle-left" aria-hidden="true"></i>
            <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.previous') }}</span>
        </a>
        <span>{{ $calendar->niceDate() }}</span>

        <a href="#" class="widget-calendar-switch" data-url="{{ route('dashboard.calendar.add', $widget) }}" data-widget="{{ $widget->id }}"  data-toggle="tooltip" title="{{ __('dashboard.widgets.calendar.actions.next') }}" role="button">
            <i class="fa-solid fa-chevron-circle-right" aria-hidden="true"></i>
            <span class="sr-only">{{ __('dashboard.widgets.calendar.actions.next') }}</span>
        </a>
    @else
        {{ $calendar->niceDate() }}
    @endcan

</div>

@if ($weather)
    <div class="text-center">
        <div class="weather weather-{{ $weather->weather }}" data-html="true" data-toggle="tooltip" title="{!! $weather->tooltip() !!}">
            <i class="fa-solid fa-{{ $weather->weather }}"></i>
            {{ $weather->weatherName() }}
        </div>
    </div>
@endif

<div class="row">
    @if ($previousEvents->isNotEmpty())
        <div class="col-md-12 col-lg-6">
            <div class="text-lg mb-2">
                {{ __('dashboard.widgets.calendar.previous_events') }}
                <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations" target="_blank" data-toggle="tooltip" title="{{ __('helpers.calendar-widget.info') }}">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                </a>
            </div>
            <ul class="style-none p-0">
                @foreach ($previousEvents->take(5) as $reminder)
                    @if (!$reminder->entity) @continue @endif
                    <li data-ago="{{ $reminder->daysAgo() }}" class="">
                        <div class="pull-right">
                            @if (!empty($reminder->comment))
                                <i class="fa-solid fa-comment" title="{{ $reminder->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                            @endif
                                @if ($reminder->is_recurring)
                                <i class="fa-solid fa-arrows-rotate" title="{{ __('calendars.fields.is_recurring') }}" data-toggle="tooltip"></i>
                            @endif
                            <i class="fa-solid fa-calendar" title="{{ $reminder->readableDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                        </div>
                        {{ link_to($reminder->entity->url(), $reminder->entity->name) }}

                        @if (app()->environment('local'))
                            <span class="text-xs">({{ $reminder->date() }}, {{ $reminder->daysAgo() }} days ago)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($upcomingEvents->isNotEmpty())
        <div class="col-lg-6 col-md-12">
            <div class="text-lg mb-2">
                {{ __('dashboard.widgets.calendar.upcoming_events') }}
                <a href="//docs.kanka.io/en/latest/guides/dashboard.html#known-limitations" target="_blank" data-toggle="tooltip" title="{{ __('helpers.calendar-widget.info') }}">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('helpers.calendar-widget.info') }}</span>
                </a>
            </div>
            <ul class="style-none p-0">
                @foreach ($upcomingEvents->take(5) as $reminder)
                    @if (!$reminder->entity) @continue @endif
                    <li data-in="{{ $reminder->inDays() }}">
                        <div class="pull-right">
                            @if (!empty($reminder->comment))
                                <i class="fa-solid fa-comment" title="{{ $reminder->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                            @endif
                            @if ($reminder->is_recurring)
                                <i class="fa-solid fa-arrows-rotate" title="{{ __('calendars.fields.is_recurring') }}" data-toggle="tooltip"></i>
                            @endif
                            @if ($reminder->isToday($calendar))
                                <i class="fa-solid fa-calendar-check" data-toggle="tooltip" title="{{ __('calendars.actions.today') }}"></i>
                            @else
                                <i class="fa-solid fa-calendar" title="{{ $reminder->readableDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                            @endif
                        </div>
                        {{ link_to($reminder->entity->url(), $reminder->entity->name, ['title' => $reminder->comment, 'data-toggle' => 'tooltip']) }}
                        @if (app()->environment('local'))
                            <span class="text-xs">({{ $reminder->date() }}, in {{ $reminder->inDays() }} days)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
