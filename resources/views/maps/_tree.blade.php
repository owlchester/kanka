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
        [
            'label' => trans('maps.actions.explore'),
            'render' => function($model) {
                return '<a href="' . route('maps.explore', $model) . '" target="_blank"><i class="fa fa-map" data-tree="escape"></i></a>';
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('maps.fields.maps'),
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
        'route' => 'maps.tree',
        'baseRoute' => 'maps',
        'trans' => 'maps.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->maps->count();
                }
            ]
        ]
    ]
) !!}
