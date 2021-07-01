<?php /**
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->map)
    <div class="entity-header-sub pull-left">
        <i class="fas fa-map" title="{{ __('crud.fields.map') }}"></i>


        {!! $model->map->tooltipedLink() !!}

    </div>
@endif
