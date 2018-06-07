@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
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
        'is_completed',
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'quests.index',
        'baseRoute' => 'quests',
        'trans' => 'quests.fields.',
        'campaign' => $campaign
    ]
) !!}