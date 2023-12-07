<?php /**
 * @var \App\Models\Character $model
 */
?>
@if (!$campaign->enabled('locations') || empty($model->location))
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('location')" :title="__('entities.location')" />

        @if ($model->location->location)
            {!! __('crud.fields.locations', [
                'first' => $model->location->tooltipedLink(),
                'second' => $model->location->location->tooltipedLink(),
            ]) !!}
        @else
            {!! $model->location->tooltipedLink() !!}
        @endif
    </div>
</div>


