@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'label' => __('races.fields.races'),
            'render' => function($model) {
                return $model->races->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('races.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters->count() . ' / ' . $model->allCharacters(true)->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'races.tree',
        'baseRoute' => 'races',
        'trans' => 'races.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->races->count();
                }
            ],
        ]
    ]
) !!}
