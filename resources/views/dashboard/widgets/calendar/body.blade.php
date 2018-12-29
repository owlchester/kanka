<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 */
$entity = $widget->entity;
$calendar = $entity->child;
$previousEvents = $calendar->dashboardEvents('<');
$upcomingEvents = $calendar->dashboardEvents('>=');

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
                    <li>
                        {{ link_to($event->entity->child->getLink(), $event->entity->name) }}
                        <i class="fa fa-calendar pull-right" title="{{ $event->getDate() }}"></i>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($upcomingEvents->count() > 0)
        <div class="col-md-6 col-sm-12">
            <h4>{{ __('dashboard.widgets.calendar.upcoming_events') }}</h4>
            <ul class="list-unstyled">
                @foreach ($upcomingEvents as $event)
                    <li>
                        {{ link_to($event->entity->child->getLink(), $event->entity->name) }}
                        @if ($event->date == $calendar->date)
                            <span class="label label-default pull-right" title="{{ $event->getDate() }}">
                            {{ __('calendars.actions.today') }}
                            </span>
                        @else
                            <i class="fa fa-calendar pull-right" title="{{ $event->getDate() }}"></i>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>