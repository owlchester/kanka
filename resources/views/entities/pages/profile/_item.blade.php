<?php /** @var \App\Models\Item $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('items.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p>
                        <b>{{ __('items.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->character)
                    <p>
                        <b>{{ __('items.fields.character') }}</b><br />
                        {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->price)
                    <p>
                        <b>{{ __('items.fields.price') }}</b><br />
                        {{ $model->price }}
                    </p>
                @endif
                @if ($model->size)
                    <p>
                        <b>{{ __('items.fields.size') }}</b><br />
                        {{ $model->size }}
                    </p>
                @endif
                @if ($model->weight)
                    <p>
                        <b>{{ __('items.fields.weight') }}</b><br />
                        {{ $model->weight }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
