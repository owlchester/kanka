<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($campaignService->enabled('locations') && $model->location)
    <div class="entity-header-sub pull-left">
        <x-icon class="ra ra-tower" :tooltip="\App\Facades\Module::singular(config('entities.ids.location'), __('entities.location'))"></x-icon>

        @if ($model->location->parentLocation)
            {!! __('crud.fields.locations', [
                'first' => $model->location->tooltipedLink(),
                'second' => $model->location->parentLocation->tooltipedLink(),
            ]) !!}
        @else
            {!! $model->location->tooltipedLink() !!}
        @endif

    </div>
@endif
