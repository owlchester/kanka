<?php /** @var \App\Models\Item $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('items.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p class="entity-location" data-foreign="{{ $model->location_id }}">
                        <b>{{ __('items.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->character)
                    <p class="entity-character" data-foreign="{{ $model->character_id }}">
                        <b>{{ __('items.fields.character') }}</b><br />
                        {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->price)
                    <p class="entity-price">
                        <b>{{ __('items.fields.price') }}</b><br />
                        {{ $model->price }}
                    </p>
                @endif
                @if ($model->size)
                    <p class="entity-size">
                        <b>{{ __('items.fields.size') }}</b><br />
                        {{ $model->size }}
                    </p>
                @endif
                @if ($model->weight)
                    <p class="entity-weight">
                        <b>{{ __('items.fields.weight') }}</b><br />
                        {{ $model->weight }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
