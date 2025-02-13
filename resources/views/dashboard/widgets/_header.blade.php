<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->entity != null && $widget->entity->child != null)
    <a href="{{ $widget->entity->url() }}">
        <{{ $widget->customSize() }} class="widget-header-text text-center my-4  {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </{{ $widget->customSize() }}>
    </a>
@else
    <{{ $widget->customSize() }} class="widget-header-text text-center my-4 {{ $widget->customClass() }}" id="dashboard-widget-{{ $widget->id }}">
        {{ $widget->conf('text') }}
    </{{ $widget->customSize() }}>
@endif
