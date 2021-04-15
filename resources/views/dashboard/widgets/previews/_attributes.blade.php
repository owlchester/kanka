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

    @include('cruds.partials.attributes', [
        'attributes' => $model->entity->attributes()->with('entity')->order(null, 'default_order')->get()
    ])
</div>
