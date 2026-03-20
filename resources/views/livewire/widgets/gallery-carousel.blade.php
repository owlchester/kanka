<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var array $images
 * @var bool $showName
 * @var bool $readyToLoad
 */
?>
<div wire:init="loadImages">
    @if (!$readyToLoad)
        <x-icon class="loading"></x-icon>
    @elseif (count($images) > 0)
        <x-box padding="0" class="widget-gallery {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
            <x-gallery-carousel :images="$images" :show-name="$showName" />
        </x-box>
    @else
        <x-box class="widget-gallery {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
            <p class="text-neutral-content text-center">{{ __('Nothing to show') }}</p>
        </x-box>
    @endif
</div>
