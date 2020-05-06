<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 * @var \App\Models\EntityEvent $reminder
 */
$entity = $widget->entity;
$calendar = $entity->child;
$currentYear = $calendar->currentDate('year');
$currentMonth = $calendar->currentDate('month');
$currentDay = $calendar->currentDate('date');

$yearlyEvents = $calendar->dashboardEvents('=', 0);
$upcomingEvents = new \Illuminate\Support\Collection();
$previousEvents = new \Illuminate\Support\Collection();

// Loop through reminders occurring on this year, and sort them out in upcoming and past.
// Todo: only take a few close to the current date?
foreach ($yearlyEvents as $reminder) {
    if ($reminder->isPast($calendar)) {
        $previousEvents->push($reminder);
    } else {
        $upcomingEvents->push($reminder);
    }
}

// If we need more previous events, get some
if ($previousEvents->count() < 5) {
    $previousSingleEvents = $calendar->dashboardEvents('<');
    foreach ($previousSingleEvents as $reminder) {
        $previousEvents->push($reminder);
    }
}

// Order the past events in descending date to get the closest ones to the current date first
$previousEvents = $previousEvents->sortByDesc(function ($reminder) {
    return [$reminder->year, $reminder->month, $reminder->day];
});

// If we need more upcoming events, get some
if ($upcomingEvents->count() < 5) {
    $upcomingSingleEvents = $calendar->dashboardEvents('>');
    foreach ($upcomingSingleEvents as $reminder) {
        $upcomingEvents->push($reminder);
    }
}

// Get the recurring events separately to make sure we always have 5 real "upcoming" events that mix recurring and single
$upcomingRecurringEvents = $calendar->dashboardEvents('>=', 5, true);
foreach ($upcomingRecurringEvents as $event) {
    // Recurring events can be forever, so check that's best
    $until = !empty($event->recurring_until) ? min($event->recurring_until, $currentYear + 5) : $currentYear + 5;
    for ($y = $currentYear; $y < $until; $y++) {
        if ($y <= $currentYear && ($event->month < $currentMonth || ($event->month == $currentMonth && $event->day < $currentDay))) {
            continue;
        }
        // Make a copy to change the date
        $e = clone($event);
        $e->year = $y;
        $upcomingEvents->push($e);
    }
}
// Order the upcoming events by date
$upcomingEvents = $upcomingEvents->sortBy(function ($reminder) {
    return [$reminder->year, $reminder->month, $reminder->day];
});

// It could be that we get reminders for events the user can't see (2019-08: should no longer be the case? )
$shownUpcomingEvents = 0;

/** @var \App\Models\EntityEvent $event */
?>
<div class="current-date" id="widget-date-{{ $widget->id }}">
    @can('update', $calendar)
        <i class="fa fa-chevron-circle-left widget-calendar-switch" title="{{ __('dashboard.widgets.calendar.actions.previous') }}" data-url="{{ route('dashboard.calendar.sub', $widget) }}" data-widget="{{ $widget->id }}"></i>
        {{ $calendar->niceDate() }}
        <i class="fa fa-chevron-circle-right widget-calendar-switch" title="{{ __('dashboard.widgets.calendar.actions.next') }}" data-url="{{ route('dashboard.calendar.add', $widget) }}" data-widget="{{ $widget->id }}"></i>
    @else
        {{ $calendar->niceDate() }}
    @endcan
</div>
<div id="widget-loading-{{ $widget->id }}" class="text-center hidden">
    <i class="fa fa-spin fa-spinner"></i>
</div>
<div class="row">
    @if ($previousEvents->isNotEmpty())
        <div class="col-md-12 col-lg-6">
            <h4>{{ __('dashboard.widgets.calendar.previous_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($previousEvents->take(5) as $reminder)
                    @if (!empty($reminder->entity->child))
                    <li>
                        <div class="pull-right">
                            @if (!empty($reminder->comment))
                                <i class="fa fa-comment" title="{{ $reminder->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                            @endif
                            <i class="fa fa-calendar" title="{{ $reminder->readableDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                        </div>
                        {{ link_to($reminder->entity->url(), $reminder->entity->name) }}
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if ($upcomingEvents->isNotEmpty())
        <div class="col-lg-6 col-md-12">
            <h4>{{ __('dashboard.widgets.calendar.upcoming_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($upcomingEvents->all() as $event)
                    @if ($shownUpcomingEvents < 5 && !empty($event->entity->child))
                        <li>
                            <div class="pull-right">
                                @if (!empty($event->comment))
                                    <i class="fa fa-comment" title="{{ $event->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                                @endif
                                @if ($event->isToday($calendar))
                                    <span class="label label-default" title="{{ $event->readableDate() }}">
                                        {{ __('calendars.actions.today') }}
                                    </span>
                                @else
                                    <i class="fa fa-calendar" title="{{ $event->readableDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                                @endif
                            </div>
                            {{ link_to($event->entity->url(), $event->entity->name, ['title' => $event->comment, 'data-toggle' => 'tooltip']) }}
                        </li>
                        <?php $shownUpcomingEvents++; ?>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>
