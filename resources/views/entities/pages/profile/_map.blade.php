<?php /** @var \App\Models\Location $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('locations.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->map)
                    <p class="entity-map" data-foreign="{{ $model->map_id }}">
                        <b>{{ __('maps.fields.map') }}</b><br />
                        {!! $model->map->tooltipedLink() !!}
                    </p>
                @endif

                @if ($model->location)
                    <p class="entity-location" data-foreign="{{ $model->location_id }}">
                        <b>{{ __('maps.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
