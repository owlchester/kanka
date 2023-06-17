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
    <ul class="m-0 p-0 list-none">

    @include('entities.components.attributes')
    </ul>
</div>
