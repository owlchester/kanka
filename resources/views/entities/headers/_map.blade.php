<?php /**
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->map || $model->location)
    <div class="entity-header-sub pull-left">
        @if ($model->map)
            <span  class="margin-r-5">
                <i class="fas fa-map" title="{{ __('crud.fields.map') }}"></i>
                {!! $model->map->tooltipedLink() !!}
            </span>
        @endif

        @if ($model->location)
            <i class="ra ra-tower" title="{{ __('crud.fields.location') }}"></i>
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
@endif

