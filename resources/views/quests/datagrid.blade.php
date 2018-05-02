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