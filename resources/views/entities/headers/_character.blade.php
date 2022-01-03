<?php /**
 * @var \App\Models\Character $model
 * @var \App\Services\CampaignService $campaign
 */
?>

@if (($campaign->enabled('locations') && $model->location) || ($campaign->enabled('races') && $model->race))
    <div class="entity-header-sub entity-header-line">
    @if ($campaign->enabled('locations') && $model->location)
        <div class="entity-header-sub-element">
            <i class="ra ra-tower" title="{{ __('crud.fields.location') }}" data-toggle="tooltip"></i>

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

    @if ($campaign->enabled('races') && !$model->races->isEmpty())
        @foreach ($model->races as $race)
        <div class="entity-header-sub-element entity-header-sub-race" style="display: none">
            <i class="ra ra-dragon" title="{{ __('crud.fields.race') }}" data-toggle="tooltip"></i>
            {!! $race->tooltipedLink() !!}
        </div>
        @endif
    @endif

    @if ($campaign->enabled('families') && $model->family)
        <div class="entity-header-sub-element entity-header-sub-family" style="display: none">
            <i class="ra ra-double-team" title="{{ __('crud.fields.family') }}" data-toggle="tooltip"></i>
            {!! $model->family->tooltipedLink() !!}
        </div>
    @endif

    </div>
@endif


