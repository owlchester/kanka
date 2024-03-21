<?php /** @var \App\Models\DiceRoll $model */?>
@if ($model->parameters)
| {{ __('dice_rolls.fields.parameters') }} | {{ $model->parameters }} |
@endif
@if ($model->character)
| {!! \App\Facades\Module::singular(config('entities.ids.character'), __('entities.character')) !!} | {!! $model->character->tooltipedLink() !!} |
@endif
