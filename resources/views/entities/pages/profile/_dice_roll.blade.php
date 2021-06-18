<?php /** @var \App\Models\DiceRoll $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->parameters)
                    <p class="entity-parameters">
                        <b>{{ __('dice_rolls.fields.parameters') }}</b><br />
                        {{ $model->parameters }}
                    </p>
                @endif
                @if ($campaign->enabled('characters') && $model->character)
                    <p class="entity-character">
                        <b>{{ __('crud.fields.character') }}</b><br />
                        {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
