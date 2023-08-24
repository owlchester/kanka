<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\EntityEvent $event
 */
$entity = $widget->entity;
$calendar = $entity->child;
// Todo: move this to the query
if (empty($calendar)) {
    return;
}
?>
<div class="panel panel-default {{ $widget->customClass($campaign) }} widget-render" id="dashboard-widget-{{ $widget->id }}" data-url="{{ route('dashboard.calendar.render', [$campaign, $widget->id]) }}">
    @if (!$calendar->image)
    <div class="panel-heading px-4 py-2">
       <h3 class="panel-title m-0">
           {{ link_to($calendar->getLink(), (!empty($widget->conf('text')) ? $widget->conf('text') : $entity->name)) }}
       </h3>
    </div>
    @else
        <div class="panel-heading panel-heading-entity" style="background-image: url('{{ $widget->entity->child->thumbnail(600) }}')">
            <h3 class="panel-title m-0">
                {{ link_to($calendar->getLink(), $entity->name) }}
            </h3>
        </div>
    @endif
    <div class="panel-body p-4" id="widget-body-{{ $widget->id }}">
        <div class="widget-loading text-center">
            <i class="fa-solid fa-spin fa-spinner fa-4x"></i>
        </div>
        <div class="widget-body"></div>
    </div>

</div>
