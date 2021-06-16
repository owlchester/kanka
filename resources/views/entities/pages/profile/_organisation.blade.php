<?php /** @var \App\Models\Organisation $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('organisations.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p class="entity-location" data-foreign="{{ $model->location_id }}">
                        <b>{{ __('organisations.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->organisation)
                    <p class="entity-organisation" data-foreign="{{ $model->organisation_id }}">
                        <b>{{ __('organisations.fields.organisation') }}</b><br />
                        {!! $model->organisation->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
