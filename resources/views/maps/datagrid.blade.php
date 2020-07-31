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
            'label' => trans('maps.actions.explore'),
            'render' => function($model) {
                if (empty($model->image)) {
                    return '';
                }
                return '<a href="' . route('maps.explore', $model) . '" target="_blank"><i class="fa fa-map"></i></a>';
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('crud.fields.map'),
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
            'label' => '<i class="fa fa-users" title="' . trans('maps.fields.maps') . '"></i>',
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
