<?php /**
 * @var \App\Models\Character $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if (!$campaignService->enabled('locations') || empty($model->location))
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    <div class="entity-header-sub-element">
        <i class="ra ra-tower" title="{{ __('entities.location') }}" data-toggle="tooltip"></i>

        @if ($model->location->parentLocation)
            {!! __('entities.locations', [
                'first' => $model->location->tooltipedLink(),
                'second' => $model->location->parentLocation->tooltipedLink(),
            ]) !!}
        @else
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
</div>


