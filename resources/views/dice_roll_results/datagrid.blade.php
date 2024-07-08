<?php /** @var \App\Models\DiceRollResult $model */ ?>
{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar',
            'parent' => 'diceRoll',
            'parent_route' => 'dice_rolls',
        ],
        [
            'label' => __('entities.dice_roll'),
            'field' => 'diceRoll.name',
            'render' => function($model) use ($campaign) {
               return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->diceRoll->entity, $campaign)
                );
            }
        ],
        [
            'label' => __('entities.character'),
            'field' => 'diceRoll.character.name',
            'disableSort' => true,
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) use ($campaign) {
                if ($model->diceRoll->character) {
                   return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->diceRoll->character->entity, $campaign)
                );
                }
            }
        ],
        [
            'label' => __('crud.fields.creator'),
            'field' => 'user.name',
            'render' => function($model) {
                if ($model->user) {
                    return e($model->user->name);
                }
            }
        ],
        'results',
        [
            'label' => __('dice_rolls.results.fields.date'),
            'field' => 'created_at',
            'render' => function($model) {
                return $model->updated_at->diffForHumans();
            }
        ],
    ])
    ->options([
        'route' => 'dice_roll_results.index',
        'baseRoute' => 'dice_roll_results',
        'trans' => 'dice_rolls.fields.',
        'disableEntity' => true,
    ]
) !!}
