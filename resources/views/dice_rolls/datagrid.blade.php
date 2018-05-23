@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
        'parameters',
        'results',
        [
            'label' => trans('crud.notes.fields.creator'),
            'field' => 'user.name',
            'render' => function($model) {
                if ($model->creator) {
                    return $model->creator->name;
                }
            }
        ],
        [
            'label' => trans('crud.fields.character'),
            'field' => 'character.name',
            'render' => function($model) {
                if ($model->character) {
                    return '<a href="' . route('characters.show', $model->character_id) . '">' . $model->character->name . '</a>';
                }
            }
        ],
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'dice_rolls.index',
        'baseRoute' => 'dice_rolls',
        'trans' => 'dice_rolls.fields.',
        'campaign' => $campaign,
    ]
) !!}