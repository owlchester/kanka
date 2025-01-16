<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */
?>
<x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity">
    @if ($entity->child->isDead())
        <x-icon class="ra ra-skull" :title="__('characters.fields.is_dead')" tooltip />
    @endif
</x-widgets.previews.head>
<x-widgets.previews.body  :widget="$widget" :campaign="$campaign" :entity="$entity">
</x-widgets.previews.body>
