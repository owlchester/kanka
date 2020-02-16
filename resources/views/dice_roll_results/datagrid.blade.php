@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
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
                return '<a href="' . route('dice_rolls.show', $model->dice_roll_id) . '">' . e($model->diceRoll->name) . '</a>';
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
            'field' => 'diceRoll.character.name',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                if ($model->diceRoll->character) {
                    return $model->diceRoll->character->tooltipedLink();
                }
            }
        ],
        [
            'label' => trans('crud.fields.creator'),
            'field' => 'user.name',
            'render' => function($model) {
                if ($model->user) {
                    return e($model->user->name);
                }
            }
        ],
        'results',
        [
            'label' => trans('dice_rolls.results.fields.date'),
            'field' => 'created_at',
            'render' => function($model) {
                return $model->updated_at->diffForHumans();
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
