@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
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
            'label' => __('maps.fields.map'),
            'field' => 'map.name',
            'render' => function($model) {
                if ($model->map) {
                    return $model->map->tooltipedLink();
                }
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . __('maps.fields.maps') . '"></i>',
            'render' => function($model) {
                return $model->maps->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'maps.index',
        'baseRoute' => 'maps',
        'trans' => 'maps.fields.',
        'campaignService' => $campaignService
    ]
) !!}
