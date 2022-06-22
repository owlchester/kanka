@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'parameters',
        [
            'label' => trans('crud.fields.character'),
            'field' => 'character.name',
            'render' => function($model) {
                if ($model->character) {
                    return $model->character->tooltipedLink();
                }
            }
        ],
        [
            'label' => trans('dice_rolls.fields.rolls'),
            'render' => function($model) {
                return $model->diceRollResults()->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ],
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'dice_rolls.index',
        'baseRoute' => 'dice_rolls',
        'trans' => 'dice_rolls.fields.',
        'campaignService' => $campaignService,
    ]
) !!}
