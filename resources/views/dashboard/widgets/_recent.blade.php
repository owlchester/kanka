<?php
/** @var \App\Models\Entity $entity */
/** @var \App\Models\CampaignDashboardWidget $widget */
if (!isset($offset)) {
    $offset = 0;
}
$entityType = $widget->conf('entity');
$entities = \App\Models\Entity::recentlyModified()->type($entityType)->standardWith()->acl()->take(10)->offset($offset)->get();
$entityString = !empty($entityType) ? ($widget->conf('singular') ? $entityType : str_plural($entityType)) : null;
?>
<div class="panel panel-default" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading">
        <h4 class="panel-title">
            @if ($widget->conf('entity'))
                {{ __('entities.' . $entityString) }} -
            @endif{{ __('dashboard.widgets.recent.title') }}
        </h4>
    </div>
    <div class="panel-body widget-recent-body">
        @if (!empty($widget->conf('singular')))
            @include('dashboard.widgets._recent_singular', ['entities' => $entities])
        @else
            @include('dashboard.widgets._recent_list', ['entities' => $entities, 'offset' => $offset])
        @endif
    </div>
</div>