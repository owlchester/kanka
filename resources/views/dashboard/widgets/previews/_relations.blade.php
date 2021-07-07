<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\MiscModel $model
 */
?>
@if(!$campaign->boosted() || !$widget->showRelations())
    @php return @endphp
@endif

@inject('attributeService', 'App\Services\AttributeService')

<div class="widget-advanced-relations">
    <dl class="dl-horizontal">
    @include('entities.components.relations')
    </dl>
</div>
