<?php
/**
* @var \App\Models\CampaignDashboardWidget $widget
*/
?>
{{-- Check if the header is linked to an entity
     and if the user has read permissions on it --}}
@if ($widget->entity != null && $widget->entity->child != null)
    <a href="{{ $widget->entity->url() }}">
        <h3 class="widget-header-text text-center" id="dashboard-widget-{{ $widget->id }}">
            {{ $widget->conf('text') }}
        </h3>
    </a>
@else
    <h3 class="widget-header-text text-center" id="dashboard-widget-{{ $widget->id }}">
        {{ $widget->conf('text') }}
    </h3>
@endif
