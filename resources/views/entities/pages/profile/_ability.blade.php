<?php /** @var \App\Models\Ability $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('abilities.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->ability)
                    <p>
                        <b>{{ __('abilities.fields.ability') }}</b><br />
                        {!! $model->ability->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->charges)
                    <p>
                        <b>{{ __('abilities.fields.charges') }}</b><br />
                        {{ $model->charges }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
