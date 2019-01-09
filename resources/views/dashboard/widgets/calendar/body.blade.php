<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 */
$entity = $widget->entity;
$calendar = $entity->child;
$currentYear = $calendar->currentDate('year');
$currentMonth = $calendar->currentDate('month');
$currentDay = $calendar->currentDate('date');

// Todo: refactor this into just one query? Gets tricky with taking just 5 in each direction
$previousEvents = $calendar->dashboardEvents('<');
$upcomingSingleEvents = $calendar->dashboardEvents('>=');

// Get the recurring events separately to make sure we always have 5 real "upcoming" events that mix recurring and single
$upcomingRecurringEvents = $calendar->dashboardEvents('>=', 5, true);

$upcomingEvents = [];
foreach ($upcomingSingleEvents as $event) {
    $date = explode('-', $event->date);
    $upcomingEvents[$date[0]][$date[1]][$date[2]][] = $event;
}
foreach ($upcomingRecurringEvents as $event) {
    $until = $event->recurring_until ?: 5;
    for ($y = $currentYear; $y < $until; $y++) {
        $date = explode('-', $event->date);
        if ($y <= $currentYear && $date[1] <= $currentMonth && $date[2] < $currentDay) {
            continue;
        }
        // Make a copy to change the date
        $e = clone($event);
        $e->date = $y . '-'. $date[1] . '-' . $date[2];
        $upcomingEvents[$y][$date[1]][$date[2]][] = $e;
    }
}
ksort($upcomingEvents);
$shownUpcomingEvents = 0;
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
    @if ($previousEvents->count() > 0)
        <div class="col-md-6 col-sm-12">
            <h4>{{ __('dashboard.widgets.calendar.previous_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($previousEvents as $event)
                    @if (!empty($event->entity->child))
                    <li>
                        {{ link_to($event->entity->url(), $event->entity->name) }}
                        <i class="fa fa-calendar pull-right" title="{{ $event->getDate() }}"></i>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($upcomingEvents))
        <div class="col-md-6 col-sm-12">
            <h4>{{ __('dashboard.widgets.calendar.upcoming_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($upcomingEvents as $y => $year)
                    @foreach ($year as $month)
                        @foreach ($month as $day)
                            @foreach ($day as $event)
                                @if ($shownUpcomingEvents <= 5 && !empty($event->entity->child))
                                    <li>
                                        {{ link_to($event->entity->url(), $event->entity->name) }}
                                        @if ($event->date == $calendar->date)
                                            <span class="label label-default pull-right" title="{{ $event->getDate() }}">
                                        {{ __('calendars.actions.today') }}
                                        </span>
                                        @else
                                            <i class="fa fa-calendar pull-right" title="{{ $event->getDate() }}"></i>
                                        @endif
                                    </li>
                                    <?php $shownUpcomingEvents++; ?>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </ul>
        </div>
    @endif
</div>