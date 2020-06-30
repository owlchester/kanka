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
            'label' => trans('abilities.fields.abilities'),
            'render' => function($model) {
                return $model->abilities->count();
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
        'route' => 'abilities.tree',
        'baseRoute' => 'abilities',
        'trans' => 'abilities.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->abilities->count();
                }
            ]
        ]
    ]
) !!}
