<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 */
?>
<h3 class="widget-header-text text-center" id="dashboard-widget-{{ $widget->id }}">
    {{ $widget->conf('text') }}
</h3>
