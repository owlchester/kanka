@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)->render(
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
            'label' => __('creatures.fields.creatures'),
            'render' => function($model) {
                return $model->creatures->count();
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
        'route' => 'creatures.index',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
        'campaignService' => $campaignService
    ]
) !!}
