<?php /** @var \App\Models\DiceRoll $model */ ?>

{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'parameters',
        [
            'label' => __('entities.character'),
            'field' => 'character.name',
            'render' => function(\App\Models\DiceRoll $model) use ($campaign) {
                if ($model->character && $model->character->entity) {
                    return \Illuminate\Support\Facades\Blade::renderComponent(
                        new \App\View\Components\EntityLink($model->character->entity, $campaign)
                    );
                }
            }
        ],
        [
            'label' => __('dice_rolls.fields.rolls'),
            'render' => function($model) {
                return $model->diceRollResults()->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ],
    ])
    ->options([
        'route' => 'dice_rolls.index',
        'baseRoute' => 'dice_rolls',
        'trans' => 'dice_rolls.fields.',
    ]
) !!}
