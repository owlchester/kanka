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
        'price',
        'size',
        // Location
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        // Character
        [
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'items.index',
        'baseRoute' => 'items',
        'trans' => 'items.fields.',
        'campaign' => $campaign
    ]
) !!}
