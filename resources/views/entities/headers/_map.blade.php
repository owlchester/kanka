<?php /**
 * @var \App\Models\Map $model
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
        <x-icon :class="\App\Facades\Module::icon(config('entities.ids.location'), 'ra ra-tower')" :tooltip="\App\Facades\Module::singular(config('entities.ids.location'), __('entities.location'))"></x-icon>
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
@endif

