@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->filters($filters)
    ->nested()
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
        // Character
        [
            'type' => 'avatar',
            'parent' => 'character',
            'parent_route' => 'characters',
            'visible' => $campaign->enabled('characters'),
        ],
        [
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
        ],
        [
            'label' => trans('quests.fields.locations'),
            'visible' => $campaign->enabled('locations'),
            'render' => function($model) {
                return $model->locations()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('quests.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('quests.fields.organisations'),
            'visible' => $campaign->enabled('organisations'),
            'render' => function($model) {
                return $model->organisations()->count();
            },
            'disableSort' => true,
        ],
        'is_completed',
        [
            'type' => 'calendar_date',
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