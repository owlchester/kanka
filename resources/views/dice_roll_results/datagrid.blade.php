@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
    $filterService,
    // Columns
    [
        // Avatar
        [
            'type' => 'avatar',
            'parent' => 'diceRoll',
            'parent_route' => 'dice_rolls',
        ],
        [
            'label' => trans('crud.fields.dice_roll'),
            'field' => 'diceRoll.name',
            'render' => function($model) {
                return '<a href="' . route('dice_rolls.show', $model->dice_roll_id) . '">' . $model->diceRoll->name . '</a>';
            }
        ],
        [
            'type' => 'avatar',
            'parent' => 'character',
            'parent_route' => 'characters',
            'visible' => $campaign->enabled('characters'),
        ],
        [
            'label' => trans('crud.fields.character'),
            'field' => 'character.name',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                if ($model->diceRoll->character) {
                    return '<a href="' . route('characters.show', $model->diceRoll->character->id) . '" data-toggle="tooltip" title="' . $model->diceRoll->character->tooltip() . '">' . $model->diceRoll->character->name . '</a>';
                }
            }
        ],
        [
            'label' => trans('crud.fields.creator'),
            'field' => 'user.name',
            'render' => function($model) {
                if ($model->user) {
                    return $model->user->name;
                }
            }
        ],
        'results',
        [
            'label' => trans('dice_rolls.results.fields.date'),
            'field' => 'created_at',
            'render' => function($model) {
                return $model->elapsed();
            }
        ],
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'dice_roll_results.index',
        'baseRoute' => 'dice_roll_results',
        'trans' => 'dice_rolls.fields.',
        'campaign' => $campaign,
        'disableEntity' => true,
    ]
) !!}