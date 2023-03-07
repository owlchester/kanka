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
            'label' => '<i class="fa-solid fa-map" data-toggle="tooltip" title="' . __('maps.actions.explore') . '"></i>',
            'render' => function($model) {
                return $model->exploreLink();
            },
            'disableSort' => true,
        ],
        [
            'label' => __('maps.fields.maps'),
            'render' => function($model) {
                return $model->maps->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'maps.tree',
        'baseRoute' => 'maps',
        'trans' => 'maps.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->maps->count();
                }
            ]
        ]
    ]
) !!}
