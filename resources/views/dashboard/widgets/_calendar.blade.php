<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 */
$entity = $widget->entity;
$calendar = $entity->child;
?>
<div class="panel panel-default" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
       <h3 class="panel-title">
           {{ link_to($calendar->getLink(), $entity->name) }}
       </h3>
    </div>
    <div class="panel-body" id="widget-body-{{ $widget->id }}">
        @include('dashboard.widgets.calendar.body')
    </div>
</div>