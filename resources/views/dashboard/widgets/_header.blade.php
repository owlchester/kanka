<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->entity && !$widget->entity->isMissingChild())
    <a href="{{ $widget->entity->url() }}">
        <{{ $widget->customSize() }} class="text-2xl widget-header-text text-center my-4  {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </{{ $widget->customSize() }}>
    </a>
@else
    <{{ $widget->customSize() }} class="widget-header-text text-center my-4 {{ $widget->customClass($campaign) }} text-2xl " id="dashboard-widget-{{ $widget->id }}">
        {{ $widget->conf('text') }}
    </{{ $widget->customSize() }}>
@endif
