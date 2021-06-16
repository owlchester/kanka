<?php /** @var \App\Models\Family $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('families.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p class="entity-location" data-foreign="{{ $model->location_id }}">
                        <b>{{ __('families.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->family)
                    <p class="entity-family" data-foreign="{{ $model->family_id }}">
                        <b>{{ __('families.fields.family') }}</b><br />
                        {!! $model->family->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
