<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->entity != null && $widget->entity->child != null)
    <a href="{{ $widget->entity->url() }}">
        <{{ $widget->customSize($campaign) }} class="widget-header-text text-center {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </{{ $widget->customSize($campaign) }}>
    </a>
@else
    <{{ $widget->customSize($campaign) }} class="widget-header-text text-center {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
        {{ $widget->conf('text') }}
    </{{ $widget->customSize($campaign) }}>
@endif
