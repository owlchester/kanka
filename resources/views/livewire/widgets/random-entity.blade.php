<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */
?>
<div wire:init="loadEntity">
    @if (!$readyToLoad)
        <x-icon class="loading"></x-icon>
    @elseif ($entity)
        <x-box padding="0" class="widget-random {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
            @if(view()->exists($specificPreview))
                @include($specificPreview, ['entity' => $entity, 'customName' => $customName])
            @else
                <x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity" />
                <x-widgets.previews.body :widget="$widget" :campaign="$campaign" :entity="$entity" />
            @endif
        </x-box>
    @else
        <p>{{ __('Nothing to show') }}</p>
    @endif
</div>
