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
            'type' => 'organisation',
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
            'label' => '<i class="fa fa-users" title="' . trans('organisations.fields.members') . '"></i>',
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->members->count();
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
        'route' => 'organisations.index',
        'baseRoute' => 'organisations',
        'trans' => 'organisations.fields.',
        'campaign' => $campaign
    ]
) !!}
