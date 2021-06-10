<?php /** @var \App\Models\Family $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ trans('races.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->race)
                    <p>
                        <b>{{ trans('races.fields.race') }}</b><br />
                        {!! $model->race->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
