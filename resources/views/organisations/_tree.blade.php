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
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => trans('organisations.fields.organisations'),
            'render' => function($model) {
                return $model->organisations()->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('organisations.fields.members'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->members()->count();
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
        'route' => 'organisations.tree',
        'baseRoute' => 'organisations',
        'trans' => 'organisations.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->organisations()->count();
                }
            ]
        ]
    ]
) !!}
