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
        'type',
        [
            'label' => trans('quests.fields.quests'),
            'render' => function($model) {
                return $model->quests()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('quests.fields.quest'),
            'render' => function($model) {
                if ($model->quest) {
                    return '<a href="' . route('quests.show', $model->quest->id) . '">' . e($model->quest->name) . '</a>';
                }
            },
            'field' => 'quest.name',
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'quests.tree',
        'baseRoute' => 'quests',
        'trans' => 'quests.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->quests()->count();
                }
            ]
        ]
    ]
) !!}