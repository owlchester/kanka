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
if (empty($calendar) || $calendar->missingDetails()) {
    return;
}
?>
<x-box padding="0" class="widget-calendar {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity" />
    <div class="p-4" data-render="{{ route('dashboard.calendar.render', [$campaign, $widget->id]) }}" data-id="{{ $widget->id }}">
        <div class="text-center py-10 text-2xl" id="widget-loading-{{ $widget->id }}">
            <x-icon class="load" />
        </div>
        <div id="widget-body-{{ $widget->id }}"></div>
    </div>
</x-box>
