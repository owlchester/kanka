<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Entity $entity
 */
$entity = $entity ?? $widget->entity;

if (empty($entity) && $entity->isMissingChild()) {
    return;
}

$specificPreview = 'dashboard.widgets.previews.' . $entity->entityType->code;
$customName = !empty($widget->conf('text')) ? str_replace('{name}', $entity->name, $widget->conf('text')) : null;

\App\Facades\Dashboard::add($entity);
foreach ($entity->mentions as $mention) {
    if (!$mention->isEntity() || !$mention->target) {
        continue;
    }
    \App\Facades\Mentions::preloadEntity($mention->target);
}
?>
<x-box padding="0" class="widget-preview {{ $widget->customClass($campaign) }} entity-{{ $entity->id }}" id="dashboard-widget-{{ $widget->id }}">
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $entity])
@else
        <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity" />
        <x-widgets.previews.body :widget="$widget" :campaign="$campaign" :entity="$entity" />
@endif
</x-box>
