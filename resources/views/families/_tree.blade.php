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
        [
            'label' => trans('families.fields.families'),
            'render' => function($model) {
                return $model->families()->count();
            },
            'disableSort' => true,
        ],
        // Location
        [
            'type' => 'avatar',
            'parent' => 'location',
            'parent_route' => 'locations',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => trans('families.fields.members'),
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
        'route' => 'families.index',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
        'campaign' => $campaign,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->families()->count();
                }
            ]
        ]
    ]
) !!}