@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->service($filterService)
    ->models($models)
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
            'render' => function($model) {
                return '<a href="' . route('dice_rolls.show', [$model->diceRoll->campaign_id, $model->dice_roll_id]) . '">' . e($model->diceRoll->name) . '</a>';
            }
        ],
        [
            'label' => __('entities.character'),
            'field' => 'diceRoll.character.name',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                if ($model->diceRoll->character) {
                    return $model->diceRoll->character->tooltipedLink();
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
