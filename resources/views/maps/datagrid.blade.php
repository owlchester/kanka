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
            'label' => '<i class="fa-solid fa-map" data-toggle="tooltip" title="' . __('maps.actions.explore') . '"></i>',
            'render' => function($model) {
                if (empty($model->image)) {
                    return '';
                }
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
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . trans('maps.fields.maps') . '"></i>',
            'render' => function($model) {
                return $model->maps->count();
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
        'route' => 'maps.index',
        'baseRoute' => 'maps',
        'trans' => 'maps.fields.',
        'campaign' => $campaign
    ]
) !!}
