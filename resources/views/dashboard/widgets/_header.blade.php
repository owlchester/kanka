<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->target instanceof \App\Models\Entity && !$widget->target->isMissingChild())
    <a href="{{ $widget->target->url() }}">
        <{{ $widget->customSize() }} class="text-2xl widget-header-text text-center my-4  {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </{{ $widget->customSize() }}>
    </a>
@elseif ($widget->target instanceof \App\Models\CampaignDashboard)
    <a href="{{ route('dashboard', [$campaign, 'dashboard' => $widget->target->id]) }}">
        <{{ $widget->customSize() }} class="text-2xl widget-header-text text-center my-4 {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </{{ $widget->customSize() }}>
    </a>
@else
    <{{ $widget->customSize() }} class="widget-header-text text-center my-4 {{ $widget->customClass() }} text-2xl " id="dashboard-widget-{{ $widget->id }}">
        {{ $widget->conf('text') }}
    </{{ $widget->customSize() }}>
@endif
