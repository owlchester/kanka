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
            'label' => __('creatures.fields.creatures'),
            'render' => function($model) {
                return $model->creatures->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'creatures.tree',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->creatures->count();
                }
            ],
        ]
    ]
) !!}
