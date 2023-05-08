<?php /**
 * @var \App\Models\Map $model
 * @var \App\Services\CampaignService $campaign
 */
?>
@if ($model->map || $model->location)
    <div class="entity-header-sub pull-left">
        @if ($model->map)
            <span  class="mr-2">
                <x-icon class="fa-regular fa-map" :title="__('crud.fields.parent')"></x-icon>
                {!! $model->map->tooltipedLink() !!}
            </span>
        @endif

        @if ($model->location)
            <i class="ra ra-tower" aria-hidden="true" title="{{ \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location')) }}"></i>
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
@endif

