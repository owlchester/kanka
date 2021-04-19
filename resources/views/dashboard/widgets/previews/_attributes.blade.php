<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\MiscModel $model
 */
?>
@if(!$campaign->boosted() || !$widget->showAttributes())
    @php return @endphp
@endif

@inject('attributeService', 'App\Services\AttributeService')

<div class="widget-advanced-attributes">
    <dl class="dl-horizontal">

    @include('entities.components.attributes')
    </dl>
</div>
