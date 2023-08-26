<?php /**
 * @var \App\Models\MiscModel $model
 */
?>
@if ($campaign->enabled('locations') && $model->location)
    <div class="entity-header-sub pull-left">
        <x-icon entity="location" />

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
