<?php /** @var \App\Models\Family $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ trans('races.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->race)
                    <p class="entity-race" data-foreign="{{ $model->race_id }}">
                        <b>{{ trans('races.fields.race') }}</b><br />
                        {!! $model->race->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
