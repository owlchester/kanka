<?php /**
 * @var \App\Models\Character $model
 */
?>
@if (!$campaign->enabled('locations') || empty($model->location))
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::icon(config('entities.ids.location'), 'ra ra-tower')" :tooltip="\App\Facades\Module::singular(config('entities.ids.location'), __('entities.location'))"></x-icon>

        @if ($model->location->parentLocation)
            {!! __('crud.fields.locations', [
                'first' => $model->location->tooltipedLink(),
                'second' => $model->location->parentLocation->tooltipedLink(),
            ]) !!}
        @else
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
</div>


