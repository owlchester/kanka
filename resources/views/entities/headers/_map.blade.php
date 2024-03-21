<?php /**
 * @var \App\Models\Map $model
 */
?>
@if ($model->map || $model->location)
    <div class="entity-header-sub pull-left flex items-center gap-2">
        @if ($model->map)
            <span class="">
                <x-icon :class="\App\Facades\Module::duoIcon('map')" :title="__('crud.fields.parent')" />
                {!! $model->map->tooltipedLink() !!}
            </span>
        @endif

        @if ($model->location)
            <x-icon entity="location" />
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
@endif

