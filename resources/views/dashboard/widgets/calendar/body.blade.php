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
    $until = $event->recurring_until ?: ($currentYear + 5);
    for ($y = $currentYear; $y < $until; $y++) {
        $date = explode('-', $event->date);
        if ($y <= $currentYear && ($date[1] < $currentMonth || ($date[1] == $currentMonth && $date[2] < $currentDay))) {
            continue;
        }
        // Make a copy to change the date
        $e = clone($event);
        $e->date = $y . '-'. $date[1] . '-' . $date[2];
        $upcomingEvents[$y][$date[1]][$date[2]][] = $e;
    }
}
$upcomingEvents = array_sort_recursive($upcomingEvents);
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
    @if ($previousEvents->count() > 0)
        <div class="col-md-12 col-lg-6">
            <h4>{{ __('dashboard.widgets.calendar.previous_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($previousEvents as $event)
                    @if (!empty($event->entity->child))
                    <li>
                        <div class="pull-right">
                            @if (!empty($event->comment))
                                <i class="fa fa-comment" title="{{ $event->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                            @endif
                            <i class="fa fa-calendar" title="{{ $event->getDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                        </div>
                        {{ link_to($event->entity->url(), $event->entity->name) }}
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($upcomingEvents))
        <div class="col-lg-6 col-md-12">
            <h4>{{ __('dashboard.widgets.calendar.upcoming_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($upcomingEvents as $y => $year)
                    @foreach ($year as $month)
                        @foreach ($month as $day)
                            @foreach ($day as $event)
                                @if ($shownUpcomingEvents < 5 && !empty($event->entity->child))
                                    <li>
                                        <div class="pull-right">
                                            @if (!empty($event->comment))
                                                <i class="fa fa-comment" title="{{ $event->comment }}" data-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                            @if ($event->date == $calendar->date)
                                                <span class="label label-default" title="{{ $event->getDate() }}">
                                            {{ __('calendars.actions.today') }}
                                            </span>
                                            @else
                                                <i class="fa fa-calendar" title="{{ $event->getDate() }}" data-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                        </div>
                                        {{ link_to($event->entity->url(), $event->entity->name, ['title' => $event->comment, 'data-toggle' => 'tooltip']) }}
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