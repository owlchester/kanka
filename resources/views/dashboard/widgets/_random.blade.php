<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Tag $tag
 */
if (!isset($offset)) {
    $offset = 0;
}

$entity = $widget->randomEntity();

if (empty($entity) || $entity->isMissingChild()) {
    return;
}
\App\Facades\Dashboard::add($entity);

$specificPreview = 'dashboard.widgets.previews.' . $entity->entityType->code;
$customName = !empty($widget->conf('text')) ? str_replace('{name}', $entity->name, $widget->conf('text')) : null;
$widget->setEntity($entity);
?>
<x-box padding="0" css="widget-random {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $entity, 'customName' => $customName])
@else
    <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity" />
    <x-widgets.previews.body :widget="$widget" :campaign="$campaign" :entity="$entity" />
@endif
</x-box>
